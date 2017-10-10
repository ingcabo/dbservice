<?php

Class User Extends CI_Controller {


public function __construcct(){

  parent::__construcct();
  $this->load->model('user_model');

}

public function index(){

$data['include'] = 'usr/index';
$this->load->view('home',$data);

}
 
		public function add(){

		$postdata= file_get_contents("php://input");
		$request = json_decode($postdata);
		$name = $request->name;
		$city = $request->city;
		$id = $this->usr_model->AddUser($name,$city);

					If($id){
						echo $result = '{"status" : "success"}';
					}else{
						echo $result = '{"status" : "failure"}';
					}

		 }


}
?>
