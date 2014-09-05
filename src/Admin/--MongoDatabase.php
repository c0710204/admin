<?php

namespace Admin;

class MongoDatabase
{
    public $db = null;
    public $failed = false;

    public function __construct ($configfile = '')
    {
        if (!is_file($configfile)) {
            throw new \Exception('Error: no config file like "'.$configfile.'"');
            return false;
        } else {
            // Load configuration
            $this->config = json_decode(file_get_contents($configfile));
        }

        $str="mongodb://".$this->config->mongo->host.":".$this->config->mongo->port;//my vm

        if (!$this->db = new \MongoClient($str)) {
            throw new \Exception('Error: mongo connection');
        }

        if (!$this->db->connected) {
            //$this->modulestore = $this->mgdb->edxapp->modulestore;
            throw new \Exception('Error: no mongo connection');
        }
        return $this->db;
    }

    private function __clone()
    {
    }
    /*
    public static function getDatabase()
    {
        if (self::$failed == false && is_null(self::$db)) {

            $db_host     = '';
            $db_name     = '';
            $db_driver   = '';
            $db_user     = '';
            $db_password = '';

            try {
                self::$db = new \MongoClient();//todo complete here
            } catch (PDOException $e) {
                self::$failed = true;
                echo "<li>" . __FILE__ . __FUNCTION__ . " error : " . $e->getMessage();
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
