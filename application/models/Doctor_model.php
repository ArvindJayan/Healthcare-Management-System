<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function profile_exists($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('doctors') > 0;
    }

    public function create_doctor($data) {
        return $this->db->insert('doctors', $data);
    }

    public function get_doctor_by_id($id) {
        $this->db->select('doctors.*, users.name, users.email');
        $this->db->from('doctors');
        $this->db->join('users', 'users.id = doctors.user_id');
        $this->db->where('doctors.id', $id);
        return $this->db->get()->row();
    }

    public function get_all_doctors($search = NULL, $specialty = NULL) {
        $this->db->select('doctors.*, users.name, users.email');
        $this->db->from('doctors');
        $this->db->join('users', 'users.id = doctors.user_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('doctors.specialization', $search);
            $this->db->group_end();
        }

        if (!empty($specialty)) {
            $this->db->where('doctors.specialization', $specialty);
        }

        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_specializations() {
        $this->db->select('specialization');
        $this->db->distinct();
        $this->db->from('doctors');
        $this->db->where('specialization IS NOT NULL');
        $this->db->where('specialization !=', '');
        $this->db->order_by('specialization', 'ASC');
        $query = $this->db->get();
        
        return array_column($query->result_array(), 'specialization');
    }

    public function get_doctor_count() {
        return $this->db->count_all('doctors');
    }

    public function update_doctor($id, $doctor_data, $user_data = []) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('doctors', $doctor_data);

        if (!empty($user_data)) {
            $doctor = $this->get_doctor_by_id($id);
            if ($doctor) {
                $this->db->where('id', $doctor->user_id);
                $this->db->update('users', $user_data);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}