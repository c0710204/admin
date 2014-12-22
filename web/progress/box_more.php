<?php
// box more

$box=new Admin\SolidBox;
$box->icon("fa fa-eye");
$box->id("boxMore");
$box->loading(true);
$box->title("More");

echo $box->html("Please wait");
