<?php
// box thread info

$title=$r['title'];

$body=$foot=[];

$org=explode("/", $r['course_id'])[0];






$body[]='<div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">';
                      
$created=$r['created_at']->sec;
$date=date("Y-m-d H:i", $created);

$body[]='<div class="item">';

//$body[]='';
//$body[]='<i class="fa fa-user"></i>';

$body[]='<img src="../img/user.jpg" alt="user image" class="online">';
$body[]='<p class="message">';

$body[]='<a href="../user/?id='.$r['author_id'].'" class="name">';
$body[]='<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '.$date.'</small>';
$body[]=ucfirst($r['author_username']);
$body[]="</a>";
$body[]="<b>".$r['title']."</b>";
$body[]='</p>';

//comments
$body[]="<div class=attachment>";


//$body[]=$com['author_username'].":".;
$body[]="<p class=filename>".$r['body']."</p>";
//print_r($com);

$body[]="</div>";
$body[]='</div>';


$body[]='</div>';//box-body chat




$body[]='<hr />';

$body[]="(this post is about <a href=#>???</a>)";
$body[]='<hr />';


// row thread info

$body[]="<div class='row'>";

// Org
$body[]="<div class='col-lg-4'>";
$body[]="<div class=form-group>";
$body[]="<label>Org : $org</label>";
//$body[]="<div>$org</div>";
$body[]="</div>";
$body[]="</div>";

// Course
$body[]="<div class='col-lg-8'>";
$body[]="<div class=form-group>";
$body[]="<label>Course : <a href='../course/?id=".$r['course_id']."'>".$edxapp->courseName($r['course_id'])."</a></label>";
//$body[]="<input type=text class=form-control id=course placeholder=Course value='".$r['course_id']."'>";
$body[]="</div>";
$body[]="</div>";

$body[]="</div>";//end row



// Dates

// Updated
$updated_at=date("Y-m-d H:i", $r['updated_at']->sec);

// Created
$created_at=date("Y-m-d H:i", $r['created_at']->sec);

//Last activity
$last_activity_at=date("Y-m-d H:i", $r['last_activity_at']->sec);



// row dates
$body[]="<div class='row'>";

// Created
$body[]="<div class='col-lg-4'>";
$body[]="<div class=form-group>";
$body[]="<label>Created</label>";
$body[]="<input type=text class=form-control value='$created_at'>";
$body[]="</div>";
$body[]="</div>";

// Updated
$body[]="<div class='col-lg-4'>";
$body[]="<div class=form-group>";
$body[]="<label>Updated</label>";
$body[]="<input type=text class=form-control value='$updated_at'>";
$body[]="</div>";
$body[]="</div>";

// Last activity
$body[]="<div class='col-lg-4'>";
$body[]="<div class=form-group>";
$body[]="<label>Last activity</label>";
$body[]="<input type=text class=form-control value='$last_activity_at'>";
$body[]="</div>";
$body[]="</div>";

$body[]="</div>";//end row





if ($r['closed']) {
    $body[]=$admin->callout("danger", "<i class='fa fa-warning'></i> Thread is closed !");
}




// Closed
// $body[]="Closed";
if (!$r['closed']) {
    $foot[]="<a href=# class='btn btn-default' onclick='closeThread(true)'><i class='fa fa-ban'></i> Close thread</a> ";
} else {
    $foot[]="<a href=# class='btn btn-default' onclick='closeThread(false)'><i class='fa fa-ban'></i> Reopen thread</a> ";
}

$foot[]="<a href=# class='btn btn-danger pull-right' onclick='trashThread()'><i class='fa fa-trash-o'></i> Delete thread</a> ";

$box=new Admin\Box;
$box->type("success");
$box->icon('fa fa-bullhorn');
$box->title($title);
$box->body($body);
$box->footer($foot);
echo $box->html();

//echo "<pre>"; print_r($r); echo "</pre>";
