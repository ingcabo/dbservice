<?php

//debemos colocar esta línea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';

class Products extends REST_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->helper('my_api_helper');
		$this->load->model('Model_products');
		$this->load->config('rest');
	}
	
	public function index_get(){

		$criterio['activo'] = 1;
		$data = $this->Model_products->get_many_by($criterio);
		$this->response(array("status" =>"susses", "data"=> $data),200);
	}

}
