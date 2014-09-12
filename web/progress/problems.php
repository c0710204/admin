<?php
// problems //


$modulestore=$edxCourse->modulestore;

$filter=['_id.org'=>'edX','_id.course'=>'Open_DemoX', '_id.name'=>'edx_demo_course', '_id.category'=>'course'];
$course=$modulestore->findOne($filter);
//echo "<pre>";print_r($course);

$sections = $course['definition']['children'];

foreach ($sections as $section_id) {

    // Chapters
    echo "<h2>".$edxCourse->unitName($section_id)."</h2>\n";//<small>$section_id</small>
    //echo $admin->box("",$edxCourse->unitName($section_id),[],[]);

    echo "<hr />";
    
    $sequence=$edxCourse->unitChildrens($section_id);

    foreach ($sequence as $sequence_id) {
        
        //echo "<br />";
        echo "<h4>".$edxCourse->unitName($sequence_id)."</h4>\n";// <span class='label label-info'>$sequence_id</span>
        
        $problems=[];

        $verticals=$edxCourse->unitChildrens($sequence_id);
        
        foreach ($verticals as $vertical_id) {
            //echo "<li>".$edxCourse->unitName($vertical_id)."<br />\n";
            $childrens=$edxCourse->unitChildrens($vertical_id);
            

            foreach ($childrens as $children_id) {
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

        if (count($problems)) {
            //print_r($problems);
            foreach($problems as $problem_id){
                echo "<li><a href='../course_unit/?id=$problem_id'>".$edxCourse->unitName($problem_id)."</a></li>\n";
            }
        } else {
            echo "<li>No problem scores in this section</li>";
        }

    }
}
