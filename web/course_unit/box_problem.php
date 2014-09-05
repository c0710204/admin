<?php
// course unit - problem

$html=$unit['definition']['data']['data'];


$body=$foot=[];

//$body[]='<textarea id="editor1" style="width:100%;height:350px">';
//$body[]=substr($unit['definition']['data']['data'], 0, 255);
//$body[]='</textarea>';

$body[]="<pre>".htmlentities($html)."</pre>";

//$foot[]="<a href=# class='btn btn-default'><i class='fa fa-save'></i> Save html</a>";

$box=new Admin\Box;
$box->type("primary");
$box->icon('fa fa-code');
$box->title('Problem');
$box->body($body);
echo $box->html();
//echo $admin->box("primary", "<i class='fa fa-code'></i> Problem", $body, $foot);
?>

<script>
function saveHtml(){
}

$('#editor1').ckeditor( function( textarea ) {
   //console.log("textarea is ready", textarea);
});
</script>