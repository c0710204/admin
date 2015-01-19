<?php
/**
 * EdxCrm
 */
namespace Admin;



/**
* @brief Class providing edx mysql data related tools
* author: jambon
*/
class EdxCrm
{

    /**
     * [$config description]
     * @var [type]
     */
    private $config=null;//config object
    private $db=null;//myslq db connection
    //private $user=[];// django user
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

            // logs
            //$logger=new Admin\EdxLog();
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


   
    // return the mongodb connection
    public function db()
    {
        return $this->db;
    }

    /**
     * Return mongodb connected status
     * @return [type] [description]
     */
    public function connected()
    {
        return $this->db->connected;
    }

    

    public function company($company_id=0)
    {
        $company_id*=1;
        
        if(!$company_id){
            return false;
        }

        $sql ="SELECT * FROM edxcrm.companies WHERE c_id=$company_id;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        
        return $q->fetch(\PDO::FETCH_ASSOC);
    }


    public function company_exist($company_name = '')
    {

        $sql ="SELECT * FROM edxcrm.companies WHERE c_name LIKE '$company_name';";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    
    public function company_create($company_name = '')
    {
        
        $company_name=trim($company_name);
        if(!$company_name){
            return false;
        }

        $sql ="INSERT INTO edxcrm.companies (c_name, c_updated) VALUES (".$this->db->quote($company_name).", NOW());";
        $this->db->query($sql) or die(print_r($this->db->errorInfo(), true));
        
        return $this->db->lastInsertId();
    }










    /*
     
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
    */

    
}
