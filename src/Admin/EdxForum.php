<?php
/**
 * EdxCourse
 */
namespace Admin;

/**
* @brief Class providing edx course data
* author: jambon
*/
class EdxForum
{

    private $org ='';// from config
    private $configfile='';//path to config file

    public $mgdb;//mongodb
    
    public $contents=null;
    public $subscriptions=null;
    public $users=null;


    public function __construct ()
    {
        
        if (isset($_SESSION['configfile'])) {
            $this->configfile=$_SESSION['configfile'];
        }

        if (!is_file($this->configfile)) {
            throw new \Exception('Error: config file not found');
            return false;
        } else {
            // Load configuration
            $this->config = json_decode(file_get_contents($this->configfile));
        }



        $str="mongodb://".$this->config->mongo->host.":".$this->config->mongo->port;//my vm

        if (!$this->mgdb = new \MongoClient($str)) {
            throw new \Exception('Error: mongo connection');
        }

        if (!$this->mgdb->connected) {
            //$this->modulestore = $this->mgdb->edxapp->modulestore;
            throw new \Exception('Error: no mongo connection');
        } else {
            $this->contents=$this->mgdb->cs_comments_service_development->contents;
            $this->subscriptions=$this->mgdb->cs_comments_service_development->subscriptions;
            $this->users=$this->mgdb->cs_comments_service_development->users;
        }
        
    }



    /**
     * Return one thread data (cursor)
     * @return [type]
     */
    /*
    public function thread()
    {

        $contents = $this->contents->find(["comment_thread_id"=>new \MongoId($threadid)]);
        
        return $contents;
    }
    */


    /**
     * Return the list of forum threads by sorted
     * @return [type]
     */
    public function threads($org  = '')
    {
        $filter=[];
        $filter["_type"]="CommentThread";
        
        if ($org) {
            $filter["course_id"]=new \MongoRegex("/^".$org."/i");//org
        }

        if ($this->org) {//config override
            $filter["course_id"]=new \MongoRegex("/^".$this->org."/i");//org
        }



        $contents = $this->contents->find($filter);
        $contents->sort(['updated_at'=>-1]);
        return $contents;
    }


    /**
     * Return the number of subitems for a given thread
     * @param  string $threadid
     * @return [type]
     */
    public function threadClose($threadid = '', $close = true)
    {

        if ($close=='false') {
            $close=false;
        }

        $mongoId=new \MongoId($threadid);
        $filter=["_id"=>$mongoId, '_type'=>'CommentThread'];
        $data = $this->contents->findOne($filter);
        //print_r($data);
        //exit;
        if ($close == true) {
            $data['closed']=1;
        } else {
            $data['closed']=0;
        }
        //print_r("closed:".$data['closed']);
        return $this->contents->update($filter, $data);

        return true;
    }



    /**
     * Return the number of subitems for a given thread
     * @param  string $threadid
     * @return [type]
     */
    public function threadCountSubitems($threadid = '')
    {
        $contents = $this->contents->find(["comment_thread_id"=>new \MongoId($threadid)]);
        return $contents->count();
    }



    /**
     * Delete one thread completely
     * @param  string $thread
     * @return [type]
     */
    public function threadDelete($threadid = '')
    {
        if (!$threadid) {
            return false;
        }

        //replies
        $this->contents->remove(["comment_thread_id"=>new \MongoId($threadid)]);
        
        //master thread
        $filter=["_id"=>new \MongoId($threadid)];
        return $this->contents->remove($filter);

        //return true;
    }


    public function threadTitle($threadid = '')
    {
        //echo __FUNCTION__."($threadid);";

        if (!$threadid) {
            return false;
        }

        $r = $this->contents->findOne(["_id"=>new \MongoId($threadid)]);
        //echo "<pre>";print_r($r);
        return $r['title'];
    }


    /**
     * Return the list of courses that i'm supposed to see (within my org, with forum threads)
     * @return [type] [description]
     */
    public function courses()
    {
        //db.contents.distinct("course_id")
        $q = $this->contents->distinct("course_id");
        return $q;
    }



    /**
     * Delete one forum record
     * @param  [type] $modulestore [description]
     * @param  string $org         [description]
     * @param  string $course      [description]
     * @return bool              [description]
     */
    public function deleteContent($id = '')
    {
        // $collection = $this->mgdb->edxapp->modulestore;
        
        // delete
        $filter=[];
        $filter["_id"] = new \MongoId($id);
        if ($this->org) {
            $filter["course_id"] = new \MongoRegex($this->org);
        }

        $del = $this->contents->remove($filter);

        if (!$del) {
            return false;
        }

        return true;
    }



    /**
     * Change vissible status. (useless)
     * Do not affect visibilty in edx !!
     * @param  [type] $modulestore [description]
     * @param  string $org         [description]
     * @param  string $course      [description]
     * @return bool              [description]
     */
    public function hideContent($id = '')
    {
        //$collection = $this->mgdb->edxapp->modulestore;
        
        // delete
        $filter=["_id"=>new \MongoId($id)];
        $data = $this->contents->findOne($filter);
        $data["visible"]=false;

        return $this->contents->update($filter, $data);


        return true;
    }

    /**
     * Count the number of post for a given user
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function postCount($user_id)
    {
        $cursor=$this->contents->find(["author_id"=>"$user_id"]);
        return $cursor->count();
    }

}
