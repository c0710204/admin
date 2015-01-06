<?php
// progress sessions
// a view where we can see how much time the user spend on the course

echo "<h1>Progress sessions</h1>";
echo "<pre>";
print_r($edxApp->courseUnitData($course_id, $user_id));
echo "</pre>";


