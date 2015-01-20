<?php
// admin :: User import -> Upload xls file
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";
require_once 'excel_reader2.php';

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCrm;

$admin = new AdminLte();
$admin->title("Upload xls");
echo $admin->printPrivate();

//$edxApp = new EdxApp();

?>

<section class="content-header">
    <h1><i class='fa fa-file-excel-o'></i> Upload user list</h1>
</section>


<section class="content">
<div class="row">

<!-- Main content -->
<section class="col-md-6">
<?php
//http://plugins.krajee.com/file-input/demo
$box=new Admin\SolidBox;
$box->icon('fa fa-upload');
$box->title('Upload excel file');

$html=[];
$html[]='<form action="upload.php" method="post" enctype="multipart/form-data" id=ff>';
    //$html[]='Select excel file to upload:<br />';
    //$html[]='<br />';
  
    $html[]='<input type="file" name="xlsfile" id="xlsfile">';
    $html[]='<br />';
    $html[]='<input type="submit" value="Upload xls file" name="submit">';
$html[]='</form>';

$foot=[];
$foot[]="<a href=index.php class='btn btn-default'><i class='fa fa-arrow-left'></i> Back</a>";
//$foot[]="<a href=# class='btn btn-default pull-right' id=btnUpload><i class='fa fa-upload'></i> Upload</a>";
echo $box->html($html,$foot);
?>
</section>

<section class="col-md-6">
<?php
$box=new Admin\SolidBox;
$box->icon('fa fa-warning');
$box->title('Upload info');

$html=[];
$html[]="<pre>";
$html[]="Excel file must contain the following columns :\n\n";
$html[]=" - email\n";
$html[]=" - first_name\n";
$html[]=" - last_name";
$html[]="</pre>";

echo $box->html($html);
//<div class='alert alert-danger'><i class='fa fa-warning'></i> Warning : current list will be overwriten</div>
?>


</section>

</div><!--end row -->

<?php
include "upload_process.php";
?>
</section>




</div>
</section>

<script>

$(function(){
	$('#btnUpload').click(function(){
		$('#ff').submit();
	});
});

</script>