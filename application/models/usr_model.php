<?php

 Class Usr_Model extends CI_Model{


public function __Construct(){

	parent::__Construct();


}


		public function AddUser($name,$city){

		$data = array('name'=>$name,'city'=>$city);
		$this->db->insert('user',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;

		}
 

 
 
 } 

?>