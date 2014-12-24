<?php
// Session search form

$username='';
if (isset($_GET['username'])) {
	$username=$_GET['username'];
}

$box=new Admin\SolidBox;
$box->icon("fa fa-search");
$box->title("Search");
$box->type("default");

$htm=[];
$htm[]="<div class='row'>";

// Username
$htm[]="<div class='col-sm-4'>";
$htm[]="<div class='form-group'>";
$htm[]="<label><i class='fa fa-user'></i> User</label>";
$htm[]="<input type=text class=form-control id='searchStr' value='$username'>";
$htm[]="</div></div>";

// Date joined
$htm[]="<div class='col-sm-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label><i class='fa fa-calendar'></i> From</label>";
$htm[]="<input type='date' class=form-control id='date_from'>";
$htm[]="</div></div>";

// Date joined
$htm[]="<div class='col-sm-2'>";
$htm[]="<div class='form-group'>";
$htm[]="<label><i class='fa fa-calendar'></i> To</label>";
$htm[]="<input type='date' class=form-control id='date_to'>";
$htm[]="</div></div>";

// Limit
$htm[]="<div class='col-sm-1'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Limit</label>";
$htm[]="<input type=text class=form-control id='limit' placeholder='Limit' value=100>";
$htm[]="</div></div>";

// Reload
$htm[]="<div class='col-sm-1'>";
$htm[]="<div class='form-group'>";
$htm[]="<label>Reload</label><br />";
$htm[]="<a href=# class='btn btn-default' id='btnReload'><i class='fa fa-refresh'></i></a>";
$htm[]="</div></div>";

$htm[]="</div>";

$foot="<a href=# class='btn btn-default'>Search</a>";
echo $box->html($htm);