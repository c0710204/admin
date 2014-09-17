<?php
/**
 * Canvas user migration class
 * by jambonbill
 */

namespace Admin;


class Canvas
{
    
    private $db='';

    public function __construct()
    {
        try {
            $dsn     = "pgsql:host=localhost;dbname=canvas_production";
            //echo "dsn=$dsn";
            $this->db = new \PDO($dsn, 'toto', 'caca');
        } catch (PDOException $e) {
            //$failed = true;
            echo "<li>error" . $e->getMessage();
        }
    }
    
    public function db()
    {
        return $this->db;
    }


    /**
     * Bring the list of courses
     * @return [type] [description]
     */
    public function courses()
    {
        $sql="SELECT id, name, account_id, course_code FROM courses WHERE account_id=1;";// WHERE 1
        $q = $this->db->query($sql);
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r;
        }
        return $DAT;
    }

    /**
     * Return user email for a given user_id
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function userEmail($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $q = $this->db->query("SELECT path as email FROM communication_channels WHERE user_id=$user_id AND path_type='email';");
        // AND workflow_state='active'
        
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            return $r['email'];
        }
        return false;
        //
    }

    /**
     * Return user enrollments
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function userEnrollments($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $sql="SELECT course_id, created_at FROM enrollments WHERE user_id=$user_id;";
        $q = $this->db->query($sql);
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $r['created_at']=substr($r['created_at'], 0, 19);
            $DAT[]=$r;
        }
        return $DAT;
    }


    /**
     * Return the list of user ids assocatied with accout [1]First Business MOOC
     * @param  integer $limit [description]
     * @return array         [description]
     */
    public function userIds($limit = 0)
    {
        if ($limit>1) {
            $sql="SELECT DISTINCT user_id FROM user_account_associations WHERE account_id=1 LIMIT $limit;";
        } else {
            $sql="SELECT DISTINCT user_id FROM user_account_associations WHERE account_id=1;";
        }

        $q = $this->db->query($sql) or die(print_r($canvas->db()->errorInfo(), true));
        
        $DAT=[];
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $DAT[]=$r['user_id'];
        }
        return $DAT;
    }


    /**
     * Return one user record
     * @param  integer $user_id [description]
     * @return [type]           [description]
     */
    public function user($user_id = 0)
    {
        $user_id*=1;
        
        if ($user_id<1) {
            return false;
        }

        $sql="SELECT id, name, sortable_name, created_at, updated_at FROM users WHERE id=$user_id;";
        $q=$this->db()->query($sql) or die(print_r($this->db()->errorInfo(), true));
        
        if ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            @$r['first_name']=trim(explode(',', $r['sortable_name'])[1]);
            $r['last_name']=trim(explode(',', $r['sortable_name'])[0]);
            
            $r['created_at']=substr($r['created_at'], 0, 19);
            $r['updated_at']=substr($r['updated_at'], 0, 19);

            $r['email']=$this->userEmail($r['id']);

            return $r;
        }
        return false;
    }
}


/*
La liste des cours sont stockes dans la table 'courses'

Les users sont stockes dans la table 'users'

Les accounts, c'est quoi : ?? Je sais pas, mais c'est dans la table 'accounts'.
Il y en a 3 : [1]First Business MOOC, [2]Site Admin, [3]Cours créés manuellement
Les users sont lies aux 'accounts' dans la table user_account_associations

On va garder les users de lies au [1]


Il y a une table course_account_associations. Je sais pas a quoi elle sert.




Les emails des users sont dans la table 'communication_channels'





des fragments de cours dans les tables : 

context_id et context_code sont les id des cours.
Par exemple context_id=1 == context_code=course_1 == MOOC Analyse financière

asset_user_accesses
assignments (pas mal de choses)
attachments (fichiers lies au cours)

content_tags
context_modules

conversation_messages : Un espece de forum/chat dans la table 

course_account_associations

course_sections : presque la liste des cours

courses : la liste des cours. tout simplement

*/