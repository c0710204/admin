<?php
// course unit - box vertical

$body=[];
//show childrens

if (isset($definition['children'])) {
    //$body[]="<hr />";
    $body[]="<b>Children(s):</b><br />";
    foreach ($definition['children'] as $children) {
        $childName=$edxCourse->unitName($children);
        $body[]="<li><a href='?id=$children'>".$childName."</a>";
    }
}

$foot=[];
//$foot[]="<button class='btn'><i class='fa fa-save'></i> Save</button>";

echo $admin->box("primary", $edxapp->categoryIcon('vertical')." Vertical", $body, $foot);
?>
<style>
ul.location {
    list-style-type: none;
}
</style>