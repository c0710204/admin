<?php
// chapter structure
$body=[];

$body[]="<table class='table table-condensed'>";
$body[]="<thead></thead>";
$body[]="<tbody>";
foreach ($unit['definition']['children'] as $sequence_id) {

    $body[]= "<tr class=sequentials>";
    $body[]= "<td><b>".$edxapp->categoryIcon('sequential')." ".$edxCourse->unitName($sequence_id)."</a>";
    $body[]= "<td><i class='fa fa-check-circle' style='color:#008d4c'></i></td>";

    foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {
        //category : verticals
        $body[]= "<tr class='verticals'>";
        $body[]= "<td><span class='label col-lg-2' style='width:20px'>-</span> ";// class='list-group-item'
        $body[]= "<i>".$edxapp->categoryIcon('vertical')." ".$edxCourse->unitName($vertical_id);//vertical

        $body[]= "<td><i class='fa fa-circle-thin' style='color:#ccc'></i></td>";

        foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
            $u=$edxCourse->unit($children_id);
            $ID=$u['_id'];
            // i4x://q/q/sequential/2795f34a935447db93bc4362bc84e1d7'
            $unit_id=$ID['tag'].'://'.$ID['org'].'/'.$ID['course'].'/'.$ID['category'].'/'.$ID['name'];

            $body[]= "<tr class=units>";
            $body[]= "<td><span class='label col-lg-2' style='width:40px'>-</span> ";// class='list-group-item'
            $body[]= "<a href=../course_unit/?id=$unit_id>".basename($edxCourse->unitName($children_id))."</a> ";
            $body[]= $edxapp->categoryIcon($ID['category']);
            $body[]= " <small class='text-muted'><i>".$ID['category']."</i></small>";
            $body[]= "</li>";
            
            $body[]= "<td><i class='fa fa-circle-thin' style='color:#ccc'></i></td>";
        }
    }
}

$body[]="</table>";

$box=new Admin\SolidBox;
//$box->title("$unitName");
$box->title("Chapter structure II");
$box->icon('fa fa-sitemap');

$foot=[];
$foot[]="<a href=# class='btn btn-success'>success</a>";

echo $box->html($body, $foot);
