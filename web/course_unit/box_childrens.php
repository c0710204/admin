<?php
// course unit - box vertical

$body=[];
//show childrens

if (isset($definition['children'])) {
    //$body[]="<hr />";
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

$foot=[];
//$foot[]="<button class='btn'><i class='fa fa-save'></i> Save</button>";

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-sitemap');
$box->title('Childrens');
$box->body($body);
echo $box->html();
?>
<style>
ul.location {
    list-style-type: none;
}
</style>