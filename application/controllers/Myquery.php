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
					$this->load->library('email'); 
					date_default_timezone_set("America/New_York");
					


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
					$criterio['num_factura'] = $this->uri->segment(3);
					$ulttrack = $this->Model_comprat->ult_track($criterio['num_factura']);
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
					$headerso = apache_request_headers();
					$headers = apache_request_headers();
					
					$headers = json_encode($headers);
					$headers = json_decode($headers,true);
					
					$metodo_data= array();
					foreach ($headers as $header => $value) {
    				               $metodo_data[$header] =  $value;
					}	
						
					$key = $headerso['Key'];
					

					$entrada = $this->put();	
					$this->load->library('form_validation');	
					$data = remove_unknown_fields($entrada,$this->form_validation->get_field_names('traking_put'));

					$this->form_validation->set_data($data);

					$this->load->model('Model_traking');

					$usrDat = $this->Model_traking->consulta_usuario($key);

					$data['responsable'] = $usrDat['username'];
					
					unset($usrDat['password']);
					unset($usrDat['key_id']);
					unset($usrDat['pregunta1']);
					unset($usrDat['respuesta1']);
					
					unset($usrDat['id']);
					unset($usrDat['user_id']);
					unset($usrDat['level']);
					unset($usrDat['ignore_limits']);
					unset($usrDat['is_private_key']);
					unset($usrDat['ip_addresses']);
					unset($usrDat['date_created']);
					unset($usrDat['status']);
					unset($usrDat['cargo']);
					
					
					unset($usrDat['register_date']);
					unset($usrDat['nombres']);
					unset($usrDat['apellidos']);
					unset($usrDat['email']);
					unset($usrDat['is_private_key']);
					unset($usrDat['update_timestamp']);
					
					
				
					
   
 				


					if ($this->form_validation->run('traking_put') != false){

						$trakId= $this->Model_traking->insert($data);


								if (!$trakId){

										//si no se puede hacer el insert muestro un error			
								$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('fallo') , $this->config->item('rest_message_field_name') => 'un error al crear el Registro', $this->config->item('data') =>'false'),REST_Controller::HTTP_BAD_REQUEST);
								}else{

									$this->envio_mail($data);
									$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "Registro Creado", $this->config->item('data') => $data),200);
									
									

								}


					}else{


						//aca muestro que faltan datos en el formulario o no cumplen con lo esperado
						$this->response(array($this->config->item('rest_status_field_name')  => $this->config->item('fallo') , $this->config->item('rest_message_field_name') => $this->form_validation->get_errors_as_array(), $this->config->item('data') => $this->config->item('dataF')),404);
					}


					}
					
					
					
					
					function envio_mail($data){
					
						$this->load->model('model_lote');
						$arreglo= $this->model_lote->get_by(array("status"=>"active","id_lote"=>$data['id_lote']));
						
						$cuerpo = $this->cuerpo_correo($data);
						
						
						$this->email
						    ->from('ventas@nyxvzla.com ', 'Nyx Cosmetics Venezuela  ')
						    ->to($arreglo['email'])
						    ->subject('Un Nuevo Estatus de tu Compra. ')
						    ->message($cuerpo)
						    ->set_mailtype('html');
						
						// send email
						$this->email->send();
					
					
					
					
					
					}
					
					
					function  cuerpo_correo($data){
					
				$status = $data['descripcion'];	
				$p1 = $data['id_lote'];
				
			        $this->load->model('model_status');
				$this->load->model('model_lote');
				$this->load->model('Model_compra');
				$this->load->model('Model_compra_detalle');
				
				$arreglo= $this->model_lote->get_by(array("status"=>"active","id_lote"=>$data['id_lote']));
			
			
				$compra = array($this->Model_compra_detalle->get_by(array("id_lote"=>$data['id_lote'])));
				
				$p2 = $arreglo['control'];
								
					
					
 	$url = "http://www.nyxvzla.com/site/systema/detalle.php?id=";
     
     //	$arreglo = json_decode($arreglo,true); 
    //	 $compra = json_decode($compra,true);
     					
					
 $text = '
    <html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

<br><div class="gmail_quote"><div><div dir="ltr"><div><br>

    	<div style="padding:70px 0px;width:100%;background-color:rgb(245,245,245)">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tbody><tr><td align="center" valign="top">
                		<img style="border:currentColor;min-height:auto;text-transform:capitalize;line-height:100%;font-size:14px;font-weight:bold;text-decoration:none;display:inline" alt="NYX Venezuela"><br>
                	<table style="border-radius:6px!important;border:1px solid rgb(220,220,220);background-color:rgb(253,253,253)" border="0" cellpadding="0" cellspacing="0" width="600">

                    <tbody>
                    <tr>
                    <td align="center" valign="top">
                                	
                    <table style="color:rgb(255,255,255);line-height:100%;font-family:Arial;font-weight:bold;vertical-align:middle;border-bottom-color:currentColor;border-bottom-width:0px;border-bottom-style:none;border-top-left-radius:6px!important;border-top-right-radius:6px!important;background-color:rgb(0,0,0)" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                    <tr>
                    <td>
                    <h1 style="padding:28px 24px;text-align:left;color:rgb(255,255,255);line-height:150%;font-family:Arial;font-size:30px;font-weight:bold;display:block">Estatus de Compra <br/>'. $status.'
                    </h1>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    
                    </td>
                    </tr>
                    <tr>
                    <td align="center" valign="top">

                    <table border="0" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                    <tr>
                    <td style="border-radius:6px!important;background-color:rgb(253,253,253)" valign="top">

                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                    <td valign="top">
                    <div style="text-align:left;color:rgb(51,51,51);line-height:150%;font-family:Arial;font-size:14px">


                    <h2 style="text-align:left;color:rgb(0,0,0);line-height:150%;font-family:Arial;font-size:30px;font-weight:bold;display:block">Factura: #'.$p1.'     Control: #'.$p2.'</h2>
                    
                    
                     <table style="border:1px solid rgb(238,238,238);width:100%" border="1" cellpadding="6" cellspacing="0">
                
                <thead>
                <tr>
                <th style="border:1px solid rgb(238,238,238);text-align:left" scope="col">Producto</th>
    			<th style="border:1px solid rgb(238,238,238);text-align:left" scope="col">Cantidad</th>
	       		<th style="border:1px solid rgb(238,238,238);text-align:left" scope="col">Precio</th>
		        </tr>

                </thead>

                

                <tbody>'; 
                
                                 
                    
	
     
  
     
    
  
     
     $text .= "<tbody>";
     
     
    
     
     foreach ($compra as  $clave){ 
     
     $text .= "<tr>"; 
     
     $text .= '<td style="border:1px solid rgb(238,238,238);text-align:left;vertical-align:middle">'.$clave['descripcion_producto'].'</td>';
     
     $text .= '<td style="border:1px solid rgb(238,238,238);text-align:left;vertical-align:middle">'.$clave['cantidad_producto'].'</td>';
     
     $text .= '<td style="border:1px solid rgb(238,238,238);text-align:left;vertical-align:middle"> <span>'.$clave['costo_producto'].'</span> </td>';
     
     $text .= "</tr>"; 
     }
   
     
    
    
     $text .='</tbody>
     
  
     
     
     <tfoot>
                <tr>
                <th style="border-width:4px 1px 1px;border-style:solid;border-color:rgb(238,238,238);text-align:left" colspan="2" scope="row">
                Subtotal del carrito
                </th>
                <td style="border-width:4px 1px 1px;border-style:solid;border-color:rgb(238,238,238);text-align:left">
                <span>'.$arreglo['monto_total'].'</span>
                </td>
                </tr>
                <tr>
                <th style="border:1px solid rgb(238,238,238);text-align:left" colspan="2" scope="row">
                Total del Pedido:
                </th>
				<td style="border:1px solid rgb(238,238,238);text-align:left">
                <span>'.$arreglo['monto_total'].'</span>
                </td>
				</tr>
                </tfoot>
     
     
     </table>




              
                <h3 style="text-align:left;color:rgb(0,0,0);line-height:150%;font-family:Arial;font-size:26px;font-weight:bold;display:block">
                Tus Datos
                </h3>

                
               <b>Nombre:</b> '.$arreglo['nombres'].'<br>

               <b>C.I:</b>  '.$arreglo['doc_identidad'].' <br>

	           <b>Email:</b> '.$arreglo['email'].'<br>
	           
               <b>Tel:</b> '.$arreglo['telefono'].'<br>
               
               <b>Datos Envio:</b> '.$arreglo['datos_env'].'<br>


<div style="background:rgb(249,249,249);padding:1em 1em 1.5em;border-bottom-color:rgb(221,221,221);border-bottom-width:1px;border-bottom-style:solid">


<b>¡Preparadas para Vivir la Experiencia
NYXVZLA!</b><br>

Para continuar con el Proceso debemos tomar en Cuenta las
siguientes Normas:<br>


1.- Las compras pasan por un proceso de Revisión de Pagos, el
mismo demora de 2 a 3 días
hábiles, dependiendo el banco de la tarjeta.<br>
2.- Los envíos se realizan de Lunes a Jueves, UNICAMENTE con la
empresa TEALCA. <br>
3.- Los envíos se realizan a una dirección especifica o una
agencia Tealca, la cual puedes
ubicar en <a style="color:rgb(0,0,0);font-weight:normal;text-decoration:underline" href="http://tealca.com/cobertura" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=http://tealca.com/cobertura&amp;source=gmail&amp;ust=1467943212210000&amp;usg=AFQjCNFs8QjtKk7UjZLqHysYH5-Ey25wcg">http://tealca.com/cobertura </a> <br>
4.- Todos los envíos son pagados en destino y son asegurados.<br>
5.- La empresa Tealca se hace responsable por algún daño del
paquete, siempre y cuando al
momento de recibirlo delante del personal Tealca valide lo que esta
dentro del mismo.
La empresa NYX VENEZUELA, no se hace responsable por daños no
reportados a la empresa
Tealca al momento de recibir el paquete.<br>
6.- Durante todo el Proceso la empresa NYX VENEZUELA, le estará
informando el Status de su
Compra.<br>

&nbsp;<br>';



$text.='<a style="background:black;padding:0.6em 0.8em;color:white;text-transform:uppercase;letter-spacing:1px;font-size:1em;font-weight:normal;text-decoration:none;display:inline-block"   href="'.$url.$p2.'" onClick="window.open('.$url.$p2.',"Detalle","resizable,height=600,width=1100,top=120,left=160,toolbar=no,scrollbars=yes,resizable=yes"); return false;" >Consulta el estatus de tu Compra</a>';




$text.='</div>
<b>¡Gracias por Preferirnos!</b><br>
Conoce los mejores tips de belleza y también entérate de nuestras
promociones y concursos...<br>
<ul style="padding:0px;list-style-type:none"><li style="display:inline-block"><a style="color:rgb(0,0,0);font-weight:normal;text-decoration:underline" href="https://twitter.com/NyxVzla" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=https://twitter.com/NyxVzla&amp;source=gmail&amp;ust=1467943212210000&amp;usg=AFQjCNHMfp7keFTsVqb-jjrfeVfr2lR6LQ"><img style="border:currentColor;min-height:auto;text-transform:capitalize;line-height:100%;font-size:14px;font-weight:bold;text-decoration:none;display:inline" height="auto" width="25"></a></li>
<li style="display:inline-block"><a style="color:rgb(0,0,0);font-weight:normal;text-decoration:underline" href="https://es-es.facebook.com/NYXVenezuela" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=https://es-es.facebook.com/NYXVenezuela&amp;source=gmail&amp;ust=1467943212210000&amp;usg=AFQjCNH8Fx0g_alLpw5TEVmS7sy7yFIlpw"><img style="border:currentColor;min-height:auto;text-transform:capitalize;line-height:100%;font-size:14px;font-weight:bold;text-decoration:none;display:inline" height="auto" width="25"></a></li>
<li style="display:inline-block"><a style="color:rgb(0,0,0);font-weight:normal;text-decoration:underline" href="http://instagram.com/nyxvzla" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=http://instagram.com/nyxvzla&amp;source=gmail&amp;ust=1467943212210000&amp;usg=AFQjCNHFrMfzuvuQHao9VRE53TMdD5UlqQ"><img style="border:currentColor;min-height:auto;text-transform:capitalize;line-height:100%;font-size:14px;font-weight:bold;text-decoration:none;display:inline" height="auto" width="25"></a></li>
</ul></div>
</td>
</tr></tbody></table></td>
</tr></tbody></table></td>
</tr><tr></tr></tbody></table></td>
                                        </tr></tbody></table>

                                	<table style="border-top-color:currentColor;border-top-width:0px;border-top-style:none" border="0" cellpadding="10" cellspacing="0" width="600"><tbody><tr><td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"><tbody><tr><td style="border:0px currentColor;text-align:center;color:rgb(102,102,102);line-height:125%;font-family:Arial;font-size:12px" colspan="2" valign="middle">

	<a href="http://nyxvzla.com" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=http://nyxvzla.com&amp;source=gmail&amp;ust=1467943212210000&amp;usg=AFQjCNHEp-B6--VhqtLx9A6odoi0m1BUYA">nyxvzla.com</a><br>
                                                        </td>
                                                    </tr></tbody></table></td>
                                        </tr></tbody></table>
                            </div></div> 		 	   		  <p></p></div></div>
</div><br><br clear="all"><br>-- <br><div class="gmail_signature" data-smartmail="gmail_signature">.<br></div>';		
					
					
					return  $text;
					
					}



} 