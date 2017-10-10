<?php

class Model_products extends My_model{

  protected $_table = 'Products';
  protected $primary_key = 'id';
  protected $return_type = 'array';
  
  protected $after_get = array('remove_sensite_data');
  protected $before_create = array('prep_data');
  protected $before_update = array('update_timestamp');

  protected function remove_sensite_data($arg){
    unset($arg['id']);
    unset($arg['activo']);
    unset($arg['create_timestamp']);
    unset($arg['update_timestamp']);
    return $arg;
  }

  protected function prep_data($arg){
    //$arg['ip_address']        =  $this->input->ip_address();
    $arg['create_timestamp']  = date('Y-m-d H:i:s');
    return $arg;
  }

  protected function update_timestamp($arg){
    $arg['update_timestamp'] = date('Y-m-d H:i:s');
    return $arg;
  }

}

?>
