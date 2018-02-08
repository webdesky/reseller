<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller 
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
          $this->data['title']="Resaller Category";
          $this->data['header']=$this->load->view('admin/include/header',$this->data); 
          $this->data['side_bar']=$this->load->view('admin/include/sidebar'); 
    }
    /*Category List*/
    public function category_master()
    {
        $where = $this->db->where('parent_id = ',0);
        $data['category_master'] = $this->common_model->getAlldata('category_master','');
        $data['header']=$this->load->view('admin/include/header'); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $this->load->view('admin/category_master',$data);
        $data['footer']=$this->load->view('admin/include/footer'); 
    }

    /*Sub Category List*/
    public function subcategory_master()
    {

        $where = $this->db->where('parent_id != ',0);
        $data['subcategory_master'] = $this->common_model->getAlldata('category_master',$where);
        $data['header']=$this->load->view('admin/include/header'); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $this->load->view('admin/subcategory_master',$data);
        $data['footer']=$this->load->view('admin/include/footer'); 
    }
    /* Product List*/
    public function product_master()
    {
        $data['product_master'] = $this->common_model->getAlldata('product_master','');
        $data['header']=$this->load->view('admin/include/header'); 
        $data['side_bar']=$this->load->view('admin/include/sidebar'); 
        $this->load->view('admin/product_master',$data);
        $data['footer']=$this->load->view('admin/include/footer'); 
    }
    /*Add New Category*/
    public function addcategory_master()
    {
        if(isset($_POST['update'])){
         $data = array(
            'category_name' => $this->input->post('category_name'),
            'parent_id' => $this->input->post('parent_id'),
            'added_date' => $this->input->post('added_date')
          ); 
          if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
          } 
          $id = $this->input->post('id');
          $where = array('category_id' => $id);
          $this->common_model->updateFields('category_master',$data,$where);
          redirect('home/category_master');
        }
        if(isset($_POST['submit'])){
            $data = array(
              'category_name' => $this->input->post('category_name'),
              'added_date' => date('Y-m-d H:i:s'),
              'category_status' => 1,
              'level' => 0
              ); 
              if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
             }
            $this->common_model->insertData('category_master', $data);
            redirect('home/category_master');
        }
        else{
              $data['category_master'] = "";
              if($this->uri->segment(3)){
                 $uid = $this->uri->segment(3);
                 $data['category_master'] = $this->common_model->getDatabyid('category_master','category_id',$uid);  
              }
            $data['header']=$this->load->view('admin/include/header'); 
            $data['side_bar']=$this->load->view('admin/include/sidebar'); 
            $this->load->view('admin/categoryadd',$data);
            $data['footer']=$this->load->view('admin/include/footer'); 
        }
    }
    /*Add New Sub Category*/
    public function addsubcategory_master()
    {
        if(isset($_POST['update'])){
         $data = array(
            'category_name' => $this->input->post('category_name'),
            'parent_id' => $this->input->post('parent_id'),
            'added_date' => $this->input->post('added_date')
          ); 
          if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
          } 
          $id = $this->input->post('id');
          $where = array('category_id' => $id);
          $this->common_model->updateFields('category_master',$data,$where);
          redirect('home/subcategory_master');
        }
        if(isset($_POST['submit'])){
            $data = array(
              'category_name' => $this->input->post('category_name'),
              'parent_id' => $this->input->post('parent_id'),
              'added_date' => date('Y-m-d H:i:s'),
              'category_status' => 1,
              'level' => 0
              ); 
              if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
             }
            $this->common_model->insertData('category_master', $data);
            redirect('home/subcategory_master');
        }
        else{
              $data['subcategory_master'] = "";
              if($this->uri->segment(3)){
                 $uid = $this->uri->segment(3);
                 $data['subcategory_master'] = $this->common_model->getDatabyid('category_master','category_id',$uid);  
                 $where = $this->db->where('parent_id = ',0);
                 $data['category_master'] = $this->common_model->getAlldata('category_master',$where); 
              }
            $where = $this->db->where('parent_id = ',0);
            $data['category_master'] = $this->common_model->getAlldata('category_master',$where);  
            $data['header']=$this->load->view('admin/include/header'); 
            $data['side_bar']=$this->load->view('admin/include/sidebar'); 
            $this->load->view('admin/subcategoryadd_master',$data);
            $data['footer']=$this->load->view('admin/include/footer'); 
        }
    }

    /*Add New Product*/
    public function addproduct_master()
    {
        if(isset($_POST['update'])){
         $data = array(
            'product_name' => $this->input->post('product_name'),
            'category_id' => $this->input->post('category_id'),
            'product_description' => $this->input->post('product_description'),
            'coupan_amount' => $this->input->post('coupan_amount'),
            'discount_id' => $this->input->post('discount_id'),
            'offer_id' => $this->input->post('offer_id'),
            'coupan_id' => $this->input->post('coupan_id'),
            'tax_id' => $this->input->post('tax_id'),
            'tax_amount' => $this->input->post('tax_amount'),
            'offer_amount' => $this->input->post('offer_amount'),
            'discount_amount' => $this->input->post('discount_amount'),
            'product_price' => $this->input->post('product_price'),
            'sale_price' => $this->input->post('sale_price'),
            'edited_by' => 1,
            'edited_date' => date('Y-m-d H:i:s'),
            'edited_ip' => 1
          ); 
          if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
          } 
          $id = $this->input->post('id');
          $where = array('category_id' => $id);
          $this->common_model->updateFields('product_master',$data,$where);
          redirect('home/product_master');
        }
        if(isset($_POST['submit'])){
            $data = array(
              'product_name' => $this->input->post('product_name'),
              'category_id' => $this->input->post('category_id'),
              'product_description' => $this->input->post('product_description'),
              'coupan_amount' => $this->input->post('coupan_amount'),
              'discount_id' => $this->input->post('discount_id'),
              'offer_id' => $this->input->post('offer_id'),
              'coupan_id' => $this->input->post('coupan_id'),
              'tax_id' => $this->input->post('tax_id'),
              'tax_amount' => $this->input->post('tax_amount'),
              'offer_amount' => $this->input->post('offer_amount'),
              'discount_amount' => $this->input->post('discount_amount'),
              'product_price' => $this->input->post('product_price'),
              'sale_price' => $this->input->post('sale_price'),
              'product_status' => 1,
              'added_by' => 1,
              'added_date' => date('Y-m-d H:i:s'),
              'added_ip' => 11,

              ); 
              if(!empty($_FILES['category_image']['name'])) {                  
                $config['file_name']     = time().$_FILES['category_image']['name']; 
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = '10000';                 
                $config['max_width']     = '0';
                $config['max_height']    = '0';
                $config['remove_spaces'] = true;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);                 
                if (!$this->upload->do_upload('category_image')) {                 
                     echo $error = array('error' => $this->upload->display_errors());                                       
                } else {                       
                    $img = array('upload_data' => $this->upload->data());                       
                    $data['category_image'] = $img['upload_data']['file_name'];
                  }       
             }
            $this->common_model->insertData('product_master', $data);
            redirect('home/product_master');
        }
        else{
              $data['product_master'] = "";
              if($this->uri->segment(3)){
                 $uid = $this->uri->segment(3);
                 $data['product_master'] = $this->common_model->getDatabyid('product_master','product_id',$uid);  
                 $where = $this->db->where('parent_id = ',0);
                 $data['category_master'] = $this->common_model->getAlldata('category_master',$where); 
              }
            $where = $this->db->where('parent_id = ',0);
            $data['category_master'] = $this->common_model->getAlldata('category_master',$where);  
            $data['header']=$this->load->view('admin/include/header'); 
            $data['side_bar']=$this->load->view('admin/include/sidebar'); 
            $this->load->view('admin/productadd_master',$data);
            $data['footer']=$this->load->view('admin/include/footer'); 
        }
    }   
    public function inactive_status_change($cat_id,$page)
    {
        $status_data=array("category_status"=>0);
        $where=array("category_id"=>$cat_id);
        $this->common_model->updateFields('category_master',$status_data,$where);
        $redirect='category/'.$page;
        redirect($redirect, 'refresh');
    }
    public function active_status_change($cat_id,$page)
    {
        $status_data=array("category_status"=>1);
        $where=array("category_id"=>$cat_id);
        $this->common_model->updateFields('category_master',$status_data,$where);
        $redirect='category/'.$page;
        redirect($redirect, 'refresh');
    } 
    public function delete_category($cat_id,$page)
    {
        
        $where=array("category_id"=>$cat_id);
        $this->common_model->delete('category_master',$where);
        $redirect='category/'.$page;
        redirect($redirect, 'refresh');
    }
}