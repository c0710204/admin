<?php
// admin :: Session (Edx Session)
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Session");
echo $admin->printPrivate();

$edxApp = new EdxApp();
$edxCourse = new EdxCourse();

$session_id=$_GET['id'];
/*
$USERID=@$_GET['id']*1;
if(isset($_GET['user_id']))$USERID=$_GET['user_id']*1;

$usr=$edxApp->user($USERID);
$up =$edxApp->userprofile($USERID);

if (!$usr) {
    echo "Error : user not found";
    exit;
}
*/
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-bolt'></i> Session
        <small> <?php echo $_GET['id'];?></small>
    </h1>
    
</section>

<?php
$data=$edxApp->tracking($session_id);
if ($data) {
    $session_date=substr($data[0]['time'], 0, 10);
    $S=$edxApp->tracking_session($session_id);
    $USR=$edxApp->user($S['user_id']);
} else {
    echo "<li>Error : No session data<hr />";
}

?>

<!-- Main content -->
<section class="content">


<!-- Main row -->
<div class="row">


    <section class="col-sm-3 connectedSortable">
    <?php
    include "session_info.php";
    ?>
    </section><!-- /.Col -->



    <!-- Left col -->
    <section class="col-sm-9 connectedSortable">
    <!-- Userinfo -->
    <?php
    include "session_details.php";
    ?>
    </section>


</div>