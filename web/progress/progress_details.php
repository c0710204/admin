<?php
// progress details

$ICON=[];//course unit icons
$ICON['course']="<i class='fa fa-book' title='Course'></i>";
$ICON['combinedopenended']="<i class='fa fa-book' title='combinedopenended'></i>";
$ICON['chapter']="<i class='fa fa-bookmark' title='Chapter'></i>";
$ICON['discussion']="<i class='fa fa-comments' title='Discussion'></i>";
$ICON['sequential']="<i class='fa fa-caret-square-o-right' title='Sequencial'></i>";
$ICON['textbook']="<i class='fa fa-file-pdf-o' title='Textbook'></i>";
$ICON['vertical']="<i class='fa fa-arrow-down' title='Vertical'></i>";
$ICON['html']="<i class='fa fa-code' title='Html'></i>";
$ICON['video']="<i class='fa fa-film' title='Video'></i>";
$ICON['peergrading']="<i class='fa fa-question' title='Peergrading'></i>";
$ICON['problem']="<i class='fa fa-question-circle' title='Problem'></i>";
$ICON['survey']="<i class='fa fa-question-circle' title='Survey'></i>";//survey

$cu=@$edxApp->courseUnitData($course_id, $user_id, 'course')[0];//get the root course record
$progressData=$edxApp->progressData($course_id, [$user_id])[$user_id];// user progress data

if ($cu && $progressdata) {
    
    $module_id=$cu['module_id'];// root course elelment
    
    // chapters
    $chapters=$edxCourse->chapters($course_id);//list of chapters
    $elements=$totalseen=$totalelements=0;
    
    if (in_array($module_id, $progressdata)) {
        $totalseen++;
    }

    // 
    $body=[];

    foreach ($chapters as $k=>$chapter){
        
        $chapter_id=$chapter[0];
        $chapter_name=$chapter[1];
        
        $chapter_elements=1;

        $CLASS='text-muted';
        if(in_array($chapter_id, $progressdata))$CLASS='';
        
        $body[]="<h3 class='$CLASS'><i class='fa fa-bookmark-o' title='Chapter $chapter_id'></i> ".ucfirst(strtolower($chapter_name));
        if($CLASS)$body[]="<i class='fa fa-circle-o pull-right' style='color:#ccc'></i>";
        else $body[]="<i class='fa fa-check-circle pull-right' style='color:#090'></i>";

        $body[]="</h3>";// chapter name
        

        
        $body[]="<table class='table table-condensed table-striped'>";
        /*
        $body[]="<thead>";
        $body[]="<th>*</th>";
        $body[]="<th>Name</th>";
        //$body[]="<th>Progress</th>";
        $body[]="</thead>";
        */        

        foreach($edxCourse->unitChildrens($chapter_id) as $sequence_id){//seq
            $chapter_elements++;

            $CLASS='text-muted';
            if(in_array($sequence_id, $progressdata))$CLASS='';
            $type=explode('/', $sequence_id)[4];
            $body[]="<tr class='$CLASS'>";
            $body[]="<td width=20>".$ICON[$type];
            $body[]="<td>".ucfirst(strtolower($edxCourse->unitName($sequence_id)));//sequence name
            
            if($CLASS)$body[]="<i class='fa fa-circle-o pull-right' style='color:#ccc'></i>";
            else $body[]="<i class='fa fa-check-circle pull-right' style='color:#090'></i>";

            foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {
                // verticals are only structure elements, they are not 'seen' or 'logged'
                $sequence_name=$edxCourse->unitName($sequence_id);
                $vertical_name=$edxCourse->unitName($vertical_id);
                //echo "<li>$sequence_name -> $vertical_name <i title='$vertical_id'>id</i>";//
                foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
                    
                    $type=explode('/', $children_id)[4];
                    if($type == 'html')continue;
                    
                    $chapter_elements++;
                    $CLASS='text-muted';

                    if(in_array($children_id, $progressdata))$CLASS='';
                    $body[]="<tr class='$CLASS'>";
                    $body[]="<td width=20>".$ICON[$type];
                    $body[]="<td>".$vertical_name;
                    //$body[]="<td>".$edxCourse->unitName($children_id);
                    
                    if($CLASS)$body[]="<i class='fa fa-circle-o pull-right' style='color:#ccc'></i>";
                    else $body[]="<i class='fa fa-check-circle pull-right' style='color:#090'></i>";
                }
            }
        }
        
        /*
        $body[]="<tfoot>";
        $body[]="<th>A</th>";  
        $body[]="<th>B</th>";  
        $body[]="</tfoot>";
        */
        $body[]="</table>";        
        $body[]="<i class='text-muted'>$chapter_elements element(s)</i>";
            
    }


} else {
    
    if (!$cu) {
        $body[] = "<li>Warning : no course record";
    }

    $body[]= "<li>Warning : no progressdata";
    $foot[]= "";
}

$box=new Admin\SolidBox;
$box->icon("fa fa-eye");
$box->title("Progress details");

echo $box->html($body);
