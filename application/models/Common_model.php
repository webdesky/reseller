<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model
{
    function getDatabyid($table,$colname,$id){
     $this->db->select('*');
     $this->db->from($table);
     $this->db->where($colname,$id);
     $query = $this->db->get();
     return $query->result_array();
    }   
    
    function insertData($table, $dataInsert)
    {
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }    
    function updateFields($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
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
    function get_matching_record($table,$val,$field_name)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where("$field_name LIKE '%$val%'");
        $q = $this->db->get();
        $num = $q->num_rows();
        if ($num > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    function get_selected_field($table, $where = '', $fld='', $order_by = '', $order = '')
    {
        if ($fld != NULL) {
            $this->db->select($fld);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
       
        $q   = $this->db->get($table);
        return $q->result();
    }
    function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = '')
    {
        if ($fld != NULL) {
            $this->db->select($fld);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
        $this->db->limit(1);
        $q   = $this->db->get($table);
        $num = $q->num_rows();
        if ($num > 0) {
            return $q->row();
        }
    }
    
    function GetJoinRecord($table, $field_first, $tablejointo, $field_second, $field_val = '', $where = "",$group_by='')
    {
        if (!empty($field_val)) {
            $this->db->select("$field_val");
        } else {
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        if (!empty($where)) {
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by("$table.$field_first");
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    
    function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '')
    {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        $q        = $this->db->get($table);
        //echo $this->db->last_query(); 
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    
    function getAll($table, $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '')
    {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        $q        = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result_array() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    
    function getAllwherenew($table, $where, $select = 'all')
    {
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->where($where, NULL, FALSE);
        $q        = $this->db->get($table);
        // echo $this->db->last_query();
        // die;
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result_array() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        } else {
            return 'no';
        }
    }
    
    function getcount($table, $where)
    {
        $this->db->where($where);
        $q = $this->db->count_all_results($table);
        return $q;
    }
    
    function getTotalsum($table, $where, $data)
    {
        $this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->row();
    }
    
    function GetJoinRecordNew($table, $field_first, $tablejointo, $field_second,$tablejointhree, $field_third, $field, $value, $field_val)
    {
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        $this->db->join("$tablejointhree", "$tablejointhree.$field_third = $table.$field_first");
        $this->db->where("$table.$field", "$value");
        //$this->db->group_by("$table.$field_first");
        $this->db->limit(1);
        $q = $this->db->get();
        // echo $this->db->last_query();
        // die;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    function Getrecords_for_view()
    {

//SELECT um.user_id, um.user_fullname, um.user_email FROM sales_order_master as som INNER JOIN sales_order_product AS sop ON sop.sales_order_id=som.sale_order_id  INNER JOIN users_master AS um ON um.user_id=som.user_id WHERE 1

        $this->db->select("users_master.user_id, users_master.user_fname, users_master.user_lname, users_master.user_email,sales_order_master.total_sale_price, sales_order_master.invoice_no,sales_order_master.transaction_no , sales_order_master.total_tax_amount,sales_order_master.total_discount_amount,sales_order_product.product_name ,sales_order_product.tax_amount, sales_order_product.product_price, sales_order_product.product_qty, sales_order_product.tax_amount , sales_order_product.sale_amount, sales_order_product.dicount_amount");
        $this->db->from("sales_order_master");
        $this->db->join("sales_order_product", "sales_order_product.sale_order_id = sales_order_master.sale_order_id");
        $this->db->join("users_master", "users_master.user_id = sales_order_master.user_id");
        //$this->db->join("port", "port.port_id = $table.port_of_loading");
        //$this->db->join("invoice_consinee_details", "invoice_consinee_details.job_id = $table.job_id");
        //$this->db->join("consignee_details", "consignee_details.consignee_id = invoice_consinee_details.consigner_id");
        //$this->db->where("$table.$field", "$value");
        //$this->db->group_by("$table.job_id");
        //$this->db->order_by("$table.job_id",'DESC');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $rows) {
                $data[] = $rows;
            }
            $q->result_array();
            return $data;
        }
    }
    function GetSalerecords_for_view($table)
    {
        $this->db->select("*");
        $this->db->from("$table");
        $this->db->order_by('job_id','DESC');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    function getRecords($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }
    
    function getAllRecords($table, $conditions = '')
    {
        if (!empty($conditions)) {
            $query = $this->db->get_where($table, $conditions);
        } else {
            $query = $this->db->get($table);
        }
        return $query->result_array();
    }
    
    function delete($table, $where)
    {
        $this->db->where($where)->delete($table);
    }
    
    function update($table, $update, $where)
    {
        $query = $this->db->where($where)->update($table, $update);
    }
    
    // some extra function start //
    function countRecord($table, $condition)
    {
        $this->db->where($condition);
        $query = $this->db->get($table);
        return $query->num_rows();
    }
    
    function fetchMaxRecord($table, $field)
    {
        $this->db->select_max($field, 'max');
        $query = $this->db->get($table);
        return $query->row_array();
    }
    
    function insertPasswordResetString($email_address, $password_reset_key)
    {
        $this->db->where('email', $email_address);
        $this->db->update(USERS, array(
            "password_reset_key" => $password_reset_key
        ));
    }
    
    function exists($fields)
    {
        $query = $this->db->get_where(USERS, $fields, 1, 0);
        if ($query->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }
    
    function updatePassword($password, $password_reset_key)
    {
        $this->db->where('password_reset_key', $password_reset_key);
        $this->db->update(USERS, array(
            "password_reset_key" => "",
            "password" => md5($password)
        ));
    }
    
    function check_oldpassword($oldpass, $user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->where('password', md5($oldpass));
        $query = $this->db->get('admins'); //data table
        return $query->num_rows();
    }

    function get_invoice_data($job_id){
        $this->db->distinct();
        $this->db->select('*,invoice_details.invoice_id as invoice_main_id');
        $this->db->from('invoice_details');
        $this->db->join('invoice_frieght_details','invoice_frieght_details.job_id = invoice_details.job_id', 'inner');
        $this->db->join('invoice_other_details', 'invoice_other_details.job_id = invoice_frieght_details.job_id', 'inner');
        $this->db->join('invoice_consinee_details', 'invoice_consinee_details.job_id = invoice_other_details.job_id', 'inner');
        $this->db->join('currency', 'currency.currency_id = invoice_details.currency', 'inner');
        $this->db->where('invoice_details.job_id', $job_id);
        $this->db->group_by('invoice_details.invoice_id');
        $q = $this->db->get();
        // echo $this->db->last_query();
        // die;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }    


    }

    function multiple_delete_data($id){
        $this->db->delete('job_details', array('job_id' => $id)); 
        $this->db->delete('purchaser_detail', array('job_id' => $id));
        $this->db->delete('igm_other_details', array('job_id' => $id));
        $this->db->delete('igm_details', array('job_id' => $id)); 
        $this->db->delete('igm_container_details', array('job_id' => $id));
        $this->db->delete('invoice_details', array('job_id' => $id));
        $this->db->delete('invoice_frieght_details', array('job_id' => $id)); 
        $this->db->delete('invoice_consinee_details', array('job_id' => $id));
        $this->db->delete('invoice_other_details', array('job_id' => $id));
        $this->db->delete('product_details', array('job_id' => $id)); 
        $this->db->delete('product_applied_cust_duty', array('job_id' => $id));
        $this->db->delete('product_general_information', array('job_id' => $id));
        $this->db->delete('product_manufaturer_details', array('job_id' => $id));
        $this->db->delete('product_cust_duty', array('job_id' => $id));
        $this->db->delete('product_previous_details', array('job_id' => $id)); 
        $this->db->delete('product_constituent_and_control_details', array('job_id' => $id));
        $this->db->delete('bond_certificate_details', array('job_id' => $id));
        $this->db->delete('bond_detail', array('job_id' => $id)); 
        $this->db->delete('bond_shipment_detail', array('job_id' => $id));
        $this->db->delete('bond_supporting_document', array('job_id' => $id));
        return 'success';
    }

    
      function get_sales_all_records($id)
    {
        $this->db->select('*');
        $this->db->from('sale_job_details');
        $this->db->join('saler_details', 'saler_details.job_id = sale_job_details.job_id');
        $this->db->join('consignee_other_details', 'consignee_other_details.job_id = sale_job_details.job_id');
        $this->db->join('sale_invoice_details', 'sale_invoice_details.job_id = sale_job_details.job_id');
        $this->db->join('sale_shipment_details', 'sale_shipment_details.job_no = sale_job_details.job_id');
        $this->db->where('sale_job_details.job_id', $id);
        $this->db->group_by('sale_invoice_details.invoice_id');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }   
    }
    
    function get_editable_igm($id)
    {
        $this->db->select('*');
        $this->db->from('igm_details');
        $this->db->join('igm_other_details', 'igm_other_details.job_id = igm_details.job_id');
        $this->db->join('igm_container_details', 'igm_container_details.job_id = igm_other_details.job_id');            
        $this->db->where('igm_details.job_id', $id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }        
    }


    function get_editable_bond($id)
    {
        $this->db->select('*');
        $this->db->from('bond_detail');
        $this->db->join('bond_shipment_detail', 'bond_shipment_detail.job_id = bond_detail.job_id');
        $this->db->join('bond_supporting_document', 'bond_supporting_document.job_id = bond_shipment_detail.job_id'); 
        $this->db->join('bond_certificate_details', 'bond_certificate_details.job_id = bond_supporting_document.job_id');            
        $this->db->where('bond_detail.job_id', $id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }        
    }

    function all_invoice_in_product_by_job_id($id){
        $this->db->select('invoice_details.invoice_no');
        $this->db->from('invoice_details');
        $this->db->where("job_id", $id);
        $this->db->group_by('invoice_details.invoice_id');
        $this->db->order_by('invoice_details.invoice_id');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }   
    }


    function all_product_by_product_id($id, $job_id=''){
        $this->db->select('*');
        $this->db->from('product_details');
        $this->db->join('product_anti_dumping_duty', 'product_anti_dumping_duty.product_id = product_details.product_details_id');
        $this->db->join('product_applied_cust_duty', 'product_applied_cust_duty.product_id = product_anti_dumping_duty.product_id');
        $this->db->join('product_constituent_and_control_details', 'product_constituent_and_control_details.product_id =product_applied_cust_duty.product_id');
        $this->db->join('product_cust_duty', 'product_cust_duty.product_id = product_constituent_and_control_details.product_id');
        $this->db->join('product_excize_duty', 'product_excize_duty.product_id = product_cust_duty.product_id');
        $this->db->join('product_ex_duty', 'product_ex_duty.product_id = product_excize_duty.product_id');     
        $this->db->join('product_general_information', 'product_general_information.product_id = product_ex_duty.product_id');
        $this->db->join('product_gst_details', 'product_gst_details.product_id = product_general_information.product_id');
        $this->db->join('product_manufaturer_details', 'product_manufaturer_details.product_id = product_gst_details.product_id');
        $this->db->join('product_previous_details', 'product_previous_details.product_id = product_manufaturer_details.product_id');
        $this->db->where('product_details.product_details_id', $id);
        if(!empty($job_id)){
            $this->db->where('product_details.job_id', $job_id);
        }
        $q = $this->db->get();

        // echo $this->db->last_query(); 
        // die;

        if ($q->num_rows() > 0) {
            return $q->result_array();
        }  
    }
    function puchase_sales_invoice_data($id, $where){
        $this->db->select('*,invoice_details.invoice_id as main_invoice_id');
        $this->db->from('invoice_details');
        $this->db->join('invoice_frieght_details','invoice_frieght_details.job_id = invoice_details.job_id', 'inner');
        $this->db->join('invoice_other_details', 'invoice_other_details.job_id = invoice_details.job_id', 'inner');
        $this->db->join('invoice_consinee_details', 'invoice_consinee_details.job_id = invoice_details.job_id', 'inner');
        $this->db->join('currency', 'currency.currency_id = invoice_details.currency', 'inner');
        $this->db->where("invoice_details.$where", $id);
        $this->db->group_by('invoice_details.invoice_id');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }   
    }

    function get_sales_invoice_data($job_id){
        $this->db->select('*,sale_invoice_details.invoice_id as mainid');
        $this->db->from('sale_invoice_details');
        $this->db->join('sale_invoice_frieght_details','sale_invoice_frieght_details.job_id = sale_invoice_details.job_id', 'inner');
        $this->db->join('sale_invoice_other_details', 'sale_invoice_other_details.job_id = sale_invoice_frieght_details.job_id', 'inner');
        $this->db->join('sale_invoice_third_party', 'sale_invoice_third_party.job_id = sale_invoice_other_details.job_id', 'inner');
        $this->db->where('sale_invoice_details.job_id', $job_id);
        $this->db->group_by('sale_invoice_details.invoice_id');
        // echo $this->db->last_query();
        // die;
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }    


    }


    function get_allexporter_details($id){
        $this->db->select("branch_details.*,bank_details.*,country.*,state.*,branch_details.branch_id as main_branch_id");
        $this->db->from("branch_details");
        $this->db->join("bank_details", "bank_details.exporter_id = branch_details.exporter_id" ,'inner');
        $this->db->join("country","country.country_id = branch_details.country" ,'inner');
        $this->db->join("state", "state.state_id = branch_details.state" ,'inner');
        $this->db->where("branch_details.exporter_id", $id);
        $this->db->group_by('branch_details.branch_id');
        $q = $this->db->get();
        // echo $this->db->last_query();
        // die;
        if ($q->num_rows() > 0) 
        {
          return $result=$q->result_array();
        }

    }

    function get_editable_purchase($id)
    {
        $this->db->select('*');
        $this->db->from('job_details');
        $this->db->join('igm_other_details', 'igm_other_details.job_id = job_details.job_id');
        $this->db->join('igm_details', 'igm_details.job_id = job_details.job_id');
        $this->db->join('igm_container_details', 'igm_container_details.job_id = job_details.job_id');
        $this->db->join('invoice_details', 'invoice_details.job_id = job_details.job_id');
        $this->db->join('invoice_frieght_details', 'invoice_frieght_details.job_id = job_details.job_id');
        $this->db->join('invoice_consinee_details', 'invoice_consinee_details.job_id = job_details.job_id');
        $this->db->join('invoice_other_details', 'invoice_other_details.job_id = job_details.job_id');
        $this->db->join('product_anti_dumping_duty', 'product_anti_dumping_duty.job_id = job_details.job_id');
        $this->db->join('product_applied_cust_duty', 'product_applied_cust_duty.job_id = job_details.job_id');
        $this->db->join('product_constituent_and_control_details', 'product_constituent_and_control_details.job_id =job_details.job_id');
        $this->db->join('product_cust_duty', 'product_cust_duty.job_id = job_details.job_id');
        $this->db->join('product_details', 'product_details.job_id = job_details.job_id');
        $this->db->join('product_excize_duty', 'product_excize_duty.job_id = job_details.job_id');
        $this->db->join('product_ex_duty', 'product_ex_duty.job_id = job_details.job_id');     
        $this->db->join('product_general_information', 'product_general_information.job_id = job_details.job_id');
        $this->db->join('product_gst_details', 'product_gst_details.job_id = job_details.job_id');
        $this->db->join('product_manufaturer_details', 'product_manufaturer_details.job_id = job_details.job_id');
        $this->db->join('product_previous_details', 'product_previous_details.job_id = job_details.job_id');
        $this->db->join('purchaser_detail', 'purchaser_detail.job_id = job_details.job_id');
        $this->db->join('bond_certificate_details', 'bond_certificate_details.job_id = job_details.job_id');
        $this->db->join('bond_detail', 'bond_detail.job_id = job_details.job_id');
        $this->db->join('bond_shipment_detail', 'bond_shipment_detail.job_id = job_details.job_id');
        $this->db->join('bond_supporting_document', 'bond_supporting_document.job_id = job_details.job_id');
        $this->db->where('job_details.job_id', $id);    
        $q = $this->db->get();
        return $q->num_rows(); 
        // if ($q->num_rows() > 0) {
        //     foreach ($q->result() as $rows) {
        //         $data[] = $rows;
        //     }
        //     $q->free_result();
        //     return $data;
        // }        
    }

    function get_consignee_all_records($id)
    {
        $this->db->select('*');
        $this->db->from('consignee_other_details');
        $this->db->where('job_id',$id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }   
    }
    function delete_product_data($id){
        $this->db->delete('product_details', array('product_details_id' => $id)); 
        $this->db->delete('product_applied_cust_duty', array('product_id' => $id));
        $this->db->delete('product_general_information', array('product_id' => $id));
        $this->db->delete('product_manufaturer_details', array('product_id' => $id));
        $this->db->delete('product_cust_duty', array('product_id' => $id));
        $this->db->delete('product_previous_details', array('product_id' => $id)); 
        $this->db->delete('product_constituent_and_control_details', array('job_id' => $id));
        $this->db->delete('product_anti_dumping_duty', array('product_id' => $id));
        $this->db->delete('product_excize_duty', array('product_id' => $id));
        $this->db->delete('product_ex_duty', array('product_id' => $id)); 
        $this->db->delete('product_gst_details', array('product_id' => $id));
    }


    function delete_invoice_data($id, $invoice_no){
        $this->db->delete('invoice_details', array('invoice_id' => $id));
        $this->db->delete('invoice_frieght_details', array('invoice_id' => $id)); 
        $this->db->delete('invoice_consinee_details', array('invoice_id' => $id));
        $this->db->delete('invoice_other_details', array('invoice_id' => $id));      
        $this->db->delete('product_details', array('invoice_no' => $invoice_no)); 
    }

}
