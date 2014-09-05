<?php

$box = new Admin\Box;
//$box->id("box1");
$box->type("primary");
$box->icon("fa fa-dashboard");
$box->title("Box class id=".$box->id('toto'));
$box->body("<h1>Super body</h1>");
$footer=[];
$footer[]="<a href=# class='btn btn-primary' onclick=boxload('toto')>Load</a>";
$footer[]="<a href=# class='btn btn-primary' onclick=console.log()>Html</a>";
$box->footer($footer);



echo '<section class="col-lg-6 connectedSortable">';
echo $box->html();
echo '</section>';

$box = new Admin\Box;
$box->id('box123');
$box->loading(true);
$box->body("<h1>Box body lorem lipsum</h1>");
$box->footer($box->id());
echo '<section class="col-lg-6 connectedSortable">';
echo $box->html();
echo '</section>';

?>



<script>

function boxloaded(id){
   // $(target).
    $('#'+id+' .overlay').hide();
    $('#'+id+' .loading-img').hide();
}

function boxtitle(id){
    return $('#'+id+' .box-title');
}

function boxbody(id){// good shortcut
    return $('#'+id+' .box-body');
}

function boxfooter(id){
    return $('#'+id+' .box-footer');
}

function boxload(id){
    console.log('boxload('+id+')');
    $('#'+id+' .overlay').show();
    $('#'+id+' .loading-img').show();
}



$(function(){
    $('#btn_loading').click(function(){
        $('#box1 .overlay').show();
        $('#box1 .loading-img').show();
    });
    $('#btn_loaded').click(function(){
        //$('#box1 .overlay').hide();
        //$('#box1 .loading-img').hide();
        boxloaded('box1');
    });

    function youpi(){
        alert('youpi()');
    }

});

</script>