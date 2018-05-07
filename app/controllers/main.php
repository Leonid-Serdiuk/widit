<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02.04.2017
 * Time: 12:36
 */
class Main extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loader->getModel('main');
        $this->view->setLayout("main_layout");
    }

    public function index()
    {
        //echo "hello<br>";
        $name = $this->main_model->test();

        $this->loader->getModel('login_model');
        $this->view->setTitle('Money Keeper');
        $this->view->render("main", array("name" => $name));
        //System::redirect("/login");
    }
}