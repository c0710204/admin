<?php
//mongo backup
// http://docs.mongodb.org/v2.4/tutorial/backup-with-mongodump/
$body=[];

$body[]="<div class='overlay'></div>";
$body[]="<div class='loading-img'></div>";
//$body[]="<pre>".`mongodump --version`."</pre>";
//$body[]=print_r($definition, true);
//$body[]="http://docs.mongodb.org/v2.4/tutorial/backup-with-mongodump/";
//$body[]=`whoami`;
//$body[]=`ls -l archives/*.tgz`;
//$body[]="</pre>";


$f=glob("archives/*mongo.tgz");

if (count($f)) {
    $body[]="<table class='table table-condensed'>";
    $body[]="<thead>";
    $body[]="<th>Filename</th>";
    $body[]="<th>Size</th>";
    $body[]="<th></th>";
    $body[]="</thead>";
    $body[]="<tbody>";
    foreach ($f as $k => $v) {
        $body[]= "<tr>";
        $body[]= "<td><a href='dl.php?file=".basename($v)."'><i class='fa fa-file'></i> ".basename($v)."</a>";
        
        $k=round(filesize($v)/1024);
        $body[]= "<td>".number_format($k)."k";
        $body[]= "<td><a href=#del onclick=delFile(this) title='".basename($v)."'><i class='fa fa-trash-o'></i> Del</a></td>";
    }
    $body[]="</tbody>";
    $body[]="</table>";
} else {
    $body[]=$admin->callout("Danger", "No backup");
}

$foot=[];
$foot[]="<button class='btn btn-primary' onclick='mongoBackup()'><i class='fa fa-save'></i> Backup ".$admin->config()->mongo->host."</button> ";
//$foot[]="<button class='btn btn-default' onclick='mongoRestore()'><i class='fa fa-save'></i> Restore</button> ";

$box=new Admin\Box;
$box->icon('fa fa-cloud-download');
$box->title('Mongo backup');
$box->body($body);
$box->footer($foot);
echo $box->html();

//echo $admin->box("primary", "<i class='fa fa-cloud-download'></i> Mongo backup <small>".`mongodump --version`."</small>", $body, $foot);

?>
<div id='b'></div>

<script>
function mongoBackup(){

    console.log('doBackup()');
    $('#b').html("backup...");
    $('#b').load('ctrl.php',{'do':'mongobackup'},function(){});
}

function delFile(o){
    if(!o.title)return false;
    $('#b').html("delete "+o.title);
    $('#b').load('ctrl.php',{'do':'delete','file':o.title},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

$(function(){
    //$('#b').load('ctrl.php',{'do':'mongodumpVersion'},function(){});
});

</script>