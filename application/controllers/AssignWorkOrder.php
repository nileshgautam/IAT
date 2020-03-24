<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssignWorkOrder extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata"); //Set server date an time to Asia
        if (!isset($_SESSION['userInfo'])) {
            $this->session->sess_destroy();
            redirect('login');
        }
    }

    function allowcated_work_order($clientid = null)

    {

        $data['users'] = $this->MainModel->selectAllWhere('users', array('role!=' => 'Admin'));
        $data['roles'] = $this->MainModel->selectAllWhere('roles', array('status' => '0'));
        $data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
        // $data['clientid'] = base64_decode($clientid);
        $data['clientid'] = $clientid;

        // // echo '<pre>';
        // print_r($data['clientid']);die;
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('template/allowcateWorkorder', $data);
        $this->load->view('layout/footer');
    }

    function get_work_order()
    {
        if (isset($_POST['id'])) {
            $workOrder = $this->MainModel->selectAllWhere('client_workorder_relationship', array('client_id' => $_POST['id']));
            if (!empty($workOrder)) {
                echo json_encode($workOrder);
            } else {
                echo "System Error! Contact to IT";
            }
        } else {
            echo "System Error! Contact to IT";
        }
    }

    // assign Work orders
    function save_assigned_work()
    {
        // print_r($_POST);die;
// echo '<pre>';
        if (isset($_POST)) {
            $validate = $this->MainModel->selectAllWhere('users_work_order_relationship', array('work_order_id' => $_POST['workorderId'], 'user_id' => $_POST['employeeId'], 'role'=>$_POST['projectRole']));
            // print_r($_POST);
            // print_r($validate);die;
            if (!empty($validate)) {
                echo json_encode(array("type" => 'danger', 'msg' => "User Already working on this work order", 'status' => 'A'));
                // for terminate process
            } else {
                $insert = array(
                    'work_order_id' => $_POST['workorderId'],
                    'user_id' => $_POST['employeeId'],
                    'role' => $_POST['projectRole'],
                    'clientId' => $_POST['clientId'],
                    'work_status' => false
                );

                $res = $this->MainModel->insertInto('users_work_order_relationship', $insert);

                if (!empty($res)) {
                    echo json_encode(array("type" => 'success', 'msg' => "Work Successfully Assigned", 'status' => 'Y'));
                } else {
                    echo json_encode(array("type" => 'danger', 'msg' => "work did not Assign, Contact to IT", 'status' => 'E'));
                }
            }
        }
    }
}
