<?php
// course forum moderators
$htm=[];

// Forum admin and moderators
$group_id=$edxapp->clientRoles($course_id)['Moderator'];
$users=$edxapp->clientRoleUsers($group_id);

$htm[]= "<table class='table table-condensed table-striped'>";

foreach ($users as $k => $user_id) {
    $htm[]= "<tr>";
    $htm[]= "<td><a href='../user/?id=$user_id'>".$edxapp->userName($user_id);//nothin
}
$htm[]= "</table>";


$footer=[];



$box=new Admin\SolidBox;
$box->icon('fa fa-comments-o');
$box->title(count($users)." forum moderator(s)");
$box->collapsed(!$threads->count());

echo $box->html($htm, $footer);
