<?php
// admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

// die("test");
//print_r($_SESSION);
$_SESSION['configfile']='';
?>
<title>Index</title>
<a href='./web/'> Please wait or click here to continue</a>
<script>
document.location.href='web';
</script>