<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function profile_exists($user_id) {
        $query = $this->db->get_where('patients', ['user_id' => $user_id]);
        return $query->num_rows() > 0;
    }

    public function create_patient($data) {
        return $this->db->insert('patients', $data);
    }

    public function get_patient_by_user_id($user_id) {
        $this->db->select('patients.*, users.name, users.email, users.created_at as registered_since');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');
        $this->db->where('patients.user_id', $user_id);
        return $this->db->get()->row();
    }

    public function get_patient_by_id($id) {
        $this->db->select('patients.*, users.name, users.email, users.created_at as registered_since');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');
        $this->db->where('patients.id', $id);
        return $this->db->get()->row();
    }

    public function get_all_patients($search = NULL) {
        $this->db->select('patients.*, users.name, users.email');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('patients.phone', $search);
            $this->db->group_end();
        }

        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_patient_count() {
        return $this->db->count_all('patients');
    }

    public function update_patient($id, $patient_data, $user_data = []) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('patients', $patient_data);

        if (!empty($user_data)) {
            $patient = $this->get_patient_by_id($id);
            if ($patient) {
                $this->db->where('id', $patient->user_id);
                $this->db->update('users', $user_data);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
