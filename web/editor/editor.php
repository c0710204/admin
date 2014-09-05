<?php


$HTM[]='<textarea id="some-textarea" placeholder="Enter text ..." style="width:100%;height:180px"></textarea>';

$footer="<button class='btn btn-primary'>Save</button>";
echo $admin->box("primary", "Editor", $HTM, $footer);

?>
<script type="text/javascript">
    $('#some-textarea').wysihtml5();
</script>
