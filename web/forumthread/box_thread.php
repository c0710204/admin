<?php
// thread

$contents = $forum->contents->find(["comment_thread_id"=>new \MongoId($_GET['id'])]);
//$contents->limit(3);

$replies=[];
$comments=[];

foreach ($contents as $r) {

    if ($r['parent_ids']) {
        //print_r($r['parent_ids']);
        $parent_id=$r['parent_ids'][0];
        $comments["$parent_id"][]=$r;
        //print_r($r);
        //continue;
    } else {
        $replies[]=$r;
    }
    /*
    echo "<pre>";
    
    $created=$r['created_at']->sec;
    $date=date("Y-m-d H:i:s", $created);

    //$r['author_id']
    echo "<a href=# title='".$r['_id']."'>id</a> ";
    echo "<a href=#>".$r['author_username'] . "</a>  <span class='pull-right'>$date</span><br />";
    
    //echo " $date";

    echo $r['body']."<br />";
    
    echo "<a href=# title='delete'>x</a>";

    echo "</pre>";
    */
}

$body=[];

$body[]='<div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">';
                                    
foreach ($replies as $r) {
    $ID=$r['_id'];
    $created=$r['created_at']->sec;
    $date=date("Y-m-d H:i", $created);

    $body[]='<div class="item">';
    //$body[]='';
    //$body[]='<i class="fa fa-user"></i> ';
    $body[]='<img src="../img/user.jpg" alt="user image" class="online">';
    $body[]='<p class="message">';
    
    $body[]='<a href="../user/?id='.$r['author_id'].'" class="name">';
    $body[]='<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '.$date.'</small>';
    $body[]=ucfirst($r['author_username']);
    $body[]="</a>";
    $body[]=$r['body'];
    $body[]='<small class="text-muted pull-right" title='.$ID.'><a href=# onclick=deleteContent("'.$ID.'")><i class="fa fa-trash-o"></i></a></small>';
    $body[]='</p>';

    //comments
    
    if (isset($comments["$ID"])) {


        //$coms=$comments["$ID"];
        //echo "<pre>".print_r($coms,true)."</pre>";
        
        $body[]="<h4>".count($comments["$ID"])." comment(s):</h4>";


        foreach ($comments["$ID"] as $com) {
        $body[]="<div class=attachment>";

            //$body[]=$com['author_username'].":".;
            $body[]="<p class=filename><a href='../user/?id=".$com['author_id']."'>".$com['author_username']."</a> : ".$com['body']."</p>";
            $body[]="<small class='pull-right'><a href=# onclick=deleteContent('".$com['_id']."')><i class='fa fa-trash-o'></i></a></small>";
            //print_r($com);        
            $body[]="</div>";

        }

    }
    
    $body[]='</div>';
    $body[]='<hr />';
}

$body[]='</div>';//box-body chat
/*
<div class="item">
    <img src="img/avatar.png" alt="user image" class="online">
    <p class="message">
        <a href="#" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
            Mike Doe
        </a>
        I would like to meet you to discuss the latest news about
        the arrival of the new theme. They say it is going to be one the
        best themes on the market
    </p>
    <div class="attachment">
        <h4>Attachments:</h4>
        <p class="filename">
            Theme-thumbnail-image.jpg
        </p>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm btn-flat">Open</button>
        </div>
    </div><!-- /.attachment -->
</div>
*/

$box=new Admin\SolidBox;
$box->type("success");
$box->icon("fa fa-comments-o");
$box->title(count($replies)." Replie(s)");
$box->body($body);
echo $box->html();
