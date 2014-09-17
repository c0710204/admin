<?php
// Drop a user !!

$sql = "SELECT * FROM certificates_generatedcertificate WHERE user_id=$USERID;";

$title="<i class='fa fa-ban'></i> Drop user <small>Think twice</small>";
$body=new Admin\Callout("danger", "This cannot be undone");
$foot="<a href=# class='btn btn-danger'><i class='fa fa-trash'></i> Drop</a>";

$box=new Admin\Box;
$box->type("danger");
$box->title($title);
$box->collapsed(true);
echo $box->html($body, $foot);
?>
<script>
function dropUser()
{
	if(!confirm("Drop user ?"))return false
}
</script>