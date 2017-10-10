<?php


			

			function date_today(){

			 $cd =& get_instance();
   			 $cd->load->helper('date');	

			date_default_timezone_set("America/New_York");	
			$datestring = "%Y-%m-%d %H:%i:%s";
			$time = time();
			$date = date("h%i%s");
			$fecha= mdate($datestring, $time);	

				return $fecha;
			};



			function insrt_wp_posts($control){

// Get a reference to the controller object
  $CI = get_instance();

// You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Model_wpposts');

					

				$arg_wp_posts = array(
				"post_author" 			=>1,
				"post_date" 			=>date_today(),
				"post_date_gmt"			=>date_today(),
				"post_content" 			=>"",
				"post_title"   			=>"",
				"post_excerpt" 			=>"",
				"post_status"  			=>"publish",
				"comment_status" 		=>"open",
				"ping_status"   		=>"closed",
				"post_password" 		=>"",
				"post_name"     		=>"",
				"to_ping"       		=>$control,
				"pinged"        		=>"",
				"post_modified" 		=>date_today(),
				"post_modified_gmt"		=>"",
				"post_content_filtered" =>"",
				"post_parent"    		=>0,
				"guid"          		=>"",
				"menu_order"    		=>0,
				"post_type"				=>"shop_order",
				"post_mime_type" 		=>"",
				"comment_count"  		=>3
				);//retorna id compra


			$insert = $CI->Model_wpposts->insert($arg_wp_posts);


			return $insert;

			}

			function insrt_wp_postmeta($control,$idwoo){

				// Get a reference to the controller object
 				$Cp = get_instance();

				// You may need to load the model if it hasn't been pre-loaded
  				$Cp->load->model('Model_wppostmeta');


				// Get a reference to the controller object
				$CI = get_instance();

				// You may need to load the model if it hasn't been pre-loaded
				$CI->load->model('Model_lote');

				
				// Get a reference to the controller object
 				$Cs = get_instance();

				// You may need to load the model if it hasn't been pre-loaded
  				$Cs->load->model('Model_status');


				$query_status= $CI->Model_status->get_by(array("control"=>$control));
				if ($query_status['estado'] == "A"){
					$estado= "Aprobado";
				}else{
					$estado="Rechazado";
				}

				$query_lote= $CI->Model_lote->get_by(array("control"=>$control));
				

				$arg_wp_postmeta= array(

			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_billing_first_name",
				"meta_value"=>$query_lote['nombres']
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_billing_email",
				"meta_value"=>$query_lote['email']
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_billing_phone",
				"meta_value"=>$query_lote['telefono']
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_payment_method",
				"meta_value"=>'TDC -'.$estado.'  #Control '.$control
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_payment_method_title",
				"meta_value"=>"TDC"
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_order_total",
				"meta_value"=>$query_lote['monto_total']   
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_order_currency",
				"meta_value"=>"VEF"
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_completed_date",
				"meta_value"=>date_today()
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_recorded_sales",
				"meta_value"=>"yes"
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_billing_address_1",
				"meta_value"=>$query_lote['datos_env'] 
				),
			array(
				"post_id"=>$idwoo,
				"meta_key"=>"_shipping_address_1",
				"meta_value"=>$query_lote['datos_env'] 
				)
		);

				
				$insert = $Cp->Model_wppostmeta->insert_many_desa($arg_wp_postmeta);

					return $insert;
			}



			function insrt_wp_woocommerce_order_items($control,$idwoo){

				$arg_wp_order_items = array(
					"order_item_name" => "",
					"order_item_type" =>"line_item",
					"order_id"        => $idwoo

				);


				
				$CI = get_instance();
				$CI->load->model('Model_compra_vista_p');

				$CO = get_instance();
				$CO->load->model('Model_wporderitems');

				$CT = get_instance();
				$CT->load->model('Model_wporderitemmeta');






				$query_compra = $CI->Model_compra_vista_p->get_many_by(array("control"=>$control));

				$coun = count($query_compra);
			
			foreach ($query_compra as $name => $value) {
		  
				$arg_wp_order_items['order_item_name'] = $value['id_producto']." - ".$value['descripcion_producto'];
			
				$insert = $CI->Model_wporderitems->insert($arg_wp_order_items);


				$arg_wp_woocommerce_order_itemmeta = array(

				array(	"order_item_id" =>$insert,
						"meta_key"=>"_qty",
						"meta_value" =>$value['cantidad_producto']
					),
				array(	"order_item_id" =>$insert,
						"meta_key"=>"_product_id",
						"meta_value" =>$value['id_producto']
					),
				array(	"order_item_id" =>$insert,
						"meta_key"=>"_variation_id",
						"meta_value" =>$value['variation_id']
					),
				array(	"order_item_id" =>$insert,
						"meta_key"=>"_line_subtotal",
						"meta_value" =>$value['costo_producto']
					),
				array(	"order_item_id" =>$insert,
						"meta_key"=>"_line_total",
						"meta_value" =>$value['costo_producto']
					),
				
				array(	"order_item_id" =>$insert,
						"meta_key"=>"tono",
						"meta_value" =>$value['tono']
					),

				array(	"order_item_id" =>$insert,
						"meta_key"=>"_tax_class",
						"meta_value" =>""
					),
				


	);	
				$insert = $CT->Model_wporderitemmeta->insert_many_desa($arg_wp_woocommerce_order_itemmeta);

				
			}	

		

			return $query_compra;


			}





?>