<?php
// course unit - unit location

$body=[];
$foot=[];


$parents=[];
$uid=$unit_id;
while ($parent = $edxCourse->unitParent($uid)) {
    $parents[]=$parent;
    $uid=$parent;
}

if (count($parents)) {

    $parents=array_reverse($parents);

    $body[]="<ul class=location>";

    foreach ($parents as $parent) {
        $u=$edxCourse->unit($parent);
        $body[]="<li>";
        $body[]= $edxapp->categoryIcon($u['_id']['category']);//Icon
        $body[]= " <a href='?id=$parent' title='".ucfirst($u['_id']['category'])."'>";
        $body[]= $edxCourse->unitName($parent)."</a><br />";
        $body[]="<ul class=location>";
    }

    //the current unit
    $body[]="<li>";
    $body[]= $edxapp->categoryIcon($category)." $unitName<br />";
    $body[]="</ul>";
}

//childrens
if (isset($definition['children'])) {
    $body[]="<label>Children(s):</label>";
    $body[]="<ol>";
    foreach ($definition['children'] as $children) {
        $u=$edxCourse->unit($children);
        $category=$u['_id']['category'];
        $childName=$edxCourse->unitName($children);

        $body[]="<li>";
        $body[]=$edxapp->categoryIcon($category);
        $body[]=" <a href='?id=$children' title='$category'>".$childName."</a>";
        $body[]="<br />";
    }
    $body[]="</ol>";
}

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-crosshairs');
$box->title('Unit location');
$box->body($body);
echo $box->html();

?>
<style>
ul.location {
    list-style-type: none;
}
</style>