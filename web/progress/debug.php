<?php
// debug table //

//$progressData=$edxapp->courseUnitData($course_id, $user_id);
foreach ($edxApp->courseUnitData($course_id, $user_id) as $r) {
    unset($r['id']);
    unset($r['course_id']);
    unset($r['student_id']);
    unset($r['done']);
    unset($r['state']);
    unset($r['grade']);
    unset($r['max_grade']);
    //echo "<pre>";print_r($r);echo "</pre>";
    $progressData[]=$r['module_id'];   
    
}

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


foreach ($sections as $section_id) {

    // Chapters
    
    echo "<li><i class='fa fa-user'></i> <a href=../course_chapter/?id=$section_id>".ucfirst(strtolower($edxCourse->unitName($section_id)))."</a>\n";//<small>$section_id</small>
    
    //echo $admin->box("",$edxCourse->unitName($section_id),[],[]);
    //echo "<hr />";
    
    $sequence=$edxCourse->unitChildrens($section_id);

    echo "<table class='table table-condensed table-striped'>";
    echo "<thead><th width=16>ico</th><th>name</th></thead>";
    foreach ($sequence as $sequence_id) {
        $ICO='';
        if(in_array($sequence_id, $progressData))$ICO="<i class='fa fa-circle-o' style='color:green'></i>";
        echo "<tr>";
        echo "<td>".$ICO;//ico
        echo "<td>".ucfirst(strtolower($edxCourse->unitName($sequence_id)));
        
        //echo "<i class=muted>$sequence_id</i>";//
        //echo "</td>\n";// <span class='label label-info'>$sequence_id</span>
        //$seen=0;
        
        

        $problems=[];

        $verticals=$edxCourse->unitChildrens($sequence_id);
        
        

        
        //echo " - <i>".count($verticals)." verts</i>";

        foreach ($verticals as $vertical_id) {
            $ICO='';
            if(in_array($vertical_id, $progressData))$ICO="<i class='fa fa-circle-o' style='color:green'></i>";

            echo "<tr>";
            echo "<td>".$ICO;//ico
            echo "<td>".$edxCourse->unitName($vertical_id)."<br />\n";
            
            $childrens=$edxCourse->unitChildrens($vertical_id);
            
            
            //echo " - <i>".count($childrens)."childs</i>";
            
            
            
            foreach ($childrens as $children_id) {
                $ICO='';
                if(in_array($children_id, $progressData))$ICO="<i class='fa fa-circle-o' style='color:green'></i>";
                echo "<tr>";
                echo "<td>".$ICO;//ico
                echo "<td>children ".$edxCourse->unitName($children_id)."<br />\n";

                

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
        
        
        //echo "<td>";
        //echo "</td>";

        //echo "<td width=50>";//icon progress
        //if(in_array(needle, haystack))
        //echo "<i class='fa fa-circle-thin pull-right'></i>";// seen
        //echo "<i class='fa fa-check-circle pull-right' style='color:#00cc00'></i>";// seen

        echo "</tr>";
    }
    echo "</table>";
}
