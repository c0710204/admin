<?php
// user_certificates

$sql = "SELECT * FROM certificates_generatedcertificate WHERE user_id=$USERID;";

$title="<i class='fa fa-certificate'></i> Certificates <small>x certificates</small>";// certificates_generatedcertificate

$box=new Admin\SolidBox;

$box->title($title);
$box->collapsed(true);
echo $box->html("<pre>$sql</pre>");
