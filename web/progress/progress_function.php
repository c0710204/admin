<?php
// progress function

echo __FILE__."<hr />";


$chapters=$edxCourse->chapters($course_id);//list of chapters


$rcu=[];//relevent course units

foreach ($chapters as $k=>$chapter){
    foreach($edxCourse->unitChildrens($chapter[0]) as $sequence_id){//seq
        $rcu[$sequence_id]=$sequence_id;
        foreach ($edxCourse->unitChildrens($sequence_id) as $vertical_id) {//verticals are only structure elements, they are not 'seen' or 'logged'
            foreach ($edxCourse->unitChildrens($vertical_id) as $children_id) {
                $type=explode('/', $children_id)[4];
                if($type == 'html')continue;//children type html are not logged as seen
                $rcu[$children_id]=$children_id;
            }
        }
    }
}

//print_r($rcu);

echo "<li>".count($rcu)." rcu<br />";

$rcu=$edxCourse->releventCourseUnits($course_id);
echo "<li>".count($rcu)." rcu<br />";

