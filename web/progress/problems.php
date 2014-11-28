<?php
// problems //

//$progressData=$edxapp->courseUnitData($course_id, $user_id);
foreach ($edxApp->courseUnitData($course_id, $user_id) as $r) {
    @$progressData[$r['module_id']]=$r['module_id'];   
    //echo "<pre>";print_r($r);echo "</pre>";
}

//echo "<pre>";print_r($progressData);echo "</pre>";
//exit;
//print_r($_GET);

$x=explode("/", $_GET['course_id']);

$modulestore=$edxCourse->modulestore;

$filter=['_id.org'=>$x[0],'_id.course'=>$x[1], '_id.name'=>$x[2], '_id.category'=>'course'];
$course=$modulestore->findOne($filter);
//echo "<pre>";print_r($course);

$sections = $course['definition']['children'];

//var_dump($sections);exit;

echo "<h2>Problems</h2>";

foreach ($sections as $section_id) {

    // Chapters
    
    echo "<i class='fa fa-user'></i> <a href=../course_chapter/?id=$section_id>".ucfirst(strtolower($edxCourse->unitName($section_id)))."</a>\n";//<small>$section_id</small>
    
    //echo $admin->box("",$edxCourse->unitName($section_id),[],[]);
    //echo "<hr />";
    
    $sequence=$edxCourse->unitChildrens($section_id);

    echo "<table class='table table-condensed table-striped'>";
    
    foreach ($sequence as $sequence_id) {
        
        echo "<tr>";
        echo "<td>".ucfirst(strtolower($edxCourse->unitName($sequence_id)));
        
        //echo "<i class=muted>$sequence_id</i>";//
        //echo "</td>\n";// <span class='label label-info'>$sequence_id</span>
        $seen=0;
        if(in_array($sequence_id, $progressData))echo "<li>seq seen!";

        $problems=[];

        $verticals=$edxCourse->unitChildrens($sequence_id);
        
        

        
        echo " - <i>".count($verticals)." verts</i>";

        foreach ($verticals as $vertical_id) {
            //echo "<li>".$edxCourse->unitName($vertical_id)."<br />\n";
            $childrens=$edxCourse->unitChildrens($vertical_id);
            
            echo " - <i>".count($childrens)."childs</i>";
            
            if(in_array($vertical_id, $progressData))echo "<li>vert seen!";
            
            foreach ($childrens as $children_id) {
                
                if(in_array($children_id, $progressData))echo "<li>child seen!";

                $u=explode('/', $children_id);
                $type=$u[4];
                
                if ($type=='problem') {
                    //echo "<li>".$edxCourse->unitName($children_id)."\n";
                    $problems[]=$children_id;
                } else {
                    //echo "$type,";
                }
            }
        }
        
        
        echo "<td>";

        if (count($problems)) {
            //print_r($problems);
            foreach ($problems as $problem_id) {
                $unitName=$edxCourse->unitName($problem_id);
                /*
                if (!$unitName) {
                    $unitName=$problem_id;
                }
                */
                echo "<li><a href='../course_unit/?id=$problem_id'>".$unitName."</a></li>\n";
            }
        } else {
            //echo "<i class=muted>No problem score</i>";
            echo "<i class='fa fa-times' title='No problem score'></i>";
        }
        echo "</td>";

        echo "<td width=50>";//icon progress
        //if(in_array(needle, haystack))
        echo "<i class='fa fa-circle-thin pull-right'></i>";// seen
        echo "<i class='fa fa-check-circle pull-right' style='color:#00cc00'></i>";// seen

        echo "</tr>";
    }
    echo "</table>";
}
