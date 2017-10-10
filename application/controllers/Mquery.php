<?php

//debemos colocar esta línea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';



					class Mquery extends REST_Controller
					{

					function __construct(){
					parent:: __construct();
					$this->load->helper('my_api_helper');
					$this->load->helper('file');
					$this->load->config('rest');
					$this->load->helper('date');
					} 


					public function detallecompra_get(){

					//$entrada = $this->put();	
		    		//$nombre = $this->put('username');
		
				    //Leemos la cabecera de la peticion
					$headers = apache_request_headers();
					$this->load->model('Model_compra');	
					
					//decodificamos metodo json a un array php es entrada
					$headers = json_encode($headers);
					$data = json_decode($headers,true);
					


					$criterio = array();

					$criterio['status'] = "active";

					if(!$this->uri->segment(3) === FALSE){	
					$criterio['control'] = $this->uri->segment(3);
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
				  $qdetalle = $this->Model_compra->get_many_by($criterio);


					
/******************************************************************************/


						$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "consulta realizada", $this->config->item('data') => $qdetalle),200);
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
					$ulttrack = null;


					if(!$this->uri->segment(3) === FALSE){	
					$criterio['num_control'] = $this->uri->segment(3);
					//$ulttrack = $this->Model_comprat->ult_track($criterio['num_control']);
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
				//  $qdetalle = $this->Model_comprat->get_many_by($criterio);
				$qdetalle = $this->Model_comprat->get_many_by($criterio);

					
				$factura= $qdetalle[0]['num_factura'];
				 	
				$ulttrack = $this->Model_comprat->ult_track($factura); 

				   

				  


					
/******************************************************************************/


						$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "consulta realizada", $this->config->item('data') => $qdetalle,"track"=> $ulttrack),200);
					}



					function traking_get(){

							//$entrada = $this->put();	
		    		    //$nombre = $this->put('username');
		
				    //Leemos la cabecera de la peticion
					$headers = apache_request_headers();
					$this->load->model('Model_traking');	
					
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
				

				
				
				
    				//aca consultamos segun el criterio
				  $qdetalle = $this->Model_traking->get_many_by($criterio);






				$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "consulta realizada", $this->config->item('data') => $qdetalle),200);
					}

					function traking_put(){


					//capturamos los datos que vienen en la cabecera
					$headers = apache_request_headers();
					$metodo_data= array();
					foreach ($headers as $header => $value) {
    				$metodo_data[$header] =  $value;
 			
					}		
					$key = $metodo_data['key'];

					$entrada = $this->put();	
					$this->load->library('form_validation');	
					$data = remove_unknown_fields($entrada,$this->form_validation->get_field_names('traking_put'));

					$this->form_validation->set_data($data);

					$this->load->model('Model_traking');

					$usrDat = $this->Model_traking->consulta_usuario($key);

					$data['responsable'] = $usrDat['username'];


					if ($this->form_validation->run('traking_put') != false){

						$trakId= $this->Model_traking->insert($data);


								if (!$trakId){

										//si no se puede hacer el insert muestro un error			
								$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('fallo') , $this->config->item('rest_message_field_name') => 'un error al crear el Registro', $this->config->item('data') =>'false'),REST_Controller::HTTP_BAD_REQUEST);
								}else{

									$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "Registro Creado", $this->config->item('data') => $this->config->item('dataT')),200);

								}


					}else{


						//aca muestro que faltan datos en el formulario o no cumplen con lo esperado
						$this->response(array($this->config->item('rest_status_field_name')  => $this->config->item('fallo') , $this->config->item('rest_message_field_name') => $this->form_validation->get_errors_as_array(), $this->config->item('data') => $this->config->item('dataF')),404);
					}


					}



} 



