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
        // die;
        $work_order_id = $_POST['work-order-id'];
        $work_step_id = $_POST['workstepId'];

        $data = array();
        if (empty($_FILES['files']['name'])) {
            echo json_encode(array("type" => 'danger', 'msg' => "Please select file"));
            exit();
        }
        // print_r($_SESSION['userInfo']['id']);die;
        if (!empty($_FILES['files']['name'])) {

            // File upload configuration

            $file_name = $_FILES['files']['name'];
            $file_name = preg_replace("/\s+/", "_", $file_name);

            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = pathinfo($file_name, PATHINFO_FILENAME);

            $file_name = $file_name . "_" . $work_order_id . "_" . $work_step_id . "_" . date('mjYHis') . "." . $file_ext;
            $config['file_name'] = $file_name;

            $config['upload_path'] = './upload/files'; // working on localhost

            // $config["upload_path"] = base_url() . "upload/files/";

            // // or Code:

            // $config[‘upload_path’] = site_url() . "upload/files/";


            $config['allowed_types'] = '*';
            $config['max_size'] = 2000;


            // Load and initialize upload library
            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            $this->upload->do_upload();

            // Upload file to server
            if ($this->upload->do_upload('files')) {
                // Uploaded file data

                $data = array(
                    'file_name' => $file_name,
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_by' => $_SESSION['userInfo']['id'],
                    'work_order_id' => $_POST['work-order-id'],
                    'work_step_id' => $_POST['workstepId']
                    // 'complete_status' => 0
                );
                // print_r($data);
            } else {
                // print_r($_FILES['file']['name']);
                echo  json_encode(array('type' => 'danger', 'msg' => $this->upload->display_errors()));
            }
            if (!empty($data)) {
                // Insert files data into the database

                $checkFiles = $this->MainModel->selectAllFromWhere('files', array(
                    'work_order_id' => $work_order_id,
                    'work_step_id' => $work_step_id
                ));

                // print_r($checkFiles);die;
                if ($checkFiles > 0) {

                    $res = $this->MainModel->update_table('files', array('work_order_id' => $work_order_id,  'work_step_id' => $work_step_id), $data);

                    echo json_encode(array("type" => 'success', 'msg' => "File updated.", 'file_name' => $file_name), true);
                } else {
                    $result = $this->MainModel->insertInto('files', $data);
                    // Upload status message
                    if ($result) {

                        echo json_encode(array("type" => 'success', 'msg' => "File successfully uploaded ", 'file_name' => $file_name), true);
                    } else {
                        echo json_encode(array("type" => 'danger', 'msg' => $this->upload->display_errors()), true);
                    }
                }
            }
        }
    }
}
