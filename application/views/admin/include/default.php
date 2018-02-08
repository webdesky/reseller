<?php
    echo $page; 
    die;
$this->load->view('admin/include/header');
$this->load->view('admin/include/sidebar');
$this->load->view('admin/'.$page);

?>