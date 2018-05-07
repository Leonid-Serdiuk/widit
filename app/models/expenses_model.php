<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10.04.2017
 * Time: 19:34
 */
class Expenses_model extends Model
{
    private $table = 'expenses';

    public function getAll($period, $period_number, $type = 'array')
    {
        $field = ($period != 'week') ? '`created_at`' : '`created_at`, 1' ;
        $current = ($period != 'week') ? $period_number : $period_number ;
        $day_query = ($period == 'day') ? ' AND MONTH(`created_at`) = MONTH(CURRENT_DATE()) ' : '';
        $period = strtoupper($period);
        $query = "SELECT * FROM " . $this->table ." WHERE " . $period . "(" . $field . ") = " . $current . $day_query . " ORDER BY `created_at` DESC";
        $this->db->query($query);
        return ($type == 'object') ? $this->db->getArray() : $this->db->getObject();
    }

    public function getOne($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . "WHERE id = ':id'", array('id' => $id));
        return $this->db->getRow();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->last_insert_id;
    }

    public function update($data, $id)
    {
        $this->db->update($this->table, $data, array('id' => $id));
        return $id;
    }
}