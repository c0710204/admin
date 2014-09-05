<?php
// Forum recent activity

$body=$foot=[];

$contents = $forum->contents->find();
$contents->sort(['updated_at'=>-1]);
//$contents.limit(5);

$body[]="<table class='table table-condensed'>";
$body[]="<thead>";
$body[]="<th><i class='fa fa-user'></i> User</th>";
$body[]="<th>Message</th>";
$body[]="<th>Date</th>";
$body[]="<th width=20></th>";
$body[]="</thead>";
$body[]="<tbody>";

foreach ($contents as $r) {
    //echo "<pre>";var_dump($r);echo "</pre>";exit;
    if (!$r['visible']) {
        $class='text-muted';
    } else {
        $class='';
    }

    $body[]= "<tr class=$class>";
    $body[]= "<td><a href='../user/?id=".$r['author_id']."'>".$r['author_username'];
    //$r['author_id'];
    //$body[]= "<td>".$edxapp->courseName($r['course_id']);
    //$body[]= "<td>".$r['visible'];
    //$body[]= "<td>".typeIcon($r['_type']);
    $body[]= "<td>".typeIcon($r['_type'])." ".substr($r['body'], 0, 32);
    //$body[]= "<td>".date("Y-m-d H:i", $r['created_at']->sec);
    $body[]= "<td>".$admin->dateRelative($r['updated_at']->sec);
    $body[]= "<td width=20><a href=# title='".$r['_id']."' onclick=trashit('".$r['_id']."')><i class='fa fa-ban'></i></a></td>";
    $body[]= "</tr>";
    //echo "<pre>";print_r($r);echo "</pre>";
    
    //exit;
}

$body[]="</tbody>";
$body[]="</table>";

$foot[]="<div id=recentmsg>recent</div>";

function typeIcon($type)
{
    switch($type)
    {
        case 'Comment':
            return "<i class='fa fa-comments'></i>";
            break;
        
        case 'CommentThread':
            return "<i class='fa fa-comments'></i>";
            break;


        default:
            return $type;
    }
}

echo $admin->box("primary", "<i class='fa fa-bolt'></i> Recent activity", $body, $foot);
?>
<script>
function hideit(id){
    $('#recentmsg').html('Please wait...');
    $('#recentmsg').load('ctrl.php',{'do':'hide','id':id},function(x){
        alert(x);
    });
}

function trashit(id){
    $('#recentmsg').html('Please wait...');
    $('#recentmsg').load('ctrl.php',{'do':'trash','id':id},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}
</script>