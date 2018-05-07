<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 09.05.2017
 * Time: 13:52
 */

class DataBase
{
    /** @var PDO object*/
    private $dbo;
    /** @var  PDOStatement object*/
    private $stmt;
    /** @var int count of midified rows */
    public $count_rows = 0;
    /** @var  int id of last insert row */
    public $last_insert_id;

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        // Set connection variables
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        // Connect to database and get PDO object
        $this->dbo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }

    /**
     * Set and execute MySql query.
     * @param string $sql
     * @param array $bind
     * @return void
     */
    public function query($sql, $bind = array())
    {
        try {
            // Prepeare sql string
            $this->stmt = $this->dbo->prepare($sql);
            // Execute query
            $this->stmt->execute($bind);
        }
        catch (Exception $e)
        {
            HttpError::show(500, $e->getMessage());
        }
    }

    /**
     * Insert data to database
     * @param string $table database table
     * @param array $data associated array of data where key = database field name and value = db value
     * @return void
     */
    public function insert($table, $data)
    {
        // Get array of part query strings
        $pre_data = implode(",", $this->getPrepeareValues($data));
        // Sql query
        $sql = "INSERT INTO $table SET $pre_data";
        try {
            // Prepeare sql query
            $this->stmt = $this->dbo->prepare($sql);
            // Execute the query
            $this->stmt->execute($data);
        }
        catch (Exception $e)
        {
            HttpError::show(500, $e->getMessage());
        }
        // Set last insert id
        $this->last_insert_id = $this->dbo->lastInsertId();
        // Set count of modified rows
        $this->count_rows = $this->stmt->rowCount();

        return true;
    }

    /**
     * Update data to database.
     * @param string $table table name
     * @param array $data associated array of modified data
     * @param array $where associated array of filter values
     * @return void
     */
    public function update($table, $data, $where)
    {
        // Get array of part query strings for set
        $pre_data = implode(",", $this->getPrepeareValues($data));
        // Get array of part query strings for filter
        $where_data = implode(" AND ", $this->getPrepeareValues($where, "where_"));
        // Proccess where array for binding
        $where = $this->setKeyPrefix($where, "where_");
        // Query string
        $sql = "UPDATE $table SET $pre_data WHERE $where_data";
        try {
            // Set query string
            $this->stmt = $this->dbo->prepare($sql);
            // Execute the query
            $this->stmt->execute(array_merge($data, $where));
        }
        catch (Exception $e)
        {
            HttpError::show(500, $e->getMessage());
        }
        // Set count of modified rows
        $this->count_rows = $this->stmt->rowCount();
    }

    /**
     * Delete data from database.
     * @param string $table table name
     * @param $where associated array of filter values
     * @return void
     */
    public function delete($table, $where)
    {
        // Get array of part query strings for filter
        $where_data = implode(" AND ", $this->getPrepeareValues($where, "where_"));
        // Proccess where array for binding
        $where = $this->setKeyPrefix($where, "where_");
        // Query string
        $sql = "DELETE FROM $table WHERE $where_data";
        try {
            // Set query string
            $this->stmt = $this->dbo->prepare($sql);
            // Execute the query
            $this->stmt->execute(array_merge($where));
        }
        catch (Exception $e)
        {
            HttpError::show(500, $e->getMessage());
        }
        // Set count of modified rows
        $this->count_rows = $this->stmt->rowCount();
    }

    /**
     * Takes array of data and makes prepeared sql string.
     * @param array $data array of data
     * @param string $prefix prefix will be added to alias
     * @return array
     */
    private function getPrepeareValues($data, $prefix = "")
    {
        // Default array
        $pre_data = array();
        // Proccess keys(fields) and store processed string to defult array
        foreach ($data as $field => $value) {
            $pre_data[] = "`$field` = :$prefix$field";
        }
        // Return data
        return $pre_data;
    }

    /**
     * Proceess array of values by setting prefix to array keys for binding.
     * @param array $data stored data
     * @param string $prefix
     * @return array
     */
    private function setKeyPrefix($data, $prefix)
    {
        // Default array
        $res_array = array();
        // Change array keys by adding prefix to them
        foreach ($data as $key => $value)
        {
            $res_array[$prefix.$key] = $value;
        }
        // Return proccessed array
        return $res_array;
    }

    /**
     * Gets column from executed query.
     * @return array
     */
    public function getColumn()
    {
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Gets results from executed query as array of arrays
     * @return array
     */
    public function getArray()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Gets results from executed query as array of objects
     * @return array
     */
    public function getObject()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Gets row from database as associated array
     * @return array
     */
    public function getRow()
    {
        return $this->stmt->fetch();
    }

    public function getResult()
    {
        $result = $this->stmt->fetch();
        return reset($result);
    }
}