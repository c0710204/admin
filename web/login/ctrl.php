<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte(false);

//print_r($_POST);

switch ($_POST['do']) {

    case "login":
        print_r($_POST);
        break;

    case "logout":
        print_r($_POST);
        $admin->logout();
        break;

    case "testProfile":
        //print_r($_POST);
        $configfile="../config/profiles/".$_POST['conf'];
        if (is_file($configfile)) {

            $conf = json_decode(file_get_contents($configfile));
            //exit;

            if ($err=json_last_error_msg()) {
                if ($err!='No error') {
                    //die("<pre>".print_r($err, true)."</pre>");
                    echo $admin->callout("danger", "<i class='fa fa-ban'></i> Profile error (json)", $err);
                    exit;
                }
            }


            $result = exec("ping -c 1 -W 1 ".$conf->pdo->host);
            if (!$result) {
                $msg="Couldnt reach ".$conf->pdo->host;
                echo $admin->callout("danger", "<i class='fa fa-ban'></i> Host error", $msg);
                exit;
            }

            //die($result);
            /*
            $pingresult = exec("ping -n 3 ".$conf->pdo->host, $outcome, $status);
            if (0 == $status) {
                $status = "alive";
            } else {
                $status = "dead";
            }
            die($status);
            */

            try {
                $dsn = "mysql:host=".$conf->pdo->host.";dbname=edxapp";
                $db = new \PDO($dsn, $conf->pdo->user, $conf->pdo->pass);
                 //echo "dsn=$dsn";
                 echo $admin->callout("success", "<i class='fa fa-thumbs-o-up'></i> PDO Connection Ok", "<pre>$dsn</pre>");
            } catch (PDOException $e) {
                //echo "<li>" . $e->getMessage();
                echo $admin->callout("danger", "<i class='fa fa-ban'></i> PDO Connection error", $e->getMessage());
            }

            // test mongo
            $str="mongodb://".$conf->mongo->host.":".$conf->mongo->port;

            //echo "<pre>$str</pre>";
            try {
                $mgdb= new MongoClient($str);
            } catch (MongoException $e) {
                //echo $admin->callout("danger", "Mongo Connection error", "$e");
                $mgdb=null;
                $err=$e;
            }
            /*
            if (!$mgdb) {
                die("nope");
                //throw new \Exception('Error: mongo connection');
                echo $admin->callout("danger", "Mongo Connection error", "Nope");
            }
            */
            if (isset($mgdb->connected)) {
                echo $admin->callout("success", "<i class='fa fa-thumbs-o-up'></i> MongoDB Connection Ok", "<pre>$str</pre>");//ok
            } else {
                echo $admin->callout("danger", "<i class='fa fa-ban'></i> Mongo Connection error", "$err");
            }

            //
            $_SESSION['configfile']=$configfile;

        } else {
            die("Error: config file not found");
        }
        break;

    default:
        die('Error');
}

/*
function json_last_error_msg() {
    static $errors = array(
        JSON_ERROR_NONE             => null,
        JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
        JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
        JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );
    $error = json_last_error();
    return array_key_exists($error, $errors) ? $errors[$error] : "Unknown error ({$error})";
}
*/