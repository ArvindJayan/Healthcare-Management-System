<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');

        $this->load->model('Doctor_model');
        $this->load->model('Patient_model');

        if ($role_id == 2 && !$this->Doctor_model->profile_exists($user_id)) {
            redirect('/onboarding');
        } else if ($role_id == 3 && !$this->Patient_model->profile_exists($user_id)) {
            redirect('/onboarding');
        }
    }

    public function index() {
        $data['name']      = $this->session->userdata('name');
        $data['role_name'] = $this->session->userdata('role_name');
        $data['role_id']   = $this->session->userdata('role_id');

        $this->load->view('dashboard/index', $data);
    }
}