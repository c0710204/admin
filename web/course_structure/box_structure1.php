<?php
// Course structure:
// first, the mother
$modulestore=$edxCourse->modulestore;

$filter=['_id.org'=>'q','_id.course'=>'q', '_id.name'=>'q', '_id.category'=>'course'];
$course=$modulestore->findOne($filter);
echo "<pre>";print_r($course);

$sections = $course['definition']['children'];

foreach ($sections as $section_id) {

    // Chapters
    echo "<h2>".$edxCourse->unitName($section_id)." <small>$section_id</small></h2>\n";

    //echo $admin->box("",$edxCourse->unitName($section_id),[],[]);

    echo "<hr />";
    $sequence=$edxCourse->unitChildrens($section_id);

    foreach ($sequence as $sequence_id) {
        echo "<br />";
        echo "<h4>".$edxCourse->unitName($sequence_id)." <span class='label label-info'>$sequence_id</span></h4>\n";
        $verticals=$edxCourse->unitChildrens($sequence_id);
        foreach ($verticals as $vertical_id) {
            echo "<li>".$edxCourse->unitName($vertical_id)." <span class='label label-default'>$vertical_id</span>\n";
            $childrens=$edxCourse->unitChildrens($vertical_id);
            var_dump($childrens);
        }
    }
}
