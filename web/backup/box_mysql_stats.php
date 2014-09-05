<?php
//mysql stats

// SHOW TABLE STATUS FROM edxapp;
$q=$admin->db()->query("SHOW TABLE STATUS FROM edxapp;") or die("mysql error");
$tableCount=$q->rowCount();
$records=0;
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $records+=$r['Rows'];
}

echo "<li>$tableCount tables";
echo "<li>$records records";
