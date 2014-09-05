<?php
// course enrollments



//echo "<li>count=$count<br />";


/**
 * [enrolled description]
 * @param  string $course_id [description]
 * @return [type]            [description]
 */
function enrolled($course_id = '')
{
    global $admin;
    $sql="SELECT * FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id';";
    $q=$admin->db()->query($sql) or die("<pre>".print_r($admin->db()->errorInfo(), true)."</pre>");
    $dat=[];
    while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
        $dat[]=$r;
    }
    return $dat;
}




$htm=[];

$enrolled=enrolled($course_id);
$unitCount=$edxCourse->unitCount();


if (count($enrolled)) {

    $htm[]="<table class='table table-condensed table-striped'>";
    $htm[]="<thead>";
    $htm[]="<th>#</th>";
    $htm[]="<th>User</th>";
    $htm[]="<th width=50>Progress</th>";
    $htm[]="<th>Date</th>";
    $htm[]="</thead>";

    $htm[]="<tbody>";
    foreach ($enrolled as $r) {
        $htm[]="<tr>";
        $htm[]="<td width=50>".$r['user_id'];//print_r($r, 1);
        $htm[]="<td><a href='../user/?id=".$r['user_id']."'>".$edxapp->username($r['user_id'])."</a>";//print_r($r, 1);
        $progress=($edxapp->courseUnitSeen($course_id, $r['user_id'])/$unitCount)*100;
        $htm[]="<td class='text-right'><a href=../progress/?user_id=".$r['user_id']."&course_id=$course_id>".round($progress).'%';
        $htm[]="<td width=150>".substr($r['created'], 0, 16);
    }

    $htm[]="</tbody>";
    $htm[]="</table>";

} else {
    $htm[]="<pre>No enrollment</pre>";
}

$footer=[];
$footer[]="<button class='btn btn-default' onclick='enrollUser()'><i class='fa fa-rocket'></i> Enroll user</button> ";
$footer[]="<button class='btn btn-default' onclick='enrollModal()'><i class='fa fa-rocket'></i> Modal</button> ";
$footer[]="<span id=moreEnroll></span>";

//echo "<pre>".print_r($meta, true)."</pre>";
$box=new Admin\SolidBox;
//$box->type("danger");
$box->icon('fa fa-user');
$box->title("Enrollments <small>".$edxapp->courseEnrollCount($course_id)." Enrollments</small>");
$box->body($htm);
$box->footer($footer);
echo $box->html();

?>
<script>
function enrollUser()
{
    var uid=prompt("Enter user id to enroll");
    if(!uid)return false;

    var p={
        'do':'enroll',
        'course_id':$('#course_id').val(),
        'user_id':uid
    };

    $("#moreEnroll").load('ctrl.php',p,function(x){

    });
}

function enrollModal()
{
    console.log('enrollModal()');
    $('#myModal').modal({'show':true});
}

</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-file'></i> Enroll users</h4>
      </div>
      <div class="modal-body">
        Add some stuff here
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-ban'></i> Cancel</button>
        <button type="button" class="btn btn-primary"><i class='fa fa-save'></i> Enroll</button>
      </div>
    </div>
  </div>
</div>
