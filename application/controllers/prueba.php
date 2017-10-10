<?php
Class Prueba extends CI_Controller {

  function Prueba()   {
    parent::__construct(); 

    // load helpers
    $this->load->helper('url');
  }
  
  
  function index(){
  
  
  $this->load->view('test',true);
  
  
  }
  
}
	
	?>