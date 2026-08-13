<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination
 * @property Patient_model $Patient_model
 */
class Patients extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            $this->session->set_flashdata('error', 'Please log in to continue.');
            redirect('/auth/login');
        }

        $this->load->model('Patient_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index() {
        $search = $this->input->get('search', TRUE);

        $config['base_url'] = site_url('patients/index');
        $config['total_rows'] = $this->Patient_model->get_patients_count($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-end">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link bg-danger border-danger" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $data['patients'] = $this->Patient_model->get_all_patients($search, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->load->view('patients/index', $data);
    }

    public function view($id = NULL) {
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');

        if ($id) {
            $data['patient'] = $this->Patient_model->get_patient_by_id($id);
        } else {
            $data['patient'] = $this->Patient_model->get_patient_by_user_id($user_id);
        }

        if (!$data['patient']) {
            show_404();
        }

        $this->load->view('patients/view', $data);
    }

    public function edit($id) {
        $data['patient'] = $this->Patient_model->get_patient_by_id($id);

        if (!$data['patient']) {
            show_404();
        }

        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|in_list[Male,Female,Other]');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('patients/edit', $data);
        } else {
            $update_data = array(
                'phone'           => $this->input->post('phone', TRUE),
                'gender'          => $this->input->post('gender', TRUE),
                'dob'             => $this->input->post('dob', TRUE),
                'blood_group'     => $this->input->post('blood_group', TRUE),
                'address'         => $this->input->post('address', TRUE),
                'medical_history' => $this->input->post('medical_history', TRUE)
            );

            if ($this->Patient_model->update_patient($id, $update_data)) {
                $this->session->set_flashdata('success', 'Profile updated successfully.');
                redirect('/patients/view/' . $id);
            } else {
                $this->session->set_flashdata('error', 'Update failed. Try again.');
                redirect('/patients/edit/' . $id);
            }
        }
    }
}