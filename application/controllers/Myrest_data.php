<?php

//debemos colocar esta línea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';



class Myrest extends REST_Controller{

function __construct(){
parent:: __construct();
$this->load->helper('my_api_helper');
$this->load->helper('url');
$this->load->helper('xml');
$this->load->helper('file');




 

} 




function lote_get(){





	$this->response(array("staus" =>"bien", "mensaje"=> "NYX WS"),200);
}
			

function lote_put(){


			
			//aca esta la entrada de datos
			//$datos_compra=  file_get_contents('http://127.0.0.1/nixapiRest/application/controllers/data.json');
		


			$headers = apache_request_headers();
				
			$headers = json_encode($headers);
			$headers = json_decode($headers,true);


				
				
			$metodo_data= array();
			foreach ($headers as $header => $value) {
    				$metodo_data[$header] =  $value;
    						
    						
 			
			}


	

			$compra = json_decode($headers["Compra"],true);
			$lote = json_decode($headers["Lote"],true);
					
					
					//$compra = json_encode($compra);
					//$compra = json_decode($compra);

				

						
					//file_put_contents("respuestas/compra.txt",$compra);


		//	$this->response(array("staus" =>"ver", "compra"=> $compra),200);		
		//	$this->response(array("staus" =>"ver", "compra"=> $compra[0]->id_producto),200);

					
					
						

/******************************************************************************/
					


				//	$this->response(array("staus" =>"susses","lote"=>$lote),200);
			
		


		//	$dito = $this->put();
			//$dito = json_decode($dito);	

			// $dito = $this->output
			// ->set_content_type('application/json')
			// ->set_output($this->put());

			//$desa = $this->put();
			

		//	$datos_2 = json_decode($datos_compra);

			//$compra = $this->put();

//			$compra =$dito->lote;

//			$datos = $dito->compra;

	//		$compra = $dito['compra'];
	//		$lote  = $dito['lote'];

	//		$lote   = $entrada->lote;
	//		$compra = $entrada->compra;

            //$this->response(array("completo"=>$compra),200);
			//file_put_contents("respuestas/datos.txt",$lote);
			
			//$lote = json_encode($lote);		
			$this->load->library('form_validation');
			$data = remove_unknown_fields($lote,$this->form_validation->get_field_names('lote_put'));
			$this->form_validation->set_data($data);


            
			//file_put_contents("respuestas/data.txt",$data);

			


					$this->load->model('Model_lote');
				
					//$this->load->model('Model_status');	

	
					$inic = $this->Model_lote->getMaxmin('max');

					if (1== 1){
										
					
						
			$lote_id = $this->Model_lote->insert($data);	

			
		if ($lote_id) {
				
		$i = 0;
		foreach ($compra as $var){
		  
		$compra[$i]['id_lote'] = $lote_id;
		
		$i++;
		}		
			
			$this->load->model('Model_compra');

			$compra = 	$this->Model_compra->insert_many_desa($compra);	
		//	$this->response(array("staus" =>"ingreso lote", "compra"=> $compra));


							if ($compra >= 1){

									$criterio = array("id_lote"=> $lote_id);	
									$lote = $this->Model_lote->get_by($criterio);
									
									$this->response(array("staus" =>"susses", "id_lote"=> $lote_id,"total_lote"=>$lote['monto_total'],"email"=>$lote['email']),200);

							}else{

									$this->Model_lote->delete($lote_id);

									$this->response(array("staus" =>"Faliurede", "lote borrado"=> $lote_id,"id_lote"=> null ),405);

							}

			}else{

				$this->response(array("staus" =>"Faliurede", "data" => $data,"id_lote"=>$lote_id,"data"=>$compra),400);

			}

				}else{

			$this->response(array('status' => 'Faliurede' ,"id_lote"=> null,'message' => $this->form_validation->get_errors_as_array()),404);
			

			}




		}




		function megasoft_get(){


			$url = 'http://127.0.0.1/nixapiRest/application/controllers/ejemplo_aprobado.xml';
			//aprobada	
			$compra =  file_get_contents($url);

			//$origen =
			$para1 = '<![CDATA[';
			$para2 = ']]>'; 

			$compra = str_replace($para1, '', $compra);
			$compra = str_replace($para2, '', $compra);



			$xml = json_decode(json_encode(simplexml_load_string($compra)), true);


	

		

			//pendiete
		//	$compra=  file_get_contents('http://127.0.0.1/nixapiRest/application/controllers/ejemplo_pendiente.xml');
			//rechazada
		//	$compra=  file_get_contents('http://127.0.0.1/nixapiRest/application/controllers/ejemplo_rechazado.xml');



			$this->response(array('status' => 'Faliurede' ,'message' =>"llegamos","data"=> $xml),200);

		}

/*

		function urls_get(){


				//URL 	pre registro		
				$preregistro = 'https://29999999.71.151.226:8443/payment/action/paymentgatewayuniversal-prereg?cod_afiliacion= p1&factura=p2&monto=p3';

				$preregistro = "https://paytest.megasoft.com.ve:8443/payment/login.htm?cod_afiliacion=p1&factura=p2&monto=p3";
				//Validar que trae consigo el numero de control (validar manejo de numero de control en el manual del Payment)
				//este valor numero de control me lo regresan luego del rperegistro
				$url_p = 'https://29999.71.151.226:8443/payment/action/paymentgatewayuniversal-data?control=p4';
				//url de verificacion de numero de control
				$url_veri ='https://299999.71.151.226:8443/payment/action/paymentgatewayuniversal-querystatus?control=p4';



				$this->response(array('preregistro' => $preregistro ,"pago" =>$url_p, "verificacion" =>$url_veri),200);
		}

*/

		function control_put(){



				$headers = apache_request_headers();
				$headers = json_encode($headers);
			        $headers = json_decode($headers,true);
			        
				$data= array();
				foreach ($headers as $header => $value) {
    			$data[$header] =  $value;
 			
				}
				
				$control= json_decode($headers["Control"],true);
			        $lote= json_decode($headers["Lote"],true);	
				
				
				$this->load->model('Model_lote');


				if (isset($control) && isset($lote)){


							$dato = array('control'=>$control);
							$dito= array('id_lote' =>$lote);
							$ddelete = array("status"=>"delete");



							$exist_control = $this->Model_lote->count_by($dato);
							$exist_lote    = $this->Model_lote->count_by($dito);

							if ($exist_control) {


							$update_d = $this->Model_lote->update($lote,$ddelete);

							$this->response(array("bandera"=> 3,'mensaje' => 'numero de control ya existe'),500);
							
							}

							if ($exist_lote){

							$update = $this->Model_lote->update($lote,$dato); 

							}

							

							if ($update){

									$this->response(array("bandera"=> 0,'mensaje' => 'ingreso exitoso'),200);

							}else{

									$this->response(array("bandera"=> 1,'mensaje' => 'ingreso no exitoso'),500);
							}


					
				}


			$this->response(array("bandera"=> 2,'mensaje' => 'parametro incompletos',"data"=> $data),500);
		
		}
		
		
		
		
		
		function status_put(){



				$headers = apache_request_headers();
				$headers = json_encode($headers);
			        $headers = json_decode($headers,true);
				$data= array();
				foreach ($headers as $header => $value) {
    			$data[$header] =  $value;
 			
				}

				$status = json_decode($headers["Status"],true);
				$this->load->model('model_status');
				$this->load->model('model_lote');
				$this->load->model('Model_compra');

			
			   $this->load->library('form_validation');
			   $data = remove_unknown_fields($status,$this->form_validation->get_field_names('status_put'));
			   $this->form_validation->set_data($data);

			  

				$conrtol=$data['control'];
				$factura=$data['factura'];

				//consulto si la factura existe asociada al numerode control
			$exist_factura= $this->model_lote->count_by(array("id_lote"=>$factura,"control"=>$conrtol));
			$existe_control= $this->model_status->count_by(array("factura"=>$factura,"control"=>$conrtol));
			$query_lote= $this->model_lote->get_by(array("status"=>"active","id_lote"=>$factura));
			$query_compra = $this->Model_compra->get_by(array("id_lote"=>$factura));



 			if ($exist_factura >= 1){



			 		if ($existe_control>= 1){

			 		$this->response(array("status"=> "duplicado","descripcion"=>"El Registro ya existe","data"=>$data,"dato"=>$query_lote,"comprad"=>$query_compra),200);	
			 		}else{
			 		$insert = $this->model_status->insert($data);

			 		}


 				}else{

 					$this->response(array("status"=> "error","descripcion"=>"el numero de factura y numero de control no esta asociados en nuestra base de datos","data"=>null,"dato"=>null),200);
 				}




					
			if (!$insert){

	$this->response(array("status"=> "error","descripcion"=>"los datos no fueron ingresados en nuestra base de datos, por favor guarde este vaucher y pongase en contacto con nuestra tienda","data"=>$data,"dato"=>$query_lote,"comprad"=>array($query_compra)),500);

			}else{

			$this->response(array("status"=> "success","descripcion"=>"los datos fueron ingresados en nuetra base de datos,si su pago fue exitoso nuestro analistas se pondran en contactos con usted a traves de los datos personales ingresados en el formulario de compra","data"=>$data,"dato"=>$query_lote,"comprad"=>array($query_compra)),200);


			}






		}
		
		
		
		
		


}


