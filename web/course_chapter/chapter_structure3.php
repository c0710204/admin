<h1>Chapter structure 3</h1>
<?php
// chapter structure
/*
 - Permanent
   - Chapter
     - Sequential
       - Vertical
         - Any course units

$body=[];

$chapter=[];
foreach ($unit['definition']['children'] as $sequence_id) {

    //$body[]= "<td><b>".$edxapp->categoryIcon('sequential')." ".$edxCourse->unitName($sequence_id)."</a>";

    foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {
      
        //$body[]= "<i>".$edxapp->categoryIcon('vertical')." ".$edxCourse->unitName($vertical_id);//vertical
        
        foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
            $u=$edxCourse->unit($children_id);
        
            $ID=$u['_id'];
        
            // i4x://q/q/sequential/2795f34a935447db93bc4362bc84e1d7'
            $unit_id=$ID['tag'].'://'.$ID['org'].'/'.$ID['course'].'/'.$ID['category'].'/'.$ID['name'];

            $body[]= "<a href=../course_unit/?id=$unit_id>".basename($edxCourse->unitName($children_id))."</a> ";
        }
    }
}

$body[]="</table>";
/*
$box=new Admin\Box;
//$box->title("$unitName");
$box->title("Chapter structure II");
$box->icon('fa fa-sitemap');
$foot=[];
$foot[]="<a href=# class='btn btn-success>success</a> youpu";
$box->footer($foot);
echo $box->html($body);
*/