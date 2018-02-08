<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller 
{
    public $data;
    function __construct() 
    {
          parent::__construct();
          $this->load->model('common_model');      
          $this->load->library('upload');
          $session_id=$this->session->all_userdata();
          if(empty($session_id['logged_in']))
          {
              redirect('/');
          }
          $this->data['title']="Resaller Dashboard";
          $this->data['header']=$this->load->view('admin/include/header',$this->data); 
          $this->data['side_bar']=$this->load->view('admin/include/sidebar'); 
    }

    public function index()
    {
        $this->load->view('admin/index',$this->data);
    }
     /*
    ** Shows List of All Suppliers
    */
    public function Suppliers_list()
    {       
        $data['suppliers_data'] = $this->common_model->getAllwherenew('users_master',array('user_role'=>3));

        $this->load->view('admin/suppliers_list',$data);
    }

     /*
    ** Shows List of All Customers
    */
    public function Customers_list()
    {       
        $data['customers_data'] = $this->common_model->getAllwherenew('users_master',array('user_role'=>2));
        $this->load->view('admin/customers_list',$data);
    }
    
}