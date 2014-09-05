<?php
// Course Textbooks

$data=$edxCourse->category("course");

$body=[];

if (isset($data['metadata']['pdf_textbooks'])) {
    foreach ($data['metadata']['pdf_textbooks'] as $textbook) {
        $body[]="<h4>".$textbook['tab_title']."</h4>";
        $body[]="<ol>";
        foreach ($textbook['chapters'] as $chapter) {
            $url=$chapter['url'];
            $body[]="<li> -> <a href='download.php?filename=$url' title='$url'>".$chapter['title']."</a>";
        }
        $body[]="</ol>";
    }
} else {
    $body[]=$admin->callout("danger", "Nope", "No textbook data");
}

$footer=[];
//$footer[]="<button class='btn btn-primary' onclick=''><i class='fa fa-book'></i> Save</button>";
//$footer[]="<span id='courseOverview'></span>";

echo $admin->box("primary", "<i class='fa fa-book'></i> Course Textbooks", $body, $footer, 'collapse');

?>
<script>
</script>