<?php

class Controller {

    protected $loader;
    protected $view;
    protected $session;
    protected $input;

    function __construct()
    {
        ob_start();
        $this->getLoader();
        $this->getInput();
        $this->loader->getLibrary('System', true);
        $this->loader->getLibrary('Session', true);
        System::init();
        $this->session = new Session();
        $this->view = new View();
        ob_end_flush();
    }

    private function getInput()
    {
        $this->loader->getHelper('input', true);
        $this->input = new Input();

    }

    private function getLoader()
    {
        if(file_exists(CORE_PATH.'loader.php'))
        {
            require_once (CORE_PATH.'loader.php');
            $this->loader = new Loader($this);
        }
        else
        {
            HttpError::show(503, "core class loader does not exist");
        }
    }
}