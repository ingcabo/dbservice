<?php

//debemos colocar esta línea para extender de REST_Controller
require APPPATH.'/libraries/REST_Controller.php';



class Myrest extends REST_Controller
{

function __construct(){
parent:: __construct();
$this->load->helper('my_api_helper');
$this->load->helper('file');
$this->load->config('rest');
$this->load->helper('date');


} 





			public function move_post(){
			$this->load->model('Myrest_model');	

			
			//se simula la entrada de los parametros
		/*************************para leer desde archivo entradaSQR_json.json******************************************************/

			//			$entrada =  file_get_contents('http://127.0.0.1/apiRestCodeigniter/application/controllers/entredaSQR_JSON.json');
			//			$entrada = json_decode($entrada);
			
		/*******************************************************************************/
						//EJEMPLO DE PARAMETROS    //EJEMPLO DE PARAMETROS    //EJEMPLO DE PARAMETROS
											/*
											{
												"varios": [{
													
													"param_9" : "05/04/2016",
													"param_10": "1"
												}],

												"primeros": {
													"param_1"   : "txt",
													"param_1_2" : "fed", 
													"param_2"   : "fed",
													"param_3"   : "cc_arfed",
													"param_5"   : "8004",
													"param_6"   : "SYBCOB_DES",
													"param_7"   : "3046",
													"param_8"   : "1",
													"param_r"	: "C:/programas/ctacte/batch"

												}
											}


											*/

/************************************para leer desde formulario cliente***************************************/
					//leemos la cabecera de la peticion
					$headers = apache_request_headers();
					$metodo_data= array();
					foreach ($headers as $header => $value) {
    				$metodo_data[$header] =  $value;
 			
					}
					//decodificamos metodo json a un array php es entrada
					$entrada  = $metodo_data['sqr'];
					$entrada  = json_decode($entrada);	

/******************************************************************************/


		/*separamos los arrays de primeros parametros y varios parametros*/
			$varios   = $entrada->varios;
			$primeros = $entrada->primeros;
		
			
			
		
			/*consultamos la tabla parametros*/
			$datos = $this->Myrest_model->get_many_by(array("status"=> "active"));

			/*los indices pertenecen a los id de la tabla parametros iniciando el primer registro en cero y el ultimo id en id-1*/
			$url_origen    =$datos[0]['url']; //ruta origen de los archivos a mover si es necesario
			$url_destino   =$datos[1]['url']; // ruta destino dodne se moveran los archivos
			$extension   =  $datos[2]['url']; //extension a buscar en los archivos en ruta origen
			//usuario contraseña
			$usuario     =$datos[3]['url'];  //usuario
			$clave       =$datos[4]['url'];  //contraseña



			//extension buscada
			$buscados = strtolower(($primeros->param_1));
			//separo la ruta final para enviarla como parametro a la funcion que realizara el string SQR
			$ruta = strtolower(($primeros->param_r));





					
					// buscados es param_1 si es diferente x no se moveran archivos 
					if ($buscados !== "x"){
					//ubicamos la longitud de la extension a renombrada	
					$long_bus = strlen(trim ($primeros->param_1_2)); 
					//todo minuscula para cmoprar sin tener la complicacion de minusculas y mayusculas
					$primer   = strtolower(($primeros->param_1_2)); 
					//declaramos la nueva extension
					$new_ext  = strtolower(($primeros->param_2));
					}

					//obtengo un listado de archivos de  la ruta origen
					$archivos = get_filenames($url_origen);
				
					
					
					$data= array();
					$i = 0;
					//recorremos la carpeta origen
					foreach ($archivos as $archivo => $value) {
    				
    					//value es el mobre del archivo de la carpeta origen
    					$value = strtolower($value);
    					//su extension
 						$ext = pathinfo($url_origen.$value, PATHINFO_EXTENSION);
 						//lo pasamos a minuscula para cmoparar mejor
 						$ext = strtolower($ext);//extension de los archivos
 						
 						//$buscar_primeros = $primeros->param_1_2;
 						if ($buscados !== "x"){
 						$primeros = mb_substr($value, 0, $long_bus, 'utf-8');
 						}else{ 
 					 	$primeros="";
 					 	}
 					 	//	
 					 	//	$buscados !== "x" 
 						  //aca buscamos las extensiones y el inicio del nombre de archivo
 					if(file_exists($url_origen.$value)){	
		 				  if ($buscados !== "x" && strpos($buscados, $ext) !== false && $primeros === $primer){
		 						//separamos la extesion del nombre del archivo
		 						$partirCadena  = explode(".", $value);
		 						$new_file = $partirCadena[0].".".$new_ext; //concatenamos la nueva extension de archivos

		 					if (rename($url_origen.$value, $url_destino.$new_file)){ //movemos loS ARCHIVOS Y renombranos su extension

		 					

		 						$data[$i]['antiguo_archivo'] = $url_origen.$value;
		 						$data[$i]['nuevo_archivo']   = $url_destino.$new_file;
		 						


		 					}// si se mueven

		 				}//si es la extension buscada	

		 			}// si el archivo existe	

					$i = $i++;		
					
				}//fin foreach

				if (empty($data)) //data es un array y el equivalente de inpunt.file
				{


					$status= "No fue necesario mover archivos";	   


				}else{


					$status = "Se movieron archivos";


					
	}

	//aca le pasamos los parametros necesarios para crear el string del comando sqr
	$comando = $this->comando_sqr($entrada,$usuario,$clave,$ruta);
		
$this->response(array($this->config->item('rest_status_field_name') => $this->config->item('bien'), $this->config->item('rest_message_field_name')  => "comando ejecutado  ". $status, $this->config->item('data') => $this->config->item('dataT')),200);




	

}




			public function comando_sqr($entrada,$usuario,$clave,$ruta){

			
			/*aca calculamos la fecha actual en el formato requerido*/	
			date_default_timezone_set("America/New_York");	
			$datestring = "%m%d%Y_%H%i%s";
			$time = time();
			$date = date("h%i%s");
			$fecha= mdate($datestring, $time);	
			/*aca calculamos la fecha actual en el formato requerido*/

			/*objetos y arreglos de los parametros*/
			$varios = $entrada->varios;
			$primeros = $entrada->primeros;
			/*objetos y arreglos de los parametros*/


			/*recorremos varios que son los ultimos parametros*/
			$param_x ='';
		
			foreach($varios[0] as $value) {
                    
           /*concatenamos*/
            $param_x =  $param_x . ' ' .trim ($value);
          	/*concatenamos*/

          }
		/*recorremos varios que son los ultimos parametros*/	
		$datos = $this->Myrest_model->get_many_by(array("status"=> "active"));
			
		$rutaC    =$datos[7]['url'];


		/*asignamos valores*/
          $param_3 = $primeros->param_3;
          $param_5 = $primeros->param_5;
          $param_6 = $primeros->param_6;
          $param_7 = $primeros->param_7;
          $param_8 = $primeros->param_8;
          $string_user= $usuario.'/'.$clave; //usario contraseña
          $file_name = $param_3.'_'.$fecha.'.lis'; // nombre del archivo resultante
          $file_name_log = $param_3.'_'.$fecha.'.log'; // nombre del log
          $file_name_comando = $param_3.'_'.$fecha.'.txt'; // es parte del log, no es necesario para el string sqr
          $comando = 'sqr '; // inicio de la declaracion del comando
		  $comando = trim($comando);
          /*asignamos valores*/
		


		/*alimentamos al esqueleto del comando en este punto solo es nu string */
			
		$sqr_string = $comando.' '.$param_3.'.sqt '.$string_user.' -XCB -XMB -RT -V'.$param_6.' '.$param_5.' '.$param_7.' '.$param_8.' 1 S L -F'.$file_name.$param_x;

		/*alimentamos al esqueleto del comando en este punto solo es nu string  */

			/*definimos las rutas*/	
			 $ruta_field = str_replace('/',trim('\ '), $ruta.'\objetos\ ');
			 $ruta_final = str_replace('/',trim('\ '), $ruta.'\listados\ ');
			 /*definimos las rutas*/


			 /*string para movernos a la ruta de ejecucion del comando en Shell*/
			 $ruta = mb_substr($ruta_field,0,2).' & cd '.$ruta_field. ' & ';
			/*string para movernos a la ruta de ejecucion del comando en Shell*/
			
			
			/*en datos estara la cadena completa del comando al shell, concatenamos la ruta en la cual debemos ejecutar el sqr con el string sqr*/
			$datos = $ruta.$sqr_string;
			/*en datos estara la cadena completa del comando al shell*/

		

			/*aca si ejecutamos el comanmdp*/
	        $datos = shell_exec($datos);
	        /*aca si ejecutamos el comanmdp*/


			
	        /*espero 5 segundos*/
			sleep(5); 		



			/*cambio el sentido de las barras de directorio de archivo para buscarlo*/
			$file_lis=  str_replace(trim("\ "),"/",trim($ruta_field).trim($file_name));
			
			//movemos el archivo resultante lo movemos y lo copiamos
			if (file_exists($file_lis)){
			copy(trim($ruta_field).$file_name, $rutaC.$file_name);	
  		    rename(trim($ruta_field).$file_name, trim($ruta_final).$file_name);
  			}

			sleep(5); 
			// movemos el log que siempre se generara
		   	rename(trim($ruta_field).'sqr.log', trim($ruta_final).$file_name_log);
   			/*muevo los resultante y el log*/
  

   			/*el resultado del comando sqr solo me sirve para esperar tiempo y asi mostrar cuando termine por que en realidad da resultado null en cualquier caso*/
			 return $datos;
			 /*el resultado del comando sqr solo me sirve para esperar tiempo y asi mostrar cuando termine por que en realidad da resultado null en cualquier caso*/

			}



/*

	param_1:  nombre de los archivos que copiará del directorio compartido. Se usa una “X” en caso que no se requiera copiar archivos.
•	param_2: extensión que se le colocará a los archivos antes de ser procesados por el SQR
•	param_3: nombre del programa SQR a ejecutar
    param_5: sarta a la que pertenece (obtenida de la base de datos)
•	param_6: servidor donde se ejecuta el SQR
•	param_7: código del batch 
•	param_8: posición del batch en la sarta
•	param_9, param_10, param_11, param_12, param_13, param_14, param_15: parámetros para la ejecución del SQR.

*/

}


