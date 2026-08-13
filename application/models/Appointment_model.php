<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_appointment($data) {
        return $this->db->insert('appointments', $data);
    }

    public function get_appointment_by_id($id) {
        $this->db->select('
            appointments.*,
            doc_user.name as doctor_name,
            doc_user.email as doctor_email,
            doctors.specialization,
            pat_user.name as patient_name,
            pat_user.email as patient_email
        ');
        $this->db->from('appointments');
        $this->db->join('doctors', 'doctors.id = appointments.doctor_id');
        $this->db->join('users as doc_user', 'doc_user.id = doctors.user_id');
        $this->db->join('patients', 'patients.id = appointments.patient_id');
        $this->db->join('users as pat_user', 'pat_user.id = patients.user_id');
        $this->db->where('appointments.id', $id);
        
        return $this->db->get()->row();
    }

    public function get_appointments($role_id, $user_id, $status = NULL) {
    $doctor_id  = null;
    $patient_id = null;

    if ((int)$role_id === 2) { 
        // Doctor
        $doctor = $this->db->select('id')->where('user_id', $user_id)->get('doctors')->row();
        if (!$doctor) {
            return [];
        }
        $doctor_id = $doctor->id;
    } elseif ((int)$role_id === 3) { 
        $patient = $this->db->select('id')->where('user_id', $user_id)->get('patients')->row();
        if (!$patient) {
            return [];
        }
        $patient_id = $patient->id;
    }

    $this->db->select('
        appointments.*,
        doc_user.name as doctor_name,
        doctors.specialization,
        pat_user.name as patient_name
    ');
    $this->db->from('appointments');
    $this->db->join('doctors', 'doctors.id = appointments.doctor_id');
    $this->db->join('users as doc_user', 'doc_user.id = doctors.user_id');
    $this->db->join('patients', 'patients.id = appointments.patient_id');
    $this->db->join('users as pat_user', 'pat_user.id = patients.user_id');

    if ($doctor_id !== null) {
        $this->db->where('appointments.doctor_id', $doctor_id);
    } elseif ($patient_id !== null) {
        $this->db->where('appointments.patient_id', $patient_id);
    }

    if (!empty($status)) {
        $this->db->where('appointments.status', $status);
    }

    $this->db->order_by('appointments.appointment_date', 'DESC');
    $this->db->order_by('appointments.appointment_time', 'DESC');

    return $this->db->get()->result();
}

    public function update_appointment($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('appointments', $data);
    }
}