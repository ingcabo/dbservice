<?php 

class Model_lote extends My_model{


//Model_usr


protected $_table = 'lote_compra';
protected $primary_key = 'id_lote';
protected $return_type = 'array';

protected $after_get = array('remove_sensite_data');
protected $before_create = array('prep_data');
protected $before_update = array('update_timestamp');


protected function remove_sensite_data($lote){

				//	unset($student['password']);
					unset($lote['ip_addresss']);
					
					
					return($lote);
					
}

protected function prep_data($lote){

//$student['password']         =  md5($student['password']);
$lote['ip_address']       =  $this->input->ip_address();
$lote['create_timestamp'] = date('Y-m-d H:i:s');




return $lote;
}




protected function update_timestamp($lote){

$lote['update_timestamp'] = date('Y-m-d H:i:s');

return $lote;
}


	







}

?>