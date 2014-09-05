<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$box = new Admin\Box;
$smallbox= new Admin\SmallBox;
echo $admin->printPrivate();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Oppia test <small>Test</small></h1>
</section>

<!-- Main content -->
<section class="content">


  <oppia oppia-id="TRodQY5rP5Dq" exploration-version="3" src="https://www.oppia.org"></oppia>
  <script src="//cdn.jsdelivr.net/oppia/0.0.1/oppia-player.min.js"></script>

  <script>
  window.OPPIA_PLAYER.onExplorationLoadedPostHook = function(iframeNode) {
    console.log('Exploration loaded.');
  };
  </script>