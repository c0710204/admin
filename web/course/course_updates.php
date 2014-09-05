<?php
// Course Updates

// $data = $course->course();

$data=$edxCourse->category("course_info", true);
//$textbooks=$data['metadata']['pdf_textbooks'];


$body=[];

foreach ($data as $dat) {
    if ($dat['_id']['name']=='handouts') {
        $handouts=$dat;
    }
    if ($dat['_id']['name']=='updates') {
        $updates=$dat;
    }
}

if (isset($updates['definition']['data']['items'])) {
    $items=$updates['definition']['data']['items'];
    //$body[]="<pre>".print_r($items, true)."</pre>";
    foreach ($items as $item) {
        $body[]="<li>" . $item['date'] ." : ". htmlentities($item['content']);
    }
} else {
    $body[]=$admin->callout("Danger", "No data");
}


$footer=[];
//$footer[]="<button class='btn btn-primary' onclick=''><i class='fa fa-book'></i> Save</button>";
//$footer[]="<span id='courseOverview'></span>";

echo $admin->box("primary", "<i class='fa fa-book'></i> Course Updates", $body, $footer);
?>
<script>
</script>