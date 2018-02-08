<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller 
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
          $this->data['title']="Resaller Product";
          
    }
    public function add_excel_file()
    {
        $data['header']=$this->load->view('admin/include/header',$this->data); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $this->load->view('admin/add_excel_file',$data);
    }
    public function product_list()
    {
        $data['header']=$this->load->view('admin/include/header',$this->data); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $data['product_list_data'] = $this->common_model->getAlldata('product_master','');  
        $this->load->view('admin/product_list',$data);
    }
    public function product_sub_type()
    {
        $selected_value = $this->input->post('selected_value');
        $level          = $this->input->post('level');
        if($selected_value=='' || $selected_value==0)
        {
            echo "blank";
        }
        else
        {
            $where          = array('parent_id' =>$selected_value);
            $data['result'] = $this->common_model->getAllwhere('category_master',$where);
            $data['level'] = $level+1;
            $this->load->view('admin/multiple_select_ajax',$data);
        }
        
        
    }
    public function get_discount_value()
    {
        $discount_id=$_POST['discount_id'];
        $price=$_POST['price'];
        $where=array("discount_id"=>$discount_id);
        $result = $this->common_model->getAllwhere('discount_master',$where);
        if($result[0]->discount_type=='percentage')
        {
            $amount=(($price*$result[0]->discount_value)/100);
            $amount = number_format($amount, 2, '.', ' ');
        }
        else if($result[0]->discount_type=='fixed')
        {
            $amount=$result[0]->discount_value;
            $amount = number_format($amount, 2, '.', ' ');
        }
        else
        {
           $amount=0.00;
        }
        echo $amount;
       
    }
    public function get_offer_value()
    {
        $offer_id=$_POST['offer_id'];
        $price=$_POST['price'];
        $where=array("offer_id"=>$offer_id);
        $result = $this->common_model->getAllwhere('offer_master',$where);
        if($result[0]->offer_type=='percentage')
        {
            $amount=(($price*$result[0]->offer_value)/100);
            $amount = number_format($amount, 2, '.', ' ');
        }
        else if($result[0]->offer_type=='fixed')
        {
            $amount=$result[0]->offer_value;
            $amount = number_format($amount, 2, '.', ' ');
        }
        else
        {
           $amount=0.00;
        }
        echo $amount;
      
    }
    public function add_product()
    {
        $data['header']=$this->load->view('admin/include/header',$this->data); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $where = $this->db->where('parent_id = ',0);
        $data['category_data'] = $this->common_model->getAlldata('category_master',$where);
        $data['discount_data'] = $this->common_model->getAlldata('discount_master','');
        $data['offer_data'] = $this->common_model->getAlldata('offer_master','');    
        if($this->input->post()) 
        {
            $this->form_validation->set_rules('product_name', 'Discount Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_description', 'Discount Type', 'trim|required|xss_clean');
            for($i=0;$i<$this->input->post('level');$i++)
            {
                 $str="category_level_".$i;
                 $str1="Category Level-".$i;
                  $this->form_validation->set_rules($str, $str1, 'trim|required|numeric|xss_clean');
            }
           

            $this->form_validation->set_rules('product_price', 'Product Price', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('discount_id', 'Product Discount', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('discount_amount', 'Product Discount Amount', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('offer_id', 'Product Offer', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('offer_amount', 'Product Offer Amount', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tax_id', 'Product Tax', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tax_amount', 'Product Tax Amount', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('sale_price', 'Product Sale Price', 'trim|required|numeric|xss_clean');
            if ($this->form_validation->run() == FALSE) 
            {
               $this->load->view('admin/add_product',$data);
            } 
            else 
            {
                  
                  $current_date=date('Y-m-d H:i:s');
                  $current_ip= $_SERVER['REMOTE_ADDR'];
                  $current_login=1;
                  $perform_array=$_POST;
                  $perform_array['category_id']=$perform_array['category_level_0'];
                  
                  unset($perform_array['save_category']);

                  print_r($perform_array);
                  for($i=0;$i<$perform_array['level'];$i++)
                  {
                        $str="category_level_".$i;
                        unset($perform_array[$str]);
                  }
                  $str="category_level_".$perform_array['level'];
                  $perform_array['category_id']=$perform_array[$str];
                  unset($perform_array['level']);
                  unset($perform_array[$str]);
                  if($perform_array['product_id']=='')
                  {
                      $perform_array['product_status']=1;
                      $perform_array['added_by']=$current_login;
                      $perform_array['added_date']=$current_date;
                      $perform_array['added_ip']=$current_ip;
                      $result = $this->common_model->insertData('product_master',$perform_array);
                      $this->session->set_flashdata('msg', 'Product Added Successfully');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                      $this->load->view('admin/add_product',$data);
                  }
                  else
                  {
                      $perform_array['edited_by']=$current_login;
                      $perform_array['edited_date']=$current_date;
                      $perform_array['edited_ip']=$current_ip;
                      $product_id=$perform_array['product_id'];
                      $where=array("product_id"=>$perform_array['product_id']);
                      $result = $this->common_model->updateFields('product_master',$perform_array,$where);
                      $this->session->set_flashdata('msg', 'Product Updated Successfully');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                      $this->session->set_flashdata('class_msg', 'bg-green');
                      $url_path="product/add_product/".$perform_array["product_id"];
                      redirect($url_path, 'refresh');
                      
                  }
            }
        }
        else
        {
              if($this->uri->segment(3))
              {
                 $product_id=$this->uri->segment(3);
                 $select="all";
                 $where=array("product_id"=>$product_id);
                 $data['edit_product_data'] = $this->common_model->getAllwherenew('product_master',$where,$select);
                 $this->load->view('admin/add_product',$data);
              }
              else
              {
                  $this->load->view('admin/add_product',$data);
              }
        }
        
        // if(isset($_POST['update']))
        // {
        //      $data = array(
        //         'product_name' => $this->input->post('product_name'),
        //         'category_id' => $this->input->post('category_id'),
        //         'product_description' => $this->input->post('product_description'),
        //         'coupan_amount' => $this->input->post('coupan_amount'),
        //         'discount_id' => $this->input->post('discount_id'),
        //         'offer_id' => $this->input->post('offer_id'),
        //         'coupan_id' => $this->input->post('coupan_id'),
        //         'tax_id' => $this->input->post('tax_id'),
        //         'tax_amount' => $this->input->post('tax_amount'),
        //         'offer_amount' => $this->input->post('offer_amount'),
        //         'discount_amount' => $this->input->post('discount_amount'),
        //         'product_price' => $this->input->post('product_price'),
        //         'sale_price' => $this->input->post('sale_price'),
        //         'edited_by' => 1,
        //         'edited_date' => date('Y-m-d H:i:s'),
        //         'edited_ip' => 1
        //       ); 
        //       if(!empty($_FILES['category_image']['name'])) {                  
        //             $config['file_name']     = time().$_FILES['category_image']['name']; 
        //             $config['upload_path']   = 'uploads/';
        //             $config['allowed_types'] = 'gif|jpg|png|pdf';
        //             $config['max_size']      = '10000';                 
        //             $config['max_width']     = '0';
        //             $config['max_height']    = '0';
        //             $config['remove_spaces'] = true;
        //             $this->upload->initialize($config);
        //             $this->load->library('upload', $config);                 
        //             if (!$this->upload->do_upload('category_image')) {                 
        //                  echo $error = array('error' => $this->upload->display_errors());                                       
        //             } else {                       
        //                 $img = array('upload_data' => $this->upload->data());                       
        //                 $data['category_image'] = $img['upload_data']['file_name'];
        //               }       
        //       } 
        //       $id = $this->input->post('id');
        //       $where = array('category_id' => $id);
        //       $this->common_model->updateFields('product_master',$data,$where);
        //       redirect('home/product_master');
        // }
        // if(isset($_POST['submit']))
        // {
        //     $data = array(
        //       'product_name' => $this->input->post('product_name'),
        //       'category_id' => $this->input->post('category_id'),
        //       'product_description' => $this->input->post('product_description'),
        //       'coupan_amount' => $this->input->post('coupan_amount'),
        //       'discount_id' => $this->input->post('discount_id'),
        //       'offer_id' => $this->input->post('offer_id'),
        //       'coupan_id' => $this->input->post('coupan_id'),
        //       'tax_id' => $this->input->post('tax_id'),
        //       'tax_amount' => $this->input->post('tax_amount'),
        //       'offer_amount' => $this->input->post('offer_amount'),
        //       'discount_amount' => $this->input->post('discount_amount'),
        //       'product_price' => $this->input->post('product_price'),
        //       'sale_price' => $this->input->post('sale_price'),
        //       'product_status' => 1,
        //       'added_by' => 1,
        //       'added_date' => date('Y-m-d H:i:s'),
        //       'added_ip' => 11,

        //       ); 
        //       if(!empty($_FILES['category_image']['name'])) {                  
        //         $config['file_name']     = time().$_FILES['category_image']['name']; 
        //         $config['upload_path']   = 'uploads/';
        //         $config['allowed_types'] = 'gif|jpg|png|pdf';
        //         $config['max_size']      = '10000';                 
        //         $config['max_width']     = '0';
        //         $config['max_height']    = '0';
        //         $config['remove_spaces'] = true;
        //         $this->upload->initialize($config);
        //         $this->load->library('upload', $config);                 
        //         if (!$this->upload->do_upload('category_image')) {                 
        //              echo $error = array('error' => $this->upload->display_errors());                                       
        //         } else {                       
        //             $img = array('upload_data' => $this->upload->data());                       
        //             $data['category_image'] = $img['upload_data']['file_name'];
        //           }       
        //      }
        //     $this->common_model->insertData('product_master', $data);
        //     redirect('home/product_master');
        // }
        // else
        // {
        //       $data['product_master'] = "";
        //       if($this->uri->segment(3))
        //       {
        //          $uid = $this->uri->segment(3);
        //          $data['product_master'] = $this->common_model->getDatabyid('product_master','product_id',$uid);  
        //          $where = $this->db->where('parent_id = ',0);
        //          $data['category_master'] = $this->common_model->getAlldata('category_master',$where); 
        //       }
        //     $where = $this->db->where('parent_id = ',0);
        //     $data['category_master'] = $this->common_model->getAlldata('category_master',$where);  
        //     $data['header']=$this->load->view('admin/include/header'); 
        //     $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        //     $this->load->view('admin/productadd_master',$data);
        //     $data['footer']=$this->load->view('admin/include/footer'); 
        // }
    }   
    public function inactive_status_change($pro_id)
    {
        $status_data=array("product_status"=>0);
        $where=array("product_id"=>$pro_id);
        $this->common_model->updateFields('product_master',$status_data,$where);
        $redirect='product/product_list';
        redirect($redirect, 'refresh');
    }
    public function active_status_change($pro_id)
    {
        $status_data=array("product_status"=>1);
        $where=array("product_id"=>$pro_id);
        $this->common_model->updateFields('product_master',$status_data,$where);
        $redirect='product/product_list';
        redirect($redirect, 'refresh');
    } 
    public function delete_category($pro_id)
    {
        
        $where=array("category_id"=>$pro_id);
        $this->common_model->delete('category_master',$where);
        $redirect='product/product_list';
        redirect($redirect, 'refresh');
    }
}