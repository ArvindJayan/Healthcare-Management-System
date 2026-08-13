<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_doctor($data) {
        return $this->db->insert('doctors', $data);
    }

    public function profile_exists($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('doctors') > 0;
    }
}