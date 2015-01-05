<?php
// admin :: Calendar controller
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


//use Admin\EdxApp;
//use Admin\EdxCourse;

$admin = new Admin\AdminLte();
$admin->ctrl();

$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

switch($_POST['do']){

    //
    case 'getEnrollments'://list enrollments and add them to calendar
        //print_r($_POST);
        $user_id=$_POST['user_id'];
        $user=$edxApp->user($user_id);
        
        $events=[];//list of events
        
        // date joined        
        $event=[];
        $event['allDay']=false;
        $event['title']="User joined";
        $event['start']=$user['date_joined'];
        $event['color']='#c00';
        $event['url']='../user/?id='.$user_id;
        $events[]=$event;

        // user enrollments
        $enrolls=$edxApp->studentCourseEnrollment($user_id);
        foreach($enrolls as $enr){
            //print_r($enr);exit;
            $event=[];
            $event['allDay']=false;
            $event['title']="Enroll to ".$enr['course_id'];
            $event['start']=$enr['created'];
            $event['color']='#999';//default
            //$event['url']='../user/?id='.$user_id;
            $events[]=$event;
        }


        foreach ($edxApp->studentCourseEnrollment($user_id) as $k=>$r) {
            $meta=$edxCourse->metadata($r['course_id']);
            $name=ucfirst(strtolower($meta['display_name']));
            $start=@substr($meta['start'], 0, 10);
            $end = @substr($meta['end'], 0, 10);
            // print_r($meta);
            
            if($start){
                $event=[];
                $event['allDay']=true;
                $event['title']="$name (start)";
                $event['start']=$start;
                $event['end']=$start;
                $event['color']='#5cb85c';//green success
                $event['url']='../course/?id='.$r['course_id'];
                $events[]=$event;
            }

            if($end && $end!=$start){
                $event=[];
                $event['allDay']=true;
                $event['title']="$name (end)";
                $event['start']=$end;
                $event['end']=$end;
                $event['color']='#ccc';
                $events[]=$event;
                //echo "addEvent(".json_encode($event).");\n";   
            }

               /*
            var eventObject = {
                allDay:false,
                title: title,
                start: start,
                end: end,
                id: id,
                color: colour
            };
            echo "addEvent();";
            $('#calendar').fullCalendar('renderEvent', eventObject, true);
            */
        }

            $sessions=$edxApp->sessions([$user_id])[$user_id];
            foreach($sessions as $session){
                //print_r($session);exit;
                $event=[];
                $event['allDay']=false;
                $event['title']='session';
                $event['start']=$session['date_from'];
                $event['end']=$session['date_to'];
                $event['color']='#337ab7';//primary
                $event['url']='../session/?id='.$session['session'];
                $events[]=$event;
            }

        foreach($events as $event){
            echo "addEvent(".json_encode($event).");\n";   
        }
        exit;
        break;


    case 'list':// list all user sessions
        
        $user_id=$_POST['user_id'];
        $sessions=$edxApp->sessions([$user_id])[$user_id];
        $dat=[];
        foreach($sessions as $session){
        	$dat[]=$session;
        }
        echo json_encode($dat);
        exit;
        
        //print_r($sessions);
        break;

    default:
        die("Error : unknow action ".$_POST['do']);
}

exit;

/*
$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

$USERID=@$_GET['id']*1;
if(isset($_GET['user_id']))$USERID=$_GET['user_id']*1;


$usr=$edxApp->user($USERID);
$up =$edxApp->userprofile($USERID);

if (!$usr) {
    echo "Error : user not found";
    exit;
}
*/