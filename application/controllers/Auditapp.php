<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Filter
{
    private $colName;
    private $searchValue;

    function __construct($colName, $searchValue)
    {
        $this->searchValue = $searchValue;
        $this->colName = $colName;
    }

    function filter_callback_array($data)
    {
        $result = false;
        if (is_array($this->colName) && is_array($this->searchValue)) {
            $colcount = count($this->colName);
            $valcount = count($this->searchValue);
            if ($colcount == $valcount) {
                for ($i = 0; $i < $colcount; $i++) {
                    $result = (strtolower(trim($data[$this->colName[$i]])) == strtolower(trim($this->searchValue[$i])));
                    if (!$result) {
                        break;
                    }
                }
            }
        }
        return $result;
    }
}
// new class started
class Auditapp extends CI_Controller
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

    public function assignedTask($var = null)
    {
        $data['workorder'] = $this->MainModel->getallworkorder($_SESSION['userInfo']['id']);
        // echo '<pre>';
        // print_r($data);die;
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        $this->load->view('pages/todolist', $data);
        $this->load->view('layout/footer');
    }

    // assigned task action
    public function workorderAction($id = null)
    {
        $data['process'] = $this->MainModel->getallworkorder($_SESSION['userInfo']['id']);
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        $this->load->view('layout/footer');
    }
    // function to load work steps according to process
    function choose_services($id = null)
    {
        $id = base64_decode($id);
        $data['client_data'] = $this->MainModel->selectAllFromWhere('client_details', array('client_id' => $id));
        // print_r($data['client_data']);
        // die;
        $data['services'] = $this->MainModel->selectAll('process_master', 'process_description');
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('template/auditServices', $data);
        $this->load->view('layout/footer');
    }

    // Edit client
    public function edit_client($id)
    {
        $id = base64_decode($id);
        $data['client'] = $this->MainModel->selectAllFromWhere('client_details', array('client_id' => $id));
        $data['country'] = $this->MainModel->selectAll('countries', 'name');
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('pages/new-client', $data);
        $this->load->view('layout/footer');
    }

    // function to extract all the state from the database.
    public function select_state()
    {
        // print_r($_POST);die;
        $id = $this->input->post('c_id');
        $data = $this->MainModel->selectAllFromWhere('states', array('country_id' => $id));
        $myjson = json_encode($data, true);
        echo $myjson;
    }

    // function to extract all the city from the database.
    public function select_cities()
    {

        $id = $this->input->post('c_id');
        $data = $this->MainModel->selectAllFromWhere('cities', array('state_id' => $id));
        $myjson = json_encode($data, true);
        echo $myjson;
    }
    // function to insert new client details into the database.
    public function clientPost()
    {
        // $this->load->helper('customvalidation');

        // print_r($_POST);die;
        $c_name = $this->input->post('client-name');
        $c_id = $this->Audit_model->getNewIDorNo("CL", 'client_details');
        $c_address = $this->input->post('address');
        $c_city = $this->input->post('city');
        $c_state = $this->input->post('state');
        $c_country = $this->input->post('country');
        $c_email = $this->input->post('email');
        $c_contact_no = $this->input->post('mobile-number');
        $c_zip_pin_code = $this->input->post('zip');
        $gst_number = $this->input->post('gst-number');

        if (isset($c_email)) {
            $data = $this->MainModel->selectAllFromWhere('client_details', array('email' => $c_email));
            if (!empty($data)) {
                // $this->session->set_flashdata("error", "");
                echo $responce = json_encode(array('message' => 'Email, already exists', 'type' => 'error'), true);
                // redirect(__CLASS__ . '/client_registration_form');
            } else if (empty($data)) {
                $insert = array(
                    'client_name' => $c_name,
                    'client_id' => $c_id,
                    'address' => $c_address,
                    'city' => $c_city,
                    'state' => $c_state,
                    'country' => $c_country,
                    'pin_code' => $c_zip_pin_code,
                    'contact_no' => $c_contact_no,
                    'email' => $c_email,
                    'gst_number' => $gst_number
                );
                $res = $this->MainModel->insertInto('client_details', $insert);
                // print_r($res);die;
                if (!empty($res)) {
                    $company_data = array(
                        'company_name' => $c_name,
                        'client_id' => $c_id,
                        'email' => $c_email,
                        'company_id' => $res
                    );
                    $this->session->set_userdata("company_data", $company_data);
                    // redirect('ControlUnit/newWorkOrder/' . $c_id);
                    echo $responce = json_encode(array('message' => 'client, successfully registered', 'type' => 'success', 'path' => 'ControlUnit/newWorkOrder/' . $c_id), true);
                }
            }
        } else {
            // $this->session->set_flashdata("error", "Client Already Exist.");
            // redirect('ControlUnit/allClients');
            echo $responce = json_encode(array('message' => 'system error! contact IT', 'type' => 'error', 'path' => 'ControlUnit/allClients'), true);
        }
    }
    // function to update clients in to the database.
    public function saveEditedClient()
    {
        // print_r($_POST);die; 
        if (isset($_POST)) {
            $insert = array(
                'client_name' => $_POST['client-name'],
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'country' => $_POST['country'],
                'pin_code' => $_POST['zip'],
                'contact_no' => $_POST['mobile-number'],
                'email' => $_POST['email'],
                'gst_number' => $_POST['gst-number'],
                // 'process' => $_POST['process']
            );
            $res = $this->MainModel->update_table('client_details', array('client_id' => $_POST['client_id']), $insert);
            if (!empty($res)) {
                // $this->session->set_flashdata("success", "Client Successfully Updated.");
                $company_data = array(
                    'company_name' => $_POST['client-name'],
                    'email' => $_POST['email'],
                    'company_id' => $_POST['client_id']
                );

                $this->session->set_userdata("company_data", $company_data);
                echo $responce = json_encode(array('message' => 'client, successfully updated', 'type' => 'success', 'path' => 'ControlUnit/allClients'), true);




                // redirect(base_url('ControlUnit/allClients'));
            }
        } else {
            // $this->session->set_flashdata("error", "System Error Contact to IT.");
            echo $responce = json_encode(array('message' => 'System Error Contact to IT', 'type' => 'error', 'path' => 'ControlUnit/allClients'), true);
        }
        // redirect('ControlUnit/allClients');
    }

    //  function to insert user details into the database.
    function user_post()
    {
        // echo '<pre>';
        // print_r($_POST);die;

        if (empty($_POST)) {
            // $this->session->set_flashdata("error", "Fill all details first.");
            // redirect('ControlUnit/newUsersPage');
            echo $responce = json_encode(array('message' => 'Fill all details first.', 'type' => 'error', 'path' => 'ControlUnit/newUsersPage'), true);
        } else {
            // print_r($_POST);die;
            $data = array(
                'user_id' =>  $this->Audit_model->getNewIDorNo('U', 'users'),
                'password' => $this->input->post('password'),

                'first_name' => $this->input->post('first-name'),
                'last_name' => $this->input->post('last-name'),
                'email' => $this->input->post('email'),

                'country' => $this->input->post('country'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'address' => $this->input->post('address'),
                'adress_line_two' => $this->input->post('address-line-two'),
                'phone' => $this->input->post('mobile-no'),
                'zip_pin_code' => $this->input->post('zip-pin-code'),
                'role' => $this->input->post('role')
            );
            $email = $this->input->post('email');
            if (!empty($email)) {
                $userid = $this->MainModel->selectAllFromWhere(
                    'users',
                    array('email' => $email)
                );
                if (!empty($userid)) {
                    // $this->session->set_flashdata("error", "User already exist");
                    // redirect('ControlUnit/newUsersPage');

                    echo $responce = json_encode(array('message' => 'User already exist', 'type' => 'error', 'path' => 'ControlUnit/newUsersPage'), true);
                } elseif (empty($userid)) {
                    $inserted_data = $this->MainModel->insertInto('users', $data);
                    if (isset($inserted_data)) {

                        // $this->session->set_flashdata("success", "User successfuly register.");
                        // redirect('ControlUnit/allUsers');

                        echo $responce = json_encode(array('message' => 'User successfuly register', 'type' => 'success', 'path' => 'ControlUnit/allUsers'), true);
                    } else {
                        // $this->session->set_flashdata("error", "error.");
                        // redirect('ControlUnit/allUsers');

                        echo $responce = json_encode(array('message' => 'System error contact IT', 'type' => 'error', 'path' => 'ControlUnit/allUsers'), true);
                    }
                }
            }
        }
    }
    //  function to show  users in edit mode.
    public function edit_user($id)
    {
        $data['country'] = $this->MainModel->selectAll('countries', 'name');
        $data['role'] = $this->MainModel->selectAll('roles', 'role');
        $data['user'] = $this->MainModel->selectAllFromWhere('users', array('user_id' => $id));
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('pages/new-user', $data);
        $this->load->view('layout/footer');
    }

    // function to delete records from database by given id.
    public function delete_user($id)
    {
        $data = $this->MainModel->delete('users', array('user_id' => $id));
        if ($data != true) {
            $this->session->set_flashdata("error", "error.");
            redirect('ControlUnit/allUsers');
        } else {
            $this->session->set_flashdata("success", "User deleted");
            redirect('ControlUnit/allUsers');
        }
    }

    //  function to update users into the database.
    function user_editpost()
    {
        $data = array(
            'password' => $this->input->post('password'),
            'first_name' => $this->input->post('first-name'),
            'last_name' => $this->input->post('last-name'),
            'email' => $this->input->post('email'),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'city' => $this->input->post('city'),
            'address' => $this->input->post('address'),
            'adress_line_two' => $this->input->post('address-line-two'),
            'phone' => $this->input->post('mobile-no'),
            'zip_pin_code' => $this->input->post('zip-pin-code'),
            'role' => $this->input->post('role')
        );

        $id = $this->input->post('id');
        $result = $this->MainModel->update_table('users', array('user_id' => $id), $data);
        if ($result == "FALSE") {
            // $this->session->set_flashdata("success", " User updated successfuly register.");
            // redirect('ControlUnit/allUsers');

            echo $responce = json_encode(array('message' => 'User updated successfuly register.', 'type' => 'success', 'path' => 'ControlUnit/allUsers'), true);
        } else if ($result == "TRUE") {
            // $this->session->set_flashdata("error", "Error.");
            // redirect('ControlUnit/allUsers');

            echo $responce = json_encode(array('message' => 'System error contact IT', 'type' => 'error', 'path' => 'ControlUnit/allUsers'), true);
        }
    }

    // function to createing workorder
    function create_work_order()
    {
        // print_r($_POST);die;

        if (!empty($_POST)) {
            $sdate = yymmdd($_POST['sdate']);
            $edate = yymmdd($_POST['enddate']);
            // print_r($sdate);
            // echo '<br>';
            // print_r($edate);
            // die;
            $wo_id = $this->Audit_model->getNewIDorNo("WO", 'work_order');
            $data = array(
                'client_id' => $_POST['client_id'],
                'work_order_id' => $_POST['workorderId'],
                'work_order_name' => $_POST['workOrderName'],
                'processes' => $_POST['process'],
                'start_date' => $sdate,
                'end_date' => $edate,
                'assign_status' => '0',
                'complete_status' => '0'
            );
            // echo '<pre>';
            //             print_r($data);die;

            $result = $this->MainModel->insertInto('work_order', $data); //save work order

            $relation = array(
                'work_order_id' => $wo_id,
                'client_id' => $_POST['client_id'],
            );
            $result = $this->MainModel->insertInto('client_workorder_relationship', $relation); //save relationship between workorder and client
            if ($result) {
                $reply = array(
                    'work_order_id' => $wo_id,
                    'client_id' => $_POST['client_id'],
                    'msg' => "Work order successfully created"
                );
                $result = json_encode($reply, true);
                echo $result;
            } else {
                echo "Something Wrong!";
            }
        } else {
            echo "System Error! contact to IT";
        }
    }

    // function to show list of all the uploaded files.
    public function viewFiles()
    {
        // $id=$_POST;
        // print_r($id);die;
        $data = $this->MainModel->selectAllWhere('files', array('work_order_id' => $_POST['workid'], 'work_step_id' => $_POST['workstepsid']));
        echo $uploads_file = json_encode($data, true);
    }

    // function to show uploaded work steps file 
    public function worksteps_file()
    {
        $data = $this->MainModel->selectAllWhere('files', array('work_steps_id' => $_POST['workstepsid'], 'client_id' => $_POST['companyid']));
        echo $uploads_file = json_encode($data, true);
    }



    // public function workprocess($id = null)
    // {
    //     $id = base64_decode($id);
    //     $data = $this->MainModel->selectAllFromWhere('work_order', array('work_order_id' => $id));
    //     $process = json_decode($data[0]['processes'], true);
    //     $p_data = [];
    //     foreach ($process as $process_id => $sub_proceses) {
    //         // echo $process_id;
    //         $process_data = $this->MainModel->selectAllFromWhere('process_master', array('process_id' => $process_id));
    //         $p_data[$process_id] = $process_data[0];
    //         $sp_data = [];

    //         foreach ($sub_proceses as $key => $sub_procese) {
    //             // print_r($sub_procese);die;
    //             $sprocess_data = $this->MainModel->selectAllFromWhere('sub_process_master', array('sub_process_id' => $key, 'process_id' => $process_id));

    //             // print_r($sprocess_data);
    //             // die;
    //             $sprocess_data[0]['risk_data'] = $sub_procese;
    //             $sp_data[$key] = $sprocess_data[0];

    //             // print_r($sprocess_data);
    //         }

    //         $p_data[$process_id]['sub_process_data'] = $sp_data;
    //     }
    //     // print_r($processArr);die;
    //     $p_data['p_data'] = $p_data;
    //     $p_data['work_order'] = $id;
    //     $p_data['work_order_name'] = $data[0]['work_order_name'];
    //     $this->load->view('layout/header');
    //     $this->load->view('team/team-sidebar');
    //     $this->load->view('pages/work-space', $p_data);
    //     $this->load->view('layout/footer');
    // }



    // do new process array
    // function to show list of all the selected process by the
    public function workprocess($id = null)
    {
        $id = base64_decode($id);
        // print_r($id);die;
        $data = $this->MainModel->selectAllFromWhere('work_order', array('work_order_id' => $id));
        $clientData =$this->MainModel->selectAllFromWhere('client_details', array('client_id' => $data[0]['client_id']));

        $process = json_decode($data[0]['processes'], true);
        $countSubprocess = 0;
        $subProcessCount = [];
        $p_data = [];
        // echo '<pre>';
        // print_r($clientData);
        // die;


        foreach ($process as $process_id => $sub_processes) {
            // echo $process_id;die;
            $process_data = $this->MainModel->selectAllFromWhere('process_master', array('process_id' => $process_id));
            $p_data[$process_id] = $process_data[0];
            $sp_data = [];
            $totalWorkStep = 0;
            // print_r($sub_processes);die;
            foreach ($sub_processes as $key => $subprocess_risk) {
                // print_r($subprocess_risk);die;

                $countSP = 0;

                $sprocess_data = $this->MainModel->selectAllFromWhere('sub_process_master', array('sub_process_id' => $key, 'process_id' => $process_id));
                $riskData = [];
                $sprocess_data[0]['risk_data'] = $subprocess_risk;
                if (!empty($subprocess_risk)) {
                    foreach ($subprocess_risk as $key => $risk) {
                        // print_r($risk);
                        $controls = $this->MainModel->selectAllFromWhere('control_master', array('risk_id' => $risk['risk_id']));
                        // $riskData[$key] = $con4trols; 
                        // print_r($controls);
                        $sprocess_data[0]['risk_data'][$key]['control_data'] = $controls;

                        foreach ($controls as $key1 => $workstep) {
                            // print_r($workstep['control_id']);
                            $worksteps = $this->MainModel->selectAllFromWhere('work_steps', array('control_id' => $workstep['control_id']));
                            // echo '<pre>';
                            //    print_r(count($worksteps));
                            $countSubprocess += count($worksteps);
                            $countSP += count($worksteps);

                            $sprocess_data[0]['risk_data'][$key]['control_data'][$key1]['work_step'] = $worksteps;
                        }
                        //  $countSubprocess++;
                    }

                    array_push($subProcessCount, $countSP);
                    $totalWorkStep += $countSP;
                    // echo $countSP.'<br>' ;
                }
                // $riskData = [];
                //  $countSubprocess++;
                // echo $countSP;
                $sp_data[$key] = $sprocess_data[0];
            }
            $p_data[$process_id]['sub_process_data'] = $sp_data;
        }

        //    echo $totalWorkStep;
        //    die;

        $p_data['p_data'] = $p_data;
        $p_data['clientId'] = $clientData[0]['client_id'];
        $p_data['clientName'] = $clientData[0]['client_name'];
        // $p_data['totalrows'] = $countSubprocess;
        // $p_data['totalWorkStep'] = $totalWorkStep;
        // $p_data['countRow'] = $subProcessCount;
        $p_data['work_order'] = $id;
        $p_data['work_order_name'] = $data[0]['work_order_name'];


        // echo json_encode($p_data);die;
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        // $this->load->view('pages/work-demo', $p_data);
        $this->load->view('pages/work-order-process-demo', $p_data);
        // work-order-process-demo
        $this->load->view('layout/footer');
    }

    // public function process()
    // {
    //     $this->load->view('layout/header');
    //     $this->load->view('team/team-sidebar');
    //     $this->load->view('pages/work-order-process-demo');
    //     $this->load->view('layout/footer');
    // }



    // public function riskData($data = null, $workOrder = null)
    // {
    //     // echo '<pre>';
    //     $a = base64_decode($data);
    //     $w = base64_decode($workOrder);
    //     $workOrderDetails = json_decode($w);

    //     // print_r($a);
    //     $data1 =  json_decode($a, true);
    //     //  print_r($data1);die;
    //     $process = $this->MainModel->selectAllFromWhere('process_master', array('process_id' => $data1['process_id']));
    //     $data2['risks'] = $data1;
    //     $data2['processName'] = $process[0]['process_description'];
    //     $data2['workorderDetails'] = $workOrderDetails;

    //     // print_r( $data2['risks']);die;
    //     $this->load->view('layout/header');
    //     $this->load->view('team/team-sidebar');
    //     $this->load->view('pages/risks-data-table', $data2);
    //     $this->load->view('layout/footer');
    // }

    // popualte  worksteps from database
    // public function workSteps($riskId = null, $controlId = null, $sub_processeid = null, $processId = null, $workOrderId = null)
    // {
    //     $controlId = base64_decode($controlId);
    //     $data['riskId'] = base64_decode($riskId);
    //     $data['processid'] = base64_decode($processId);
    //     $data['workorderId'] = base64_decode($workOrderId);
    //     $data['subProceseid'] = base64_decode($sub_processeid);
    //     $data['controlId'] = $controlId;
    //     $data['workSteps']  = $this->MainModel->selectAllFromWhere('work_steps', array('control_id' => $controlId));

    //     // echo '<pre>';
    //     // print_r($data);die;
    //     $this->load->view('layout/header');
    //     $this->load->view('team/team-sidebar');
    //     $this->load->view('pages/work-steps', $data);
    //     // $this->load->view('pages/risks-data-table', $data);
    //     $this->load->view('layout/footer');
    // }

    // function to load all the workorders by ajax

    public function workorders()
    {
        //    print_r($_POST);die;
        $id = base64_decode($_POST['id']);
        $data = $this->MainModel->selectAllFromWhere('work_order', array('client_id' => $id));
        // print_r($data);die;
        $data = json_encode($data, true);
        echo $data;
    }

    // function to load all the users by ajax
    public function allemployees()
    {
        $employees = $this->MainModel->getallusers();
        $data = json_encode($employees, true);
        echo $data;
    }

    // function to load all the users by ajax
    public function getAlluersWithAsseignedWorkorders()
    {
        $employees = $this->MainModel->selectAllFromWhere('users', array('first_name' => $_POST['name']));
        $data = json_encode($employees, true);
        echo $data;
    }

    // funtion to pull all data from database
    public function downlodDatabaseMaster()
    {
        $data = $this->Files->downlodDatabaseMaster();
        // print_r($data);
        // Open a file in write mode ('w') 
        $path = 'assets/sample_data/audit-sheet.csv';
        $fp = fopen($path, 'w');
        // Loop through file pointer and a line 
        $i = 0;
        foreach ($data as $fields) {
            if ($i == 0) {
                fputcsv($fp, array_keys($fields));
            }
            fputcsv($fp, array_values($fields));
            $i++;
        }
        fclose($fp);
        echo base_url($path);
    }

    // function to show all the process to manager
    // public function workOrderprocess($id = null)
    // {
    //     $id = base64_decode($id);
    //     // print_r($id);die;
    //     $data = $this->MainModel->selectAllFromWhere('work_order', array('work_order_id' => $id));
    //     $clientID = $this->MainModel->selectAllFromWhere('client_details', array('client_id' => $data[0]['client_id']));
    //     // echo '<pre>';
    //     // print_r($data);
    //     // die;
    //     $process = json_decode($data[0]['processes'], true);

    //     // print_r($process);
    //     // die;
    //     $p_data = [];
    //     foreach ($process as $process_id => $sub_processes) {
    //         //echo $process_id;
    //         $process_data = $this->MainModel->selectAllFromWhere('process_master', array('process_id' => $process_id));
    //         $p_data[$process_id] = $process_data[0];
    //         $sp_data = [];
    //         foreach ($sub_processes as $sub_processe) {
    //             // print_r($sub_processe);die;
    //             $sprocess_data = $this->MainModel->selectAllFromWhere('sub_process_master', array('sub_process_id' => $sub_processe, 'process_id' => $process_id));
    //             $sp_data[$sub_processe] = $sprocess_data[0];
    //             // echo $sub_processe;
    //         }
    //         $p_data[$process_id]['sub_process_data'] = $sp_data;
    //     }
    //     // echo '<pre>';
    //     // print_r($p_data);die;
    //     // $upload_files = json_encode($p_data, true);
    //     $p_data['p_data'] = $p_data;
    //     $p_data['work_order'] = $id;
    //     $p_data['clientName'] = $clientID[0]['client_name'];
    //     $p_data['workOrdername'] = $data[0]['work_order_name'];
    //     // echo $data = json_encode($p_data, true);
    //     $this->load->view('layout/header');
    //     $this->load->view('manager/manager-sidebar');
    //     $this->load->view('manager/work-space-all-process', $p_data);
    //     $this->load->view('layout/footer');
    // }

    // function to show all the process to manager
    public function workOrderprocess($id = null)
    {
        $id = base64_decode($id);
        // print_r($id);die;
        $data = $this->MainModel->getSelectedWorkorder($id);
        $process = json_decode($data[0]['processes'], true);
        $countSubprocess = 0;
        $subProcessCount = [];
        $totalWorkStep = 0;
        $p_data = [];
        // echo '<pre>';
        // print_r($data);
        foreach ($process as $process_id => $sub_processes) {
            // echo $process_id;die;
            $process_data = $this->MainModel->selectAllFromWhere('process_master', array('process_id' => $process_id));
            $p_data[$process_id] = $process_data[0];
            $sp_data = [];
            // print_r($sub_processes);die;
            foreach ($sub_processes as $key => $subprocess_risk) {
                // print_r($subprocess_risk);die;

                $countSP = 0;

                $sprocess_data = $this->MainModel->selectAllFromWhere('sub_process_master', array('sub_process_id' => $key, 'process_id' => $process_id));
                $riskData = [];
                $sprocess_data[0]['risk_data'] = $subprocess_risk;
                if (!empty($subprocess_risk)) {
                    foreach ($subprocess_risk as $key => $risk) {
                        // print_r($risk);
                        $controls = $this->MainModel->selectAllFromWhere('control_master', array('risk_id' => $risk['risk_id']));
                        // $riskData[$key] = $con4trols; 
                        // print_r($controls);
                        $sprocess_data[0]['risk_data'][$key]['control_data'] = $controls;

                        foreach ($controls as $key1 => $workstep) {
                            // print_r($workstep['control_id']);
                            $worksteps = $this->MainModel->selectAllFromWhere('work_steps', array('control_id' => $workstep['control_id']));
                            // echo '<pre>';
                            //    print_r(count($worksteps));
                            $countSubprocess += count($worksteps);
                            $countSP += count($worksteps);

                            $sprocess_data[0]['risk_data'][$key]['control_data'][$key1]['work_step'] = $worksteps;
                        }
                        //  $countSubprocess++;
                    }

                    // array_push($subProcessCount, $countSP);
                    // echo $countSP.'<br>' ;
                    $totalWorkStep += $countSP;
                }
                // $riskData = [];
                //  $countSubprocess++;
                // echo $countSP;
                $sp_data[$key] = $sprocess_data[0];
            }
            $p_data[$process_id]['sub_process_data'] = $sp_data;
        }



        // $upload_files = json_encode($p_data, true);

        $p_data['work_order'] = $data[0]['work_order_id'];
        $p_data['workOrdername'] = $data[0]['work_order_name'];
        $p_data['clientName'] = $data[0]['client_name'];
        $p_data['p_data'] = $p_data;
        $p_data['totalWorkStep'] = $totalWorkStep;

        // echo '<pre>';
        // print_r($p_data); die;
        // echo $data = json_encode($p_data, true);
        $this->load->view('layout/header');
        $this->load->view('manager/manager-sidebar');
        $this->load->view('manager/work-space-all-process-demo', $p_data);
        $this->load->view('layout/footer');
    }

    // public function updateWorkSteps($var = null)
    // {
    //     //   print_r($_POST);die;
    //     $condition = array(
    //         'work_step_id' => $_POST['workstepsid'],
    //         'work_order_id' => $_POST['workOrderId']
    //     );

    //     // $datavalue = ;
    //     $data = array(
    //         'complete_status' => $_POST['checkValue']
    //     );
    //     $result = $this->MainModel->update_table('files', $condition, $data);
    //     echo $result = json_encode($result, true);
    // }

    // function to loading list of all the  users details from database
    public function allUesrs()
    {
        $data = $this->MainModel->getallusers();
        echo $data = json_encode($data, true);
    }

    // // function to save work steps
    // public function saveWorkSteps()
    // {
    //     if (isset($_POST['data'])) {
    //         $data  = json_decode($_POST['data'], true);
    //         // print_r($data);die;           
    //         for ($i = 0; $i < count($data); $i++) {
    //             $insert = array(
    //                 'work_order_id' => $data[$i]['order_id'],
    //                 'process_id' => $data[$i]['process_id'],
    //                 'sub_process_id' => $data[$i]['subprocess_id'],
    //                 'work_step_id' => $data[$i]['work_step_id'],
    //                 'file_type' => $data[$i]['mandatory_type'],
    //                 'complete_status' => '1'
    //             );
    //             $validate = $this->MainModel->selectAllFromWhere('work_steps_complete_status', $insert);
    //             if (empty($validate)) {
    //                 $res = $this->MainModel->insertInto('work_steps_complete_status', $insert);
    //             }
    //         }
    //         if ($res) {
    //             echo (json_encode(array('status' => 'success', 'msg' => 'Steps saved successfully')));
    //         } else {
    //             echo (json_encode(array('status' => 'danger', 'msg' => 'Steps did not save successfully, Contact to IT')));
    //         }
    //     } else {
    //         echo (json_encode(array('status' => 'danger', 'msg' => 'System Error! Contact to IT')));
    //     }
    // }

    // public function updateWorkorder($var = null)
    // {
    //     // print_r($_POST);die;
    //     $condition = array('work_order_id' => $_POST['workOrderId']);
    //     $data = array('complete_status' => $_POST['completeWorkOrder']);
    //     $r = $this->MainModel->update_table('work_order', $condition, $data);
    //     // print_r($r);die;
    //     // $result = json_encode($r, true);
    // }

    public function commitWorkSteps()
    {
        //    echo '<pre>';
        //     print_r($_POST);die;

        if (!empty($_POST)) {
            $workOrderId = $_POST['workOrderId'];
            $workOrderName = $_POST['workorderName'];
            $clientId = $_POST['clientId'];

            $clientName = $_POST['clientName'];
            $saveData = $_POST['workstepData'];

            $userid = $_SESSION['userInfo']['id'];
            $userName = $_SESSION['userInfo']['username'];

            $data = array(
                // 'complete_workorder_id' => $this->Audit_model->getNewIDorNo('COW', 'complete_work_steps'),
                'work_order_id' => $workOrderId,
                'workorder_name'=>$workOrderName,
                'saved_data' => json_encode($saveData),
                'client_id'=>$clientId,
                'client_name'=>$clientName,
                'user_id'=>$userid,
                'user_name'=>$userName
            );

            // print_r($data);die;
            $response = $this->MainModel->selectAllFromWhere('complete_work_steps', array('work_order_id' => $workOrderId,));
            if (!empty($response)) {
                $data = array(
                    'saved_data' => json_encode($saveData, true)
                );
                $result = $this->MainModel->update_table(
                    'complete_work_steps',
                    array('work_order_id' => $workOrderId),
                    $data
                );

                if (!empty($result)) {
                    echo $responce = json_encode(array('message' => 'successfuly updated...', 'type' => 'success'), true);
                } else {
                    echo $responce = json_encode(array('message' => 'System error! contact IT', 'type' => 'error'), true);
                }
            } else {
                $res = $this->MainModel->insertInto('complete_work_steps', $data);
                if (!empty($res)) {
                    echo $responce = json_encode(array('message' => 'successfuly save...', 'type' => 'success'), true);
                } else {
                    echo $responce = json_encode(array('message' => 'System error! contact IT', 'type' => 'error'), true);
                }
            }
        } else {
            echo $responce = json_encode(array('message' => 'Please enter Data', 'type' => 'worning'), true);
        }
    }

    // function to get all the process from the saved data
    public function getSavedWorkSteps()
    {
        $workOrderId = $_GET['workOrderId'];

        // print_r($_GET['workOrderId']);
        // die;
        $condition = array(
            'work_order_id' => $workOrderId,
        );
        $dbresult = $this->MainModel->selectAllFromWhere('complete_work_steps', $condition);
        // print_r($dbresult);
        // die;
        if (!empty($dbresult)) {
            echo json_encode($dbresult[0]);
        } else {
            echo json_encode(array('responase' => 'false'));
        }
    }
    
    // function to get all the work order 
    public function getallworkorders()
    {
        $workorders = $this->MainModel->selectAllworkOrder();
        echo json_encode($workorders);
    }

    public function getCompleteWorkorders()
    {
        $completeworkorders = $this->MainModel->selectAll('complete_work_steps');
        echo json_encode($completeworkorders);
    }
}
