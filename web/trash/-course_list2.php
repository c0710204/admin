<?php
// List of courses :
// echo "<h2>Distinct Courses</h2>";

$ids=$edxapp->courseids();// get the lst of courses
//print_r($o);

$HTM=[];

$HTM[]='<ul class="todo-list ui-sortable">';
foreach ($o as $org => $courses) {
    //echo "<li><a href='../course/?course=$v'>$v</a>";
    foreach ($courses as $course) {

        $HTM[]='<li>';
        $HTM[]='<span class="handle">';
        $HTM[]='<i class="fa fa-ellipsis-v"></i>';
        $HTM[]='<i class="fa fa-ellipsis-v"></i>';
        $HTM[]='</span>';
        $HTM[]='<span class="text">'.$course.'</span>';
        $HTM[]='<small class="label label-info">'.$org.'</small>';
        $HTM[]='<div class="tools">';
        $HTM[]='<i class="fa fa-edit"></i>';
        $HTM[]='<i class="fa fa-trash-o"></i>';
        $HTM[]='</div>';
        $HTM[]='</li>';

    }
}

$HTM[]='</ul>';


echo $admin->box("danger", "Courses", $HTM, "Delete button");
?>
<script>

</script>