<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointments extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Appointment_model');
        $this->load->model('Doctor_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        $status  = $this->input->get('status', TRUE);

        $data['status_filter'] = $status;
        $data['appointments']  = $this->Appointment_model->get_appointments($role_id, $user_id, $status);

        $this->load->view('appointments/index', $data);
    }

    public function book() {
        $role_id = (int)$this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');

        if ($role_id !== 3) { 
            $this->session->set_flashdata('error', 'Only patients can book appointments.');
            redirect('appointments');
        }

        $patient = $this->db->select('id')->where('user_id', $user_id)->get('patients')->row();
        if (!$patient) {
            $this->session->set_flashdata('error', 'Please complete your patient profile before booking.');
            redirect('dashboard');
        }

        $this->form_validation->set_rules('doctor_id', 'Doctor', 'required|numeric');
        $this->form_validation->set_rules('appointment_date', 'Date', 'required');
        $this->form_validation->set_rules('appointment_time', 'Time', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['doctors'] = $this->Doctor_model->get_all_doctors();
            $data['selected_doctor_id'] = $this->input->get('doctor_id', TRUE);
            $this->load->view('appointments/book', $data);
        } else {
            $data = [
                'patient_id'       => $patient->id,
                'doctor_id'        => $this->input->post('doctor_id', TRUE),
                'appointment_date' => $this->input->post('appointment_date', TRUE),
                'appointment_time' => $this->input->post('appointment_time', TRUE),
                'status'           => 'Pending'
            ];

            if ($this->Appointment_model->create_appointment($data)) {
                $this->session->set_flashdata('success', 'Appointment booked successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to schedule appointment.');
            }

            redirect('appointments');
        }
    }

    public function view_ajax($id) {
        $apt = $this->Appointment_model->get_appointment_by_id($id);
        if ($apt) {
            echo json_encode(['status' => 'success', 'data' => $apt]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Appointment details not found.']);
        }
    }

    public function update($id) {
        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 3) { 
            $this->session->set_flashdata('error', 'Unauthorized action.');
            redirect('appointments');
        }

        $this->form_validation->set_rules('status', 'Status', 'required|in_list[Pending,Completed,Cancelled]');

        if ($this->form_validation->run() == TRUE) {
            $update_data = [
                'status'       => $this->input->post('status', TRUE),
                'diagnosis'    => $this->input->post('diagnosis', TRUE),
                'prescription' => $this->input->post('prescription', TRUE)
            ];

            if ($this->Appointment_model->update_appointment($id, $update_data)) {
                $this->session->set_flashdata('success', 'Appointment record updated.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update record.');
            }
        }

        redirect('appointments');
    }

    public function cancel($id) {
        $apt = $this->Appointment_model->get_appointment_by_id($id);
        
        if ($apt && $apt->status === 'Pending') {
            $this->Appointment_model->update_appointment($id, ['status' => 'Cancelled']);
            $this->session->set_flashdata('success', 'Appointment cancelled.');
        } else {
            $this->session->set_flashdata('error', 'Only pending appointments can be cancelled.');
        }

        redirect('appointments');
    }
}