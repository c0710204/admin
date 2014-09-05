<?php
// Course filter

$body=[];

$body[]="<div class='row'>";

// courses
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Organisation</label>";
$body[]="<select class='form-control' id='org'>";


$list=$edxapp->orgs();
// echo "<pre>"; print_r($list); echo "</pre>";
if (count($list)==1) {
    $body[]="<option value='".$list[0]."'>".$list[0]."</option>";
} else {
    $body[]="<option value=''>Select org</option>";
    foreach ($list as $org) {
        $selected='';
        $body[]="<option value='$org' $selected>$org</option>";
    }
}
$body[]="</select>";
$body[]="</div>";
$body[]="</div>";


// search
$body[]="<div class='col-lg-6'>";
$body[]="<div class='form-group'>";
$body[]="<label>Search</label>";
$body[]="<input type=text class=form-control id='searchStr' placeholder='Display name ...'>";
$body[]="</div></div>";



$body[]="</div>";//end row

$footer=[];



$box= new Admin\SolidBox;
$box->type("danger");
$box->icon("fa fa-search");
$box->title("Filter");
$box->body($body);
echo $box->html();
