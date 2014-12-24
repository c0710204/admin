<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte();
$edxapp= new EdxApp();



switch($_POST['do']){

    case 'createUser':
        
        // check if user exist first //
        if ($user_id=$edxapp->userExist($_POST['email'])) {
            echo "alert('This user already exist !');\n";
            die("document.location.href='../user/?id=$user_id';\n");
        }

        $user_id=$edxapp->userCreate($_POST['email']);
        //var_dump($created);
        if ($user_id) {
            die("document.location.href='../user/?id=$user_id';\n");
        } else {
            die("alert('error creating user');");
        }
        break;


    case 'createUsers':
        //print_r($_POST);
        $emails=explode("\n", $_POST['emails']);
        foreach ($emails as $email) {
            //
            $created=$edxapp->userCreate($email);
        }

        //var_dump($created);
        break;


    case 'getlist':

        // save search params //

        $WHERE=[];
        
        if (preg_match("/^[0-9]+$/", $_POST['search'])) {
            $WHERE[]="id=".$_POST['search']*1;
        } else {
            $OR=[];
            $OR[]="username LIKE '%".$_POST['search']."%'";
            $OR[]="email LIKE '%".$_POST['search']."%'";
            $OR[]="first_name LIKE '%".$_POST['search']."%'";
            $OR[]="last_name LIKE '%".$_POST['search']."%'";
            $WHERE[]="(".implode(" OR ", $OR).")";
        }
        
        switch($_POST['status']) {
            
            case 'active':
                $WHERE[]="is_active=1";
                break;
            
            case 'inactive':
                $WHERE[]="is_active=0";
                break;

            case 'staff':
                $WHERE[]="is_staff=1";
                break;
            
            case 'superuser':
                $WHERE[]="is_superuser=1";
                break;
            
            default:
                break;
        }

        if ($_POST['date_joined']) {
            $WHERE[]="date_joined > '".$_POST['date_joined']." 00:00:00'";
            $WHERE[]="date_joined < '".$_POST['date_joined']." 23:59:59'";
        }

        //$WHERE[]="is_active>0";
        $list=$edxapp->userList($WHERE, $_POST['limit']);
        echo json_encode($list);
        exit;
        break;



    /**
     * Show user info
     */
    case 'getUserInfo':
        //print_r($_POST);
        $user_id=$_POST['uid']*1;
        $user=$edxapp->user($_POST['uid']);
        $username=$user['username'];
        $profile=$edxapp->userprofile($_POST['uid']);
        $courses=$edxapp->studentCourseEnrollment($_POST['uid']);

        echo "<h2>$username <br /><small><i class='fa fa-envelope'></i> $user[email]</small></h2>";

        // labels
        echo "<span class='label label-default'>#".$user['id']."</span> ";//id
        
        if ($user['is_active']) {
            echo "<span class='label label-success'>Active</span> ";
        } else {
            echo "<span class='label label-default'>Inactive</span> ";
        }
        if ($user['is_staff']) {
            echo "<span class='label label-info'>Staff</span> ";
        }
        if ($user['is_superuser']) {
            echo "<span class='label label-danger'>SuperUser</span> ";
        }


        // Sessions //      
        if ($sessions=$edxapp->sessions([$user_id])[$user_id]) {
            echo "<a href='../sessions/?username=$username' class='btn btn-default'><i class='fa fa-bolt'></i> " . count($sessions) . " session(s)</a> ";
        }

        echo "<hr />";
        //echo "<h3>Mail : $user[email]</h3>";
        echo "<h4><i class='fa fa-calendar'></i> Date joined: ".substr($user['date_joined'], 0, 16)."</h4>";
        

        if(preg_match("/0000/",$user['last_login'])){
            // no login
        } else {
            echo "<h4><i class='fa fa-calendar'></i> Last login : ".substr($user['last_login'], 0, 16)."</h4>";
        
            // courseware (what is that last user action)
            /*
            $lastunit = $edxapp->userLastAction($user['id']);
            if ($lastunit) {
                echo "<h4>Last action : <a href='../course_unit/?id=".$lastunit['module_id']."'> ";//".$lastunit['modified']."
                echo basename($lastunit['module_id'])."</a>";
                echo "</h4>";
                //echo "<pre>";print_r($lastunit);echo "</pre>";
            }
            */   
        }
        
        
        echo "<hr />";
        
        ////////////////////////////
        // Course enrollment
        ////////////////////////////
        if (count($courses)) {
            echo "<h4>Enrolled in ".count($courses)." course(s)</h4>";
            //echo "<pre>";print_r($courses);echo "</pre>";
            echo "<table class='table table-condensed table-striped'>";
            foreach ($courses as $course) {
                echo "<tr>";
                echo "<td><i class='fa fa-book'></i> <a href='../course/?id=".$course['course_id']."'>".ucfirst(strtolower($edxapp->courseName($course['course_id'])));
                
                $ORG=explode("/",$course['course_id'])[0];
                echo " <i class='text-muted'>$ORG</i>";
                
                // Progress
                //echo " <i class='pull-right'>33%</i>";
                

                //echo "<td style='text-align:right'>".substr($course['created'], 0, 10);
            }
            echo "</table>";

        } else {
            //echo "<h4><b>No enrollment</b></h4>";
            echo "<div class=form-group><label><i class='fa fa-warning' style='color:#c00'></i> Warning : </label>  No enrollment";
        }


        if (!$user['password']) {
            //echo "<hr />";
            //echo "<pre>Warning: No password</pre>";
            echo "<div class=form-group><label><i class='fa fa-warning' style='color:#c00'></i> Warning : </label>  No password";
        }

        // More info button
        echo "<hr />";
        echo "<a href='../user/?id=".$user['id'].">' class='btn btn-primary'><i class='fa fa-arrow-circle-right'></i> More about ".$user['username']."</a>";
        exit;
        break;


    case 'd3Data':
        //print_r($_POST);
        $range=explode(' - ', $_POST['date_range']);
        //print_r($range);
        $from = strtotime($range[0]);
        $to = strtotime($range[1]);
        
        $sql= "SELECT COUNT(*) as n, date(date_joined) as `date` FROM edxapp.auth_user ";
        $sql.="WHERE date_joined >= '".date('Y-m-d H:i:s', $from)."' AND date_joined <= '".date('Y-m-d 23:59:59', $to)."' ";
        $sql.=" GROUP BY date(date_joined) ORDER BY date(date_joined);";
        $q=$admin->db()->query($sql) or die($admin->db()->errorInfo()[2] . "<hr />$sql");
        //echo "<pre>$sql</pre>";
        $DAT=[];
        while ($r = $q->fetch(\PDO::FETCH_ASSOC)) {
            $r['n']*=1;
            //$DAT[]=$r;
            $DAT[$r['date']]=$r['n'];
        }
        
        // we must pad dates with no records
        while ($from < $to) {
            if (!isset($DAT[date('Y-m-d', $from)])) {
                $DAT[date('Y-m-d', $from)]=0;
            }
            $from+=86400;//24hours
        }
        ksort($DAT);
        //die('first=$first');
        //retransform
        $DATA=[];
        foreach ($DAT as $date => $n) {
            $DATA[]=['date'=>$date,'n'=>$n];
        }

        echo json_encode($DATA);
        exit;
        break;

    default:
        echo "Ctrl error";
        print_r($_POST);
        exit;
        break;
}

exit;

