<?php
/**
 * EdxCourse
 */
namespace Admin;

/**
* @brief Class providing edx course data
* author: jambon
*/
class EdxCourse
{
    private $org ='';//edX
    private $course ='';//Open_DemoX
    private $name='';//edx_demo_course
    private $configfile='';//path to config file
    public $mgdb;//mongodb
    public $modulestore=null;

    public function __construct ($org = '', $course = '', $name = '')
    {

        if (isset($_SESSION['configfile'])) {
            $this->configfile=$_SESSION['configfile'];
        }

        if (!is_file($this->configfile)) {
            //throw new \Exception('Error: config file not found');
            return false;
        } else {
            // Load configuration
            $this->config = json_decode(file_get_contents($this->configfile));
        }

        $this->org=$org;
        $this->course=$course;
        $this->name=$name;

        // id format mysql
        if (preg_match("/^([a-z0-9_-]+)\/([a-z0-9_-]+)\/([a-z0-9_-]+)/i", $org, $o)) {
            //echo "<li>mysql format detect";exit;
            $this->org=$o[1];
            $this->course=$o[2];
            $this->name=$o[3];
        }



        // org config override
        if (isset($this->config->lte->org)) {
            $this->org=$this->config->lte->org;
        }

        //$str="mongodb://192.168.33.10:27017";//my vm
        $str="mongodb://".$this->config->mongo->host.":".$this->config->mongo->port;//my vm

        if (!$this->mgdb = new \MongoClient($str)) {
            throw new \Exception('Error: mongo connection');
        }

        if (!$this->mgdb->connected) {
            //$this->modulestore = $this->mgdb->edxapp->modulestore;
            throw new \Exception('Error: no mongo connection');
        } else {
            $this->modulestore=$this->mgdb->edxapp->modulestore;
        }
    }


    /**
     * Set/Return course_id in mysql format (org/course/name)
     * as in Table: student_courseaccessrole
     * as in Table: student_courseenrollment
     * etc
     * @return [type] [description]
     */
    public function course_id($courseid = '')
    {
        if ($courseid && preg_match("/([a-z 0-9\/\._-]+)/i", $courseid, $o)) {
            $o=explode("/", $courseid);
            $this->org=$o[0];
            $this->course=$o[1];
            $this->name=$o[2];
        }

        return $this->org.'/'.$this->course.'/'.$this->name;
    }



    /**
     * return the course unit ids as list
     * userfull to compare with the user progression
     * @param  string $courseid [description]
     * @return [type]           [description]
     */
    public function courseUnitIds($course_id = '')
    {
        if ($course_id && preg_match("/([a-z 0-9\/\._-]+)/i", $course_id, $o)) {
            $o=explode("/", $course_id);
            $filter=['_id.org'=>$o[0],'_id.course'=>$o[1]];
        } else {
            $filter=['_id.org'=>$this->org,'_id.course'=>$this->course];
        }

        $units=$this->modulestore->find($filter);
        $DAT=[];
        foreach ($units as $u) {
            //echo "<pre>".print_r($u,  true)."</pre>";//exit;
            //$children=$u['definition']['children'];
            $idstring=$u['_id']['tag'].'://'.$u['_id']['org'].'/'.$u['_id']['course'].'/'.$u['_id']['category'].'/'.$u['_id']['name'];
            //$parent = $u[];
            $DAT[]=$idstring;
        }
        return $DAT;
    }


    // set org
    public function org($str)
    {
        $this->org=$str;
    }

    // set name
    public function name($str)
    {
        $this->name=$str;
    }

    // set course
    public function course($str)
    {
        $this->course=$str;
    }



    /**
     * Retun one record if course exist
     * @return string [description]
     */
    public function exist($courseid = '')
    {
        $collection = $this->mgdb->edxapp->modulestore;

        if ($courseid && preg_match("/([a-z 0-9\/\._-]+)/i", $courseid, $o)) {
            $o=explode("/", $courseid);
            $org=$o[0];
            $course=$o[1];
            // $name=$o[2];
            
            // we use mongo regex, because mongo is case sensitive
            // and in mysql, course_id's are stored, you guess it, lower case, sometimes ...
            $filter=['_id.org'=>['$regex' => new \MongoRegex("/^$org/i")], "_id.course"=>['$regex' => new \MongoRegex("/^$course/i")]];
            $filter["_id.category"]="course";// that's safe
            
            if ($r = $collection->findOne($filter)) {
                return $r['_id']['org'].'/'.$r['_id']['course'].'/'.$r['_id']['name'];
            }
        }
        return false;
    }

    



    /**
     * Return course category record(s)
     * @return [type] [description]
     */

    public function category($categoryName = '', $multiple = false)
    {
        if (!$categoryName) {
            return false;
        }

        $collection = $this->mgdb->edxapp->modulestore;
        $course = $this->course;
        $org= $this->org;

        if ($multiple) {
            return $collection->find(["_id.course"=>$course, '_id.org'=>$org, '_id.category'=>$categoryName]);
        } else {
            return $collection->findOne(["_id.course"=>$course, '_id.org'=>$org, '_id.category'=>$categoryName]);
        }

    }



    /**
     * Get the start date of a given course
     * @return [type] [description]
     */
    public function startDate($course_id = '')
    {
        $metadata=$this->metadata($course_id);
        //echo "<pre>";print_r($metadata['start']);exit;
        if (@$metadata['start']) {
            /*
            if (preg_match("/^1970/", $this->metadata()['start'])) {
                return false;
            }
            */
            return strtotime($metadata['start']);
        }
        return false;
    }

    /**
     * Get the end fate, of a given coursse
     * @return [type] [description]
     */
    public function endDate($course_id = '')
    {
        $metadata=$this->metadata($course_id);
        if (isset($metadata['end'])) {
            return strtotime($metadata['end']);
        }
        return false;
    }



    /**
     * Return course 'display' name
     * @return [type] [description]
     */
    public function displayName($course_id = '')
    {

        $meta=$this->metadata($course_id);
        //return $data['definition']['metadata']['display_name'];
        if (isset($meta['display_name'])) {
            return $meta['display_name'];
        } else {
            return $course_id;
        }
    }


    /**
     * Return course enroll data
     * @return [type] [description]
     */
    /*
    public function enrollments()
    {
        $course_id=$this->org."/".$this->course."/".$this->name;
        $sql = "SELECT * FROM edxapp.student_courseenrollment WHERE course_id=$course_id; ";

    }
    */


    /**
     * Update the course Display Name
     * @param  string $str [description]
     * @return [type]      [description]
     */
    public function updateDisplayName($str = '')//break!!!
    {
        $collection = $this->mgdb->edxapp->modulestore;
        //$data=$this->category("metadata");//nope
        $filter=["_id.course"=>$this->course, '_id.org'=>$this->org, "_id.category"=>"course"];
        $data=$this->modulestore->findOne($filter);//, ["_id"=>0]
        //echo "data:";print_r($data);exit;

        $data['metadata']['display_name']=$str;//overwrite
        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        return $collection->update($filter, $data);
    }


    public function updateMetadata(array $dat)
    {
        $collection = $this->mgdb->edxapp->modulestore;
        //$data=$this->category("metadata");//nope
        $filter=["_id.course"=>$this->course, '_id.org'=>$this->org, "_id.category"=>"course"];
        $data=$this->modulestore->findOne($filter);//, ["_id"=>0]
        $data['metadata']=$dat;
        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        return $collection->update($filter, $data);
    }


    /**
     * Course dates (in metadata)
     */


    /**
     * Date must be in ISO format (YYYY-mm-dd)
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public function updateCourseStartDate($date = '')
    {
        //echo __FUNCTION__."($date)\n";
        //$date=trim($date);
        
        // format date as ISO
        if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
            $date=implode("-", array_reverse(explode("/", $date)));
        }

        if (is_string($date)) {
            $date=strtotime("$date");
        }


        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        $data=$this->modulestore->findOne($filter);
        $data['metadata']['start']=date('c', $date);
        return $this->modulestore->update($filter, $data);
    }

    public function updateCourseEndDate($date)
    {
        //$collection = $this->mgdb->edxapp->modulestore;
        //$data=$this->category("metadata");
        
        // format date as ISO
        if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
            $date=implode("-", array_reverse(explode("/", $date)));
        }

        if (is_string($date)) {
            $date=strtotime($date);
        }
        /*
        if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
            $date=implode("-", array_reverse(explode("/", $date)));
        }
        */
        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        $data=$this->modulestore->findOne($filter);
        $data['metadata']['end']=date('c', $date);
        return $this->modulestore->update($filter, $data);
    }



    public function updateEnrollStartDate($date = '')
    {
        
        // format date as ISO
        if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
            $date=implode("-", array_reverse(explode("/", $date)));
        }

        if (is_string($date)) {
            $date=strtotime("$date");
        }

        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        $data=$this->modulestore->findOne($filter);
        $data['metadata']['enrollment_start']=date('c', $date);
        return $this->modulestore->update($filter, $data);
    }

    public function updateEnrollEndDate($date = '')
    {
        // format date as ISO
        if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
            $date=implode("-", array_reverse(explode("/", $date)));
        }

        if (is_string($date)) {
            $date=strtotime("$date");
        }
        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'course'];
        $data=$this->modulestore->findOne($filter);
        $data['metadata']['enrollment_end']=date('c', $date);
        return $this->modulestore->update($filter, $data);
    }







    /**
     * Return course short description
     * @return [type] [description]
     */
    public function shortDescription($course_id = '')
    {
        if ($course_id) {
            $x=explode("/", $course_id);
            $filter=['_id.org'=>$x[0], "_id.course"=>$x[1],  "_id.name"=>"short_description"];
        } else {
            $filter=["_id.course"=>$this->course, '_id.org'=>$this->org, "_id.name"=>"short_description"];
        }
        //["_id.course"=>$this->course, '_id.org'=>$this->org, "_id.name"=>"short_description"]
        $data=$this->modulestore->findOne($filter, ["_id"=>0, "metadata"=>0]);//
        if (!isset($data['definition']['data']['data'])) {
            return false;
        }
        return $data['definition']['data']['data'];
    }


    /**
     * Update Course ShortDescription
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public function updateShortDescription($str)
    {

        if (!$this->org || !$this->course) {
            return false;
        }
        //echo "updateShortDescription($str)\n";
        //$collection = $this->mgdb->edxapp->modulestore;
        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'about', '_id.name'=>'short_description'];
        $found=$this->modulestore->findOne($filter);
        if (!$found) {
            $dat=[];
            $dat["_id"]["tag"]="i4x";
            $dat["_id"]["org"]=$this->org;
            $dat["_id"]["course"]=$this->course;
            $dat["_id"]["category"]="about";
            $dat["_id"]["name"]="short_description";
            $dat["_id"]["revision"]=null;
            $dat["definition"]["data"]["data"]=$str;
            $dat["metadata"]=[];
            return $this->modulestore->insert($dat);
        } else {
            $value["definition"]["data"]["data"] = $str;
            return $this->modulestore->update($filter, $value);
        }
        return false;
    }



    /**
     * Return the course metadata
     * @param  [type] $course [description]
     * @return [type]         [description]
     */
    public function metadata($course_id = '')
    {
        if ($course_id) {
            $x=explode("/", $course_id);
            $filter=['_id.org'=>$x[0], "_id.course"=>$x[1],  "_id.category"=>"course"];
        } else {
            $filter=["_id.course"=>$this->course, '_id.org'=>$this->org, "_id.category"=>"course"];
        }

        $data=$this->modulestore->findOne($filter);//, ["_id"=>0]
        return $data['metadata'];
    }




    /**
     * Return list of static tabs
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function staticTab($id)
    {
        $collection = $this->mgdb->edxapp->modulestore;
        //"_id.course"=>$this->name, '_id.org'=>$this->org,
        $data=$collection->findOne(["_id.category"=>"static_tab", "_id.name"=>$id], ["_id"=>0]);
        return $data;
    }



    /**
     * Return course overview (html)
     * @return [type] [description]
     */
    public function overview()
    {
        $collection = $this->mgdb->edxapp->modulestore;
        $course = $this->course;
        $org= $this->org;
        $data=$collection->findOne(["_id.course"=>$course, '_id.org'=>$org, "_id.name"=>"overview"]);//, ["_id"=>0, "metadata"=>0]
        if (!isset($data['definition']['data']['data'])) {
            return "";
        }
        return $data['definition']['data']['data'];
    }


    /**
     * [updateOverview description]
     * @param  string $html [description]
     * @return [type]       [description]
     */
    public function updateOverview($html = '')
    {
        if (!$html) {
            return false;
        }

        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'about', '_id.name'=>'overview'];
        $value["definition"]["data"]["data"] = $html;
        return $this->modulestore->update($filter, $value);
    }


    /**
     * Return course overview (html)
     * @return [type] [description]
     */
    public function video($course_id = '')
    {
        
        if ($course_id) {
            $x=explode('/', $course_id);
            $filter=['_id.org'=>$x[0], '_id.course'=>$x[1],  '_id.name'=>'video'];
        } else {
            $filter=['_id.org'=>$this->org, '_id.course'=>$this->course, '_id.name'=>'video'];
        }
        
        $data=$this->modulestore->findOne($filter);//, ["_id"=>0, "metadata"=>0]
        if (!isset($data['definition']['data']['data'])) {
            return false;
        }
        return $data['definition']['data']['data'];
    }


    /**
     * Return course desc. youtube id
     * @return [type] [description]
     */
    public function youtubeid($course_id = '')
    {
        $html=$this->video($course_id);
        //echo htmlentities($html);
        if (preg_match("/\bembed\/([a-z0-9_-]{10,})/i", $html, $o)) {
            return $o[1];
        }
        return false;
    }


    /**
     * Update course presentation video
     * Cam Also Delete the video, if no params is given
     * @param  string $youtubeid [description]
     * @return [type]            [description]
     */
    public function updateVideo($youtubeid = '')
    {

        //https://www.youtube.com/watch?v=7plyf0qMoo0
        //https://www.youtube.com/watch?v=oimLClJ0pMM
        if (preg_match("/\/watch\?v=([a-z0-9_-]{10,})/i", $youtubeid, $o)) {
            $youtubeid=$o[1];
        }

        //echo "youtubeid=".htmlentities($youtubeid);exit;

        $html=[];
        $html[]="<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/".$youtubeid."?rel=0\" frameborder=\"0\" allowfullscreen=\"\">";
        $html[]="</iframe>";

        $filter=['_id.course' => $this->course, '_id.org'=>$this->org, '_id.category'=>'about', '_id.name'=>'video'];
        $del=$this->modulestore->remove($filter);//delete previous video if any

        if ($youtubeid) {
            $dat=[];
            $dat["_id"]["tag"]="i4x";
            $dat["_id"]["org"]=$this->org;
            $dat["_id"]["course"]=$this->course;
            $dat["_id"]["category"]="about";
            $dat["_id"]["name"]="video";
            $dat["_id"]["revision"]=null;
            $dat["definition"]["data"]["data"]=implode("", $html);
            return $this->modulestore->insert($dat);
        }
        //$value["definition"]["data"]["data"] = implode("", $html);
        return true;
    }


    /**
     * Update course image (copy de updateDisplayName)
     * @param  string $filename [description]
     * @return [type]           [description]
     */
    public function updateImage($filename = '')
    {
        $collection = $this->mgdb->edxapp->modulestore;
        $course = $this->course;
        $org= $this->org;

        //we should verify that file exist here

        //then we can update
        $meta=$this->metadata();
        $meta['course_image']=$filename;
        $filter=['_id.course' => $course, '_id.org'=>$org, '_id.category'=>'course'];//, '_id.name'=>'2014'
        $value["metadata"] = $meta;
        return $collection->update($filter, $value);
        //$meta['course_image'];
    }





    // Course unit //
    // Course unit //
    // Course unit //

    public function unit($unit_id)
    {
        if (!preg_match("/^i4x/", $unit_id)) {
            return false;
        }

        $ids=explode("/", $unit_id);

        // i4x://q/q/sequential/2795f34a935447db93bc4362bc84e1d7
        //
        $org=$ids[2];
        $course=$ids[3];
        $category=$ids[4];
        $name=$ids[5];

        $filter=["_id.org"=>$org, "_id.course"=>$course, "_id.name"=>$name];

        return $this->modulestore->findOne($filter);


    }


    /**
     * Return a course unit parent
     * @param  [type] $unit_id [description]
     * @return [type]          [description]
     */
    public function unitParent($unit_id)
    {
        $filter=["definition.children"=>$unit_id];
        $dat=$this->modulestore->findOne($filter);
        //return $dat;
        //reconstruct unit id if possible
        if ($dat) {
            $ID=$dat['_id'];
            return "i4x://".$ID['org'].'/'.$ID['course'].'/'.$ID['category'].'/'.$ID['name'];
        }
        return false;
    }


    /**
     * Return a course unit childrens
     * @param  [type] $unit_id [description]
     * @return [type]          [description]
     */
    public function unitChildrens($unit_id)
    {
        if (!preg_match("/^i4x/", $unit_id)) {
            return false;
        }

        $ids=explode("/", $unit_id);
        $org=$ids[2];
        $course=$ids[3];
        $category=$ids[4];
        $name=$ids[5];
        $filter=["_id.org"=>$org, "_id.course"=>$course, "_id.name"=>$name];
        $dat=$this->modulestore->findOne($filter);
        return $dat['definition']['children'];
    }


    /**
     * Return a course unit name
     * @param  [type] $unit_id [description]
     * @return [type]          [description]
     */
    public function unitName($unit_id)
    {
        if (!preg_match("/^i4x/", $unit_id)) {
            return false;
        }

        $ids=explode("/", $unit_id);
        $org=$ids[2];
        $course=$ids[3];
        $category=$ids[4];
        $name=$ids[5];

        $filter=["_id.org"=>$org, "_id.course"=>$course, "_id.name"=>$name];

        $dat=$this->modulestore->findOne($filter);
        if (isset($dat['metadata']['display_name']) && $dat['metadata']['display_name']) {
            return $dat['metadata']['display_name'];
        } else {
            return $unit_id;
        }
    }


    /**
     * Return the number of courseunits for a given course
     * @param  string $courseid [description]
     * @return int           [description]
     */
    public function unitCount($courseid = '')
    {
        if ($courseid && preg_match("/([a-z 0-9\/\._-]+)/i", $courseid, $o)) {
            $o=explode("/", $courseid);
            $org=$o[0];
            $course=$o[1];
            $name=$o[2];
            $filter=['_id.org'=>$org,'_id.course'=>$course];
        } else {
            $filter=['_id.org'=>$this->org,'_id.course'=>$this->course];
        }
        $units=$this->modulestore->find($filter);
        return $units->count();//todo :: imp
    }

    public function units($course_id = '')
    {
        if ($course_id && preg_match("/([a-z 0-9\/\._-]+)/i", $course_id, $o)) {
            $o=explode("/", $course_id);
            $filter=['_id.org'=>$o[0],'_id.course'=>$o[1]];
        } else {
            $filter=['_id.org'=>$this->org,'_id.course'=>$this->course];
        }
        $units=$this->modulestore->find($filter);
        return $units;
    }



    /**
     * Return he list of chapters
     * @return [type] [description]
     */
    public function chapters($courseid = '')
    {

        if ($courseid && preg_match("/([a-z 0-9\/\._-]+)/i", $courseid, $o)) {
            $o=explode("/", $courseid);
            $org=$o[0];
            $course=$o[1];
            $name=$o[2];
            $filter=['_id.org'=>$org,'_id.course'=>$course, '_id.category'=>'course'];
        } else {
            $filter=['_id.org'=>$this->org,'_id.course'=>$this->course, '_id.category'=>'course'];//'_id.name'=>$this->name,
        }
        //print_r($filter);
        $course=$this->modulestore->findOne($filter);

        if (!isset($course['definition'])) {
            return false;
        }

        $chapters=[];
        $sections = $course['definition']['children'];
        foreach ($sections as $section_id) {
            $chapters[]=[$section_id, $this->unitName($section_id)];
        }
        return $chapters;
    }


    /**
     * Return the chapter name
     * @param  string $chapterId [description]
     * @return [type]            [description]
     */
    public function chapterName($chapterId = '')
    {
        //echo "chapterName($chapterId);\n";
        
        $filter=['_id.category'=>'chapter', '_id.name'=>$chapterId];
        if ($r=$this->modulestore->findOne($filter)) {
            return $r['metadata']['display_name'];
        }
        return false;
    }



    /**
     * Delete one course from mongodbd collection
     * @param  string $course_id [description]
     * @return bool              [description]
     */
    public function delete($course_id = '')
    {

        if ($course_id && preg_match("/([a-z 0-9\/\._-]+)/i", $course_id, $o)) {
            $o=explode("/", $course_id);
            $org=$o[0];
            $course=$o[1];
            //$name=$o[2];
            $filter=['_id.org'=>$org,'_id.course'=>$course];
        } else {
            return false;
        }

        // delete course data
        $del = $this->modulestore->remove($filter);

        if (!$del) {
            return false;
        }

        // delete associated files
        $gridfs = $this->mgdb->edxapp->getGridFS();
        $files=$gridfs->find(["_id.course"=>$this->course, "_id.org"=>$this->org]);

        $deleted=0;
        foreach ($files as $file) {
            $ID = $file->file['_id'];
            $del = $gridfs->delete($ID);

            // Get lastError array
            // http://www.lightcubesolutions.com/blog/?p=257
            /*
            $errorArray = $db->lastError();
            if ($errorArray['ok'] == 1 ) {
                $retval = true;
            }else{
                //Send back the error message
                $retval = $errorArray['err'];
            }
            */

            $deleted++;
        }
        //echo "$deleted deleted file(s);\n";

        // at this point, we should delete course enrollment data in edxapp.student_courseenrollment
        

        // also we should delete forum data :
        //$del = $this->mgdb->cs_comments_service_development->remove(["course_id"=>"eeX/ee101/2014_t2"]);
        
        return true;
    }
}
