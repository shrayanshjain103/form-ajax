<?php
 class Register_model extends CI_Model{

    function insert_data($data){
        if($this->db->insert('users',$data)){
            return $data;
        }
        else{
            echo $this->db->error()['message'];
            return false;
        }

    }
    public function checkLogin($email, $password){
      $query=$this->db->get_where("users",array('email'=>$email,'password'=>$password));
      if($query->num_rows()>0){
        return true;
      }else{
         return false;
      }
    }
    public function get_all_users(){
      $query=$this->db->get('users');
      return $query->result_array();
    }
    // function getQuestionBank(){
 
    //   $response = array();
   
    //   // Select record
    //   $this->db->select('question','option_1','option_2','option_3','option_4','answer');
    //   $q = $this->db->get('course_question_bank_master');
    //   $response = $q->result_array();
   
    //   return $response;
    // }
 }
?>