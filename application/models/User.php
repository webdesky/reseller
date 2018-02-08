<?php 

class User extends CI_Model {

  function login($username, $password)
  {
	   $this -> db -> select('id, email, password,first_name,user_role');
	   $this -> db -> from('admin_master');
	   $this -> db -> where('email', $username);
	   $this -> db -> where('password', ($password));
     //$this -> db -> where('userrole', '2');
     $this -> db -> limit(1);
     $query = $this -> db -> get();
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

 function insertrecords($table,$data)
 {
   $this->db->insert($table,$data); 
 }

 function getAllUsers()
 {
   $this->db->select('us.*,ur.name as role,ur.roleid,ur.status');
   $this->db->from('users as us');
   $this->db->join('userrole as ur','ur.roleid=us.userrole');
   $this->db->where('us.userrole != ',1);
   $this->db->last_query();
   $query = $this->db->get();
   return $query->result_array();
}

 function getAlldata($table,$where){
     $this->db->select('*');
     $this->db->from($table);
     if($where){
       $where; 
     }
      $this->db->last_query();
     $query = $this->db->get();
     return $query->result_array();
 }

 function getAllOrders(){
  
     $query="SELECT booking.*, users.email
      FROM booking
      INNER JOIN users
      ON booking.user_id=users.id";
     $result = $this->db->query($query)->result_array();
    return $result;
     // $this->db->select('rs.*,rs.name as status_type ,fr.*,u.id,u.email,u.firstname,v.name as vehicle');
     // $this->db->from('fuel_request  as fr');
     // $this->db->join('users as u','fr.user_id = u.id');
     // $this->db->join('vehiclelist as vl','vl.id = fr.vehicle_id');
     // $this->db->join('vehicle as v','v.vehicle_id = vl.makeid');
     // $this->db->join('fuel_price as fp','fr.fuel_type =  fp.id','left');
     // $this->db->join('requeststatus as rs','fr.request_status = rs.id','left');
     // $this->db->order_by('fr.request_id','desc');
     // $this->db->last_query();
     // $query = $this->db->get();
     // return $query->result_array();
 }

function getOrderById($id){
     $this->db->select('rs.*,rs.name as status_type ,fr.*,u.id,u.email,u.firstname,u.lastname,u.email,u.phonenumber,v.name as vehicle,vm.model as vehicle_model');
     $this->db->from('fuel_request  as fr');
     $this->db->join('users as u','fr.user_id = u.id');
     $this->db->join('vehiclelist as vl','vl.id = fr.vehicle_id');
     $this->db->join('vehicle as v','v.vehicle_id = vl.makeid');
     $this->db->join('vehicle_model as vm','vm.model_id = vl.modelid');     
     $this->db->join('fuel_price as fp','fr.fuel_type =  fp.id','left');
     $this->db->join('requeststatus as rs','fr.request_status = rs.id','left');
     $this->db->where('fr.request_id',$id);
     $this->db->last_query();
     $query = $this->db->get();
     return $query->result_array();

 }

  function getFeedback($orderid){
     $this->db->select('fb.*,fr.request_id,fr.user_id,u.id,u.email,u.firstname,u.lastname,u.email,u.phonenumber,');
     $this->db->from('feedback  as fb');
     $this->db->join('users as u','fb.userid = u.id');
     $this->db->join('fuel_request as fr','fb.orderid = fr.request_id');
     $this->db->where('fb.orderid',$orderid);
     $this->db->last_query();
     $query = $this->db->get();
     return $query->result_array();
 }

 function getDatabyid($table,$colname,$id){
     $this->db->select('*');
     $this->db->from($table);
     $this->db->where($colname,$id);
     $query = $this->db->get();
     return $query->result_array();
   }

 function updateRecords($tablename,$colname,$id,$data)
   {
      $this->db->where($colname, $id);
      $this->db->update($tablename,$data);
   }  

   function deleteRecord($tablename,$colname,$id){
      $this->db->where($colname, $id);
      $this->db->delete($tablename);
      return true; 
   }

   function getAllVehicleList(){
       $this->db->select('*');
       $this->db->from('vehiclelist  as vl');
       $this->db->join('vehicle as v','v.vehicle_id =  vl.makeid');
       $this->db->join('vehicle_color as vc','vc.color_id = vl.colorid');
       $this->db->join('vehicle_model as vm','vm.model_id = vl.modelid');
       $this->db->join('users as u','u.id = vl.userid');
       $this->db->last_query();
       $query = $this->db->get();
      return $query->result_array();
   }
} 





?>