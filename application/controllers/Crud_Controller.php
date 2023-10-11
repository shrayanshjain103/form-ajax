<?php
class crud_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Crud_model');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->library('session');
            //$this->load->model('getQuestionBank');
        }
    }
    public function getUsers(){

       $users=$this->Crud_model->getUserData();
       $data['data']= $users;

       echo json_encode($data);
    }
   public function deleteData(){
   // print_r($_POST);die;
    $id=$_POST['id'];
    $response=$this->Crud_model->deleteUser($id);
    if($response == 1){
      echo 1;
    }
    else{
        echo 2;
    }
   }
   public function updateInfo(){
    $id=$_POST['id'];
   // print_r($id);
    $data=$this->db->get_where('users', ['id'=> $id])->row_array();
   // print_r($data);die;
    echo json_encode($data);
   }
   public function infoChange(){
    $id = $_POST['id'];
    $data = array(
      'user_name' => $_POST['name'],
      'email' => $_POST['email']
    );
    $this->db->where('id',$id);
    $update =$this->db->update('users',$data);
    if($update){
        echo 1;
    }
    else{
        echo 0;
    }
   }
   

}
