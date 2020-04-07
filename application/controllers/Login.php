<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('login/login');
    }
    // validate user login by role
    function auth()
    {
        // print_r($_POST);die;
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $remember_me = $this->input->post('remember_me');
        if (isset($remember_me)) {
            $remember_me = 1;
        } else {
            $remember_me = 0;
        }
        if ($username == "" &&  $password == "") {
            $message = json_encode(array('msg' => 'Warning! username and password are required', 'type' => 'danger'), true);
            echo $message;
        } elseif ($username == "") {
            $message = json_encode(array('msg' => 'Warning! username required', 'type' => 'danger'), true);
            echo $message;
        } elseif ($password == '') {
            $message = json_encode(array('msg' => 'Warning! password required', 'type' => 'danger'), true);
            echo $message;
        } else {
            $this->load->model('MainModel');
            $tableName = 'users';
            $condition = array('email' => $username, 'password' => $password);
            $result = $this->MainModel->selectAllFromWhere($tableName, $condition);
            if ($result == 0) {
                $message = json_encode(array('msg' => 'Warning! username and password invalid', 'type' => 'danger'), true);
                echo $message;
            } elseif ($result != 0) {
                $data  = $result;
                $id    = $data[0]['user_id'];
                $name  = $data[0]['first_name'] . " " . $data[0]['last_name'];
                $email = $data[0]['email'];
                $user_role = $data[0]['role'];
                $sesdata = array(
                    'id'       =>  $id,
                    // 'company' => $company_id,
                    'username'  => $name,
                    'email'     => $email,
                    'user_role' => $user_role,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata("userInfo", $sesdata);

                $result = json_encode(array('msg' => 'true', 'type' => 'success', 'role'=>$user_role, 'remember_me' => $remember_me), true);
                echo $result;
            }
        }
                   
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
