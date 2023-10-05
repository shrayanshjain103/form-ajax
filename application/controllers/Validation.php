<?php

class Validation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('register_model');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->library('session');
            //$this->load->model('getQuestionBank');
        }
    }

    public function ajax_process_registration()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == false) {
                $this->load->view('registration');
            } else {
                $data = array(
                    'user_name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password')

                );

                $return = $this->register_model->insert_data($data);

                if ($return == true) {
                    echo json_encode(array('status' => 'true'));
                    die;
                } else {
                    echo json_encode(array('status' => 'false'));
                }
            }
        }
    }
    public function process_registration()
    {
        $this->load->view('registration');
    }
    public function login()
    {
        // $this->load->view('login');
        if ($this->session->userdata('userdata')) {
            redirect('Validation/dashboard');
        } else {
            $this->load->view('login');
        }
    }

    public function ajax_login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $result = $this->register_model->checkLogin($email, $password);
            if ($result) {
                $user_data = $this->db->get_where('users', ['email' => $email])->row_array();
                // print_r($user_data);die;
                $this->session->set_userdata('userdata', $user_data);
                $response = array('status' => 'true');
            } else {
                $response = array('status' => 'false');
            }
            echo json_encode($response);
        }
    }

    public function dashboard()
    {
        $user_data = $this->session->userdata('userdata');
        if (!$user_data) {
            $this->login();
        } else {
            $user_status = $user_data['status'];
            if ($user_status == 1) {
                $this->load->view('welcome_login');
            } else {

                $this->load->view('student_view');
            }
        }
    }
    public function get_subjects()
    {
        $data = $this->db->get('course_subject_master')->result_array();
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo "0";
        }
    }
    public function get_table_data()
    {
        $data = $this->register_model->get_all_users();
        echo json_encode($data);
    }
    public function logout()
    {
        $this->session->unset_userdata('userdata');
        $this->session->sess_destroy();
        $this->login();
    }
    public function getTopics()
    {
        $selectedOption = $this->input->post('selected_option'); // Get selected value from the first dropdown
        $this->db->select('cstm.*');
        $this->db->where('cstm.subject_id', $selectedOption);
        $data = $this->db->get('course_subject_topic_master as cstm')->result_array();
        echo json_encode($data); // Return topics as JSON
    }

    //Used to fetch the data and represent on the screen 
    public function getQuestions()
    {
        $sub = $this->input->post('subject_id');
        $top = $this->input->post('topic_id');
        $this->db->select([
            'question',
            'option_1 as opt1', '1 AS option_order',
            'option_2 as opt2', '2 AS option_order',
            'option_3 as opt3', '3 AS option_order',
            'option_4 as opt4', '4 AS option_order',
            'answer'
        ]);
        $data = $this->db->get_where('course_question_bank_master', ['subject_id' => $sub, 'topic_id' => $top])->result_array();
        echo json_encode($data);
    }


    // Function to download the CSV file
    public function getCSV($top,$sub)
    {
        $this->db->select('question, option_1, option_2, option_3, option_4, answer');
        $q = $this->db->get_where('course_question_bank_master', ['subject_id' =>$sub , 'topic_id' =>$top]);
        $usersData = $q->result_array();

        // Check if there are records to export
        if (empty($usersData)) {
            die('No records found.');
        }

        // Set headers for CSV download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=questions.csv");
        header("Content-Type: text/csv");


        // Create a file pointer connected to the output stream
        $output = fopen("php://output", "w");

        // put the data in csv file in proper format means hindi ko hindi or english me rakhega 
        fputs($output, "\xEF\xBB\xBF"); 

        // Output the CSV column headers
        fputcsv($output, array('Question', 'Option_1', 'Option_2', 'Option_3', 'Option_4', 'Answer'));

        // Output each row of data
        // foreach ($usersData as $row) {
        //     fputcsv($output, $row);
        // }
        foreach ($usersData as $line) {
                        $nestedDataCSV = array();
                        $nestedDataCSV[] = strip_tags($line['question']);
                        $nestedDataCSV[] = strip_tags($line['option_1']);
                        $nestedDataCSV[] = strip_tags($line['option_2']);
                        $nestedDataCSV[] = strip_tags($line['option_3']);
                        $nestedDataCSV[] = strip_tags($line['option_4']);
                        $nestedDataCSV[] = strip_tags($line['answer']);
                        fputcsv($output, $nestedDataCSV);
                    }
        // Close the file pointer
        fclose($output);

        exit;
    }
    public function getDocument($top,$sub){
       
        $this->db->select('question, option_1, option_2, option_3, option_4, answer');
        $q = $this->db->get_where('course_question_bank_master', ['subject_id' =>$sub , 'topic_id' =>$top]);
        $usersData = $q->result_array();

        // Check if there are records to export
        if (empty($usersData)) {
            die('No records found.');
        }

        // Set headers for CSV download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=questions.doc");
        header("Content-Type: application/vnd.ms-word");


        // Create a file pointer connected to the output stream
        $output = fopen("php://output", "w");

        // put the data in csv file in proper format means hindi ko hindi or english me rakhega 
        fputs($output, "\xEF\xBB\xBF"); 

        // Output the CSV column headers
        //    $header=array('Question', 'Option_1', 'Option_2', 'Option_3', 'Option_4', 'Answer');
        //    $headerString=implode(',',);

        //    fputs($output,'$headerString');

        // Output each row of data
        // foreach ($usersData as $row) {
        //     fputcsv($output, $row);
        // }


        // foreach ($usersData as $line) {
        //     // print_r($line);die;
        //                 $nestedDataCSV = array();
        //                 $nestedDataCSV[] = 'Question :-'.strip_tags($line['question']);
        //                 $nestedDataCSV[] = 'Option1 :-'.strip_tags($line['option_1']);
        //                 $nestedDataCSV[] = 'Option2 :-'.strip_tags($line['option_2']);
        //                 $nestedDataCSV[] = 'Option3 :-'.strip_tags($line['option_3']);
        //                 $nestedDataCSV[] = 'Option4 :-'.strip_tags($line['option_4']);
        //                 $nestedDataCSV[] = 'Answer :-'.strip_tags($line['answer']);

        //                 fputcsv($output, $nestedDataCSV);
        //    }

        foreach ($usersData as $line){
            $content = 'Question: ' . preg_replace('/[,"]+/', '', strip_tags($line['question'])) . PHP_EOL;
            $content .= 'Option_1: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_1'])) ;
            $content .= 'Option_2: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_2'])) ;
            $content .= 'Option_3: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_3'])) ;
            $content .= 'Option_4: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_4'])). PHP_EOL ;
            $content .= 'Answer: ' . preg_replace('/[,"]+/', '', strip_tags($line['answer'])) . PHP_EOL . PHP_EOL;

            fwrite($output, $content);
        }
        fclose($output);
        exit;
    }
}
