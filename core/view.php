<?php

class View {

    private $view;
    private $show_view = "";
    private $layout;
    private $title = "";

    function __construct()
    {
        $this->view = $this;
    }

    public function setLayout($layout_name)
    {
        if(file_exists(APP_PATH . "layouts" . DS . $layout_name . ".php"))
        {
            $this->layout = $layout_name;
        }
        else
        {
            HttpError::show(503, "Layout not found");
        }
    }

    public function setTitle($title)
    {
        $this->title = htmlspecialchars($title);
    }

    public function render($view_name, $data = null)
    {
        if(is_array($data))
        {
            extract($data);
        }
        if(file_exists(APP_PATH . "views" . DS . $view_name . ".php"))
        {
           $this->show_view = APP_PATH . "views" . DS . $view_name . ".php";
        }
        ob_start();
        include APP_PATH . "layouts" . DS . $this->layout . ".php";
        ob_end_flush();
    }

    public function include($view_name, $data = null)
    {
        if(is_array($data))
        {
            extract($data);
        }
        if(file_exists(APP_PATH . "views" . DS . $view_name . ".php"))
        {
            ob_start();
            include APP_PATH . "views" . DS . $view_name . ".php";
            ob_end_flush();
        }
    }
}