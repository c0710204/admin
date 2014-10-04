<?php
/**
 * Not working as expected (mongo)
 */
namespace Admin;



/**
* @brief Class providing edx mysql data related tools
* author: jambon
*/
class EdxApp
{

    /**
     * [$config description]
     * @var [type]
     */
    private $config=null;//config object
    private $db=null;//myslq db connection
    private $mgdb=null;//myslq db connection
    private $modulestore=null;//mongo db connection
    
    /**
     * [$org description]
     * @var string
     */
    private $org='';//org limit

    public function __construct ($settings = [])
    {
        $configfile='';

        if (isset($_SESSION['configfile'])) {
           $configfile=$_SESSION['configfile'];
        }

        if (!is_file($configfile)) {
            //throw new \Exception('Error: no config file like "'.$configfile.'"');
            return false;
        } else {
            // Load configuration
            $this->config = json_decode(file_get_contents($configfile));

            // mongo
            if (isset($settings['nomongo'])) {
                // no mongo connection scotch
            } else {
                $this->mongoConnect();//temporary off
            }
            
            // pdo mysql
            $this->db = Pdo::getDatabase();

            // org
            if (isset($this->config->lte->org)) {
                $this->org=$this->config->lte->org;
            }

        }
    }


    private function mongoConnect()
    {

        $str="mongodb://".$this->config->mongo->host.":".$this->config->mongo->port;//my vm

        try {
            $this->mgdb = new \MongoClient($str);//test
        } catch (PDOException $e) {
            echo "<li>Error:" . $e->getMessage();
            die("<li>End of story");
        }

        if ($this->mgdb->connected) {
            $this->modulestore = $this->mgdb->edxapp->modulestore;
        } else {
            echo "Not connected<hr />";
        }
    }


    /**
     * Return config
     * @return [type] [description]
     */
    public function config()
    {
        return $this->config;
    }


    // debug/dev function
    // return the mongodb connection
    public function mgdb()
    {
        return $this->mgdb;
    }


    /**
     * Return mongodb connected status
     * @return [type] [description]
     */
    public function connected()
    {
        return $this->mgdb->connected;
        //$str="mongodb://192.168.33.10:27017";//my vm
        //echo "str=$str\n";
        //$m = new \MongoClient("$str");
        //var_dump($m);
    }

    

    /**
     * Return enrollments order by created date (recents first)
     * @param  string  $course_id [description]
     * @param  integer $userid    [description]
     * @return [type]             [description]
     */
    public function enrollments($course_id = '', $limit = 0)
    {
        $limit*=1;

        $sql ="SELECT *  FROM edxapp.student_courseenrollment ";
        $sql.="WHERE 1 ";
        
        if ($course_id) {// todo :: check course_id format
            $sql.=" AND course_id LIKE '".$course_id."' ";
        }

        if ($this->org) {// org restriction
            $sql.=" AND course_id LIKE '".$this->org."/%' ";
        }

        if ($limit>0) {
            $LIMIT="LIMIT $limit";
        } else {
            $LIMIT='';
        }

        $sql.="ORDER BY created DESC $LIMIT;";
        
        //echo "<pre>$sql</pre>";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $dat=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $dat[]=$r;
        }
        return $dat;
    }





    /**
     * Enroll given user into given course
     * @param  string  $course_id [description]
     * @param  integer $userid    [description]
     * @return [type]             [description]
     */
    public function enroll($course_id = '', $user_id = 0, $created = '')
    {
        $user_id*=1;
        if (!$course_id || !$user_id) {
            return false;
        }

        // todo :: check $created date format
        if (!$created) {
            $created="NOW()";
        } else {
            $created="'$created'";
        }

        // check previous enrollment 
        if ($enrid=$this->enrolled($user_id, $course_id)) {
            return $enrid;
        }

        // todo :: make sure the right mode is 'honor'
        $sql="INSERT INTO edxapp.student_courseenrollment (user_id, course_id, created, is_active, mode) ";
        $sql.="VALUES ($user_id, '$course_id', $created, 1, 'honor');";

        $q=$this->db->query($sql) or die("Error:".print_r($this->db->errorInfo(), true));
        return $this->db->lastInsertId();
    }




    /**
     * Return enrollment id for a given user/course
     * @param  integer $user_id   [description]
     * @param  string  $course_id [description]
     * @return [type]             [description]
     */
    public function enrolled($user_id = 0, $course_id = '')
    {
        $user_id*=1;
        
        if (!$user_id) {
            return false;
        }

        $sql="SELECT id FROM edxapp.student_courseenrollment WHERE user_id=$user_id AND course_id LIKE '$course_id';";
        $q=$this->db->query($sql) or die("Error:".print_r($this->db->errorInfo(), true));
        
        if ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            return $r['id'];
        }

        return false;
    }


    /**
     * Enroll given user into given course
     * @param  string  $course_id [description]
     * @param  integer $userid    [description]
     * @return [type]             [description]
     */
    public function disenroll($course_id = '', $user_id = 0)
    {
        $user_id*=1;
        if (!$course_id || !$user_id) {
            return false;
        }

        $sql ="DELETE FROM edxapp.student_courseenrollment ";
        $sql.="WHERE user_id='$user_id' AND course_id LIKE '$course_id' LIMIT 1;";

        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        return true;//todo : return affected rows
    }




    public function group($groupid = 0)
    {
        $groupid*=1;
        if (!$groupid) {
            return false;
        }

        $sql="SELECT * FROM edxapp.auth_group WHERE id = '$groupid';";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        //echo "<pre>$sql</pre>";

        $r=$q->fetch(\PDO::FETCH_ASSOC);
        
        if (!$r) {
            return false;
        }

        $type=explode("_", $r['name'])[0];
        $r["type"]=$type;

        $course_id=preg_replace('/^(beta_testers|instructor|staff)_/', '', $r['name']);
        $course_id=str_replace('.', '/', $course_id);
        $r["course_id"]=$course_id;
        
        return $r;
    }



    /**
     * Delete completely one auth user group AND data
     * @param  integer $groupid [description]
     * @return [type]           [description]
     */
    public function groupDelete($groupid = 0)
    {
        $groupid*=1;
        
        if (!$groupid) {
            return false;
        }

        $sql="DELETE FROM edxapp.auth_user_groups WHERE group_id = '$groupid';";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));

        $sql="DELETE FROM edxapp.auth_group WHERE id = '$groupid';";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));

        return true;
    }



    /**
     * Return the list of groups related to a given course
     * Default groups are : "Instructors, Staff, Beta users"
     */
    public function courseGroups($course_id = '')
    {
        if ($course_id && preg_match("/([a-z 0-9\/\._-]+)/i", $course_id, $o)) {
            $o=explode("/", $course_id);
            $org=$o[0];
            $course=$o[1];
            $name=$o[2];
        } else {
            return false;
        }

        $sql="SELECT * FROM edxapp.auth_group WHERE name LIKE '%_$org.$course.$name';";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $dat=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $type=explode("_", $r['name'])[0];
            $dat["$type"]=$r;
        }
        return $dat;
    }
    

    /**
     * Return the list of user (id's) for a given course group.
     * @param  integer $group_id [description]
     * @return [type]            [description]
     */
    public function courseGroup($group_id = 0)
    {
        if ($group_id<1) {
            return false;
        }

        $sql="SELECT id, user_id FROM edxapp.auth_user_groups WHERE group_id=$group_id;";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));

        $dat=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $dat[]=$r;
        }
        return $dat;
    }


    /**
     * Add one user for a given user group
     * @param  integer $group_id [description]
     * @param  integer $user_id  [description]
     * @return integer           inserted id
     */
    public function userGroupAddUser($group_id = 0, $user_id = 0)
    {
        $group_id*=1;
        $user_id*=1;

        if (!$group_id||!$user_id) {
            return false;
        }

        $sql="INSERT INTO edxapp.auth_user_groups (user_id, group_id) VALUES ($user_id, $group_id);";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo()[2], true));
        return $this->db->lastInsertId();
    }

    /**
     * Delete one record from auth_user_groups
     * @param  integer $id [description]
     * @return bool      [description]
     */
    public function userGroupDel($id = 0)
    {
        $id*=1;
        if (!$id) {
            return false;
        }
        
        $sql = "DELETE FROM edxapp.auth_user_groups WHERE id=$id LIMIT 1;";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        return true;
    }
    

    /**
     * Update user Password
     * @param  integer $user_id [description]
     * @param  string  $pass    [description]
     * @return [type]           [description]
     */
    public function updatePassword($user_id = 0, $pass = '')
    {
        $user_id*=1;

        if (!$pass || !$user_id) {
            return false;
        }

        //echo "<li>pass=$pass\n";
        $sql = "UPDATE edxapp.auth_user SET password='$pass' WHERE id=$user_id LIMIT 1;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        return true;
    }




    /**
     * [updateUserInfo description]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function updateUserProfile($user_id = 0, array $data = [])
    {

        $user_id*=1;

        if (!$user_id) {
            return false;
        }


        $sql ="UPDATE edxapp.auth_user SET ";

        if (@$data['is_active']) {
            $sql.="is_active=1, ";
        } else {
            $sql.="is_active=0, ";
        }

        $sql.="username=".$this->db->quote($data['username']).", ";
        //$sql.="first_name=".$this->db->quote($data['first_name']).", ";
        //$sql.="last_name=".$this->db->quote($data['last_name']).", ";
        $sql.="email=".$this->db->quote($data['email'])." ";
        $sql.="WHERE id='$user_id' LIMIT 1;";

        $q=$this->db->query($sql) or die($this->db->errorInfo()[2]);

        // todo : username should aslo be changed in edxapp.auth_userprofile
        $sql ="UPDATE edxapp.auth_userprofile SET ";
        $sql.="name=".$this->db->quote($data['username'])." ";
        $sql.="WHERE user_id='$user_id' LIMIT 1;";

        $q=$this->db->query($sql) or die($this->db->errorInfo()[2]);

        return true;
    }


    /**
     * [user description]
     * @param  integer $userid [description]
     * @return [type]          [description]
     */
    public function user($userid = 0)
    {
        $userid*=1;
        if (!$userid) {
            return false;
        }

        $sql="SELECT * FROM edxapp.auth_user WHERE id=$userid;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $r=$q->fetch(\PDO::FETCH_ASSOC);

        return $r;
    }


    /**
     * Return the username only. Simple string function
     * @param  integer $userid [description]
     * @return string          username
     */
    public function userName($userid = 0)
    {
        $userid*=1;
        if (!$userid) {
            return false;
        }
        $sql="SELECT username FROM edxapp.auth_user WHERE id=$userid;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['username'];
    }



    /**
     * [userprofile description]
     * @param  integer $userid [description]
     * @return array          auth_userprofile record
     */
    public function userProfile($userid = 0)
    {
        $userid*=1;
        if (!$userid) {
            return false;
        }
        $sql="SELECT * FROM edxapp.auth_userprofile WHERE user_id=$userid;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r;
    }



    /**
     * Create a active django user
     * @param  string $email       must be unique, 75 chars max
     * @param  string $username    must be unique, 30 chars max
     * @param  string $first_name  first name, 30 chars max
     * @param  string $last_name   last name, 30 chars max
     * @param  string $date_joined datetime
     * @return integer             user_id
     */
    public function userCreate($email = '', $username = '', $first_name = '', $last_name = '', $date_joined = '')
    {
        
        // echo "userCreate();\n";
        $email=trim(strtolower($email));

        if (!$email) {//email is the primary identifier in edx
            return false;
        }

        if ($uid = $this->userExist($email)) {
            return $uid;
        }

        // $username=explode("@", $email)[0];// we take the first part of the email as username if we dont have anything better
        
        /*
        if ($first_name) {
            $username=$first_name;//username
        }
        */
        
        // date joined
        if (!$date_joined) {
            $date_joined="NOW()";
        } else {
            $date_joined="'$date_joined'";
        }

        $sql = "INSERT INTO edxapp.auth_user (username, first_name, last_name, email, is_active, date_joined)";
        $sql.=" VALUES (".$this->db->quote($username).", ".$this->db->quote($first_name).", ".$this->db->quote($last_name).", '$email', 1, $date_joined);";

        $q=$this->db->query($sql) or die("Errror:".print_r($this->db->errorInfo(), true)."<hr />$sql");

        $userid=$this->db->lastInsertId();

        if ($userid) {
            $sql = "INSERT INTO edxapp.auth_userprofile (user_id, name, courseware, allow_certificate)";
            $sql.=" VALUES ('$userid', ".$this->db->quote($username).", 'course.xml', 1);";
            $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        } else {
            return false;
        }

        return $userid;
    }


    /**
     * Return the user id of the user for a given email adress
     * @return [type] [description]
     */
    public function userExist($email = '')
    {
        $email=trim($email);
        $sql="SELECT id FROM edxapp.auth_user WHERE email LIKE '$email';";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['id'];
    }


    /**
     * Return a list of django user(s)
     * @param  [type]  $where [description]
     * @param  integer $limit [description]
     * @return [type]         [description]
     */
    public function userList($where = [], $limit = 30)
    {
        $limit*=1;
        if (!$limit) {
            $limit=30;
        }

        $WHERE=[];
        $WHERE[]='1';

        if (is_array($where) && count($where)) {
            foreach ($where as $w) {
                $WHERE[]=$w;
            }
        }

        $sql = "SELECT id, username, email, last_login, date_joined, is_active, is_staff, is_superuser FROM auth_user ";
        $sql.= "WHERE " . implode(" AND ", $WHERE);
        $sql.= " ORDER BY date_joined DESC ";
        $sql.= "LIMIT $limit;";

        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $r['is_active']*=1;
            $r['is_staff']*=1;
            $r['is_superuser']*=1;
            $DAT[]=$r;
        }
        return $DAT;
    }



    /**
     * Return the last modified record from edxapp.course
     * @param  integer $userid [description]
     * @return [type]          [description]
     */
    public function userLastAction($user_id = 0)
    {
        $user_id*=1;
        if (!$user_id) {
            return false;
        }

        $sql="SELECT * FROM edxapp.courseware_studentmodule WHERE student_id=$user_id ORDER BY modified DESC LIMIT 1;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        return $q->fetch(\PDO::FETCH_ASSOC);
    }




    /**
     * Return groups for a given user
     * @param  integer $userid [description]
     * @return [type]          [description]
     */
    public function userGroups($userid = 0)
    {
        $userid*=1;
        if (!$userid) {
            return false;
        }

        $sql="SELECT group_id FROM edxapp.auth_user_groups WHERE user_id=$userid;";
        $q=$this->db->query($sql);

        if (!$q) {
            $r=$this->db->errorInfo();
            print_r($r);
            return false;
        }

        $groups=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $groups[]=$r['group_id'];
        }

        return $groups;
    }




    /**
     * Return student (user) enrollment data
     * @param  integer $userid [description]
     * @return [type]          [description]
     */
    public function studentCourseEnrollment($userid = 0)
    {
        $userid*=1;
        if (!$userid) {
            return [];
        }

        $sql = "SELECT * FROM student_courseenrollment ";
        $sql.= "WHERE user_id=$userid ";
        if ($this->org) {
            $sql.= " AND course_id LIKE '".$this->org."%'";
        }
        $sql.= "ORDER BY created DESC;";
        
        $q = $this->db->query($sql);
        
        //echo "<pre>$sql</pre>\n";
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r;
        }
        return $DAT;
    }


    /**
     * Return the number of users enrolled in one course
     * @param  string $courseId [description]
     * @return int           count
     */
    public function enrollCount($course_id = '')
    {
        /*
        if ($courseid && preg_match("/([a-z 0-9\/\._-]+)/i", $courseid, $o)) {
            $o=explode("/", $courseid);
            $org=$o[0];
            $course=$o[1];
            $name=$o[2];
            return $collection->findOne(['_id.org'=>$org, "_id.course"=>$course]);
        } else {
            return $collection->findOne(['_id.org'=>$this->org, "_id.course"=>$this->course]);
        }
        */
        $sql="SELECT COUNT(*) FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id';";
        $q=$this->db->query($sql) or die("<pre>error:$sql</pre>");
        $count=$q->fetch()[0];
        return $count;
    }



    /**
     * Return list of roles with their id's, for a given course id
     * Role examples : 
     * Administrator - (forum administrator) 
     * Moderator - (forum moderator)
     * Community TA - (teaching assistant) (https://sites.google.com/site/saasworldtas/edx-ta-guidelines) 
     * Student - (im not sure???)
     * @param  integer $course_id [description]
     * @return [type]             [description]
     */
    public function clientRoles($course_id = '')
    {
        //echo __FUNCTION__."($course_id)\n";

        if (!$course_id) {
            return false;
        }


        $sql = "SELECT * FROM edxapp.django_comment_client_role WHERE course_id LIKE '$course_id';";
        $q = $this->db->query($sql) or die("<pre>error:$sql</pre>");
        
        $ROLES=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $ROLES[$r['name']]=$r['id'];
        }
        //print_r($ROLES);
        return $ROLES;
    }

    

    /**
     * Return the list of user ids for the given comment client role id
     * Ex : list of Forum administrators or moderators, for a course 
     * @param  integer $client_role_id [description]
     * @return array                  [description]
     */
    public function clientRoleUsers($client_role_id = 0)
    {
        $client_role_id*=1;
        
        if (!$client_role_id) {
            return false;
        }

        $sql="SELECT id, user_id FROM edxapp.django_comment_client_role_users WHERE role_id=$client_role_id;";
        $q=$this->db->query($sql) or die("$sql");
        
        $USRS=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $USRS[$r['id']]=$r['user_id'];
        }
        return $USRS;
    }



    /**
     * Return student (user) enrollment data
     * @param  integer $userid [description]
     * @return [type]          [description]
     */
    public function studentCourseActivity($userid = 0, $where = [], $limit = 10)
    {
        $userid*=1;

        if (!$userid) {
            return [];
        }

        if (!$limit) {
            $limit=30;
        }

        /*
        1   id  int(11)
        2   module_type varchar(32)
        3   module_id   varchar(255)
        4   student_id  int(11)
        5   state   longtext
        6   grade   double
        7   created datetime
        8   modified    datetime
        9   max_grade   double
        10  done    varchar(8)
        11  course_id   varchar(255)
        */

        $WHERE[]="student_id='$userid'";
        foreach ($where as $w) {
            $WHERE[]=$w;
        }
        $WHERE=implode(" AND ", $WHERE);

        $sql = "SELECT * FROM edxapp.courseware_studentmodule WHERE $WHERE ORDER BY modified DESC LIMIT $limit;";// ORDER BY id DESC
        $q=$this->db->query($sql) or die("<pre>error:$sql</pre>");
        //echo "$sql\n";
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r;
        }
        return $DAT;
    }

    /**
     * Get the number of users enrolled in one course
     * @param  [type] $courseId [description]
     * @return [type]           [description]
     */
    public function courseEnrollCount($course_id = '')
    {
        if (!$course_id) {
            return false;
        }
        $q=$this->db->query("SELECT COUNT(*) FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id';");
        $count=$q->fetch()[0];
        return $count;
    }


    /**
     * Return the number of units `seen` per user per course
     * @param  string  $course_id [description]
     * @param  integer $user_id   [description]
     * @return [type]             [description]
     */
    public function courseUnitSeen($course_id = '', $user_id = 0)
    {
        $user_id*=1;

        $sql="SELECT COUNT(*) FROM edxapp.courseware_studentmodule WHERE course_id LIKE '$course_id' AND student_id=$user_id;";
        $q=$this->db->query($sql) or die("<pre>".print_r($this->db->errorInfo(), true)."</pre>");
        $r=$q->fetch();
        return $r['COUNT(*)'];
    }

    /**
     * Return courseware_studentmodule records per user per course
     * @param  string  $course_id [description]
     * @param  integer $user_id   [description]
     * @return [type]             [description]
     */
    public function courseUnitData($course_id = '', $user_id = 0)
    {
        $user_id*=1;
        if (!$course_id || !$user_id) {
            return false;
        }

        $sql="SELECT * FROM edxapp.courseware_studentmodule WHERE course_id LIKE '$course_id' AND student_id=$user_id;";
        $q=$this->db->query($sql) or die("<pre>".print_r($this->db->errorInfo(), true)."</pre>");
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r;
        }
        return $DAT;
    }

    /**
     * Return a group name
     * @param  integer $groupid [description]
     * @return [type]           [description]
     */
    public function groupName($groupid = 0)
    {
        $groupid*=1;
        if (!$groupid) {
            return false;
        }

        $sql="SELECT name FROM edxapp.auth_group WHERE id=$groupid;";
        $q=$this->db->query($sql);
        $f=$q->fetch();
        //todo : add controls
        return $f['name'];
    }



    /**
     * Courses
     * Courses
     * Courses
     */

    public function course($org = '', $course = '')
    {
        //global $modulestore;
        //echo __FUNCTION__."();\n";
        $data=$this->modulestore->find(["_id.course"=>$course, '_id.org'=>$org]);
        //print_r($data);
        return $data;
    }







    /**
     * Return the course short description
     * @param  [type] $course [description]
     * @return [type]         [description]
     */
    /*
    public function course_short_description($org = '', $course = '')
    {
        //global $modulestore;
        //echo "short_description($course);\n";
        $data=$this->modulestore->findOne(["_id.course"=>$course, '_id.org'=>$org, "_id.name"=>"short_description"], ["_id"=>0, "metadata"=>0]);
        //print_r($data);
        return $data['definition']['data']['data'];
    }
    */




    /**
     *   Get the list of organisations as a sorted array
     *   If the org is restricted by the config, then we return that one only
     */
    
    public function orgs()
    {
        //echo __FUNCTION__."()";
        $ops = ['$group'=>['_id'=>['org'=> '$_id.org']]];
        $orgs = $this->modulestore->aggregate($ops);
        
        $list=[];

        if ($this->org) {
            $list[]=$this->org;
            return $list;
        }

        foreach ($orgs['result'] as $k => $org) {
            $list[]=$org['_id']['org'];
        }
        sort($list);
        return $list;
        //return $orgs['result'];
    }
    

    /**
     * Return the full list of courses in a associative array
     * @return [type] [description]
     */
    public function courses()
    {
        if (!$this->modulestore) {
            return false;
        }

        //echo __FUNCTION__."()\n";

        $ops = ['$group'=>['_id'=>['course'=> '$_id.course', 'org'=> '$_id.org']]];//, 'name'=>'$_id.name'
        $courses = $this->modulestore->aggregate($ops);

        if (!$courses['ok']) {
            return false;
        }

        $DAT=[];
        foreach ($courses['result'] as $k => $v) {
            //print_r($v);
            $org = $v['_id']['org'];
            $DAT["$org"][]=$v['_id']['course'];
        }
        return $DAT;
    }

    /*
    public function courseEnrollments($courseid = '')
    {
        //$course_id=$this->org."/".$this->course."/".$this->name;
        $sql = "SELECT * FROM edxapp.student_courseenrollment WHERE course_id=$course_id;";
        $q=$this->db->query($sql);
        //echo "$sql\n";
        $DAT=[];
        while ($r=$q->fetch()) {
            $DAT[]=$r;
        }
        return $DAT;
    }
    */

    /**
     * Return the list of course id's (that you are allowed to see)
     * @return [type] [description]
     */
    public function courseids($org = '')
    {

        $filter=[];
        $filter['_id.category']='course';

        if ($org) {
            $filter['_id.org']=$org;
        }

        if ($this->org) {// restriction by config
            $filter['_id.org']=$this->org;
        }

        $data=$this->modulestore->find($filter, ['metadata'=>0, 'definition'=>0]);

        $list=[];
        foreach ($data as $dat) {
            $org   =$dat['_id']['org'];
            $course=$dat['_id']['course'];
            $name  =$dat['_id']['name'];
            $courseid="$org/$course/$name";
            @$list["$courseid"]++;
        }

        $dat=[];
        foreach ($list as $courseid => $v) {
            $dat[]=$courseid;
        }

        //print_r($list);
        return $dat;
    }



    /**
     * Return course display name, for a give course id (mysql format)
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function courseName($course_id = '')
    {
        // id format mysql
        if (preg_match("/^([a-z0-9_-]+)\/([a-z0-9_-]+)\/([a-z0-9_-]+)/i", $course_id, $o)) {
            //echo "<li>mysql format detect";exit;
            $org=$o[1];
            $course=$o[2];
            $name=$o[3];
        } else {
            return '';
        }

        $filter=["_id.course"=>$course, '_id.org'=>$org, "_id.category"=>"course"];
        $data=$this->modulestore->findOne($filter);
        
        if (!$data) {
            return "$course_id not found";
        }

        if ($data['metadata']['display_name']) {
            return $data['metadata']['display_name'];
        } else {
            //return print_r($data, true);
            return "$course_id";
        }
    }


    //db.orders.distinct( 'ord_dt', { price: { $gt: 10 } } )
    //$o=$db->modulestore->distinct('_id.org', array("course"=>array("=","Open_DemoX")));
    //echo "distinct : ";
    //print_r($o);


    //if( deleteCourse($db->modulestore );



    /**
     * Return a fa icon (html) for a given category
     * @param  string $category [description]
     * @return string           [description]
     */
    public function categoryIcon($category = '')
    {

        $ICON=[];
        $ICON['course']="<i class='fa fa-book' title='Course'></i>";
        $ICON['combinedopenended']="<i class='fa fa-book' title='combinedopenended'></i>";
        $ICON['chapter']="<i class='fa fa-bookmark' title='Chapter'></i>";
        $ICON['discussion']="<i class='fa fa-comments' title='Discussion'></i>";
        $ICON['sequential']="<i class='fa fa-caret-square-o-right' title='Sequencial'></i>";
        $ICON['textbook']="<i class='fa fa-file-pdf-o' title='Textbook'></i>";
        $ICON['vertical']="<i class='fa fa-arrow-down' title='Vertical'></i>";
        $ICON['html']="<i class='fa fa-code' title='Html'></i>";
        $ICON['video']="<i class='fa fa-film' title='Video'></i>";
        $ICON['peergrading']="<i class='fa fa-question' title='Peergrading'></i>";
        $ICON['problem']="<i class='fa fa-question-circle' title='Problem'></i>";
        return $ICON[$category];
    }

    /**
     * Remove course related data, as enrollments, courseware_studentmodule, etc
     * @param  [type] $course_id [description]
     * @return [type]            [description]
     */
    public function deleteCourseData($course_id = '')
    {
        if (preg_match("/^([a-z0-9_-]+)\/([a-z0-9_-]+)\/([a-z0-9_-]+)/i", $course_id, $o)) {
            //echo "<li>mysql format detect";exit;
            $org=$o[1];
            $course=$o[2];
            $name=$o[3];
        } else {
            return $course_id;
        }
        

        $sql="SELECT DISTINCT id FROM edxapp.courseware_studentmodule WHERE module_id LIKE 'i4x://$org/$course/%';";
        //echo "<pre>$sql</pre>";

        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        
        $ids=[];
        while ($r=$q->fetch()) {
            $ids[]=$r['id'];
        }
        
        // DELETE courseware_studentmodulehistory
        if (count($ids)) {
            $sql = "DELETE FROM edxapp.courseware_studentmodulehistory WHERE student_module_id IN (".implode(',', $ids).");";
            $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true)."<hr />$sql");
            //echo "<li>".$q->rowcount;
        }
        
        // DELETE courseware_studentmodule
        $sql = "DELETE FROM edxapp.courseware_studentmodule WHERE module_id LIKE 'i4x://$org/$course/%';";
        $q = $this->db->query($sql) or die(print_r($this->db->errorInfo(), true)."<hr />$sql");


        // Delete enrollment
        $sql = "DELETE FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id';";
        $q = $this->db->query($sql)  or die(print_r($this->db->errorInfo(), true));


        // Delete groups
        $groups=$this->courseGroups($course_id);
        foreach ($groups as $k => $g) {
            $this->groupDelete($g['id']);
        }

        return true;
    }
}
