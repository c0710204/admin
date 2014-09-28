<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();
$start=time();

require __DIR__."/../../vendor/autoload.php";


$_SESSION['canvas']['host']='localhost';
$_SESSION['canvas']['database']='canvas_production';
$_SESSION['canvas']['user']='toto';
$_SESSION['canvas']['pass']='caca';
$_SESSION['canvas']['connected']=true;
$_SESSION['configfile']="../config/profiles/yy-preprod.json";
print_r($_SESSION);


$admin = new Admin\AdminLte();// select config
$edxapp= new Admin\EdxApp();
$canvas= new Admin\Canvas();



$sql = "SELECT username, email FROM edxapp.auth_user WHERE 1;";
$q = $admin->db()->query($sql) or die("error : $sql");
$usernames=[];
$emails=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $usernames[]=strtolower(trim($r['username']));
    $emails[]=strtolower($r['email']);
}

//print_r($emails);exit;

$user_ids=$canvas->userIds();// list of canvas userIds to import

// grab all canvas user data in one time
$sql="SELECT id, name, sortable_name, created_at, updated_at FROM users;";
$q=$canvas->db()->query($sql) or die("error");
$userdata=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $r['name']=trim($r['name']);
    if ($r['name']=='test') {
        continue;
    }
    
    $userdata[$r['id']]=$r;
}

echo "$sql\n";
echo "ok\n";


// grab all canvas email data
$sql="SELECT user_id, path as email, workflow_state FROM communication_channels WHERE path_type='email';";
$q = $canvas->db()->query($sql) or die("error $sql");
$emaildata=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    if ($r['workflow_state']=='retired') {
        //continue;
    }
    $r['email']=strtolower($r['email']);
    $emaildata[$r['user_id']]=[$r['email'], $r['workflow_state']];
}

echo "$sql\n";
echo "ok\n";





// fore each canvas users
$import=0;
foreach ($user_ids as $user_id) {
    
    // get user data 
    // $usr=$canvas->user($user_id);//slow
    $usr=$userdata[$user_id];
    $usr['name']=trim($usr['name']);

    if (!@$emaildata[$user_id]) {
        echo "Warning: canvas user <a href='canvas_user.php?id=$user_id'>#$user_id</a> has no email\n";
        continue;
    }

    //echo "canvas email:".$emaildata[$user_id][0]."\n";

    if (in_array($emaildata[$user_id][0], $emails)) {
        $import++;
        //echo ".\n";
        continue;
    }

    // check email workflow_state
    if ($emaildata[$user_id][1] == 'retired') {// we're not interested
        //print_r($emaildata[$user_id]);
        //echo "retired\n";
        continue;
    }


    // this canvas username is already registered in edx, let's skip it for now
    if (in_array(strtolower($usr['name']), $usernames)) {
        //$import++;
        echo "Warning username : ".$usr['name']."\n";
        echo "this canvas username is already registered in edx, let's skip it for now\n";
        error_log($usr['name']."\n", 3, "duplicatenames.log");
        continue;
    } else {
        $usernames[]=strtolower(trim($usr['name']));
    }
    




    // register user
    $edx_user_id = $edxapp->userCreate($emaildata[$user_id][0], $usr['name'], $usr['name'], $usr['sortable_name'], substr($usr['created_at'], 0, 10));
    if (!$edx_user_id) {
        echo "Warning: couldnt create edx user for canvas # $user_id\n";
        continue;
    } else {
        echo "[$import] ".$emaildata[$user_id][0]."\t".$emaildata[$user_id][1]."\t edx_user_id=".$edx_user_id."\n";
    }

    
    // enrollments 
    $enrolls=$canvas->userEnrollments($usr['id']);
    if (is_array($enrolls) && count($enrolls)) {
        foreach ($enrolls as $enr) {
            $edxapp->enroll($enr['edx_id'], $edx_user_id, $enr['created_at']);
        }
    }

    $import++;
}

die("done in ".(time()-$start)." sec\n");




// print_r($user_ids);
// die("done in ".(time()-$start)." sec\n");
// $user_ids[]=36;// jean baptiste camus

echo "ok\n";
