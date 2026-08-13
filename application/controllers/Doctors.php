<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctors extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Doctor_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 2) {
            $this->session->set_flashdata('error', 'Access denied. Doctors cannot access doctor directory management.');
            redirect('dashboard');
        }
    }

    public function index() {
        $search    = $this->input->get('search', TRUE);
        $specialty = $this->input->get('specialty', TRUE);

        $data['search']          = $search;
        $data['specialty']       = $specialty;
        $data['specializations'] = $this->Doctor_model->get_specializations();
        $data['doctors']         = $this->Doctor_model->get_all_doctors($search, $specialty);

        $this->load->view('doctors/index', $data);
    }

    public function view_ajax($id) {
        $doctor = $this->Doctor_model->get_doctor_by_id($id);
        if ($doctor) {
            echo json_encode(['status' => 'success', 'data' => $doctor]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Doctor record not found.']);
        }
    }

    public function edit($id) {
        if ((int)$this->session->userdata('role_id') !== 1) {
            $this->session->set_flashdata('error', 'Only System Administrators can edit doctor records.');
            redirect('doctors');
        }

        $doctor = $this->Doctor_model->get_doctor_by_id($id);

        if (!$doctor) {
            $this->session->set_flashdata('error', 'Doctor not found.');
            redirect('doctors');
        }

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required|trim');
        $this->form_validation->set_rules('consultation_fee', 'Consultation Fee', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['doctor'] = $doctor;
            $this->load->view('doctors/edit', $data);
        } else {
            $doctor_data = [
                'specialization'   => $this->input->post('specialization', TRUE),
                'consultation_fee' => $this->input->post('consultation_fee', TRUE),
                'phone'            => $this->input->post('phone', TRUE)
            ];

            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->Doctor_model->update_doctor($id, $doctor_data, $user_data)) {
                $this->session->set_flashdata('success', 'Doctor profile updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update doctor profile.');
            }

            redirect('doctors');
        }
    }
}