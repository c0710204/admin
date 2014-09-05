<?php
//<h1>Versions</h1>

$body=[];
$body[]="<pre id=php>".`php --version`."</pre>";
$body[]="<pre id=fn></pre>";
$body[]="<pre id=ui></pre>";

echo $admin->box("default", "<i class='fa fa-info'></i> Software versions", $body,[],'collapse');
?>

<script>
var ver=$.fn.jquery;
$('#fn').html("jQuery version: "+$.fn.jquery);
$('#ui').html("jQuery UI version: "+$.ui.version);
</script>