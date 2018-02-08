<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Offer extends CI_Controller 
{
    
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
          $this->data['title']="Resaller Offers";
          $this->data['header']=$this->load->view('admin/include/header',$this->data); 
          $this->data['side_bar']=$this->load->view('admin/include/sidebar'); 
    }
    public function offer_list()
    {
       
        $data['header']=$this->load->view('admin/include/header'); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $data['offers']= $this->common_model->getAll('offer_master');
        $this->load->view('admin/offer_list',$data);
    }
   public function add_offer()
   {
    
        $data['header']=$this->load->view('admin/include/header'); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 

        if($this->input->post()) 
        {
         // echo $this->input->post('offer_id');die;
            $this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('offer_type', 'Offer Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('offer_apply_type', 'Offer Applied Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('offer_apply_id', 'Offer Applied Value', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('discount_start_from', 'Discount Start From', 'required|date_valid');
            //$this->form_validation->set_rules('discount_end_to', 'Discount End To', 'required|date_valid');
            $this->form_validation->set_rules('offer_value', 'Offer Value', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('offer_value', 'Offer Value', 'trim|required|numeric|xss_clean');
            if ($this->form_validation->run() == FALSE) 
            {
               
               $this->load->view('admin/add_offer',$data);
            } 
            else 
            {


                $session_id=$this->session->all_userdata();
                $current_date=date('Y-m-d H:i:s');
                $current_ip= $_SERVER['REMOTE_ADDR'];
                $current_login=1;
                $perform_array=$_POST;
                $perform_array['offer_start_from']=date('Y-m-d',strtotime($perform_array['offer_start_from']));
                $perform_array['offer_end_to']=date('Y-m-d',strtotime($perform_array['offer_end_to']));
                unset($perform_array['save_category']);
                if($this->input->post('offer_id')=='')
                {

                      $perform_array['offer_status']=1;
                      $perform_array['added_by']=$current_login;
                      $perform_array['added_date']=$current_date;
                      $perform_array['added_ip']=$current_ip;
//echo "<pre>";
//print_r($perform_array);
//die;


                      $result = $this->common_model->insertData('offer_master',$perform_array);
                      $this->session->set_flashdata('msg', 'Offer Added Successfully');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                     // $this->session->set_flashdata('class_msg', 'bg-red');
                      $this->load->view('admin/add_offer',$data);
                }
                else
                {
                      $perform_array['added_by']=$current_login;
                      $perform_array['added_date']=$current_date;
                      $perform_array['added_ip']=$current_ip;
                      $where=array("offer_id"=>$perform_array['offer_id']);
                     // print_r($perform_array);
                      //$result = $this->common_model->insertData('discount_master',$where,$fld);
                }
            }

        }
        $this->load->view('admin/add_offer',$data);

   }
}