<?php if (!defined('BASEPATH')) exit('No direct script access allowed');






					$config = array( 
					
				
					
				


					'lote_put'	=> array(
					array('field' => 'monto_total','lebel' => 'Monto Total', 'rules' => 'trim|max_length[15]'),	
					array('field' => 'nombres','lebel' => 'Nombres', 'rules' => 'trim|max_length[50]'),	
					array('field' => 'email','lebel' => 'Email', 'rules' => 'trim|valid_email'),
					array('field' => 'telefono','lebel' => 'Email', 'rules' => 'trim|max_length[50]'),
					array('field' => 'doc_identidad','lebel' => 'Documento Identidad', 'rules' => 'trim|max_length[15]'),
					array('field' => 'datos_env','lebel' => 'Datos envio', 'rules' => 'trim|max_length[500]')		

						),

					'lote_post'	=> array(
					array('field' => 'nombres','lebel' => 'Nombres', 'rules' => 'trim|max_length[50]'),	
					array('field' => 'email','lebel' => 'Email', 'rules' => 'trim|valid_email'),
					array('field' => 'telefono','lebel' => 'Email', 'rules' => 'trim|max_length[50]'),
					array('field' => 'doc_identidad','lebel' => 'Documento Identidad', 'rules' => 'trim|max_length[15]'),
					array('field' => 'datos_env','lebel' => 'Datos envio', 'rules' => 'trim|max_length[500]')
						),


						'compra_put'	=> array(
					array('field' => 'id_producto','lebel' => 'id producto', 'rules' => 'trim|max_length[10]'),	
					array('field' => 'descripcion_producto','lebel' => 'descripcion producto', 'rules' => 'trim|max_length[120]'),	
					array('field' => 'cantidad_producto','lebel' => 'cantidad producto', 'rules' => 'trim|max_length[11]'),
					array('field' => 'conto_producto','lebel' => 'costo producto', 'rules' => 'trim|max_length[10]'),
					array('field' => 'total_lote','lebel' => 'total lote', 'rules' => 'trim|max_length[15]'),
					array('field' => 'id_lote','lebel' => 'id lote', 'rules' => 'trim|max_length[11]')
						),
		
						'statusLote_put' => array(
					array('field' => 'id_lote','lebel' => 'id lote', 'rules' => 'trim|max_length[11]'),		
					array('field' => 'total_lote','lebel' => 'total lote', 'rules' => 'trim|max_length[15]'),
					array('field' => 'respuesta','lebel' => 'respuesta', 'rules' => 'trim|max_length[20]'),
					array('field' => 'tipo_mesaje','lebel' => 'tipo mensaje', 'rules' => 'trim|max_length[20]'),


						),

						'statusLote_post' => array(
					array('field' => 'id_lote','lebel' => 'id lote', 'rules' => 'trim|max_length[11]'),			
					array('field' => 'total_lote','lebel' => 'total lote', 'rules' => 'trim|max_length[15]'),
					array('field' => 'respuesta','lebel' => 'respuesta', 'rules' => 'trim|max_length[20]'),
					array('field' => 'tipo_mesaje','lebel' => 'tipo mensaje', 'rules' => 'trim|max_length[20]'),


						),
					'status_put' => array(
					array('field' => 'control','lebel' => 'control', 'rules' => 'trim|max_length[50]'),		
					array('field' => 'cod_afiliacion','lebel' => 'cod_afiliacion', 'trim|max_length[50]'),
					array('field' => 'factura','lebel' => 'factura', 'rules' => 'trim|max_length[50]'),
					array('field' => 'monto','lebel' => 'monto', 'rules' => 'trim|max_length[50]'),
					array('field' => 'estado','lebel' => 'estado', 'rules' => 'trim|max_length[5]'),		
					array('field' => 'codigo','lebel' => 'codigo', 'trim|max_length[5]'),
					array('field' => 'descripcion','lebel' => 'descripcion', 'rules' => 'trim|max_length[50]'),
					array('field' => 'vtid','lebel' => 'vtid', 'rules' => 'trim|max_length[50]'),
					array('field' => 'seqnum','lebel' => 'seqnum', 'rules' => 'trim|max_length[50]'),
					array('field' => 'authid','lebel' => 'authid', 'rules' => 'trim|max_length[50]'),
					array('field' => 'authname','lebel' => 'authname', 'rules' => 'trim|max_length[50]'),		
					array('field' => 'tarjeta','lebel' => 'tarjeta', 'trim|max_length[50]'),
					array('field' => 'referencia','lebel' => 'referencia', 'rules' => 'trim|max_length[50]'),
					array('field' => 'terminal','lebel' => 'terminal', 'rules' => 'trim|max_length[50]'),
					array('field' => 'lote','lebel' => 'lote', 'rules' => 'trim|max_length[50]'),		
					array('field' => 'rifbanco','lebel' => 'rifbanco', 'trim|max_length[50]'),
					array('field' => 'afiliacion','lebel' => 'afiliacion', 'rules' => 'trim|max_length[50]'),
					array('field' => 'voucher','lebel' => 'voucher', 'rules' => 'trim'),

						)
			
						  
						  
						  
						);
						
					
					
								

				

?>