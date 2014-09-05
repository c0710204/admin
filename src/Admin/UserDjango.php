<?php

/**
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace Admin;



/**
* @brief Class providing django users
* @see http://www.djangoproject.com
*
* Authentification backend to authenticate agains a django webapplication using
* django.contrib.auth.
*/
class UserDjango
{
    public $db=null;
    private $session=null;

    public function __construct ($db)
    {
        //echo __FUNCTION__;exit;
        //$this->db = DjangoDatabase::getDatabase();
        //$this->db = Pdo::getDatabase();
        $this->db = $db;
        //  $this->session = $this->djangoSession();//test
    }



    /**
    * @brief Check if the password is correct
    * @param $uid The username
    * @param $password The password
    * @returns true/false
    *
    * Check if the password is correct without logging in the user
    */
    public function checkPassword($email = '', $password = '')
    {
        if (!$this->db) {
            return false;
        }

        //echo __FUNCTION__."\n";

        $query  = $this->db->prepare('SELECT id, email, password, is_active, is_superuser FROM auth_user WHERE email =  ?');

        if ($query->execute(array($email))) {
            $row = $query->fetch(\PDO::FETCH_ASSOC);
            //var_dump($row);
            if (!empty($row)) {
                //print_r($row);
                $storedHash=$row['password'];
                if (self::beginsWith($storedHash, 'sha1')) {
                    $chunks = preg_split('/\$/', $storedHash, 3);
                    $salt   = $chunks[1];
                    $hash   = $chunks[2];

                    if (sha1($salt.$password) === $hash) {
                        return $row;
                    } else {
                        return false;
                    }

                } elseif (self::beginsWith($storedHash, 'pbkdf2')) {
                    $chunks = preg_split('/\$/', $storedHash, 4);
                    list($pbkdf, $algorithm) = preg_split('/_/', $chunks[0]);
                    $iter = $chunks[1];
                    $salt = $chunks[2];
                    $hash = $chunks[3];

                    //echo "<li>pbkdf2<br />";
                    //echo "<li>algorithm=$algorithm<br />";
                    //echo "<li>iter=$iter<br />";
                    //echo "<li>salt=$salt<br />";
                    //echo "<li>hash=$hash<br />";

                    if ($algorithm === 'sha1') {
                        $digest_size = 20;
                    } elseif ($algorithm === 'sha256') {
                        $digest_size = 32;
                    } else {
                        return false;
                    }

                    if (base64_encode(PhpsecCrypt::pbkdf2($password, $salt, $iter, $digest_size, $algorithm)) === $hash) {
                        return $row;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

    /**
    * @brief Helper function for checkPassword
    * @param $str The String to be searched
    * @param $sub The String to be found
    * @returns true/false
    */
    private function beginsWith($str, $sub)
    {
        return (substr($str, 0, strlen($sub)) === $sub );
    }


    /**
     * Jambon function, get a string, return it converted to a django password
     * @param  string $password [description]
     * @return [type]           [description]
     */
    public function djangopassword($password = '')
    {
        $algorithm='sha256';
        $iter='10000';
        //$salt='O1KgfAei96fL';
        $salt = substr(md5(rand(0, 999999)), 0, 12);
        $digest_size = 32;
        $b64hash=base64_encode(PhpsecCrypt::pbkdf2($password, $salt, $iter, $digest_size, $algorithm));

        return "pbkdf2_".$algorithm.'$'.$iter.'$'.$salt.'$'.$b64hash;
    }


    /**
     * Save php session id to `django_session` table.
     * The idea is to make sur the user isnt logged in twice, and keeping the standard django scheme
     * @param  [type] $session_id [description]
     * @param  [type] $userid     [description]
     * @return [type]             [description]
     */
    public function djangoSessionRegister($session_id = '', $userid = 0)
    {
        $userid*=1;

        //echo "djangoSessionRegister( $session_id, $userid);";
        $session_id=session_id();

        $sql = "INSERT INTO django_session ( session_key, session_data, expire_date ) ";
        $sql.= "VALUES ('$session_id','$userid', NOW());";

        $this->db->query($sql) or die( $this->db->error );

        return true;
    }


    /**
     * Return current session data.
     * @return [type] [description]
     */
    public function djangoSession()
    {
        //echo __FUNCTION__."()\n";
        //echo self::$db;
        $sid=session_id();
        $sql = "SELECT * FROM django_session WHERE session_key='$sid';";
        //$q=$this->db->query($sql);// or die( $this->db->)
        $q=$this->db->query($sql);// or die( $this->db->)
        $r=$q->fetch(\PDO::FETCH_ASSOC);

        //var_dump($r);
        return $r;
    }


    /**
     * Log in (jambon session system)
     * @return bool true on success
     */
    public function login($email = '', $pass = '')
    {
        $user = $this->checkPassword($email, $pass);
        //print_r($user);exit;
        if ($user && $user['is_active'] && $user['is_superuser']) {
            //Create a new session, deleting the previous session data
            session_regenerate_id(true);
            $sid=session_id();
            $this->djangoSessionRegister($sid, $user['id']);
            return true;
        }
        return false;
    }


    /**
     * Stop/Delete current session (jambon system)
     */
    public function logout()
    {
        //echo __FUNCTION__."()\n";

        $sid=session_id();
        $sql = "DELETE FROM django_session WHERE session_key='$sid';";
        $q=$this->db->query($sql);// or die( $this->db->)


        ob_clean();
        if (@session_regenerate_id(true)) {
            @$_SESSION['configfile']='';
            return session_id();
        }

        return false;
    }


    /**
    * @brief Get a list of all users
    * @returns array with all active usernames
    *
    * Get a list of all users.
    */
    public function getUsers($search = '', $limit = 10, $offset = 0)
    {
        if (!$this->db) {
            return array();
        }

        $query  = $this->db->prepare('SELECT id, username, email, is_active, is_staff FROM `auth_user` WHERE is_active=1 ORDER BY username');
        $users  = array();
        if ($query->execute()) {
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }
        }
        return $users;
    }

    /**
    * @brief check if a user exists
    * @param string $uid the username
    * @return boolean
    */
    public function userExists($uid)
    {
        if (!$this->db) {
            return false;
        }

        $query  = $this->db->prepare('SELECT username FROM `auth_user` WHERE username = ? AND is_active=1');
        if ($query->execute(array($uid))) {
            $row = $query->fetch();
            return !empty($row);
        }
        return false;
    }

    /**
     * Return django auth_user data
     * @param  integer $uid [description]
     * @return [type]       [description]
     */
    public function user($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT * FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r;
    }

    public function isActive($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_active FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }

    public function isStaff($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_staff FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }

    public function isSuperuser($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_superuser FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }
}
