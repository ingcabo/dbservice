<?php 

class Model_compra extends My_model{


//Model_usr


protected $_table = 'compra_nyx';
protected $primary_key = 'id';
protected $return_type = 'array';

protected $after_get = array('remove_sensite_data');
protected $before_create = array('prep_data');
protected $before_update = array('update_timestamp');


protected function remove_sensite_data($compra){

				//	unset($student['password']);
					unset($compra['ip_addresss']);
					
					
					return($compra);
					
}


protected function prep_data($compra){

//$student['password']         =  md5($student['password']);
$compra['ip_address']       =  $this->input->ip_address();
$compra['create_timestamp'] = date('Y-m-d H:i:s');




return $compra;
}




protected function update_timestamp($compra){

$compra['update_timestamp'] = date('Y-m-d H:i:s');

return $compra;
}


	







}

?>