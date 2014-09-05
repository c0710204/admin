<?php
// mysql backup

$body=[];
//$body[]="<pre>".`mysqldump --version`."</pre>";
$f=glob("archives/*.sql.gz");
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
        $body[]= "<td><a href=#del class=delete title='".basename($v)."'><i class='fa fa-trash-o'></i> Del</a></td>";
    }
    $body[]="</tbody>";
    $body[]="</table>";
} else {
    $body[]="<pre>No file</pre>";
}

$foot=[];
$foot[]="<button class='btn btn-primary' onclick='mysqlBackup()'><i class='fa fa-save'></i> Backup ".$admin->config()->pdo->host."</button> ";


$box=new Admin\Box;
$box->id('boxMysql');
$box->icon('fa fa-database');
$box->title('Mysql backup');
$box->loading(true);
echo $box->html($body, $foot);
?>

<script>
function mysqlBackup(){
    //console.log('doBackup()');
    $('#boxMysql .box-footer').html("Loading");
    $('#boxMysql .overlay, #boxMysql .loading-img').show()
    $('#boxMysql .box-footer').load('ctrl.php',{'do':'mysqlbackup'},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

$(function(){
    //set as loaded
    $('#boxMysql .overlay, #boxMysql .loading-img').hide();
    
    $('a.delete').click(function(o){
        console.log('a .delete',o.currentTarget.title);
        $('#boxMysql .overlay, #boxMysql .loading-img').show();
        $('#boxMysql .box-footer').load('ctrl.php',{'do':'delete','file':o.currentTarget.title},function(x){
            try{eval(x);}
            catch(e){alert(x);}
        });
    });
});

</script>