<?php
// user_certificates

$sql = "SELECT * FROM certificates_generatedcertificate WHERE user_id=$USERID;";

$title="<i class='fa fa-certificate'></i> Certificates <small>certificates_generatedcertificate</small>";

$box=new Admin\SolidBox;
//$box->type("danger");
$box->title($title);
$box->body("<pre>$sql</pre>");
//$box->footer($footer);
echo $box->html();
