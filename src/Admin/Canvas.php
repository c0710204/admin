<?php
/**
 * Canvas user migration class
 * by jambonbill
 */

namespace Admin;


class Canvas
{
    
    private $db='';

    public function __construct()
    {
        if (isset($_SESSION['canvas']['connected']) && $_SESSION['canvas']['connected']==true) {
            $this->connect();
        }
    }

    /**
     * Connect to Canvas db
     * @return [type] [description]
     */
    private function connect()
    {
        $host=$_SESSION['canvas']['host'];
        $database=$_SESSION['canvas']['database'];
        $user=$_SESSION['canvas']['user'];
        $pass=$_SESSION['canvas']['pass'];
        
        try {
            $dsn     = "pgsql:host=$host;dbname=".$database;
            //echo "dsn=$dsn";  
            $this->db = new \PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            //$failed = true;
            //echo "<li>error" . $e->getMessage();
        }
    }
    
    public function dbtest()
    {
        $host=$_SESSION['canvas']['host'];
        $database=$_SESSION['canvas']['database'];
        $user=$_SESSION['canvas']['user'];
        $pass=$_SESSION['canvas']['pass'];
        
        try {
            
            $dsn     = "pgsql:host=$host;dbname=".$database;
            echo "<li>dsn=$dsn";

            return new \PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            //$failed = true;
            echo "<li>error" . $e->getMessage();
            return false;
        }
        return false;
    }


    public function db()
    {
        return $this->db;
    }



    /**
     * Bring the list of courses
     * @return [type] [description]
     */
    public function course($course_id = 0)
    {
        $course_id*=1;
        if ($course_id<1) {
            return false;
        }

        $sql="SELECT * FROM courses WHERE id=$course_id;";// WHERE 1
        $q = $this->db->query($sql) or die("Error: $sql");
        
        
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $r['edx_id']=$this->edxCourseRelation($r['id']);
            return $r;
        }
        return false;
    }



    
    /**
     * Bring the list of courses
     * @return [type] [description]
     */
    public function courses()
    {
        $sql="SELECT id, name, account_id, start_at, conclude_at, course_code, restrict_enrollments_to_course_dates FROM courses WHERE account_id>=1;";// WHERE 1
        $q = $this->db->query($sql) or die("Error: $sql");
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $r['edx_id']=$this->edxCourseRelation($r['id']);
            $DAT[]=$r;
        }
        return $DAT;
    }





    /**
     * [courseEnrollCount description]
     * @param  integer $course_id [description]
     * @return [type]             [description]
     */
    public function courseEnrollCount($course_id = 0)
    {
        $course_id*=1;
        
        $sql="SELECT COUNT(*) FROM enrollments WHERE course_id=$course_id;";
        $q = $this->db->query($sql) or die("Error: $sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        //print_r($r);
        return $r['count'];
    }


    /**
     * [courseEnrollment description]
     * @param  integer $course_id [description]
     * @return [type]             [description]
     */
    public function courseEnrollments($course_id = 0, $workflow_state = '')
    {
        $course_id*=1;
        
        $sql ="SELECT * FROM enrollments ";
        $sql.="WHERE course_id=$course_id";
        if ($workflow_state) {
            $sql.=" AND workflow_state LIKE '$workflow_state' ";
        }
        
        $q = $this->db->query($sql) or die("Error: $sql");
        
        $dat=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $dat[]=$r;
        }
        return $dat;
    }


    /**
     * Return user email for a given user_id
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function userEmail($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $q = $this->db->query("SELECT path as email FROM communication_channels WHERE user_id=$user_id AND path_type='email';");
        // AND workflow_state='active'
        
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            return $r['email'];
        }
        return false;
        //
    }

    /**
     * Return user enrollments
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function userEnrollments($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $sql="SELECT course_id, created_at FROM enrollments WHERE user_id=$user_id;";
        $q = $this->db->query($sql);
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            if ($r['course_id']==2) continue;// TEST (à ne pas utiliser)
            if ($r['course_id']==3) continue;// Test Dev
            if ($r['course_id']==7) continue;// Demo
            $r['created_at']=substr($r['created_at'], 0, 19);
            $r['edx_id']=$this->edxCourseRelation($r['course_id']);
            $DAT[]=$r;
        }
        return $DAT;
    }


    /**
     * [edxCourseRelation description]
     * @param  integer $canvas_course_id [description]
     * @return [type]                    [description]
     */
    public function edxCourseRelation($canvas_course_id = 0)
    {
        
        $canvas_course_id*=1;

        switch ($canvas_course_id) {
            
            case 1: // Analyse Financière
                return "FFI/FFIf001/Q413";

            case 4: // Financial Analysis MOOC
                return "FFI/FFIe001/Q114";

            case 5: // Wall Street MOOC
                return "FFI/FFIe002/Q114";

            case 6: // Analyse Financière #2
                return "FFI/FFIf002/Q114";

            case 8:// Informer et communiquer sur les réseaux sociaux
                return "MJ/001/001";
            
            case 9:// Marché des changes
                return "FFI/FFIf003/Q114";

            default:
                return false;
        }
    }


    /**
     * Return the list of user ids assocatied with accout [1]First Business MOOC
     * @param  integer $limit [description]
     * @return array         [description]
     */
    public function userIds($limit = 0)
    {
        if ($limit>1) {
            $sql="SELECT DISTINCT user_id FROM user_account_associations WHERE account_id=1 LIMIT $limit;";
        } else {
            $sql="SELECT DISTINCT user_id FROM user_account_associations WHERE account_id=1;";
        }

        $q = $this->db->query($sql) or die(print_r($canvas->db()->errorInfo(), true));
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r['user_id'];
        }
        return $DAT;
    }


    /**
     * Return one user record
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function user($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $sql="SELECT id, name, sortable_name, created_at, updated_at FROM users WHERE id=$user_id AND workflow_state!='deleted';";
        //echo "<pre>$sql</pre>";
        $q=$this->db()->query($sql) or die(print_r($this->db()->errorInfo(), true)."<hr /> $sql");
        
        if ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            @$r['first_name']=trim(explode(',', $r['sortable_name'])[1]);
            $r['last_name']=trim(explode(',', $r['sortable_name'])[0]);
            
            $r['created_at']=substr($r['created_at'], 0, 19);
            $r['updated_at']=substr($r['updated_at'], 0, 19);

            $r['email']=$this->userEmail($r['id']);

            return $r;
        }
        return false;
    }
}
