<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Discount extends CI_Controller 
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
    public function discount_list()
    {       
        $data['discount_data'] = $this->common_model->getAll('discount_master');
        $this->load->view('admin/discount_list',$data);
    }
    public function add_discount()
    {  
        $data=array();      
        if($this->input->post()) 
        {
            $this->form_validation->set_rules('discount_name', 'Discount Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount_apply_type', 'Discount Applied Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount_applied_id', 'Discount Applied Value', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount_start_from', 'Discount Start From', 'required|regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))/(0[1-9]|1[0-2])/\d{4}]');
            $this->form_validation->set_rules('discount_end_to', 'Discount End To', 'required|regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))/(0[1-9]|1[0-2])/\d{4}]');
             $this->form_validation->set_rules('discount_value', 'Discount Value', 'trim|required|numeric|xss_clean');
            if ($this->form_validation->run() == FALSE) 
            {
               $this->load->view('admin/add_discount',$data);
            } 
            else 
            {

                $session_id=$this->session->all_userdata();
                $current_date=date('Y-m-d H:i:s');
                $current_ip= $_SERVER['REMOTE_ADDR'];
                $current_login=1;
                $perform_array=$_POST;
                $perform_array['discount_start_from']=date('Y-m-d',strtotime($perform_array['discount_start_from']));
                $perform_array['discount_end_to']=date('Y-m-d',strtotime($perform_array['discount_end_to']));
                unset($perform_array['save_category']);
                echo $perform_array['discount_id'];
                if($perform_array['discount_id']=='')
                {
                      $perform_array['discount_status']=1;
                      $perform_array['added_by']=$current_login;
                      $perform_array['added_date']=$current_date;
                      $perform_array['added_ip']=$current_ip;
                      $result = $this->common_model->insertData('discount_master',$perform_array);
                      $this->session->set_flashdata('msg', 'Discount Added Successfully');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                     // $this->session->set_flashdata('class_msg', 'bg-red');
                      $this->load->view('admin/add_discount',$data);
                }
                else
                {
                     
                      $perform_array['edited_by']=$current_login;
                      $perform_array['edited_date']=$current_date;
                      $perform_array['edited_ip']=$current_ip;
                      $discount_id=$perform_array['discount_id'];
                      $where=array("discount_id"=>$perform_array['discount_id']);
                      $result = $this->common_model->updateFields('discount_master',$perform_array,$where);
                      $this->session->set_flashdata('msg', 'Discount Updated Successfully');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                      $url_path="discount/add_discount/".$perform_array["discount_id"];
                      redirect($url_path, 'refresh');
                }
            }
        }
        else
        {
              if($this->uri->segment(3))
              {
                 $discount_id=$this->uri->segment(3);
                 $select="all";
                 $where=array("discount_id"=>$discount_id);
                 $data['edit_discount_data'] = $this->common_model->getAllwherenew('discount_master',$where,$select);
                 $this->load->view('admin/add_discount',$data);
              }
              else
              {
                  $this->load->view('admin/add_discount',$data);
              }
        }
        
    }
    function discount_selected_type()
    {
        $select_value=$_POST['selected_value'];
        $str="";
        if($select_value=='product')
        {       
            $result = $this->common_model->getAll('product_master');
            print_r($result);
            //die();
            // $i=0;
            // foreach ($result as $result_data) 
            // {
            //     $id=$result_data[$i]->product_id;
            //     echo $id;
            //     die();
            //     $str.='<option value="'.$id.'" >'.ucfirst($result_data[$i]->product_name).'</option>';
            //     $i++;
            // }
        }
        else
        {
            $where=array("level"=>$select_value);            
            $result = $this->common_model->getAllwhere('category_master',$where);          
            for($i=0;$i<count($result);$i++)
            {
                $id=$result[$i]->category_id;
                $str.='<option value="'.$id.'" >'.ucfirst($result[$i]->category_name).'</option>';
               
            }
        }
        echo $str;

    }
    function valid_date( $str )
    {
        $stamp = strtotime( $str );
          
        if (!is_numeric($stamp)) 
        { 
            return FALSE;
        } 
          $day   = date( 'd', $stamp );
         $month = date( 'm', $stamp );
         
         $year  = date( 'Y', $stamp );
          
         if (checkdate($day,$month,  $year)) 
         {
            return $year.'/'.$month.'/'.$day;
         }
          

         return FALSE;
    }

    public function checkDateFormat($date) 
    {
        echo $date.'<br/>';
        echo substr($date, 3, 2).'<br/>';
        echo substr($date, 0, 2).'<br/>';
        echo substr($date, 6, 4).'<br/>';
        

      
        if (preg_match("/[0-31]{2}\/[0-12]{2}\/[0-9]{4}/", $date)) 
        {

                if(checkdate(substr($date, 0, 2),substr($date, 3, 2),  substr($date, 6, 4)))
                {
                 //return true;
                    echo 'hi';die;
                }           
                else
                {
                    echo 'hi1';die;
                    //return false;
                }
                
      } 
      else 
      {
        echo 'hi2';die;
            return false;
      }
    } 
    public function inactive_status_change($discount_id)
    {
        $status_data=array("discount_status"=>0);
        $where=array("discount_id"=>$discount_id);
        $this->common_model->updateFields('discount_master',$status_data,$where);
        redirect('discount/discount_list', 'refresh');
    }
    public function active_status_change($discount_id)
    {
        $status_data=array("discount_status"=>1);
        $where=array("discount_id"=>$discount_id);
        $this->common_model->updateFields('discount_master',$status_data,$where);
        redirect('discount/discount_list', 'refresh');
    }
    public function delete_discount($discount_id)
    {
        
        $where=array("discount_id"=>$discount_id);
        $this->common_model->delete('discount_master',$where);
        redirect('discount/discount_list', 'refresh');
    }
}