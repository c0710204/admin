<?php
// course structure
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->ctrl();

$edxCourse= new EdxCourse();


$course_id=$_POST['courseid'];

echo "<a href='../course/?id=".$course_id."'>$course_id</a><hr />";

//print_r($_POST);
/*
$modulestore=$edxCourse->modulestore;
$c=explode("/", $_POST['courseid']);
$org=$c[0];
$course=$c[1];
$name=$c[2];
*/

$chapters=$edxCourse->chapters($_POST['courseid']);
//echo "<pre>";
if (is_array($chapters)) {
    echo count($chapters)." chapters:\n";
    $i=1;
    foreach ($chapters as $chapter) {
        //echo "<li>".$chapter[1];
        echo "<a href=# class='list-group-item active'><b>$i :: ".$chapter[1]."</b></a>";
        echo "<ul class='list-group'>";
        $sequence=$edxCourse->unitChildrens($chapter[0]);
        foreach ($sequence as $sequence_id) {
            //echo " - ".$edxCourse->unitName($sequence_id)."\n";
            echo "<li class='list-group-item'>";

            echo $edxCourse->unitName($sequence_id);
            $verticals=$edxCourse->unitChildrens($sequence_id);
            echo "<span class=badge>".count($verticals)."</span>";
                echo "<ul>";
                foreach ($verticals as $vertical) {
                    echo "<li><a href='../course_unit/?id=".$vertical."'>".$edxCourse->unitName($vertical)."</a></li>";
                }
                //echo "<li>2</li>";
                echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
        $i++;
    }
} else {
    echo "Error: No data";
}
//echo "</pre>";
