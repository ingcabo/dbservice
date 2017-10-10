<?php 

class Model_students extends My_model{


//Model_usr


protected $_table = 'students';
protected $primary_key = 'student_id';
protected $return_type = 'array';

protected $after_get = array('remove_sensite_data');
protected $before_create = array('prep_data');
protected $before_update = array('update_timestamp');


protected function remove_sensite_data($student){

					unset($student['password']);
					unset($student['ip_addresss']);
					
					
					return($student);
					
}

protected function prep_data($student){

$student['password']         =  md5($student['password']);
$student['ip_address']       =  $this->input->ip_address();
$student['create_timestamp'] = date('Y-m-d H:i:s');




return $student;
}




protected function update_timestamp($student){

$student['update_timestamp'] = date('Y-m-d H:i:s');

return $student;
}


	







}

?>