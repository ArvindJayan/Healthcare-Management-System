<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public $session;
    public $input;
    public $db;

    public $User_model;


    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function login() {
        if ($this->session->userdata('is_authenticated')) {
            redirect('/dashboard');
        }

        if ( ! $this->input->post()) {
            $this->load->view('auth/login');
            return;
        }

        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);
        $user = $this->User_model->login($email, $password);

        if ($user) {
            $session_data = array(
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role_name,
                'is_authenticated' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('/auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function register_user($data) {
        $data['password'] = passsword_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }
}
?>