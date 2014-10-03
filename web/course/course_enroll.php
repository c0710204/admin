<?php
// course enrollments



//echo "<li>count=$count<br />";


/**
 * [enrolled description]
 * @param  string $course_id [description]
 * @return [type]            [description]
 */
/*
function enrolled($course_id = '')
{
    global $admin;
    $sql="SELECT * FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id' LIMIT 5;";
    $q=$admin->db()->query($sql) or die("<pre>".print_r($admin->db()->errorInfo(), true)."</pre>");
    $dat=[];
    while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
        $dat[]=$r;
    }
    return $dat;
}
*/



$htm=[];

$htm[]='<div class=row>';

$htm[]='<div class="col-lg-9">';
$htm[]='<div class="input-group">';
//$htm[]='<label>Search</label>';
$htm[]='<span class="input-group-addon"><i class="fa fa-search"></i></span>';
$htm[]='<input type="text" class="form-control" id="searchStr" placeholder="Search" value="">';
$htm[]='</div>';
$htm[]='</div>';


$htm[]='<div class="col-lg-3">';
$htm[]='<div class="form-group">';
//$htm[]='<label>Search</label>';
$htm[]='<input type="text" class="form-control" id="limit" placeholder="Limit" value="">';
$htm[]='</div>';
$htm[]='</div>';

$htm[]='</div>';//end rows

$htm[]='<div id=enrollTarget></div>';//target



$footer=[];
$footer[]="<button class='btn btn-default' onclick='enrollUser()'><i class='fa fa-rocket'></i> Enroll user</button> ";
$footer[]="<a href='../course_enrollments/?course_id=$course_id' class='btn btn-default'><i class='fa fa-external-link'></i> See all enrollments</a> ";
//$footer[]="<button class='btn btn-default' onclick='enrollModal()'><i class='fa fa-rocket'></i> Modal</button> ";
//$footer[]="<span id=moreEnroll></span>";

//echo "<pre>".print_r($meta, true)."</pre>";
$box=new Admin\SolidBox;
//$box->type("danger");
$box->id('boxenroll');
$box->icon('fa fa-user');
$box->title("Enrollments <small>".$edxapp->courseEnrollCount($course_id)." Enrollments</small>");
$box->collapsed(true);
$box->loading(true);
echo $box->html($htm, $footer);

?>
<script>

function getEnrollData(){
    
    console.log('getEnrollData()');
    
    $("#boxenroll .overlay, #boxenroll .loading-img").show();//loading
    
    var r=$.ajax({
        type: "POST",
        url: "ctrl.php",
        dataType: "json",
        data: {
            'do':'listEnroll',
            'course_id':$('#course_id').val(),
            'search':$('#searchStr').val(),
            'limit':$('#limit').val()
        }
    });

    r.done(function(json){
        
        console.log(json);
        //alert(json);
        
        /*
        $.each(json,function(k,v){
            //json[k].start=new Date(v.start);
            //json[k].end=new Date(v.end);
        });
        */
        
        dispEnroll(json,$("#enrollTarget"));
        $("#boxenroll .overlay, #boxenroll .loading-img").hide();
    });

    r.fail(function(a,b,c){
        console.log('fail',a,b,c);
        $("#enrollTarget").html(a.responseText);
    });
}

function dispEnroll(json, target){
    console.log('dispEnroll()');
    
    var h=[];
    h.push("<table class='table table-striped table-condensed'>");
    h.push("<thead>");
    h.push("<th>User</th>");
    h.push("<th>Joined</th>");
    h.push("</thead>");
    h.push("<tbody>");
    $.each(json,function(k,v){
        h.push('<tr>');
        h.push('<td><a href=../user/?id='+v.user_id+'>'+v.username);
        h.push('<td>'+v.created);
        h.push('</tr>');
    });
    h.push("</tbody>");
    h.push("</table>");

    target.html(h.join(''));
}

$(function(){
    //console.log('enroll ready');
    $("#boxenroll .overlay, #boxenroll .loading-img").hide();
    $('#searchStr, #limit').change(function(){
        getEnrollData();
    });
    
});


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
