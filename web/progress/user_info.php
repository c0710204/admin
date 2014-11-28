<?php
// user
    if ($user_id) {
        $user=$edxApp->user($user_id);
    }



    $box=new Admin\SolidBox;
    $box->icon("fa fa-user");
    $box->title("User info");

    $body=[];
    
    if (!$user) {
        $body[] = new Admin\Callout("danger","user #$user_id not found");
    } else {
        $body[]='<a href="../user/?id='.$user_id.'">'.ucfirst($user['username']).'</a> - '.$user['email'].' #'.$user_id.'</a>';
    }

    // user name
    /*
    $body[]='<div class="form-group">';
    $body[]='<label><i class="fa fa-user"></i></label> <a href="../user/?id='.$user_id.'">'.ucfirst($edxapp->username($user_id)).' ('.$user_id.')</a>';
    $body[]='</div>';
    */

    /*
    $body[]='<div class="form-group">';
    $body[]='<label><i class="fa fa-user"></i></label>';
    $body[]='<a href="../user/?id='.$user_id.'">'.ucfirst($edxapp->username($user_id)).' ('.$user_id.')</a>';
    $body[]='<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" value="'.$usr['username'].'">';
    $body[]='</div>';
    
    <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" value="<?php echo $usr['username']?>">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">First name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="First name" value="<?php echo $usr['first_name']?>">
        </div>
    */

    
    //$body[]=print_r($user,true);

    echo $box->html($body);