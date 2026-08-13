<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_patients($search = '', $limit = 10, $offset = 0) {
        $this->db->select('patients.*', 'users.name', 'users.email');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('patients.phone', $search);
            $this->db->group_end();
        }

        $this->db->order_by('patients.id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function get_patients_count($search = '') {
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('patients.phone', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_patient_by_id($id) {
        $this->db->select('patients.*, users.name, users.email');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');
        $this->db->where('patients.id', $id);
        return $this->db->get()->row();
    }

    public function get_patient_by_user_id($user_id) {
        $this->db->select('patients.*, users.name, users.email');
        $this->db->from('patients');
        $this->db->join('users', 'users.id = patients.user_id');
        $this->db->where('patients.user_id', $user_id);
        return $this->db->get()->row();
    }

    public function update_patient($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('patients', $data);
    }
}
?>