<?php

//debemos colocar esta línea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';



					class Myquery extends REST_Controller
					{

					function __construct(){
					parent:: __construct();
					$this->load->helper('my_api_helper');
					$this->load->helper('file');
					$this->load->config('rest');
					$this->load->helper('date');
					$this->load->helper('url');


					} 
					
					
					
					public function test(){
					
					$this->response(array("param"=>"bien"),200);
					}


					public function detallecompra_get(){

						//$entrada = $this->put();	
		    		    //$nombre = $this->put('username');
		
				    //Leemos la cabecera de la peticion
					$headers = apache_request_headers();
					$this->load->model('Model_comprad');	
					
					//decodificamos metodo json a un array php es entrada
					$headers = json_encode($headers);
					$data = json_decode($headers,true);
					


					$criterio = array();

					$criterio['status'] = "active";

					if(!$this->uri->segment(3) === FALSE){	
					$criterio['id_lote'] = $this->uri->segment(3);
					}


					

					if  (isset($data['id_lote'])){
						
						$criterio['id_lote'] = $data['id_lote'];
						$id_lote  = $data['id_lote'];
				}
				

				if  (isset($data['id_producto'])){
						
						$criterio['id_producto'] = $data['id_producto'];
				}


					if  (isset($data['descripcion_producto'])){
						
						$criterio['descripcion_producto'] = $data['descripcion_producto'];
				}

						if  (isset($data['estado'])){
						
						$criterio['estado'] = $data['estado'];
				}
				
				
				
    				//aca consultamos segun el criterio
				  $qdetalle = $this->Model_comprad->get_many_by($criterio);


					
/******************************************************************************/


						$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "consulta realizada", "data" => $qdetalle),200);
					}

			
					public function compra_get(){

						//$entrada = $this->put();	
		    		    //$nombre = $this->put('username');
		
				    //Leemos la cabecera de la peticion
					$headers = apache_request_headers();
					$this->load->model('Model_comprat');	
					
					//decodificamos metodo json a un array php es entrada
					$headers = json_encode($headers);
					$data = json_decode($headers,true);
					




					$criterio = array();

					$criterio['status'] = "active";


					if(!$this->uri->segment(3) === FALSE){	
					$criterio['num_factura'] = $this->uri->segment(3);
					}

					

					if  (isset($data['id_lote'])){
						
						$criterio['id_lote'] = $data['id_lote'];
						$id_lote  = $data['id_lote'];
				}
				

				if  (isset($data['id_producto'])){
						
						$criterio['id_producto'] = $data['id_producto'];
				}


					if  (isset($data['descripcion_producto'])){
						
						$criterio['descripcion_producto'] = $data['descripcion_producto'];
				}

						if  (isset($data['estado'])){
						
						$criterio['estado'] = $data['estado'];
				}
				
				
				
    				//aca consultamos segun el criterio
				  $qdetalle = $this->Model_comprat->get_many_by($criterio);


					
/******************************************************************************/


						$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "consulta realizada", "data" => $qdetalle),200);
					}



} 



