<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
//$edxCourse= new Admin\EdxCourse();
//$edxTest= new Admin\EdxTest();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas <small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<pre>
<?php
$start=time();

$user_ids=$canvas->userIds();
//die("done in ".(time()-$start)." sec\n");

//$user_ids[]=36;// jean baptiste camus

// grab all canvas user data
$sql="SELECT id, name, sortable_name, created_at, updated_at FROM users;";
$q=$canvas->db()->query($sql) or die("error");
$userdata=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $userdata[$r['id']]=$r;
}
//die("done in ".(time()-$start)." sec\n");

// grab all canvas email data
$sql="SELECT user_id, path as email, workflow_state FROM communication_channels WHERE path_type='email';";
$q = $canvas->db()->query($sql) or die("error $sql");

$emaildata=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    //return $r['email'];
    $emaildata[$r['user_id']]=[$r['email'], $r['workflow_state']];
}
//die("done in ".(time()-$start)." sec\n");

foreach ($user_ids as $user_id) {
    
    // get user data 
    // $usr=$canvas->user($user_id);//slow
    $usr=$userdata[$user_id];
    
    if (!@$emaildata[$user_id]) {
        echo "Warning: canvas user <a href='canvas_user.php?id=$user_id'>#$user_id</a> has no email\n";
        continue;
    }
    
    //print_r($usr);exit;

    // register user
    echo $emaildata[$user_id][0]."\t".$emaildata[$user_id][1]."\n";

    $edx_user_id = $edxapp->userCreate($emaildata[$user_id][0], $usr['name'], $usr['name'], $usr['sortable_name'], substr($usr['created_at'], 0, 10));
    if (!$edx_user_id) {
        echo "Warning: couldnt create edx user for canvas # $user_id\n";
        continue;
    }
    
   

    // enrollments
    /*
    $enrolls=$canvas->userEnrollments($usr['id']); 
    foreach ($enrolls as $enr) {
        //$edxapp->enroll($enr['edx_id'], $edx_user_id, $enr['created_at']);
    }
    */

}
die("done in ".(time()-$start)." sec\n");
?>
</section>
