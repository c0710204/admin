<?php
// debug table //

//$progressData=$edxapp->courseUnitData($course_id, $user_id);
$stats=[];
foreach ($edxApp->courseUnitData($course_id, $user_id) as $r) {
    
    //echo "<pre>";print_r($r);echo "</pre>";
    
    @$stats[$r['module_type']]++;//compute user progress stats

    unset($r['id']);
    unset($r['course_id']);
    unset($r['student_id']);
    unset($r['done']);
    unset($r['state']);
    unset($r['grade']);
    unset($r['max_grade']);
    
    $progressData[]=$r['module_id'];   
}

//echo "<pre>user progress stats : ";print_r($stats);exit;

echo "<pre>";
echo "<li>".count($progressData)." progress records\n";
//print_r($progressData);
echo "</pre>";
//exit;
//print_r($_GET);

$x=explode("/", $_GET['course_id']);

$modulestore=$edxCourse->modulestore;

$filter=['_id.org'=>$x[0],'_id.course'=>$x[1], '_id.name'=>$x[2], '_id.category'=>'course'];
$course=$modulestore->findOne($filter);
//echo "<pre>";print_r($course);

$sections = $course['definition']['children'];

//var_dump($sections);exit;

echo "<h2>Debug</h2>";

$DEBUG=[];


// list of logged module types 
$allow=["chapter","course","problem","sequential","survey","video"];

foreach ($sections as $section_id) {// Chapters

    echo "<h3><i class='fa fa-bookmark-o'></i> <a href=../course_chapter/?id=$section_id>".ucfirst(strtolower($edxCourse->unitName($section_id)))."</a></h3>\n";//<small>$section_id</small>
    
    $sequence=$edxCourse->unitChildrens($section_id);

    echo "<table class='table table-condensed table-striped'>";
    echo "<thead>";
    echo "<th width=16>ico</th>";
    echo "<th width=100>type</th>";
    echo "<th>name</th>";
    echo "</thead>";
    echo "<tbody>";
    $SEEN=[];
    foreach ($sequence as $sequence_id) {        
        
        
        
        $ICO="<i class='fa fa-circle-o' style='color:#ccc'></i>";//default icon
        
        if (in_array($sequence_id, $progressData)) {
            $ICO="<i class='fa fa-check-circle' style='color:green'></i>";
            $SEEN[]=1;
        }else{
            $SEEN[]=0;
        }
        
        echo "<tr>";
        echo "<td>".$ICO;//ico
        echo "<td>seq";//type
        echo "<td>".ucfirst(strtolower($edxCourse->unitName($sequence_id)));
                
        foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {//verticals are only structure elements, they are not 'seen' or 'logged'
            foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
            
                $type=explode('/', $children_id)[4];
                
                if(!in_array($type, $allow))continue;// skip unwanted childrens
                
                $ICO="<i class='fa fa-circle-o' style='color:#ccc'></i>";//default icon

                if (in_array($children_id, $progressData)) {
                    $ICO="<i class='fa fa-check-circle' style='color:green'></i>";//seen icon
                    $SEEN[]=1;
                } else{
                    $SEEN[]=0;
                }

                
                echo "<tr>";
                echo "<td>".$ICO;//ico
                echo "<td>$type";//type
                echo "<td>".$edxCourse->unitName($children_id)."<br />\n";  

            }
        }
        echo "</tr>";
    }

    echo "</tbody>";
    echo "<tfoot>";
    echo "<tr>";
    echo "<td>".count($SEEN)."</td>";//
    echo "<td>Progress:</td>";//
    $PCT=(array_sum($SEEN)/count($SEEN))*100;
    echo "<td>".round($PCT)." %</td>";//
    echo "<td>progress</td>";//
    echo "</tfoot>";
    echo "</table>";
}
