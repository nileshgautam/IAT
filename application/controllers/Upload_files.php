<?php defined('BASEPATH') or exit('No direct script access allowed');

class Upload_Files extends CI_Controller
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

        // print_r($_SESSION['userInfo']['id']);die;
        $data = array();
        if (!empty($_FILES['files']['name'])) {
            // File upload configuration
            $uploadPath = './upload/files';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'csv|jpg|xlsx|png|doc|docx';
            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('files')) {
                // Uploaded file data
                $fileData = $this->upload->data();
                $data = array(
                    'file_name' => $fileData['file_name'],
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_by' => $_SESSION['userInfo']['id'],
                    'work_order_id' => $_POST['workorder-id'],
                    'title' => $_POST['title'],
                    'process_id' => $_POST['process-id'],
                    'sub_process_id' => $_POST['subprocess-id'],
                    'work_step_id' => $_POST['worksteps-id'],
                    'remarks' => $_POST['remark'],
                    'file_type' => $_POST['filetype'],
                    'complete_status' => 0
                );
                // print_r($fileData);

            } else {
                // print_r($_FILES['file']['name']);
                echo  $this->upload->display_errors();
            }


            if (!empty($data)) {
                // Insert files data into the database
                // print_r($uploadData);
                // $insert = $this->Files->insert($data);
                $result = $this->MainModel->insertInto('files', $data);

                // Upload status message
                if($result){
                    $messages = array(
                        'success' => 'Files uploaded successfully',
                       );
                }else{
                    $messages = array(
                        
                        'error' => 'Some problem occurred, please try again' );
                }
              

                echo  json_encode($messages);
                // $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
                // $this->session->set_flashdata('statusMsg', $statusMsg);
            }
        }

        // Get files data from the database
        // $data['files'] = $this->Files->getRows();
        // $json_data = json_encode($data, true);
        // echo $json_data;

    }    // $this->load->view('Auditapp/upload_file', $data);


    function get_Uploaded_file()
    {
        // Get files data from the database
        $filedata = $this->MainModel->selectAll('files');
        echo $filedata = json_encode($filedata, true);
    }
}
