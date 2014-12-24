<?php
// admin :: Session (Edx Session)

// http://devdata.readthedocs.org/en/latest/internal_data_formats/tracking_logs.html
// http://devdata.readthedocs.org/en/latest/internal_data_formats/event_list.html

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

if(isset($_GET['id'])){
    $session_id=$_GET['id'];
} else {
    die("<script>document.location.href='../sessions/';</script>");
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-bolt'></i> Session
        <small> <?php echo $_GET['id'];?></small>
    </h1>
    
</section>

<?php
// get session data //
$data=$edxApp->tracking($session_id);
//echo "<li>".count($data);
if ($data) {
    $session_date=substr($data[0]['time'], 0, 10);
    $S=$edxApp->tracking_session($session_id);
    $user_id=$S['user_id'];
    $USR=$edxApp->user($S['user_id']);
    $username=$USR['username'];
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
    //include "session_info.php";
    include "more_sessions.php";
    ?>
    </section><!-- /.Col -->



    <!-- Left col -->
    <section class="col-sm-9 connectedSortable">
    <!-- Userinfo -->
    <?php
    include "session_digest.php";
    include "session_overview.php";
    include "session_details.php";
    ?>
    </section>


</div>

<script src='session.js'></script>