<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Admin extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('common_model'); 
        $data['title']="Resaller Admin";
    }
    public function index() 
    {
        $this->load->view('admin/login');
    }
    public function signin() 
    {     
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('admin/login');
        } 
        else 
        {
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            $where=array("email"=>$email,"password"=>$password);
            $fld='id, email, password,first_name,user_role';
            $result = $this->common_model->get_selected_field('admin_master',$where,$fld);
            if ($result) 
            {
                $sess_array = array();
                foreach ($result as $row) 
                {
                    $sess_array = array('id' => $row->id, 'username' => $row->first_name,'userrole' =>$row->user_role);
                    $this->session->set_userdata('logged_in', $sess_array);
                    redirect('/home', 'refresh');
                }
            } 
            else 
            {
                $this->session->set_flashdata('error', 'Invalid usrername or password');
                $this->load->view('admin/login');
            }
        }
    }
}