<?php

class Model {

    protected $db;

    protected $file;

    function __construct()
    {
        Loader::getLibrary('DataBase', true);
        $this->db = new DataBase();
    }

}