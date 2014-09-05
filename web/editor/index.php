<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Editor");

echo $admin->printPrivate();
?>

<section class="content-header">
    <h1><i class='fa fa-edit'></i> Editor <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php
//include "ckeditor.php";

include "editor.php";
