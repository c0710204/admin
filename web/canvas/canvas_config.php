<?php
//admin :: canvas config

$box=new Admin\SolidBox;
$box->id("configbox");
$box->type("danger");
$box->title("Canvas db config");
$box->icon("fa fa-wrench");
$box->loading(true);

$htm=[];

// host
$htm[]="<div class='form-group input-group'>";
$htm[]="<div class='input-group-addon'><i class='fa fa-laptop'></i></div>";//icon
$htm[]="<input type=text id=host class=form-control placeholder=host value='".@$_SESSION['canvas']['host']."'>";
$htm[]="</div>";


// database
$htm[]="<div class='form-group input-group'>";
$htm[]="<div class='input-group-addon'><i class='fa fa-database'></i></div>";//icon
$htm[]="<input type=text id=database class=form-control placeholder=database value='".@$_SESSION['canvas']['database']."'>";
$htm[]="</div>";

// username
$htm[]="<div class='form-group input-group'>";
$htm[]="<div class='input-group-addon'><i class='fa fa-user'></i></div>";//icon
$htm[]="<input type=text id=user class=form-control placeholder=username value='".@$_SESSION['canvas']['user']."'>";
$htm[]="</div>";


// password
$htm[]="<div class='form-group input-group'>";
$htm[]="<div class='input-group-addon'><i class='fa fa-key'></i></div>";//icon
$htm[]="<input type=text id=pass class=form-control placeholder=password value='".@$_SESSION['canvas']['pass']."'>";
$htm[]="</div>";

//$htm[]="dbname";
//$htm[]="login";
//$htm[]="password";

$foot=[];
$foot[]="<a href=# id='btnconnect' class='btn btn-default'>Connect to Canvas</a>";
?>

<section class="content">
    <div class="row">
        <section class="col-lg-6 connectedSortable">
        <?php 
        echo $box->html($htm, $foot);
        if (isset($_SESSION['canvas'])) {
            echo "<pre>";
            print_r($_SESSION['canvas']);
            echo "</pre>";
        }
        ?>
        </section>
    </div>
    <div id='more'></div>
</section>


<script>
function connect(){
    
    console.log("connect()");
    
    $("#configbox .overlay, #configbox .loading-img").show();
    
    var p = {
        'do':'connect',
        'host':$('#host').val(),
        'database':$('#database').val(),
        'user':$('#user').val(),
        'pass':$('#pass').val()
    };

    $('#more').load("ctrl.php", p, function(x){
        try{ eval(x); }
        catch(e){ alert(x); }
        $("#configbox .overlay, #configbox .loading-img").hide();
    });
}

$(function(){
    $("#configbox .overlay, #configbox .loading-img").hide();
    $("#btnconnect").click(function(){
        connect();
    });
});
</script>
