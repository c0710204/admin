<?php
// List of org (organisations) :

echo "<h1>Organisations</h1>";

$m = new \MongoClient();
$db = $m->edxapp;


$o=$db->modulestore->distinct('_id.org');
print_r($o);
