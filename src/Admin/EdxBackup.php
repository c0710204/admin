<?php

/**
 * This is a php class for edxDbBackup
 * @author jambonbill
 */
namespace Admin;

/**
* @brief Class providing Edxbackup Functions
*/
class EdxBackup
{

    private $db = null;
    private $config = null;//admin config

    // user, to complete
    public $django = null;//UserDjango()

    public function __construct ()
    {
        @$this->loadConfig();
        if ($this->config) {
            $this->db = Pdo::getDatabase($_SESSION['configfile']);
            $this->django = new UserDjango($this->db);//
            $this->session = $this->django->djangoSession();//
            $this->user = $this->django->user($this->session['session_data']);//'session_data' hold the django user id
        } else {
            //echo "<li>Error: config not loaded\n";
            return false;
        }
    }


    /**
     * Load config file
     * @return [type] [description]
     */
    private function loadConfig()
    {
        // Load configuration
        if (!isset($_SESSION['configfile'])) {
            return false;
        }

        if (is_file($_SESSION['configfile'])) {
            // todo : make sure that the file is in readonly for improved security
            $this->config = json_decode(file_get_contents($_SESSION['configfile']));
            return $this->config;
        }
        return false;
    }



    /* backup the db OR just a table */
    public function backup_tables()
    {

        //echo __FUNCTION__;
        //$link = mysql_connect($host,$user,$pass);
        //mysql_select_db($name,$link);

        //get all of the tables
        $tables = array();
        $q = $this->db->query('SHOW TABLES');
        while  ($r = $q->fetch()) {
            $tables[] = $r[0];
        }

        //print_r($tables);exit;
        $return='';

        //cycle through
        foreach ($tables as $table) {

            $q = $this->db->query('SELECT * FROM '.$table);//$result
            //$num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE '.$table.';';

            $q2=$this->db->query('SHOW CREATE TABLE '.$table);
            $row2 = $q2->fetch(\PDO::FETCH_NUM);
            $return.= "\n\n".$row2[1].";\n\n";

            //for ($i = 0; $i < $num_fields; $i++) {
                while ($row = $q->fetch(\PDO::FETCH_NUM)) {
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for ($j=0; $j<count($row); $j++) {

                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n", "\\n", $row[$j]);

                        if (isset($row[$j])) {
                            $return.= '"'.$row[$j].'"' ;
                        } else {
                            $return.= '""';
                        }

                        if ($j<(count($row)-1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
            //}

            $return.="\n\n\n";
            //return $return;//stop at first table
        }

        return $return;
    }

    /*
      //save file
        $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);
     */
}
