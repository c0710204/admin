<?php
// Course outline

//echo "<br />";



//$data = $course->course();


$body=[];
$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveOverview()'><i class='fa fa-save'></i> Save</button>";
$footer[]="<span id='courseOverview'></span>";


echo $admin->box("primary", "<i class='fa fa-edit'></i> Course outline", $body, $footer);
?>
<script>
</script>