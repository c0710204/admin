<?php
/**
 * Simple logger class
 */
namespace Admin;



/**
* @brief edxAdmin log system
* author: jambon
*/
class EdxLog
{

    private $config=null;//config object
    private $path='/tmp';//log path
    private $user=[];// django user

    public function __construct ()
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
        }
    }



    /**
     * get/set user 
     * @return [type] [description]
     */
    public function user($user = [])
    {
        $this->user=$user;
        return $this->user;
    }



    /**
     * Log every login actions
     * @return [type] [description]
     */
    public function login($str = '')
    {
        // todo
        error_log(date("c")."\t".$this->user['username']."\t$str\n", 3, $this->path."/edxadmin_login.txt");
    }

    /**
     * Log every drop/delete actions
     * @return [type] [description]
     */
    public function drop($str = '')
    {
        // todo
        error_log(date("c")."\t".$this->user['username']."\t$str\n", 3, $this->path."/edxadmin_drop.txt");
    }


    /**
     * Log everything
     * @param  string $str [description]
     * @return [type]      [description]
     */
    public function msg($str = '')
    {
        // log string
        //print_r($this->user);exit;
        if (!error_log(date("c")."\t".$this->user['username']."\t$str\n", 3, $this->path."/edxadmin_log.txt")) {
            echo "nope";
        }
    }
}
