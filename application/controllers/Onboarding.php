<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboarding extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');
        $this->load->model('Doctor_model');
        $this->load->model('Patient_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');

        if ($role_id == 1) {
            redirect('/dashboard');
        }

        if ($role_id == 2 && $this->Doctor_model->profile_exists($user_id)) {
            redirect('/dashboard');
        } else if ($role_id == 3 && $this->Patient_model->profile_exists($user_id)) {
            redirect('/dashboard');
        }

        if ($role_id == 2) {
            $this->_handle_doctor_onboarding($user_id);
        } else if ($role_id == 3) {
            $this->_handle_patient_onboarding($user_id);
        }
    }

    private function _handle_doctor_onboarding($user_id) {
        $this->form_validation->set_rules('specialization', 'Specialization', 'required|trim');
        $this->form_validation->set_rules('fee', 'Consultation Fee', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('onboarding/doctor');
        } else {
            $doctor_data = array(
                'user_id'        => $user_id,
                'specialization' => $this->input->post('specialization', TRUE),
                'fee'            => $this->input->post('fee', TRUE)
            );

            $this->Doctor_model->create_doctor($doctor_data);

            $this->session->set_flashdata('success', 'Doctor profile completed!');
            redirect('/dashboard');
        }
    }

    private function _handle_patient_onboarding($user_id) {
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|in_list[Male,Female,Other]');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('onboarding/patient');
        } else {
            $patient_data = array(
                'user_id' => $user_id,
                'phone'   => $this->input->post('phone', TRUE),
                'gender'  => $this->input->post('gender', TRUE),
                'dob'     => $this->input->post('dob', TRUE)
            );

            $this->Patient_model->create_patient($patient_data);

            $this->session->set_flashdata('success', 'Patient profile completed!');
            redirect('/dashboard');
        }
    }
}