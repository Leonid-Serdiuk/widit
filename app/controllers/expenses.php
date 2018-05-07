<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24.07.2017
 * Time: 19:01
 */
class Expenses extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loader->getModel('expenses_model');
        $this->view->setLayout('main_layout');
    }

    public function index($args = false)
    {
        $period = ( isset(Router::parseUrl()[1]) && in_array( Router::parseUrl()[1], array('month', 'week', 'day') ) ) ? Router::parseUrl()[1] : $this->session->get('period', 'month');
        switch ($period)
        {
            case 'month':
                $current_period_number = date('n');
                $period_number = ($args) ?  $args[0] : $current_period_number;
                break;
            case 'week':
                $current_period_number = date('W');
                $period_number = ($args) ?  $args[0] : $current_period_number;
                break;
            case 'day':
                $current_period_number = date('j');
                $period_number = ($args) ?  $args[0] : $current_period_number;
                break;
        }
        $min_date = DateTime::createFromFormat ('d-n', '01-'.date('n'));
        $data['min_week_num'] = $min_date->format('W');
        $data['period_number'] = $period_number;
        $data['current_period_number'] = $current_period_number;
        $data['period'] = $period;
        $data['expenses'] = $this->expenses_model->getAll($period, $period_number);
        $this->view->setTitle('Expenses - ' . SITE_NAME);
        $this->view->render('expenses', $data);
    }

    public function add_expense()
    {
        $title = $this->input->post('title');
        if(!$title)
        {
            System::set_alert('Title is required!', 'danger');
            System::redirect('/expenses');
        }
        $title = stripcslashes(trim($title));

        $amount = $this->input->post('amount');
        if(!$amount)
        {
            System::set_alert('Amount is required!', 'danger');
            System::redirect('/expenses');
        }
        $amount = stripcslashes(trim($amount));

        $comment = $this->input->post('comment');
        $comment = ($comment) ? $comment : '';
        $data = array(
            'title' => $title,
            'comment' => $comment,
            'amount' => $amount,
            'tag_id' => 1,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->expenses_model->add($data);
        System::set_alert('New expense was added successfuly!', 'success');
        System::redirect('/expenses');
        exit;
    }

    public function change_period()
    {
        $period = $this->input->post('period', 'month');
        $this->session->set('period', $period);
        System::redirect('/expenses');
        exit;
    }
}