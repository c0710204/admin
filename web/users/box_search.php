<?php

//search form
$htm=[];
$htm[]="<div class='row'>";

$htm[]="<div class='col-sm-4'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Search</label>";
$htm[]="<input type=text class=form-control id='searchStr' value='searchStr' placeholder='Username, email, id ...'>";
$htm[]="</div></div>";

// Status
$values=['active','inactive','staff','superuser'];
$htm[]="<div class='col-sm-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Status</label>";
$htm[]="<select class='form-control' id='status'>";
$htm[]="<option value=''>Select";
foreach ($values as $value) {
    $htm[]="<option value='".$value."'>".$value;
}
//$htm[]="<option value='inactive'>Inactive";
//$htm[]="<option value='staff'>Staff";
//$htm[]="<option value='superuser'>SuperUser";
$htm[]="</select>";
$htm[]="</div></div>";

// Date joined
$htm[]="<div class='col-sm-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Date joined</label>";
$htm[]="<input type=date class=form-control id='date_joined'>";
$htm[]="</div></div>";

// Limit
$htm[]="<div class='col-sm-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Limit</label>";
$htm[]="<input type=text class=form-control id='limit' placeholder='Limit' value=100>";
$htm[]="</div></div>";

// Button
/*
$htm[]="<div class='col-sm-3'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Stats</label><br />";
$htm[]="<a href='./stats.php' class='btn btn-default'>Pop</a>";
$htm[]="</div></div>";
*/


/////////////////////////
// Button create user
/////////////////////////
$htm[]="<div class='col-sm-1'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>New</label><br />";
$htm[]="<a href=#create class='btn btn-primary' id=btnCreateUser><i class='fa fa-user'></i> Create a user</a>";
$htm[]="</div></div>";



$htm[]="</div>";//end row

$box=new Admin\SolidBox;
$box->type("primary");
$box->icon('fa fa-search');
$box->title('Filter');
echo $box->html($htm);

