<?php
//course tabs
$body=[];

if (isset($meta['tabs'])) {

    $body[]="<ul class='todo-list ui-sortable'>";

    foreach ($meta['tabs'] as $k => $v) {
        //$body[]=print_r($v, true);

        $body[]="<li>";

        //<!-- drag handle -->
        $body[]="<span class=handle>";
        $body[]="<i class='fa fa-ellipsis-v'></i>";
        $body[]="<i class='fa fa-ellipsis-v'></i>";
        $body[]="</span>";

        //<!-- checkbox -->
        //$body[]="<div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" value="" name="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>

        //<!-- todo text -->
        $body[]="<span class=text>".$v['name']."</span>";

        //<!-- Emphasis label -->
        //$body[]="<small class='label label-danger'><i class='fa fa-clock-o'></i> 2 mins</small>";
        if (@$v['url_slug']) {
            $body[]="<a href=#>" . $v['url_slug'] . "</a>";//url_slug
        }

        //<!-- General tools such as edit or delete-->
        $body[]="<div class=tools>";
        //$body[]="<i class='fa fa-edit'></i>";
        $body[]="<i class='fa fa-trash-o'></i>";
        $body[]="</div>";
        $body[]="</li>";
    }
    $body[]="</ul>";

} else {
    $body[]=$admin->callout("danger", "Warning", "Error : no tabs!");
}



$footer="<a href=# class='btn btn-default'>Add tab</a>";
$footer.="<button class='btn btn-default pull-right'><i class='fa fa-plus'></i> Add tab</button>";

echo $admin->box("danger", "<i class='fa fa-list'></i> Course Tabs <small>category : static_tab</small>", $body, $footer, "collapse");

//echo "Course metadata : ";
//$meta=$edxapp->course_metadata($org, $course);
//echo "<pre>".print_r($meta, true)."</pre>";
