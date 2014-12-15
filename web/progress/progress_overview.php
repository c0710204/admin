<?php
// progress overview, simplified view per chapters

// user started at
$cu=@$edxApp->courseUnitData($course_id, $user_id, 'course')[0];//get the course record

//echo "<pre>";print_r($cu);echo "</pre>";

//debug
//$test=$edxCourse->unitChildrens('i4x://MJ/001/vertical/7528faad16764523a37c4d2415d4323e');
//var_dump($test);exit;


    //$pd=$edxApp->courseUnitData($course_id, $user_id);// get the user progress data
//$progressdata=[];
//foreach($pd as $r)$progressdata[]=$r['module_id'];// lookup table

$progressdata=@$edxApp->progressData($course_id, [$user_id])[$user_id];

if ($cu && $progressdata) {
    
    $module_id=$cu['module_id'];// root course elelment
    
    // chapters
    $chapters=$edxCourse->chapters($course_id);//list of chapters
    $elements=$totalseen=$totalelements=0;
    
    if (in_array($module_id, $progressdata)) {
        $totalseen++;
        //print_r($cu);exit;
    }

    // 
    $body=[];
    $body[]="<table class='table table-condensed table-striped'>";
    $body[]="<thead>";
    $body[]="<th>Chapter</th>";
    $body[]="<th>Progress</th>";
    $body[]="</thead>";

    foreach ($chapters as $k=>$chapter){
        
        $chapter_id=$chapter[0];
        $chapter_name=$chapter[1];
        $elements++;//the chapter is the 1st element
        
        $seen=0;
        if(in_array($chapter_id, $progressdata))$seen++;

        foreach($edxCourse->unitChildrens($chapter_id) as $sequence_id){//seq
            $elements++;
            if(in_array($sequence_id, $progressdata))$seen++;
            foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {//verticals are only structure elements, they are not 'seen' or 'logged'
                //echo "<li>vertical_id=$vertical_id";
                foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
                    $type=explode('/', $children_id)[4];
                    if($type == 'html')continue;
                    $elements++;
                    if(in_array($children_id, $progressdata))$seen++;
                }
            }
        }
        
        $pct=$seen/$elements*100;// chapter progress
        $totalseen+=$seen;
        $totalelements+=$elements;
        
        $body[]="<tr>";
        
        if(in_array($chapter_id, $progressdata)){
            $body[]="<td>";
        }else{
            $body[]="<td class='text-muted'>";
        }
        $body[]="<a href=#><i class='fa fa-bookmark-o'></i></a> ".ucfirst(strtolower($chapter_name));// chapter name
        $body[]="<td title='$seen / $elements'><div class='progress xs'><div class='progress-bar progress-bar-green' style='width: $pct%;'></div></div>";

        $elements=0;//resest elements count
    }

    $body[]="<tfoot>";
    $body[]="<th>Total progress</th>";

    $pct=$totalseen/$totalelements*100;// chapter progress
    $body[]="<th>".round($pct)."%</th>";
    $body[]="</tfoot>";
    $body[]="</table>";

    $foot="<a href=# class='btn btn-default'>See in details</a>";

} else {
    
    if (!$cu) {
        $body[] = "<li>Warning : no course record";
    }

    $body[]= "<li>Warning : no progressdata";
    $foot[]= "";
}

$box=new Admin\SolidBox;
$box->icon("fa fa-eye");
$box->title("Progress overview <small>Course started @ ".substr($cu['created'],0,16)."</small>");

echo $box->html($body,$foot);



//print_r($chapters);
//echo "<pre>$totalelements elements</pre>";


