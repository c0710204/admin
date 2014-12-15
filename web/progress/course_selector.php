<?php
// Course selector
// list of courses //


// echo "User id : <a href=../user/?id=$user_id>$user_id</a>";
// $ids=$edxapp->courseids();// get the complete list of courses
$ids=$edxApp->studentCourseEnrollment($user_id);//get the list of courses the user is registered in

//print_r($ids);

$html=[];

$html[]="$username is enrolled in ".count($ids)." course(s) :";

$html[]="<select id=courses class='form-control'>";
foreach($ids as $r){
    $course_id=$r['course_id'];
    $course_name=ucfirst(strtolower($edxCourse->displayName($r['course_id'])));
    $html[]="<option value='".$r['course_id']."'>".$course_name."</option>";
}
$html[]="</select>";

$foot="<a href=# class='btn btn-default' id='btnSelectCourse'><i class='fa fa-arrow-right'></i> Select course</a>";



echo "<div class=row>";

// left column
echo "<section class='col-xs-6 connectedSortable'>";
$box=new Admin\SolidBox;
$box->type("danger");
$box->icon("fa fa-book");
$box->title("Select course");
echo $box->html($html,$foot);
echo "</section>";


// right col (free space)
echo "<section class='col-xs-6 connectedSortable'>";
echo "</section>";

echo "</div>";

?>
<script>
$(function(){
    $('#btnSelectCourse').click(function(){
        console.log('selectCourse()',$('#user_id').val(),$('#courses').val());
        document.location.href='?user_id='+$('#user_id').val()+'&course_id='+$('#courses').val();
    });
});
</script>
<?php
exit;