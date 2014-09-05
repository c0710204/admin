<?php
/**
 * EdxUser
 */
namespace Admin;

/**
* @brief Class providing edx course data
* author: jambon
*/
class EdxUser
{

    private $user_id ='';//edX

    public $pdo;//pdo
    public $mgdb;//mongodb

    public function __construct ($configfile = '')
    {
    }
}
