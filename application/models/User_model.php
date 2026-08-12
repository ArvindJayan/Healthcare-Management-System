<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        }

    public function login($email, $password) {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.email', $email);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $user = $query->row();

            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return FALSE;
    }
}
?>