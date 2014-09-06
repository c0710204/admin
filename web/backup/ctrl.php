<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxBackup;

$admin = new AdminLte();
$admin->ctrl();
$conf=$admin->config();

//print_r($_POST);

switch($_POST['do']){

    case 'mysqlbackup':

        $user=$conf->pdo->user;
        $pass=$conf->pdo->pass;
        $host=$conf->pdo->host;

        $dest="archives/".date("Y-m-d")."_".$host.".sql.gz";
        $cmd="mysqldump --opt -v -h $host -u $user -p$pass edxapp | gzip -9 > $dest";
        $out=shell_exec($cmd);
        //die("<pre>$cmd\n$out</pre>");
        die('document.location.href="?";');
        break;

    case 'mongobackup':

        $host=$conf->mongo->host;
        $port=$conf->mongo->port;
        $user=$conf->mongo->user;
        $pass=$conf->mongo->pass;

        echo "<pre>";

        $cmd="mongodump  --host $host --port $port";//backup edxapp db
        echo "$cmd\n";
        $out=shell_exec($cmd);

        // $out=`mongodump --db edxapp --host 127.0.0.1 --port 27017 --out ./`;
        echo "$out\n";

        // compress
        $archive="archives/".date("Y-m-d")."_".$host."_mongo.tgz";
        $compress="tar -czvf $archive dump";
        echo "$compress\n";
        $out=shell_exec($compress);
        echo "out:$out\n";
        chmod($archive, 0777);
        
        // delete data
        $out=`rm -rf dump/edxapp`;

        echo "</pre>";

        die('document.location.href="?";');
        break;




    //
    case 'delete':
        //print_r($_POST);
        $filename="archives/".$_POST['file'];
        if (is_file($filename) && unlink($filename)) {
           die('document.location.href="?";');
        } else {
            die("error");
        }
        exit;

    default:
        die("Error : unknow action ".$_POST['do']);
        break;
}
