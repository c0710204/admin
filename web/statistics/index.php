<?php
//admin :: statistics
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";
use Admin\AdminLte;

$admin = new AdminLte();
$admin->title("Statistics");
echo $admin->printPrivate();

?>

<section class="content-header">
    <h1><i class="fa fa-users"></i> Statistics <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php
$db=$admin->db();

/*
$q=$db->query("SELECT is_active, date(date_joined) as date FROM edxapp.auth_user WHERE 1;");
$dat=[];
while ($r=$q->fetch()) {
    @$dat[$r[1]]++;
}
echo "<pre>"; print_r($dat); echo "</pre>";
*/
?>

<div id='chart'>chart</div>
<div id='more'>more</div>


<script src='chart.js'></script>

<style>
div.white{background-color: #fff;}
div.tooltip {
  position: absolute;
  color:#fff;
  width:200px;
  padding: 8px;
  font: 12px sans-serif;
  background: #333;
  border: solid 1px #aaa;
  border-radius: 4px;
  pointer-events: none;
}


.container{
  max-width: none !important;
  width: 970px;
}
</style>