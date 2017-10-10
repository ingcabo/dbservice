<?php

//debemos colocar esta l�nea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';



class Myrest extends REST_Controller{

function __construct(){
parent:: __construct();
$this->load->helper('my_api_helper');
$this->load->helper('my_woocomerce');
$this->load->helper('url');
$this->load->helper('xml');
$this->load->helper('file');
$this->load->helper('date');
date_default_timezone_set("America/New_York");


}
function fecha_get(){


/*

$datestring = "%m%d%Y_%H%i%s";
			$time = time();
			$date = date("h%i%s");

*/


//2016-07-26 12:34:29
	date_default_timezone_set("America/New_York");
			$datestring = "%yyyy%d%Y_%H%i%s";
			$time = time();
			$date = date("h%i%s");
			$fecha= mdate($datestring, $time);



$this->response(array("staus" =>"ver", "fecha"=> $fecha),200);

}




function lote_put(){



			//aca esta la entrada de datos
			//$datos_compra=  file_get_contents('http://127.0.0.1/nixapiRest/application/controllers/data.json');



				$headers = apache_request_headers();
					$metodo_data= array();
					foreach ($headers as $header => $value) {
    						$metodo_data[$header] =  $value;

					}

						//file_put_contents("cabecera.txt",$metodo_data);


					$compra="";
					$lote = "";
					//$headers = json_encode($headers);

					/*para version web*/
				  // web	$compra = json_decode($headers['Compra'],true);
			      // web	$lote = json_decode($headers['Lote'],true);
					/*para version web*/

					/*para version local*/
					$compra = json_decode($metodo_data['compra'],true);
					$lote = json_decode($metodo_data['lote'],true);
					/*para version local*/




/******************************************************************************/






			//$lote = json_encode($lote);
			//$this->load->library('form_validation');
			//$data = remove_unknown_fields($lote,$this->form_validation->get_field_names('lote_put'));
			//$this->form_validation->set_data($data);



			//file_put_contents("respuestas/data.txt",$data);




					$this->load->model('Model_lote');

					$this->load->model('Model_status');


					//$inic = $this->Model_lote->getMaxmin('max');

					if (1== 1){



			$lote_id = $this->Model_lote->insert($lote);


		if ($lote_id) {

		$i = 0;
		foreach ($compra as $var){

		$compra[$i]['id_lote'] = $lote_id;

		$i++;
		}

			$this->load->model('model_comprarest');

			$compra = 	$this->model_comprarest->insert_many_desa($compra);
		//	$this->response(array("staus" =>"ingreso lote", "compra"=> $compra));


							if ($compra >= 1){

									$criterio = array("id_lote"=> $lote_id);
									$lote = $this->Model_lote->get_by($criterio);

									$this->response(array("staus" =>"susses", "id_lote"=> $lote_id,"total_lote"=>$lote['monto_total']),200);

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
				$data= array();
				foreach ($headers as $header => $value) {
    					$data[$header] =  $value;

				}
				$this->load->model('Model_lote');

				$control = json_decode($headers['Control'],true);
				$lote = json_decode($headers['Lote'],true);


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

				$status = json_decode($headers["status"],true);


				$this->load->model('model_status');
				$this->load->model('model_lote');
				$this->load->model('Model_compra');
				$this->load->model('Model_compra_detalle');


			   $this->load->library('form_validation');

			   $data = remove_unknown_fields($status,$this->form_validation->get_field_names('status_put'));

			   $this->form_validation->set_data($data);



				$conrtol=$data['control'];
				$factura=$data['factura'];

				//consulto si la factura existe asociada al numerode control
			$exist_factura= $this->model_lote->count_by(array("id_lote"=>$factura,"control"=>$conrtol));
			$existe_control= $this->model_status->count_by(array("factura"=>$factura,"control"=>$conrtol));

			$query_lote= $this->model_lote->get_by(array("status"=>"active","id_lote"=>$factura));


			$query_compra = $this->Model_compra_detalle->get_by(array("id_lote"=>$factura));



 			if ($exist_factura >= 1){



			 		if ($existe_control>= 1){
					$this->woocomerce($conrtol);
			 		$this->response(array("status"=> "duplicado","descripcion"=>"El Registro ya existe","data"=>$data,"dato"=>$query_lote,"comprad"=>array($query_compra)),200);
			 		}else{
			 		$insert = $this->model_status->insert($data);

			 		}


 				}else{

 					$this->response(array("status"=> "error","descripcion"=>"el numero de factura y numero de control no esta asociados en nuestra base de datos","data"=>null,"dato"=>null),200);
 				}





			if (!$insert){

	$this->response(array("status"=> "error","descripcion"=>"los datos no fueron ingresados en nuestra base de datos, por favor guarde este vaucher y pongase en contacto con nuestra tienda","data"=>$data,"dato"=>$query_lote,"comprad"=>array($query_compra)),500);

			}else{



			$this->response(array("status"=> "success","descripcion"=>"los datos fueron ingresados en nuetra base de datos, si su pago fue exitoso nuestro Asesor de Belleza se pondran en contactos con usted a traves de los datos personales ingresados en el formulario de compra","data"=>$data,"dato"=>$query_lote,"comprad"=>array($query_compra)),200);


			}






		}



		function woocomerce($control){

		//$control = 244942548681;
		$this->load->model('Model_wpposts');
		$exist_factura= $this->Model_wpposts->count_by(array("to_ping"=>$control));


		if ($exist_factura >= 1){

			$id_wp_posts = 0;
			$id_wp_postmeta = 0;
			$id_order_items = 0;

		}else{

			$id_wp_posts	 = insrt_wp_posts($control);

			$id_wp_postmeta	 = insrt_wp_postmeta($control,$id_wp_posts);

			$id_order_items	 = insrt_wp_woocommerce_order_items($control,$id_wp_posts);

		}


	//	$this->response(array("status"=> "woocomerce_put","data"=>$id_wp_posts),200);

		}











}
