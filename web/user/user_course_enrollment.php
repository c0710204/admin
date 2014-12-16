<?php
// User courses enrolment

$courses=$edxApp->studentCourseEnrollment($USERID);

$body=[];

if (count($courses)) {

    $body[]="<table class='table table-condensed table-striped'>";
    $body[]= "<thead>";
    //$body[]= "<th>Org</th>";
    $body[]= "<th><i class='fa fa-book'></i> Course</th>";
    $body[]= "<th>Progress</th>";
    $body[]= "<th width=100>Created</th>";
    $body[]= "<th width=30>x</th>";
    $body[]= "</thead>";
    $body[]= "<tbody>";
    
    foreach ($courses as $k => $r) {
        //print_r($r);
        $body[]= "<tr>";
        //$body[]= "<td>".$r['id'];
        //$body[]= "<td>".explode("/", $r['course_id'])[0];//org

        $body[]= "<td><a href=../course/?course_id=".$r['course_id']." title='".$r['course_id']."'>".ucfirst(strtolower($edxApp->courseName($r['course_id'])));

        if (!$edxCourse->exist($r['course_id'])) {
            $body[]= " <span class='label label-danger'>not found</span>";
        }

        $unitCount=$edxCourse->unitCount($r['course_id']);
        $progress=0;
        if ($unitCount > 0) {
            $progress=($edxApp->courseUnitSeen($r['course_id'], $USERID)/$unitCount)*100;
        }

        $body[]= "<td><a href='../progress/?course_id=".$r['course_id']."&user_id=$USERID'>".round($progress)."%";//progress
        $body[]= "<td>".substr($r['created'], 0, 10);
        $body[]= "<td><i class='fa fa-trash-o' onclick=disEnroll('".$r['course_id']."');></i>";
        $body[]= "</tr>";
    }
    $body[]= "</tbody>";
    $body[]= "</table>";

} else {
    $body[]="<i class='fa fa-warning' style='color:#c00'></i> <b>No course enrollment</b>";
}

$footer=[];


$footer[]="<div class=row>";

$footer[]='<div class="col-sm-9">';
$footer[]="<select id=course class='form-control'>";
$footer[]="<option value=''>Select course to enroll</option>";
foreach ($edxApp->courseids() as $courseId) {
    $footer[]="<option value='$courseId'>".ucfirst(strtolower($edxApp->courseName($courseId)))."</option>";
}
$footer[]="</select>";
$footer[]="</div>";


$footer[]='<div class="col-sm-3">';
$footer[]="<button class='btn btn-default pull-right' id=btnEnroll><i class='fa fa-arrow-right'></i> Enroll</button>";
$footer[]="</div>";

$footer[]="</div>";

$title=count($courses)." course enrollment";//student_courseenrollment

$box=new Admin\SolidBox;
$box->icon("fa fa-book");
$box->title($title);
//$box->collapsed(true);
echo $box->html($body, $footer);

?>
<div id='moreEnroll'></div>

<script>
function enroll(){
    var course_id=$('#course').val();
    if(!course_id)return false;
	if(!confirm("Enroll with "+course_id+" ?"))return false;
	var userid=$('#userid').val();
    $('#moreEnroll').load("ctrl.php",{'do':'enroll','user_id':userid,'course_id':course_id},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    })
}

function disEnroll(course_id){
	if(!confirm("Remove enrollment "+course_id+" ?"))return false;
	var userid=$('#userid').val();
    $('#moreEnroll').load("ctrl.php",{'do':'disenroll','user_id':userid,'course_id':course_id},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    })
}

$(function(){
    $('#btnEnroll').click(function(){
        enroll();
    });
});
</script>