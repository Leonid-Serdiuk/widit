<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24.07.2017
 * Time: 19:01
 */
class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loader->getModel('main_model');
        $this->view->setLayout('main_layout');
    }

    public function index()
    {
        $this->view->setTitle('Dashboard - ' . SITE_NAME);
        $this->view->render('dashboard');
    }
}