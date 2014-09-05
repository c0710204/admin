<?php
// course debug

$HTM=[];
$footer=[];
if ($edxapp->courseEnrollCount($course_id)) {
    $HTM[]="Users must be un-enrolled first";
    
} else {
    $HTM[]="You should be very careful with that one";
    $footer[]="<button class='btn btn-danger' onclick='dropCourse()'><i class='fa fa-trash-o'></i> Drop</button>";
}



//echo "<pre>".print_r($meta, true)."</pre>";
$box=new Admin\Box;
$box->id("dropmore");
$box->type("Danger");
$box->icon("fa fa-trash-o");
$box->title("Drop course");
echo $box->html($HTM, $footer);
?>
<script>
function dropCourse()
{
    if(!confirm("Drop that course ?"))return false;
    if(!confirm("I must ask you again. Are you sure ?"))return false;

    var p={
        'do':'drop',
        'course_id':$('#course_id').val()
    };

    $("#dropmore").load("ctrl.php", p, function(x){
        try{ eval(x); }
        catch(e){ alert(x);}
    });
}
</script>