<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_patient($data) {
        return $this->db->insert('patients', $data);
    }

    public function profile_exists($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('patients') > 0;
    }
}