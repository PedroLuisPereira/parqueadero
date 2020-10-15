<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }

    public function view($page = 'dashboard')
    {
        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            //error
            show_404();
        }

        $this->load->view('header');
        $this->load->view($page);
        $this->load->view('footer');
    }
    
}
