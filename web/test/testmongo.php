<?php
// mongo test
echo "<pre>";

$str="mongodb://192.168.33.10:27017";//my vm
//$str="";//local mongo

echo "str=$str\n";

$m = new \MongoClient("$str");
var_dump($m);

$db = $m->edxapp;


if ($m->connected) {
    echo "mongo connected :)\n";
    echo "------------------\n";
}

// count how much more plutonium there is
//$remaining = $radioactive->count(array('type' => 94));
$count = $db->modulestore->count();
echo "\$count=$count\n";

// distinct orgs
/*
$o=$db->modulestore->distinct('_id.org');
echo "org : ";
print_r($o);
*/

// distinct courses
/*
$o=$db->modulestore->distinct('_id.course');
echo "course : ";
print_r($o);
*/
echo "-------------------\n";


//print_r($courses);

if (deleteCourse($db->modulestore, 'video', 'vid00')) {
    //die("Course deleted\n");
}

print_r(courses($db->modulestore));exit;

/**
 * Return the full list of courses in a associative array
 * @return [type] [description]
 */
function courses($modulestore)
{
    if (!$modulestore) {
        return false;
    }

    $ops = ['$group'=>['_id'=>['course'=> '$_id.course', 'org'=> '$_id.org']]];
    $courses = $modulestore->aggregate($ops);
    if (!$courses['ok']) {
        return false;
    }
    //echo count($courses);

    //var_dump($courses);
    //die();
    $DAT=[];
    foreach ($courses['result'] as $k=>$v) {
        //$_id=$v[0];
        //print_r($v['_id']);
        $org = $v['_id']['org'];
        $course = $v['_id']['course'];
        $DAT["$org"][]=$course;
    }
    return $DAT;
}

//courses for a given org



//db.orders.distinct( 'ord_dt', { price: { $gt: 10 } } )
//$o=$db->modulestore->distinct('_id.org', array("course"=>array("=","Open_DemoX")));
//echo "distinct : ";
//print_r($o);


//if( deleteCourse($db->modulestore );

/**
 * Delete one course with a given org and name
 * @param  [type] $modulestore [description]
 * @param  string $org         [description]
 * @param  string $course      [description]
 * @return bool              [description]
 */
function deleteCourse($modulestore, $org = '', $course = '')
{
    if(!$modulestore)return false;
    if(!$org)return false;
    if(!$course)return false;

    //$m = new MongoClient();
    //$db = $m->edxapp;
    // sélectionne une collection (analogue à une table de base de données relationnelle)
    //$collection = $db->modulestore;

    $modulestore->remove(array("_id.course"=>$course, "_id.org"=>$org));
    return true;
}


/**
 * Return the list of distinct categories for a given course
 * @param  [type] $modulestore [description]
 * @param  string $org         [description]
 * @param  string $course      [description]
 * @return [type]              [description]
 */
function courseCategories($modulestore, $org = '', $course = '')
{

    $o=$db->modulestore->distinct('_id.org');
    //print_r($o);
}
