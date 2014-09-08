<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Users");
echo $admin->printPrivate();

$q=$admin->db()->query("SELECT COUNT(*) FROM edxapp.auth_user;") or die($admin->db()->errorInfo()[2]);
$count=$q->fetchColumn();
?>

<section class="content-header">
    <h1><i class="fa fa-users"></i> Users <small><?php echo "$count users";?></small></h1>
</section>

<!-- Main content -->
<section class="content">


<div class="row">
<section class="col-lg-12 connectedSortable">
<?php
include "box_search.php";
?>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <?php
        //results
        $box=new Admin\SolidBox;
        $box->id("boxlist");
        $box->icon('fa fa-users');
        $box->title("Users");
        $box->body("<div id='userList'></div>");
        //$box->footer("<button class=btn onclick=addUser()><i class='fa fa-user'></i> Add user</btn>");
        $box->loading(true);
        echo $box->html();
        //echo $admin->box("success", "<i class='fa fa-users'></i> Users", "<div id='userList'></div>", $footer);
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-5 connectedSortable">

        <?php
        $box=new Admin\Box;
        $box->type("primary");
        $box->id("boxdetails");
        $box->icon('fa fa-user');
        $box->title('User details');
        $box->style("position:fixed");
        $box->loading(true);
        echo $box->html("<div id='details'></div>");
        //echo $admin->box("success", "<i class='fa fa-list'></i> Details", "<div id='details'></div>");
        ?>
    </section>
</div>


<div id='userList'></div>


<!-- Modal New users -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-file'></i> New users</h4>
      </div>

      <div class="modal-body">
        List of users to create :<br />
        <textarea id='emails' placeholder='Paste emails here, one email per line' style='width:100%;height:100px;'></textarea>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-file'></i> Close</button>
        <button type="button" class="btn btn-primary" onclick='createUsers()'><i class='fa fa-save'></i> Create those users</button>
      </div>

    </div>
  </div>
</div>


<!-- Modal Alert -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-info'></i> Alert</h4>
      </div>

      <div class="modal-body" id='modal-body'>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-file'></i> Close</button>
      </div>

    </div>
  </div>
</div>


<script src='users.js'></script>