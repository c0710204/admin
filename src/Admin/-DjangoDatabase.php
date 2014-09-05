<?php

namespace Admin;

class DjangoDatabase
{

    protected static $db_host     = '';
    protected static $db_name     = '';
    protected static $db_driver   = '';
    protected static $db_user     = '';
    protected static $db_password = '';

    //protected static $db = null;
    public $db = null;
    protected static $failed = false;

    public function __construct ($configfile = '')
    {
        if (is_file($configfile)) {

            // Load configuration
            $config = json_decode(file_get_contents($configfile));
            //$this->$db_name;
            print_r($config);
        } else {
            throw new \RuntimeException('Database error: no config file');
        }
    }


    public static function getDatabase ()
    {
        return $this->db;
    }

    /*
    private function __clone()
    {
    }
    */



    /*
    public static function getDatabase ()
    {
        if (self::$failed == false && is_null($this->db)) {
            $db_host     = 'localhost';
            $db_name     = 'edxapp';
            $db_driver   = 'mysql';
            $db_user     = 'cron';
            $db_password = 'robotix';
            $dsn = "${db_driver}:host=${db_host};dbname=${db_name}";

            try {
                $this->db = new \PDO($dsn, $db_user, $db_password);
            } catch (PDOException $e) {
                self::$failed = true;
                echo "<li>" . $e->getMessage();
            }
        }

        if (self::$failed) {
            return false;
        } else {
            return $this->db;
        }
    }
    */

    /*
    public static function getDatabase ()
    {
        if (self::$failed == false && is_null(self::$db)) {
            $db_host     = 'localhost';
            $db_name     = 'edxapp';
            $db_driver   = 'mysql';
            $db_user     = 'cron';
            $db_password = 'robotix';
            $dsn = "${db_driver}:host=${db_host};dbname=${db_name}";

            try {
                self::$db = new \PDO($dsn, $db_user, $db_password);
            } catch (PDOException $e) {
                self::$failed = true;
                echo "<li>" . $e->getMessage();
            }
        }

        if (self::$failed) {
            return false;
        } else {
            return self::$db;
        }
    }
    */
}
