<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10.04.2017
 * Time: 18:31
 */
class Main_model extends Model
{
    public function test()
    {
        $array = array('username' => 'admin');
        $this->db->query("SELECT * FROM users WHERE username = :username", $array);
        $result = $this->db->getRow();
        return $result['name'];
    }
}