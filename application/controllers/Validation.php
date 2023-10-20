<?php

class Validation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('register_model');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->helper('custom');
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
        $searchTerm = $this->input->post('search');
        $this->db->select('id, name, image');
        $this->db->limit(30);
        if (!empty($searchTerm)) {
            $this->db->group_start();
            if (is_numeric($searchTerm)) {
                $this->db->like('id', $searchTerm, 'after');
            } else {
                $this->db->like('name', $searchTerm, 'after');
            }
            $this->db->group_end(); // 'both' means search for the term anywhere in the 'name' field
        }

        $data = $this->db->get('course_subject_master')->result_array();



        echo json_encode($data);
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
        $lang = $this->input->post('lang_id');
        // print_r($_POST);die;
        $this->db->select([
            'question',
            'option_1 as opt1', '1 AS option_order',
            'option_2 as opt2', '2 AS option_order',
            'option_3 as opt3', '3 AS option_order',
            'option_4 as opt4', '4 AS option_order',
            'answer'
        ]);
        $data = $this->db->get_where('course_question_bank_master', ['subject_id' => $sub, 'topic_id' => $top, 'lang_code' => $lang])->result_array();
        echo json_encode($data);
    }
    public function questionList()
    {
        $requestData = $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 => 'title',
            1 => 'stream',
            2 => 'category',
            3 => 'Subject',
            4 => 'publish',
            5 => 'is_new',
            6 => 'is_cloud',
            7 => 'course_for',
            8 => 'creation_time',
            9 => 'last_updated',
        );
        $query = "SELECT count(cm.id) as total FROM course_question_bank_master cm";
        $query = $this->db->query($query);
        $query = $query->row_array();
        $totalData = (count($query) > 0) ? $query['total'] : 0;
        $totalFiltered = $totalData;


        $sql = "SELECT cqbm.*, csm.name as sub_name, cbtm.topic as top_name
          FROM course_question_bank_master as cqbm 
          LEFT JOIN course_subject_master as csm ON cqbm.subject_id = csm.id
          LEFT JOIN course_subject_topic_master as cbtm ON cqbm.topic_id = cbtm.id
          where cqbm.status = 1 OR cqbm.status = 0";
        // getting records as per search parameters
        if (!empty($requestData['columns'][0]['search']['value'])) {
            $sql .= " AND cqbm.id = '" . $requestData['columns'][0]['search']['value'] . "%' ";
        }
        if (!empty($requestData['columns'][1]['search']['value'])) {
            //salary
            $sql .= " AND cqbm.question LIKE '" . $requestData['columns'][1]['search']['value'] . "%' ";
        }
        if (!empty($requestData['columns'][2]['search']['value'])) {
            //salary
            $sql .= " AND cqbm.option_1 LIKE '" . $requestData['columns'][2]['search']['value'] . "%' ";
        }
        if (!empty($requestData['columns'][3]['search']['value']) && ($requestData['columns'][3]['search']['value'] != "")) {
            //salary
            $sql .= " AND cqbm.option_2 LIKE '" . $requestData['columns'][3]['search']['value'] . "%' ";
        }
        if (!empty($requestData['columns'][4]['search']['value']) && ($requestData['columns'][3]['search']['value'] != "")) {
            //salary
            $sql .= " AND cqbm.option_3 = '" . $requestData['columns'][4]['search']['value'] . "%' ";
        }
        if (!empty($requestData['columns'][5]['search']['value']) || $requestData['columns'][5]['search']['value'] != "") {
            //salary
            $sql .= " AND cqbm.option_4 LIKE '" . $requestData['columns'][5]['search']['value'] . "%' ";
        }
        if ($requestData['columns'][6]['search']['value'] != '') {
            //salary
            $sql .= " AND cqbm.answer LIKE '" . $requestData['columns'][6]['search']['value'] . "%' ";
        }
        if ($requestData['columns'][7]['search']['value'] != '') {
            //salary
            $sql .= " AND csm.name LIKE '" . $requestData['columns'][7]['search']['value'] . "%' ";
        }
        if ($requestData['columns'][8]['search']['value'] != '') {
            //salary
            $sql .= " AND cbtm.topic LIKE '" . $requestData['columns'][8]['search']['value'] . "%' ";
        }
        if ($requestData['columns'][9]['search']['value'] != '') {
            //salary
            $sql .= " AND cqbm.lang_code = '" . $requestData['columns'][9]['search']['value'] . "%' ";
        }
        if ($requestData['columns'][10]['search']['value'] != '') {
            //salary
            $sql .= " AND cqbm.status = '" . $requestData['columns'][10]['search']['value'] . "%' ";
        }


        $query = $this->db->query($sql)->result();
        // print_r($this->db->last_query());

        $totalFiltered = count($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.

        $sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   "; // adding length

        $result = $this->db->query($sql)->result();
        // echo $this->db->last_query();
        // die;
        $data = array();
        foreach ($result as $r) {
            // preparing an array
            //print_r($r);die;
            $nestedData = array();

            $nestedData[] =  $r->id;
            $nestedData[] =  $r->sub_name;

            $nestedData[] =  $r->top_name;

            $nestedData[] = $r->lang_code == 1 ? 'English' : 'Hindi';
            $nestedData[] = $r->question;
            //$nestedData[] = $r->category;
            $nestedData[] = $r->option_1;
            $nestedData[] = $r->option_2;
            //$nestedData[] = ($r->publish == 1 )?'<span class="badge ">Published</span>':"--";
            //$nestedData[] = $r->opt2;

            $nestedData[] = $r->option_3;

            $nestedData[] =  $r->option_4;

            $nestedData[] = $r->answer;

            // $nestedData[] = $r->last_updated;
            // <a href="javascript:void(0)"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">Add Question</button></a>
            $action = "<a class='btn-xs bold  btn btn-info' onclick='editmodel(" . $r->id . ")'>Edit</a> <a class='btn-xs bold  btn btn-warning' href='deleteQuestion/" . $r->id . "'>Delete</a>";
            $nestedData[] = $action;
            $sts =  $r->status == 1 ? 'Active' : 'Inactive';
            $status = "<a class='btn-xs bold  btn btn-info'  href='editStatus/" . $r->id . "/" . $r->status . " '> $sts</a>";
            $nestedData[] = $status;

            $data[] = $nestedData;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data, // total data array
        );

        echo json_encode($json_data);
    }


    // Function to download the CSV file
    public function getCSV($top, $sub, $lang)
    {
        $this->db->select('question, option_1, option_2, option_3, option_4, answer, description');
        $q = $this->db->get_where('course_question_bank_master', ['subject_id' => $sub, 'topic_id' => $top, 'lang_code' => $lang]);
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
        fputcsv($output, array('Question', 'Option_1', 'Option_2', 'Option_3', 'Option_4', 'Answer', 'Description'));

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
            // $nestedDataCSV[] = strip_tags($line['description']);
            $description = htmlspecialchars_decode(strip_tags($line['description']), ENT_QUOTES | ENT_HTML5);
            $description = str_replace('&nbsp;', "\xC2\xA0", $description);
            $nestedDataCSV[] = $description;

            fputcsv($output, $nestedDataCSV);
        }
        // Close the file pointer
        fclose($output);

        exit;
    }
    public function getDocument($top, $sub, $lang)
    {

        $this->db->select('question, option_1, option_2, option_3, option_4, answer, description');
        $q = $this->db->get_where('course_question_bank_master', ['subject_id' => $sub, 'topic_id' => $top, 'lang_code' => $lang]);
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

        foreach ($usersData as $line) {
            $content = 'Question: ' . preg_replace('/[,"]+/', '', strip_tags($line['question'])) . PHP_EOL;
            $content .= 'Option_1: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_1']));
            $content .= 'Option_2: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_2']));
            $content .= 'Option_3: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_3']));
            $content .= 'Option_4: ' . preg_replace('/[,"]+/', '', strip_tags($line['option_4'])) . PHP_EOL;
            $content .= 'Answer: ' . preg_replace('/[,"]+/', '', strip_tags($line['answer'])) . PHP_EOL . PHP_EOL;
            // $content .= 'Description: ' . preg_replace('/[,"]+/', '', strip_tags($line['description'])) . PHP_EOL . PHP_EOL;
            $content .= 'Description: ' . str_replace('&nbsp;', "\xC2\xA0", htmlspecialchars_decode(strip_tags($line['description']), ENT_QUOTES | ENT_HTML5)) . PHP_EOL . PHP_EOL;

            fwrite($output, $content);
        }
        fclose($output);
        exit;
    }
    public function addQuestion()
    {
        $this->load->view('question.php');
    }

    // it will delete the question from table
    public function deleteQuestion($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->delete("course_question_bank_master");
        if ($data) {
            $this->session->set_flashdata('Success', 'Question deletedd Sucessfully');
            redirect("validation/addQuestion");
        } else {
            $this->session->set_flashdata('error', 'Question Can not be Deleted');
            redirect("validation/addQuestion");
        }
    }

    // it will edit the question of the table
    public function editQuestion($id)
    {
        // $this->db->get('question, option_1, option_2, option_3, option_4, answer');
        $data = $this->db->get_where('course_question_bank_master', ['id' => $id])->row_array();
        echo json_encode($data);
    }

    //will add new questions in the table
    public function addnewQuestion()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('subject_id', 'subject_id', 'required');
            $this->form_validation->set_rules('topic_id', 'topic_id', 'required');
            $this->form_validation->set_rules('lang_code', 'lang_code', 'required');
            $this->form_validation->set_rules('Question', 'Question', 'required');
            $this->form_validation->set_rules('option1', 'option1', 'required');
            $this->form_validation->set_rules('option2', 'option2', 'required');
            $this->form_validation->set_rules('option3', 'option3', 'required');
            $this->form_validation->set_rules('option4', 'option4', 'required');
            $this->form_validation->set_rules('Answer', 'Answer', 'required');
            $this->form_validation->set_rules('Description', 'Description', 'required');
            $this->form_validation->set_rules('status', 'status', 'required');

            if ($this->form_validation->run() == false) {
                echo 0;
            } else {
                $data = array(
                    'subject_id' => $this->input->post('subject_id'),
                    'topic_id' => $this->input->post('topic_id'),
                    'lang_code' => $this->input->post('lang_code'),
                    'question' => $this->input->post('Question'),
                    'option_1' => $this->input->post('option1'),
                    'option_2' => $this->input->post('option2'),
                    'option_3' => $this->input->post('option3'),
                    'option_4' => $this->input->post('option4'),
                    'answer' => $this->input->post('Answer'),
                    'description' => $this->input->post('Description'),
                    'status' => $this->input->post('status'),

                );
                if ($this->db->insert('course_question_bank_master', $data)) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
        }
    }
    public function editStatus($id, $stat)
    {
        $updatestat = $stat == 1 ? 0 : 1;
        $this->db->where('id', $id);
        $this->db->set('status', $updatestat);
        $data = $this->db->update('course_question_bank_master');
        if ($data) {
            redirect('http://localhost/form-ajax/index.php/validation/addQuestion');
        } else {
            redirect('http://localhost/form-ajax/index.php/validation/addQuestion');
        }
    }
    public function editform($id)
    {
        // print_r($id);die;
        $data = array(
            'question' => $this->input->post('question'),
            'option_1' => $this->input->post('option_1'),
            'option_2' => $this->input->post('option_2'),
            'option_3' => $this->input->post('option_3'),
            'option_4' => $this->input->post('option_4'),
            'answer' => $this->input->post('answer')
        );
        $this->db->where('id', $id);
        $update = $this->db->update('course_question_bank_master', $data);
        if ($update) {
            echo 1;
        } else {
            //echo 0;
            echo 'Update Error: ' . print_r($this->db->error(), true);
        }
    }
    // reset password funtion
    public function resetPassword()
    {
        $this->load->view('resetPassword');
    }
    public function updatePassword()
    {
        $id = $_SESSION['userdata']['id'];
        $this->db->select('password');
        $this->db->where('id', $id);
        $password = $this->db->get('users')->row_array();
        $sts = $_POST['newPassword'];
        if ($password['password'] == $_POST['currentPassword']) {
            $this->db->where('id', $id);
            $this->db->set('password', $sts);
            $result = $this->db->update('users');
            if ($result) {
                echo 1;
              $this->session->sess_destroy();
            } else {
                echo 0;
            }
        }
        else{
            echo 2;
        }
    }
}
