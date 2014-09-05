<?php
//admin :: chapter
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$edxapp = new EdxApp();
$edxCourse = new EdxCourse();

$admin->title("Chapter");
echo $admin->printPrivate();


$unit_id=@$_GET['unit_id'];//chapter

$unitName=$edxCourse->unitName($unit_id);
$unit=$edxCourse->unit($unit_id);
$chapterName=$unit['metadata']['display_name'];

$ID=$unit['_id'];
$name=$unit['_id']['name'];
$category=$unit['_id']['category'];
$definition=$unit['definition'];
$metadata=$unit['metadata'];

$course_id = $ID['org'].'/'.$ID['course'].'/permanent';

if (!$unit_id) {
    die("Error");
}
?>
<section class="content-header">
    <h1><a href='../course/?course_id=<?php echo $course_id;?>'><i class='fa fa-book'></i></a> Chapter : <?php echo $unitName;?><small></small></h1>
</section>


<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        include "chapter_info.php";
        //include "chapter_structure.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        //include "chapter_location.php";
        //include "chapter_structure.php";
        include "chapter_structure2.php";
        ?>
    </section>
</div>