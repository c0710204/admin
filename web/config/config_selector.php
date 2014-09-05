<?php
//retrieve profiles
$configs=glob('../config/profile/*.json');

$body=[];
$body[]="<select id='configs' class='form-control'>";
$body[]="<option value=''>Select</option>";

$footer=[];
$footer="<button class='btn'>Apply</button>";

foreach($configs as $conf){
    $conf=basename($conf);
    $body[]="<option value=$conf>$conf</option>";
}

$body[]="</select>";

echo $admin->box("danger", "<i class='fa fa-book'></i> Profiles", $body, $footer);
