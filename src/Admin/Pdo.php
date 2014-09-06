<?php

namespace Admin;

class Pdo
{
    protected static $db_host     = '';
    protected static $db_name     = '';
    protected static $db_driver   = '';
    protected static $db_user     = '';
    protected static $db_pass     = '';
    protected static $dsn = '';
    protected static $db = null;
    //public $db = null;
    protected static $failed = false;

    public function __construct ()
    {
        //echo "__construct()";die();
        self::getConfig($configfile);
    }

    public static function getConfig ()
    {
        //echo "getConfig ($configfile = '');\n";
        if (is_file($_SESSION['configfile'])) {

            // Load configuration
            $config = json_decode(file_get_contents($_SESSION['configfile']));

            //echo "<pre>";print_r($config);exit;

            self::$db_host = $config->pdo->host;
            self::$db_name = $config->pdo->name;
            self::$db_driver=$config->pdo->driver;
            self::$db_user = $config->pdo->user;
            self::$db_pass = $config->pdo->pass;
        } else {
            throw new \RuntimeException(__FUNCTION__.' error: no config file like '.$_SESSION['configfile']);
        }
    }


    public static function getDatabase ()
    {
        //echo __FUNCTION__."()\n";exit;
        self::getConfig();

        try {
            $dsn     = self::$db_driver.":host=".self::$db_host.";dbname=".self::$db_name;
            //echo "dsn=$dsn";
            self::$db = new \PDO($dsn, self::$db_user, self::$db_pass);
        } catch (PDOException $e) {
            self::$failed = true;
            echo "<li>" . $e->getMessage();
        }
        return self::$db;
    }
}
