<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller 

{   
    function __construct() {
      parent::__construct();
      $this->load->helper('common_helper');
      $this->load->helper('fcm_helper');
      $this->load->model('common_model');
      $this->load->helper(array('form', 'url'));
      $this->load->library('upload');
      $this->load->helper('file');
    }
    /*
     Users signup service
    */
    public function signup_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        //$data = $_POST;
        $object_info = $data;

        $required_parameter = array('user_fname','user_lname','user_email','user_mobile','user_role');
        $chk_error = check_required_value($required_parameter, $data);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        
        $data['added_date'] = date('Y-m-d H:i:s');
        /* Check for email */
        $check_email = $this->common_model->getRecordCount('users_master', array('user_email' => $data['user_email']));

        if($check_email > 0) {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'EMAIL_IS_ALREADY_EXISTS', 'error_label' => 'This email is already exists in our database.'));
            $this->response($resp);
        }
        $userId = $this->common_model->addRecords('users_master', $data);
        
        if($userId) {        
            /* Get user data */
            $otp= rand(1000,9999);
            $data_mobile= array('otp_number'=>$otp,'otp_status'=>0,'user_id'=>$userId);
            $data_mobile['added_date'] = date('Y-m-d H:i:s');
            //$response= $this->smsapi($otp,$data['user_mobile']);
            $otplink = '<a href="http://control.textlab.in/index.php/smsapi/httpapi/?uname=posh1993&password=posh@123&sender=Poshsu&receiver='.$data['user_mobile'].'&route=TA&msgtype=1&sms='.$otp.'">';
            $otp_id = $this->common_model->addRecords('user_otp_master',$data_mobile);
            $userData = $this->common_model->getSingleRecordById('users_master', array('user_id' => $userId));
            $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData, 'otp' => $otplink));
        } else {
            $resp = array('code' => ERROR, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured, please try again.'));
        }
        @$this->response($resp);
    
    }

    /*
     Users login service
    */

    public function login_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );

        //$data = $_POST;
        $object_info = $data;
        $required_parameter = array('email', 'password');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        /* Check for email */
        $check_email = $this->common_model->getRecordCount(USER, array('email' => $data['email']));
        //print_r($check_email); die();
        if($check_email == 0) {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'EMAIL_IS_NOT_EXISTS', 'error_label' => 'This email is not exists in our database.'));
            @$this->response($resp);
        }

        $check_login = $this->common_model->getSingleRecordById(USER, array('email' => $data['email'], 'password' => MD5($data['password'])));
        if ($check_login['userrole'] == '3') {  
            $listingData = $this->common_model->getSingleRecordpById('listing', array('user_id' => $check_login['id']));
            $cons = array('salon_id' => $listingData['salon_id']);
            $imgArr = $this->common_model->getAllRecordsById('listing_images',$cons);
            //print_r($imgArr); die();
            $check_login["profile_status"] = 1;
            
            if(empty($listingData))
            {
                $check_login["profile_status"] = 0;
            }
        }
        /*else{
        $check_login = $this->common_model->getSingleRecordById(USER, array('email' => $data['email'], 'password' => MD5($data['password'])));
        }*/
        //
        $path = base_url().'uploads/';
        if(!empty($listingData)){
            /*array_combine(keys, values);
            array_merge(array1);*/
            $checkLogin = array_merge($check_login,$listingData,$imgArr);
        }
        else{
            $checkLogin = $check_login;
        }
        if(!empty($check_login)) {
            $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $checkLogin,'img_url'=> IMG_URL));
        } else {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'INVALID_DETAILS', 'error_label' => 'Email OR Password is not correct, please try again.'));
        }
        @$this->response($resp);
    
    }

    /*verify otp*/
    public function verifyotp_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','otp_number');
          $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
                 $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'FAILURE', 'error_label' =>'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param'])));
                 $this->response($resp);
            }
              $condition = array('user_id' => $data['user_id'],'otp_number' => $data['otp_number']);                      
              $result=$this->common_model->getSingleRecordById('user_otp_master',$condition);
              $resultuser=$this->common_model->getSingleRecordById('users_master',array('user_id' => $data['user_id']));

              //print_r($resultuser);

              //die;
            if(!empty($result))
            {
                $updateArr = array('otp_status' => 1);
                $updateArr2 = array('mobile_veryfy' => 1,'user_status' => 1);
                $condition2 = array('user_id' => $data['user_id']);//die;
                $this->common_model->updateRecords('users_master', $updateArr2, $condition2);
                $this->common_model->updateRecords('user_otp_master', $updateArr, $condition);
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('message' => "Your Otp Password has been verified"));
                }
              else
              {
                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'otp_not_match', 'error_label' =>'Your Otp Password do not verified.'));
              }
              $this->response($resp);  
    
    }

    /*
    * Social Login and sign up
    */

    public function social_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('connected_via', 'firstname','lastname','email','device_type','device_id','device_token');
        $chk_error = check_required_value($required_parameter, $object_info);
        if($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             $this->response($resp);
        }
        /* Check for user */

        if($data['connected_via'] == 'facebook') {
            $checkUser = $this->common_model->getSingleRecordById(USER, array('facebook_token' => $data['device_token']));
        } elseif($data['connected_via'] == 'google') {
            $checkUser = $this->common_model->getSingleRecordById(USER, array('google_token' => $data['device_token']));
        } 
         else {
            $resp = array('code' => ERROR, 'message' => 'ERROR', 'response' => 'INVALID_SOCIAL_TYPE');
            $this->response($resp);
        }
           $device_type = isset($data['device_type']) ? $data['device_type'] : '';
           $device_id   = isset($data['device_id']) ? $data['device_id'] : '';
           $device_token = isset($data['device_token']) ? $data['device_token'] : '';
           $imageurl = isset($data['imgurl']) ? $data['imgurl'] : '';
        if(!empty($checkUser['id'])) {
           /* Proced to login */
           $condition = array('id' => $checkUser['id']);  
           $updateArr = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'device_type'=>$device_type,'device_id'=> $device_id,'device_token'=>$device_token, 'image' => $imageurl);             
           $this->common_model->updateRecords(USER, $updateArr, $condition);
           /* Proced to login */
           $userData = $this->common_model->getSingleRecordById(USER, array('id' => $checkUser['id']));
           $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData));
           $this->response($resp); 
        } else {
          $checkEmail = $this->common_model->getSingleRecordById(USER, array('email' => $data['email']));
            if(!empty($checkEmail['id'])) {
               $condition = array('id' => $checkEmail['id']);
               /* Proced to login */
               $update_device_data = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'device_type'=>$device_type,'device_id'=> $device_id , 'device_token'=>$device_token );            
               $this->common_model->updateRecords(USER, $update_device_data, $condition);
              /* Proced to login */
             /* Update user social ids */          
                $updateArr = array(
                    'facebook_token' => ($data['connected_via'] == 'facebook') ? $data['social_id'] : '',
                    'google_token' => ($data['connected_via'] == 'google') ? $data['social_id'] : ''
                 );

                $this->common_model->updateRecords(USER, $updateArr, $condition);
                /* Proceed to login */
                $userData = $this->common_model->getSingleRecordById(USER, array('id' => $checkEmail['id']));
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData));
                $this->response($resp);
                } else {
                /* create User */
                $postData = array(
                    'facebook_token' => ($data['connected_via'] == 'facebook') ? $data['social_id'] : '',
                    'google_token' => ($data['connected_via'] == 'google') ? $data['social_id'] : '',
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'device_type'=>$device_type,
                    'device_id'=> $device_id , 
                    'device_token'=>$device_token,
                    'image' => $imageurl,
                    'createdate' => date('Y-m-d H:i:s')
                 );
                $userId = $this->common_model->addRecords(USER, $postData);
                if($userId) {
                    /* Get user data */
                    $userData = $this->common_model->getSingleRecordById(USER, array('id' => $userId));
                    $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData));
                } else {
                    $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'SERVER_ERROR', 'error_label' => 'Some error ocured, please try again again later.'));
                }
                /* Return Response */
                $this->response($resp);
            }
        }
    
    }
    /**
    * Login Process
    */ 
    public function processLogin($userId, $data) {
        /* Get user data */
        $userData = $this->common_model->getSingleRecordById(USER, array('user_id' => $userId));
        $userData['profile_pic_url'] = (!empty($userData['profile_pic'])) ? base_url().USER_UPLOAD_PATH.$userData['profile_pic'] : '';
        /* Update user login information */
        $deviceArr = array(
            'user_id' => $userId,
            'device_type' => $data['device_type'],
            'device_id' => $data['device_id'],
            'device_token' => $data['device_token'],
            'login_ip' => $this->input->ip_address(),
            'login_time' => date('Y-m-d H:i:s')
        );
        $this->common_model->addRecords(USER_LOGIN, $deviceArr);
        $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData));
        $this->response($resp);
   
    }

    /**
    * Forgot password
    */  

    public function forgot_password_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('email');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             $this->response($resp);
        }
        /* Check for email */
        $check_email = $this->common_model->getRecordCount(USER, array('email' => $data['email']));
        if($check_email == 0) {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'EMAIL_IS_NOT_EXISTS', 'error_label' => 'This email is not exists in our database.'));
            $this->response($resp);
        }
        /* Get user info */
        $userData = $this->common_model->getSingleRecordById(USER, array('email' => $data['email']));
        $password_reset_key = substr(md5(time()),rand(7,9),rand(15,25));
        /* Update password reset key on user info */
        $condition = array('email' => $userData['email']);
        $updateArr = array('password_reset_key' => $password_reset_key);
        $this->common_model->updateRecords(USER, $updateArr, $condition);
        /* Return response */
        $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('password_reset_key' => $password_reset_key, 'user_data' => $userData)); 
        $this->response($resp);
    
    }
    /**
    * Change password
    */ 
    public function changepassword_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('id', 'old_password', 'new_password');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'FAILURE',"response" => array("error" => "MISSED_A_PARAMETER","error_label"=> 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param'])));
             $this->response($resp);
        }
        $user_id = $data["id"];
        $old_password = md5($data["old_password"]);
        $new_password = md5($data["new_password"]);
        $userData = $this->common_model->getSingleRecordById('users', array('id' => $user_id));
        //print_r($userData); die();
        if(empty($userData))
        {
            $resp = array('code' => ERROR, 'message' => 'Invalid User Id');
            $this->response($resp);   
        }else if($userData["password"] != $old_password)
        {
            $resp = array('code' => ERROR, 'message' => 'Invalid Old Password');
            $this->response($resp); 
        }
        $this->common_model->updateRecords('users', array("password" => $new_password), array("id" => $user_id));
        /* Response array */
        $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('success' => 'PASSWORD_CHANGED', 'success_label' => 'Password changed successfully.'));
        $this->response($resp);
    
    }

    /**
    * Edit Profile
    */
    public function updateprofile_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','username','email','phonenumber','address');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             $this->response($resp);
        }
         /* Check for valid user */
         $check_email = $this->common_model->getRecordCount(USER, array('id' => $data['user_id']));
          if($check_email == 0) {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'USER_IS_NOT_EXISTS', 'error_label' => 'This user is not exists in our database.'));
            $this->response($resp);
          }   
           $uid = $data['user_id'];
            unset($data['user_id']);
           /* Update userdata */
              if(isset($data['email'])){
                 $checkemail = $this->common_model->getRecordCount(USER, array('email' => $data['email']));
               }
              if($data){
                 $this->common_model->updateRecords(USER, $data, array('id' => $uid));
              } 
               $pic_data = "";  
               $validFiles = array('png', 'jpg', 'jpeg', 'bmp', 'gif');
                if(!empty($_FILES['profile_pic']['name'])) {
                    /* Check for valid profile pic */
                    $fileType = explode('/', $_FILES['profile_pic']['type']);
                    if(!in_array($fileType[1], $validFiles)) {
                        $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'INVALID_PROFILE_PIC_FILE_TYPE', 'error_label' => 'Invalid file type, please check it again.'));
                        $this->response($resp);
                    }
                    $config['file_name']     = time().$_FILES['profile_pic']['name']; 
                    $config['upload_path']   = './uploads/users';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                    $config['max_size']      = '0';
                    $config['max_width']     = '0';
                    $config['max_height']    = '0';
                    $config['remove_spaces'] = true;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_pic')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $img = array('upload_data' => $this->upload->data());
                        $pic_data['profile_pic_url'] = (!empty($img['upload_data']['file_name'])) ? base_url().USER_UPLOAD_PATH.$img['upload_data']['file_name'] : '';
                        $postData = array( 'image' => $img['upload_data']['file_name'] );
                        $this->common_model->updateRecords(USER, $postData, array('id' => $uid));
                   }
              }

             /* Get user data */

             $userData = $this->common_model->getSingleRecordById(USER, array('id' => $uid));
            if($pic_data){
               $result =  $userData + $pic_data;
             } else{
              $result = $userData; 
             } 
            if(!empty($userData)) {    
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' =>$result ));
            } else { 
                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'FAILURE', 'error_label' => 'Some error occured, please try again.'));
            }
        $this->response($resp);
   
    }

    /**

    * Get user detail by user id

    * @param user id

    */

    public function getprofile_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");

        $data = json_decode($pdata,true);

        $object_info = $data; 

        $required_parameter = array('user_id');
      
        $chk_error = check_required_value($required_parameter, $object_info);

        if ($chk_error) {

             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));

             $this->response($resp);

        }

        /* Check for valid user */

        $check_email = $this->common_model->getRecordCount(USER, array('id' => $data['user_id']));

        if($check_email == 0) {

            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'USER_IS_NOT_EXISTS', 'error_label' => 'This user is not exists in our database.'));

            $this->response($resp);

        }

        /* Get user info */

        $userData = $this->common_model->getSingleRecordById(USER, array('id' => $data['user_id']));

        if(!empty($userData)) {    
          
            $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('user_data' => $userData));

        } else {

            $resp = array('code' => ERROR, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured, please try again.'));

        }

        $this->response($resp);

    }
   
    /*
    all category service
    */
    public function getallcategory_post() {

            /* Check for required parameter */
            $pdata = file_get_contents("php://input");
            $data = json_decode($pdata,true);
            $object_info = $data;  
            $required_parameter = array('parent_id');
                        $chk_error = check_required_value($required_parameter, $object_info);
                       if ($chk_error) {
                             $resp = array('code' => MISSING_PARAM, 'message' => ('YOU_HAVE_MISSED_A_PARAMETER_') . strtoupper($chk_error['param']));
                             $this->response($resp);
                        }
            $category_data = $this->common_model->getAllRecordsById('category_master',array('parent_id' => $data['parent_id']));
            if(!empty($category_data)) {  
                $path = base_url().'uploads/';
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $category_data,'img_url' => IMG_URL));
            } else {

                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('category not found')));
            }
         $this->response($resp);
    
    }
    /*
    all product by category service
    */
    public function getallproductbycategory_post() {

            /* Check for required parameter */
            $pdata = file_get_contents("php://input");
            $data = json_decode($pdata,true);
            $object_info = $data;  
            $required_parameter = array('category_id');
                        $chk_error = check_required_value($required_parameter, $object_info);
                       if ($chk_error) {
                             $resp = array('code' => MISSING_PARAM, 'message' => ('YOU_HAVE_MISSED_A_PARAMETER_') . strtoupper($chk_error['param']));
                             $this->response($resp);
                        }
            $product_data = $this->common_model->getAllRecordsById('product_master',array('category_id' => $data['category_id']));
            if(!empty($product_data)) {  
                $path = base_url().'uploads/';
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $product_data,'img_url' => IMG_URL));
            } else {

                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('product not found')));
            }
         $this->response($resp);
    
    }
    /*
    all product service
    */
    public function getallproduct_post() {

            /* Check for required parameter */
            $pdata = file_get_contents("php://input");
            $data = json_decode($pdata,true);
            $object_info = $data;  
            $product_data = $this->common_model->getAllRecords('product_master');
            if(!empty($product_data)) {  
                $path = base_url().'uploads/';
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $product_data,'img_url' => IMG_URL));
            } else {

                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('product not found')));
            }
         $this->response($resp);
    
    }
     /*
     product details
    */
    public function productdetails_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode($pdata,true);
        $object_info = $data;  
        $required_parameter = array('product_id');
                    $chk_error = check_required_value($required_parameter, $object_info);
                   if ($chk_error) {
                         $resp = array('code' => MISSING_PARAM, 'message' => ('YOU_HAVE_MISSED_A_PARAMETER_') . strtoupper($chk_error['param']));
                         $this->response($resp);
                    }
        $product_data = $this->common_model->getSingleRecordById('product_master',array('product_id' => $data['product_id']));
        if(!empty($product_data)) {  
            $path = base_url().'uploads/';
            $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $product_data,'img_url' => IMG_URL));
        } else {

            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('product not found')));
        }
        $this->response($resp);
    
    }
    /*
    all banner list
    */
    public function getbannerimage_post() {

            /* Check for required parameter */
            $pdata = file_get_contents("php://input");
            $data = json_decode($pdata,true);
            $object_info = $data;  
            $banner_data = $this->common_model->getAllRecords('banner');
            if(!empty($banner_data)) {  
                $path = base_url().'uploads/';
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $banner_data,'img_url' => IMG_URL));
            } else {

                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('image not found')));
            }
         $this->response($resp);
    
    }
    /*
    sms api function
    */
    public function smsapi($otp,$mobile){
        $param['uname'] = 'posh1993'; 

        $param['password'] = 'posh@123'; 

        $param['sender'] = 'Poshsu'; 

        $param['receiver'] = $mobile; 

        $param['route'] = ''; 

        $param['msgtype'] = ''; 

        $param['sms'] = ''; 

        $parameters = http_build_query($param); 

        $url="http://control.textlab.in/index.php/Bulksmsapi/httpapi"; 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch,CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters); 
        $result = curl_exec($ch);

    }
    /*
    searching 
    */
    public function searching_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata, true);
      $object_info = $data;
      $required_parameter = array('keyword');
      $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
            $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'FAILURE', 'error_label' => 'YOU_HAVE_MISSED_A_PARAMETER_'. strtoupper($chk_error['param'])));
        }
      $whr1= "category_name LIKE'" . $data['keyword'] ."%'";
      $valuedata1 = $this->common_model->likesearch1('category_master',$whr1);
      $whr3= "product_name LIKE'" . $data['keyword'] ."%'";
      $valuedata3 = $this->common_model->likesearch3('product_master',$whr3);
      $whr4= "name LIKE'" . $data['keyword'] ."%'";
      $valuedata4 = $this->common_model->likesearch3('banner',$whr4);
      $whr5= "discount_name LIKE'" . $data['keyword'] ."%'";
      $valuedata5 = $this->common_model->likesearch3('discount_master',$whr5);
      $whr6= "coupan_name LIKE'" . $data['keyword'] ."%'";
      $valuedata6 = $this->common_model->likesearch3('coupan_master',$whr6);
      //$whr7= "name LIKE'" . $data['keyword'] ."%'";
      $valuedata = array_merge($valuedata1,$valuedata3,$valuedata4,$valuedata5,$valuedata6);
        //print_r($valuedata); die;
        if (!empty($valuedata)) {
          $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('value_data' => $valuedata,'img_url' => IMG_URL,));

        } else {

        $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('value_data' => $valuedata,'img_url' => IMG_URL,));

        }
        $this->response($resp);
    
    }
     /*
    all supplier service
    */
    public function getallsuppilers_post() {

            /* Check for required parameter */
            $pdata = file_get_contents("php://input");
            $data = json_decode($pdata,true);
            $object_info = $data;  
            $required_parameter = array('user_role');
                        $chk_error = check_required_value($required_parameter, $object_info);
                       if ($chk_error) {
                             $resp = array('code' => MISSING_PARAM, 'message' => ('YOU_HAVE_MISSED_A_PARAMETER_') . strtoupper($chk_error['param']));
                             $this->response($resp);
                        }
            $supplier_data = $this->common_model->getAllRecordsById('users_master',array('user_role' => $data['user_role']));
            if(!empty($supplier_data)) {  
                $path = base_url().'uploads/';
                $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('result' => $supplier_data,'img_url' => IMG_URL));
            } else {

                $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response'=> array('error' => 'FAILURE', 'error_label' => ('supplier not found')));
            }
         $this->response($resp);
    
    }
    /*
     Add To Card
    */
    public function add_to_cart_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        //$data = $_POST;
        $object_info = $data;

        $required_parameter = array('user_id','product_id','product_qty','product_price','tax_amount','discount_amount','offer_amount','coupan_amount','sale_price','cart_wish_type');
        $chk_error = check_required_value($required_parameter, $data);
        if ($chk_error) {
             $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['cart_wish_status'] = 0;
        $product_cart_id = $this->common_model->addRecords('product_cart_to_cart_wishlist', $data);
        
        if($product_cart_id) {        
            /* Get add to cart data */
            $addtocartData = $this->common_model->getSingleRecordById('product_cart_to_cart_wishlist', array('product_cart_id' => $product_cart_id));
            $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('card_data' => $addtocardData));
        } else {
            $resp = array('code' => ERROR, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured, please try again.'));
        }
        @$this->response($resp);
    
    }
}

?>