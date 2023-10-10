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

}
