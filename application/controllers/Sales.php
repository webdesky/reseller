<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sales extends CI_Controller 
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
           $this->data['title']="Resaller Discount";
           $this->data['header']=$this->load->view('admin/include/header',$this->data); 
           $this->data['side_bar']=$this->load->view('admin/include/sidebar'); 
    }
    public function sales_list()
    {       
        $data['sales_data'] = $this->common_model->Getrecords_for_view();
        $this->load->view('admin/sales_list',$data);
    }
   
}