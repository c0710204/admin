<?php
// chapter structure
$body=$foot=[];
$body[]="";

//echo "<pre>"; print_r($unit['definition']['children']); echo "</pre>";
$i=1;
foreach ($unit['definition']['children'] as $sequence_id) {
    // category : sequencial

    //echo "<h3>".$edxapp->categoryIcon('sequential')." ".$edxCourse->unitName($sequence_id)."</h3>";
    $body[]= "<a href=# class='list-group-item active'><b>".$i."</b> ".$edxapp->categoryIcon('sequential')." ".$edxCourse->unitName($sequence_id)."</a>";

    $verticals=$edxCourse->unitChildrens($sequence_id);

    foreach ($verticals as $vertical_id) {
        //category : verticals
        $body[]= "<ul class='list-group'>";

        //echo "<a href=# class='list-group-item active'>".$edxapp->categoryIcon('vertical')." <b>".$edxCourse->unitName($vertical_id)."</b></a>";
        $body[]= "<li>";// class='list-group-item'
        $body[]= "<a href=#>".$edxapp->categoryIcon('vertical')." ".$edxCourse->unitName($vertical_id)."</a>";

        $body[]= "<ul>";// class='list-group'

        $childrens=$edxCourse->unitChildrens($vertical_id);
        //var_dump($childrens);
        foreach ($childrens as $children_id) {
            $u=$edxCourse->unit($children_id);
            $ID=$u['_id'];
            // i4x://q/q/sequential/2795f34a935447db93bc4362bc84e1d7'
            $unit_id=$ID['tag'].'://'.$ID['org'].'/'.$ID['course'].'/'.$ID['category'].'/'.$ID['name'];

            $body[]= "<li>";// class='list-group-item'
            $body[]= $edxapp->categoryIcon($ID['category']);
            $body[]= " <a href=../course_unit/?id=$unit_id>".$edxCourse->unitName($children_id)."</a>";
            $body[]= "</li>";
        }
        $body[]= "</ul>";
        $body[]= "</ul>";
    }
    $i++;
}

$box=new Admin\SolidBox;
//$box->title("$unitName");
$box->title("Chapter structure");
$box->icon('fa fa-sitemap');
$box->body($body);
echo $box->html();
