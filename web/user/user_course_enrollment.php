<?php
// User courses enrolment

//$courses=$edxApp->studentCourseEnrollment($USERID);

$body=[];
$body[]="Please wait";
/*
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
*/

$footer=[];
$footer[]="<a href=# class='btn btn-default' id=btnEnroll><i class='fa fa-arrow-right'></i> Enroll</a>";
/*
$footer[]="<div class=row>";
$footer[]='<div class="col-sm-9">';
$footer[]="<select id=course class='form-control'>";
$footer[]="<option value=''>Select course to enroll</option>";
foreach ($edxApp->courseids() as $courseId) {
    $footer[]="<option value='$courseId'>".ucfirst(strtolower($edxApp->courseName($courseId)))."</option>";
}
$footer[]="</select>";
$footer[]="</div>";
*/
//$footer[]='<div class="col-sm-6">';
//$footer[]="<a href=#enroll class='btn btn-default pull-right' id=btnEnroll><i class='fa fa-arrow-right'></i> Enroll</a>";
////$footer[]="</div>";

//$footer[]="</div>";

$title="Course enrollment";//student_courseenrollment

$box=new Admin\SolidBox;
$box->id("boxEnroll");
$box->icon("fa fa-book");
$box->title($title);
$box->body_padding(false);
$box->loading(true);
echo $box->html($body, $footer);
?>


<script>
function enroll(course_id){
    //var course_id=$('#course').val();
    
    if(!course_id)return false;
	if(!confirm("Enroll with "+course_id+" ?"))return false;
	
    $('#myModal').modal('hide');// hide modal window

    var p={'do':'enroll','user_id':$('#userid').val(),'course_id':course_id}
    $('#boxEnroll .box-body').load("ctrl.php", p, function(x){
        try{eval(x);}
        catch(e){alert(x);}
    })
}

function disEnroll(course_id){
	
    if(!confirm("Remove enrollment " + course_id + " ?")){
        return false;
	}

    var p = {
        'do':'disenroll',
        'user_id':$('#userid').val(),
        'course_id':course_id
    }
    
    $("#boxEnroll .overlay, #boxEnroll .loading-img").show();
    $('#boxEnroll .box-body').load("ctrl.php", p, function(x){
        try{
            eval(x);
        }
        catch(e){
            alert(x);
        }
        $("#boxEnroll .overlay, #boxEnroll .loading-img").hide();
    })
}


function getEnrolls(){
    
    var p = {
        'do':'enrollList',
        'user_id':$('#userid').val()
    };
    
    $("#boxEnroll .overlay, #boxEnroll .loading-img").show();
    $('#boxEnroll .box-body').load("ctrl.php",p,function(x){
        
        try{
            var dat=eval(x);    
            //console.log(dat.length+" records", dat);
            dispEnroll(dat);
        }
        catch(e){
            console.log(e);
        }    
        $("#boxEnroll .overlay, #boxEnroll .loading-img").hide();
    });
}

function dispEnroll(dat){
    var user_id=$('#userid').val();
    var htm=[];
    htm.push("<table class='table table-condensed table-striped'>");
    htm.push("<thead>");
    htm.push("<th>Course</th>");
    htm.push("<th>Progress</th>");
    //htm.push("<th>Created</th>");
    htm.push("<th>x</th>");
    htm.push("</thead>");
    htm.push("<tbody>");
    for(var i=0;i<dat.length;i++){
        htm.push("<tr>");
        htm.push("<td><a href='../course/?id="+dat[i].course_id+"'>"+dat[i].name);
        htm.push("<td style='text-align:right'><a href='../progress/?user_id="+user_id+"&course_id="+dat[i].course_id+"'>"+dat[i].progress+"%</a>");
        //htm.push("<td>"+dat[i].created);
        htm.push("<td><a href=# onclick=disEnroll('"+dat[i].course_id+"'); title='DisEnroll'><i class='fa fa-trash-o'></i></a></td>");
        htm.push("</tr>");
    }
    htm.push("</tbody>");
    htm.push("</table>");
    
    if(dat.length>0){
        htm.push("&nbsp;<i class='text-muted'>"+dat.length+" enrollment(s)</i>");
    } else{
        htm.push("<br />&nbsp;<i class='fa fa-warning' style='color:#c00'></i> No course enrollment<br /><br />");
    }
    $('#boxEnroll .box-body').html(htm.join(''));
    $('#tileEnroll h3').text(dat.length);
}


$(function(){
    $('#btnEnroll').click(function(){
        //enroll();
        $('#myModal').modal();
    });
    $('a[href="#enroll"]').click(function(o){
        //console.log(o,o.target,o.target.title);
        var course_id=o.target.title;
        //console.log(course_id);
        enroll(o.target.title);
    });
    getEnrolls();
});
</script>