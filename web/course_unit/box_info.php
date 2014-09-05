<?php
// course unit - box info

if (!isset($metadata['start'])) {
    $metadata['start']='';
}

$body=[];


// org
$body[]='<div class="col-lg-6">';
$body[]='<div class="form-group">';
$body[]='<label><i class="fa fa-book"></i> <a href=#>'.$edxapp->courseName($course_id).'</a></label>';
//$body[]='<div><a href=#>Real course name to add here</a></div>';
$body[]='</div>';
$body[]='</div>';


// org
$body[]='<div class="col-lg-3">';
$body[]='<div class="form-group">';
$body[]='<label>Org: </label> '.$ID['org'];
//$body[]='<div class=form-control readonly>'.$ID['org'].'</div>';
$body[]='</div>';
$body[]='</div>';


// course
$body[]='<div class="col-lg-3">';
$body[]='<div class="form-group">';
$body[]='<label>Course: </label> '.$ID['course'];
//$body[]='<div class=form-control readonly>'.$ID['course'].'</div>';
$body[]='</div>';
$body[]='</div>';





// display name
$body[]='<div class="form-group">';
$body[]='<label>Display name</label>';
$body[]='<input type="text" class="form-control" id="displayName" value="'.@$metadata['display_name'].'">';
$body[]='</div>';

// start
if ($metadata['start']) {
    $body[]='<div class="form-group">';
    $body[]='<label>Start</label>';
    $body[]='<input type="text" class="form-control" id="start" value="'.$metadata['start'].'">';
    $body[]='</div>';
}

// location
$parents=[];
$uid=$unit_id;
while ($parent = $edxCourse->unitParent($uid)) {
    $parents[]=$parent;
    $uid=$parent;
}

if (count($parents)) {

    $parents=array_reverse($parents);

    $body[]="<label>Location:</label>";
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
    //$body[]="</ul>";
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


$foot=[];
$foot[]="<button class='btn'><i class='fa fa-save'></i> Save</button>";

$box=new Admin\Box;
$box->html("primary");
$box->icon('fa fa-info');// "<i class=></i> Unit : ".ucfirst($category)." <small>$name</small>", $body, $foot);
$box->title("Unit : ".ucfirst($category)." <small>$name</small>");
echo $box->html($body);
