<?php
 class Crud_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

       public function getUserData(){
        return $this->db->get('users')->result_array();
    }

    public function deleteUser($id){
        $this->db->where('id', $id);
       $data = $this->db->delete("users");
      
        return $data;

      
    }
 }
?>