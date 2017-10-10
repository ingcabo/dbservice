<?php
defined("BASEPATH") or die("El acceso al script no está permitido");
 
class Blog_model extends CI_Model
{
public function __construct()
{
parent::__construct();
}


/**
* @desc logueamos a los usuarios
* @param username - string
* @param password - string
* @param auth - string login o register
*/
public function authUser($username,$password,$auth)
{
if($auth === "login")
{
$query = $this->db->get_where('users', array('username' => $username, 'password' => $password));
 
if($query->num_rows() === 1)
        {
            return $query->row()->id;
        }
        else
        {
            return false;
        }
}
else
{
$data = array(
"username"	=>	$username,
"password"	=>	$password
);
 
$query = $this->db->insert('users',$data);
 
if($query)
{
            return true;
        }
        else
        {
            return false;
        }
}
    }


}

?>