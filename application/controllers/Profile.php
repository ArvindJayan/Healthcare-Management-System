<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('User_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');

        $data['user'] = $this->User_model->get_user_profile($user_id, $role_id);
        $this->load->view('profile/index', $data);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        $role_id = (int)$this->session->userdata('role_id');

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim|min_length[3]');
        
        $original_email = $this->db->select('email')->where('id', $user_id)->get('users')->row()->email;
        if ($this->input->post('email') != $original_email) {
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[users.email]');
        } else {
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        }

        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'New Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $user_data = [
                'name'  => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE)
            ];

            if ($this->input->post('password')) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }

            $role_data = [];
            if ($role_id === 2) { 
                $role_data = [
                    'specialization'   => $this->input->post('specialization', TRUE),
                    'fee' => $this->input->post('consultation_fee', TRUE)
                ];
            } elseif ($role_id === 3) { 
                $role_data = [
                    'phone'   => $this->input->post('phone', TRUE),
                    'dob'     => $this->input->post('dob', TRUE),
                    'gender'  => $this->input->post('gender', TRUE)
                ];
            }

            if ($this->User_model->update_profile($user_id, $role_id, $user_data, $role_data)) {
                $this->session->set_userdata('name', $user_data['name']);
                $this->session->set_userdata('email', $user_data['email']);

                $this->session->set_flashdata('success', 'Profile updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile.');
            }

            redirect('profile');
        }
    }
}