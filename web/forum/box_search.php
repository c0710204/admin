<?php
// Forum Search

$body=[];
$body[]="<div class='row'>";

// org
$body[]="<div class='col-xs-4'>";
$body[]="<div class='form-group'>";
$body[]="<label>Organisation</label>";
$body[]="<select class='form-control' id='org'>";
$body[]="<option value=''>Any</option>";

$list=$edxapp->orgs();
// echo "<pre>"; print_r($list); echo "</pre>";

foreach ($list as $org) {
    $selected='';
    $body[]="<option value='$org' $selected>$org</option>";
}

$body[]="</select>";
$body[]="</div>";
$body[]="</div>";


// forum courses
$body[]="<div class='col-xs-4'>";
$body[]="<div class='form-group'>";
$body[]="<label>Courses</label>";
$body[]="<select class='form-control' id='course'>";
$body[]="<option value=''>Any</option>";

foreach ($forum->courses() as $org => $course_id) {
    $selected='';
    $body[]="<option value='$course_id' $selected>$course_id</option>";
}

$body[]="</select>";
$body[]="</div>";
$body[]="</div>";

// search
$body[]="<div class='col-xs-4'>";
$body[]="<div class='form-group'>";
$body[]="<label>Search</label>";
$body[]="<input type=text class=form-control id='searchStr' placeholder='Display name ...'>";
$body[]="</div></div>";

$body[]="</div>";//end row

$box= new Admin\SolidBox;
$box->type("success");
$box->icon("fa fa-search");
$box->title("Filter");
echo $box->html($body);
