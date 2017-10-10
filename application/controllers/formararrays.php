<?php

$arg_wp_posts = array(
	"post_author" 			=>1,
	"post_date" 			=>"2016-08-16 15:07:09",
	"post_date_gmt"			=>"",
	"post_content" 			=>"",
	"post_title"   			=>"",
	"post_excerpt" 			=>"",
	"post_status"  			=>"publish",
	"comment_status" 		=>"open",
	"ping_status"   		=>"closed",
	"post_password" 		=>"",
	"post_name"     		=>"",
	"to_ping"       		=>"",
	"pinged"        		=>"",
	"post_modified" 		=>"2016-08-16 15:07:18",
	"post_modified_gmt"		=>"",
	"post_content_filtered" =>"",
	"post_parent"    		=>0,
	"guid"          		=>"",
	"menu_order"    		=>0,
	"post_type"				=>"shop_order",
	"post_mime_type" 		=>"",
	"comment_count"  		=>3
	);//retorna id compra




	$arg_wp_postmeta= array(

			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_billing_first_name",
				"meta_value"=>"Adriana"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_billing_email",
				"meta_value"=>"abdc@gmail.com"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_billing_phone",
				"meta_value"=>"04167555555"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_payment_method",
				"meta_value"=>"TDC - aprobada - control #7777777555555"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_payment_method_title",
				"meta_value"=>"TDC"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_order_total",
				"meta_value"=>"21250"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_order_currency",
				"meta_value"=>"VEF"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_completed_date",
				"meta_value"=>"2016-08-16 15:07:15"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_recorded_sales",
				"meta_value"=>"yes"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_billing_address_1",
				"meta_value"=>"Calle carabobo av 28"
				),
			array(
				"post_id"=>"idcompra",
				"meta_key"=>"_shipping_address_1",
				"meta_value"=>"Calle carabobo av 29"
				)
		);



	$arg_wp_woocommerce_order_items = array(
					"order_item_name" => "Matte Lipstick",
					"order_item_type" =>"line_item",
					"order_id"        => 6068

		);//retorna id producto order_item_id




$arg_wp_woocommerce_order_itemmeta = array(

				array(	"order_item_id" =>8971,
						"meta_key"=>"_qty",
						"meta_value" =>2
					)
				array(	"order_item_id" =>8971,
						"meta_key"=>"_product_id",
						"meta_value" =>"763"
					)
				array(	"order_item_id" =>8971,
						"meta_key"=>"_variation_id",
						"meta_value" =>"764"
					)
				array(	"order_item_id" =>8971,
						"meta_key"=>"_line_subtotal",
						"meta_value" =>"23000"
					)
				array(	"order_item_id" =>8971,
						"meta_key"=>"tono",
						"meta_value" =>"NUDE (MLS01)"
					)


	);





 			date_default_timezone_set("America/New_York");	
			$datestring = "%Y%m%d %H%i%s";
			$time = time();
			$date = date("h%i%s");
			$fecha= mdate($datestring, $time);	




?>

