<?php

//search form
$htm=[];
$htm[]="<div class='row'>";

$htm[]="<div class='col-lg-4'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Search</label>";
$htm[]="<input type=text class=form-control id='searchStr' placeholder='Username, email, id ...'>";
$htm[]="</div></div>";

// Status
$htm[]="<div class='col-lg-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Status</label>";
$htm[]="<select class='form-control' id='status'>";
$htm[]="<option value=''>Select";
$htm[]="<option value='active'>Active";
$htm[]="<option value='inactive'>Inactive";
$htm[]="<option value='staff'>Staff";
$htm[]="<option value='superuser'>SuperUser";
$htm[]="</select>";
$htm[]="</div></div>";

// Date joined
$htm[]="<div class='col-lg-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Date joined</label>";
$htm[]="<input type=date class=form-control id='date_joined'>";
$htm[]="</div></div>";

// Limit
$htm[]="<div class='col-lg-1'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Limit</label>";
$htm[]="<input type=text class=form-control id='limit' placeholder='Limit' value=100>";
$htm[]="</div></div>";

// Button
$htm[]="<div class='col-lg-3'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Stats</label><br />";
$htm[]="<a href='./stats.php' class='btn btn-default'>Pop</a>";
$htm[]="</div></div>";

$htm[]="</div>";

$box=new Admin\SolidBox;
$box->type("primary");
$box->icon('fa fa-search');
$box->title('Filter');
$box->body($htm);
//echo $box("success", "<i class='fa fa-search'></i> Search", $htm);
echo $box->html();
