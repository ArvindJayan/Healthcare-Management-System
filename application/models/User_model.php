<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
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

    public function register_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        if ($this->db->insert('users', $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_user_by_id($id) {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }

    public function get_non_admin_roles() {
        $this->db->where('name !=', 'Admin');
        $this->db->where('id !=', 1);
        return $this->db->get('roles')->result();
    }
    public function get_user_profile($user_id, $role_id) {
        $this->db->select('users.id, users.name, users.email, users.role_id, users.created_at');
        $this->db->from('users');

        if ((int) $role_id === 2) {
            $this->db->select('doctors.id as doctor_id, doctors.specialization, doctors.fee');
            $this->db->join('doctors', 'doctors.user_id = users.id', 'left');
        } elseif ((int) $role_id === 3) {
            $this->db->select('patients.id as patient_id, patients.phone, patients.dob, patients.gender');
            $this->db->join('patients', 'patients.user_id = users.id', 'left');
        }

        $this->db->where('users.id', $user_id);
        return $this->db->get()->row();
    }

    public function update_profile($user_id, $role_id, $user_data, $role_data = []) {
        $this->db->trans_start();

        if (!empty($user_data)) {
            $this->db->where('id', $user_id);
            $this->db->update('users', $user_data);
        }

        if (!empty($role_data)) {
            if ((int) $role_id === 2) {
                $this->db->where('user_id', $user_id);
                $this->db->update('doctors', $role_data);
            } elseif ((int) $role_id === 3) {
                $this->db->where('user_id', $user_id);
                $this->db->update('patients', $role_data);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
?>