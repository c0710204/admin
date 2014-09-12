
<div class="row">
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    Course unit id's
    <?php 
    //$unitCount=$edxCourse->unitCount($course_id);
    $units=$edxCourse->courseUnitIds($course_id);
    //echo "<li>unitCount=".$units->count()."<br />";
    /*
    foreach ($edxCourse->units($course_id) as $u) {
        $idstring=$u['_id']['tag'].'://'.$u['_id']['org'].'/'.$u['_id']['course'].'/'.$u['_id']['category'].'/'.$u['_id']['name'];
        $units[]=$idstring;
    }
    */
    echo "<pre>";
    foreach($units as $unit){
        echo "<a href='../course_unit/?id=$unit'>$unit</a>\n";
    }
    //print_r($units);
    echo "</pre>";
    ?>
    </section>
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    Progress data
    <?php 
    //table edxapp.courseware_studentmodule
    $progressData=$edxapp->courseUnitData($course_id, $user_id);
    //echo "<li>".count($progressData)." records<hr />";
    $DAT=[];

    foreach ($progressData as $r) {
        @$DAT[$r['module_id']]++;   
        //echo "<pre>";print_r($r);echo "</pre>";
    }
    echo "<pre>";
    //print_r($DAT);
    foreach ($DAT as $k => $v) {
        echo "<a href='../course_unit/?id=$k'>$k</a>\n";
    }
    ?>
    </section>

</div>
