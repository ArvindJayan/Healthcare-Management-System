<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Patient_model');
        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 3) {
            $this->session->set_flashdata('error', 'Access denied. Patients cannot access patient management.');
            redirect('dashboard');
        }
    }

    public function index() {
        $search = $this->input->get('search', TRUE);
        $data['search']   = $search;
        $data['patients'] = $this->Patient_model->get_all_patients($search);

        $this->load->view('patients/index', $data);
    }

    public function view_ajax($id) {
        $patient = $this->Patient_model->get_patient_by_id($id);
        if ($patient) {
            // Calculate age dynamically
            $dob = new DateTime($patient->dob);
            $now = new DateTime();
            $patient->age = $dob->diff($now)->y;

            echo json_encode(['status' => 'success', 'data' => $patient]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Patient record not found.']);
        }
    }

    public function edit($id) {
        $patient = $this->Patient_model->get_patient_by_id($id);

        if (!$patient) {
            $this->session->set_flashdata('error', 'Patient not found.');
            redirect('patients');
        }

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['patient'] = $patient;
            $this->load->view('patients/edit', $data);
        } else {
            $patient_data = [
                'phone'  => $this->input->post('phone', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'dob'    => $this->input->post('dob', TRUE)
            ];

            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->Patient_model->update_patient($id, $patient_data, $user_data)) {
                $this->session->set_flashdata('success', 'Patient profile updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update patient profile.');
            }

            redirect('patients');
        }
    }
}