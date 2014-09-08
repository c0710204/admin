<?php
//admin :: files filter

$body=[];


$body[]="<div class='row'>";

// courses
$body[]="<div class='col-lg-3'>";
$body[]="<div class='form-group'>";
$body[]="<label>Select course</label>";
$body[]="<select class='form-control' id='course_id'>";
$body[]="<option value=''>Select course</option>";
$list=$edxapp->courseids();
foreach ($list as $courseid) {
    $selected='';
    if (@$_GET['course_id']==$courseid) {
        $selected='selected';
    }
    $body[]="<option value='$courseid' $selected>$courseid</option>";
}
$body[]="</select>";
$body[]="</div>";
$body[]="</div>";




// content type
// get distinct file types
$files = $edxapp->mgdb()->edxapp->fs->files;
$r=$files->distinct('contentType');
$types=[];
foreach ($r as $f) {
    if ($f) {
        $types[]=$f;
    }
}
sort($types);
$body[]="<div class='col-lg-3'>";
$body[]="<div class='form-group'>";
$body[]="<label>Content type</label>";
$body[]="<select class='form-control' id='contentType'>";
$body[]="<option value=''>Any type</option>";
$list=$edxapp->courses();
foreach ($types as $type) {
    $body[]="<option value='$type'>$type</option>";
}
$body[]="</select>";
$body[]="</div>";
$body[]="</div>";




// filename
$body[]="<div class='col-lg-6'>";
$body[]="<label>Search</label>";
$body[]="<div class='input-group'>";
$body[]="<span class='input-group-addon'>@</span>";
$body[]="<input type=text class='form-control' id='filename' placeholder='Filename'>";
$body[]="</div>";
$body[]="</div>";


$body[]="</div>";


// footer
$footer=[];
//$footer[]="<button class='btn' onclick=searchFiles()><i class='fa fa-search'></i> Search</button>";




$box = new Admin\SolidBox;
$box->type("danger");
$box->icon('fa fa-search');
$box->title('Filter');
echo $box->html($body, $footer);
?>


<script>
var dat=[];
function searchFiles()
{
    var p={
        'do':'find',
        'filename':$('#filename').val(),
        'course_id':$('#course_id').val(),
        'contentType':$('#contentType').val()
    };

    $('#boxfiles .overlay,#boxfiles .loading-img').show();
    $('#more').load('ctrl.php',p,function(x){
        try{
            dat = jQuery.parseJSON(x);
            //console.log(obj);
            printFiles($('#more'));
            $('#boxfiles .overlay,#boxfiles .loading-img').hide();
        }
        catch(e){
            alert(x);
        }
    });
}

function printFiles(target){
    var h=[];
    h.push("<table class='table table-condensed table-striped'>");
    for(var i=0;i<dat.length;i++){
        var o=dat[i];
        h.push("<tr onclick=fileInfo("+i+") title='"+o.displayName+"'>");
        var ico="<i class='fa fa-file'></i>&nbsp;";
        h.push("<td>" + ico + o.displayname);
        h.push("<td>"+o.contentType);
        //h.push("<td>"+o.contentType);
        h.push("<td>"+o.length);
        h.push("<td>");//icons
        h.push("<a href=# onclick=delFile('"+i+"')><i class='fa fa-trash-o'></i></a>");
        h.push("&nbsp;");
        h.push("<a href=# onclick=fileDownload('"+o.md5+"')><i class='fa fa-download'></i></a>");
        h.push("</tr>");
    }
    h.push("</table>");

    if(dat.length==0){
        h.push("<div class=alert>No file</div>");
    }

    $(target).html(h.join(''));
}

function fileInfo(i){
    //console.log('fileInfo(i)', i, dat[i].md5);
    var o=dat[i];
    var p={
        'id':o._id,
        'org':o._id.org,
        'course':o._id.course,
        'name':o._id.name,
        'md5':o.md5
    };
    //var p={'id':o._id}
    $('#fileinfo').html("Loading");
    $('#fileinfo').load("file_info.php",o._id,function(x){
        //
    });
}

function fileDownload(md5){
    document.location.href='download.php?md5='+md5;
}

function delFile(i){
    if(!confirm("Delete this file ?"))return false;
    var o=dat[i];
    var p={
        'do':'delete',
        'org':o._id.org,
        'course':o._id.course,
        'md5':o.md5
    };
    $('#fileinfo').html("Deleting...");
    $('#fileinfo').load("ctrl.php",p,function(x){
        console.log(x);
    });
}

$(function(){
    $('#filename, #course_id, #contentType').change(function(){
        searchFiles();
    });
    $('#filename').focus();
    //console.log("ready");
    searchFiles();
});

</script>