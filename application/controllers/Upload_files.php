<?php defined('BASEPATH') or exit('No direct script access allowed');

class Upload_files extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        // Load session library
        $this->load->library('session');
        // Load file model
        $this->load->model('Files');
    }

    function upload_file()
    {
        // echo '<pre>';
        // print_r($_POST);
        // print_r()
        // die;
        $data = array();
        if (empty($_FILES['files']['name'])) {
            echo json_encode(array("type" => 'danger', 'msg' => "Please select file"));
            exit();
        }
        // print_r($_SESSION['userInfo']['id']);die;
        if (!empty($_FILES['files']['name'])) {
            // File upload configuration
            $uploadPath = './upload/files';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'csv|jpg|xlsx|png|doc|docx|pdf|txt|xls';
            $config['max_size'] = 2000;
            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('files')) {
                // Uploaded file data
                $fileData = $this->upload->data();
                // print_r($fileData);die;
                $data = array(
                    'file_name' => $fileData['file_name'],
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_by' => $_SESSION['userInfo']['id'],
                    'work_order_id' => $_POST['workOrderId'],
                    'work_step_id' => $_POST['workstepId']
                    // 'complete_status' => 0
                );
            } else {
                // print_r($_FILES['file']['name']);
                echo  json_encode(array('type' => 'danger', 'msg' => $this->upload->display_errors()));
            }
            if (!empty($data)) {
                // Insert files data into the database
                $result = $this->MainModel->insertInto('files', $data);

                // print_r($result);
                // die;
                // Upload status message
                if ($result) {
                    $uploadedFile = $this->MainModel->selectAllFromWhere('files', array('id' => $result));
                    
                    
                // print_r($uploadedFile);
                // die;
                    
                    echo json_encode(array("type" => 'success', 'msg' => "Files uploaded successfully" ,'files'=>$uploadedFile));
                } else {
                    echo json_encode(array("type" => 'danger', 'msg' => $this->upload->display_errors()));
                }
            }
        }
    }

    // $this->load->view('Auditapp/upload_file', $data);


    // function get_Uploaded_file()
    // {
    //     // Get files data from the database
    //     $filedata = $this->MainModel->selectAll('files');
    //     echo $filedata = json_encode($filedata, true);
    // }
}
