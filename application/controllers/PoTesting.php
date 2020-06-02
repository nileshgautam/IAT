<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PoTesting extends CI_Controller
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

    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        $this->load->view('template/po-testing');
        $this->load->view('layout/footer');
    }
    // reading data potinging data
    public function readingpodata()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_FILES['files'])) {
                // echo '<pre>';    

                // print_r($_FILES['files']);

                $file = $_FILES['files']['tmp_name'];
                $filename = $_FILES['files']['name'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                // validating file extention
                if (!empty($extension)) {
                    if ($extension != 'csv' && $extension != 'xlsx' && $extension != 'XLSX') {
                        echo $responce = json_encode(array('message' => 'Warning! Only CSV and Xlsx files are allowed. ', 'type' => 'warning'), true);
                    } else {
                        if (!is_readable($file)) {
                            echo $responce = json_encode(array('message' => 'error', "File is not readable.", 'type' => 'danger'), true);
                        } else {

                            $objPHPExcel = PHPExcel_IOFactory::load($file); //Creating file object 

                            $po_testing_sheet = $objPHPExcel->getSheetByName('PO Testing');

                            $po_collection = $po_testing_sheet->getCellCollection();

                            foreach ($po_collection as $cell) {

                                $column = $objPHPExcel->getSheetByName('PO Testing')->getCell($cell)->getColumn();
                                // print_r($column);

                                $row = $objPHPExcel->getSheetByName('PO Testing')->getCell($cell)->getRow();

                                $data_value = $objPHPExcel->getSheetByName('PO Testing')->getCell($cell)->getValue();

                                //header will/should be in row 1 only. of course this can be modified to suit your need.
                                $arr_data[$row][$column] = $data_value;
                            }

                            if (
                                $arr_data[1]['A'] != 'S. No.' &&
                                $arr_data[1]['B'] != 'PR Number'
                                && $arr_data[1]['C'] != 'PR Date.'
                                && $arr_data[1]['D'] != 'PO Number'
                                && $arr_data[1]['E'] != 'Vendor Code'
                                && $arr_data[1]['F'] != 'Vendor Name'
                                && $arr_data[1]['G'] != 'Item Code'
                                && $arr_data[1]['H'] != 'Item Description'
                                && $arr_data[1]['I'] != 'PO Qty'
                                && $arr_data[1]['J'] != 'PO Rate'
                                && $arr_data[1]['K'] != 'PO Date'
                                && $arr_data[1]['L'] != 'PO Creation Date'
                                && $arr_data[1]['M'] != 'PO Approved Date'
                                && $arr_data[1]['N'] != 'PO Creation By'
                                && $arr_data[1]['O'] != 'Release status'
                                && $arr_data[1]['P'] != 'Authorization Status'
                                && $arr_data[1]['Q'] != 'Revision No.'
                                && $arr_data[1]['R'] != 'Status of PO'
                                && $arr_data[1]['S'] != 'PO Approval date'
                                && $arr_data[1]['T'] != 'Invoice Qty'
                                && $arr_data[1]['U'] != 'Invoice value'
                                && $arr_data[1]['V'] != 'GRN Qty'
                                && $arr_data[1]['W'] != 'Open PO Qty'
                                && $arr_data[1]['X'] != 'Any Other Important clause'
                                && $arr_data[1]['Y'] != 'PR Item.'
                                && $arr_data[1]['Z'] != 'PR Qty.'

                                && $arr_data[1]['AA'] != 'PR Date vs PO date'
                                && $arr_data[1]['AB'] != 'PR Item vs PO Item'
                                && $arr_data[1]['AC'] != 'PR qty vs PO qty'
                                && $arr_data[1]['AD'] != 'PO Qty vs Invoice Qty'
                                && $arr_data[1]['AE'] != 'PO rate vs Invoice rate'
                                && $arr_data[1]['AF'] != 'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee'
                                && $arr_data[1]['AG'] != 'Whether all POs are supported by valid PR s'
                            ) {
                                echo $responce = json_encode(array('message' => 'error Invalid coloumn Kindly upload correct format.', 'type' => 'danger'), true);
                            } else {
                                // print_r($pr_arr_data);
                                // print_r($arr_data);

                                // $a=array_merge($pr_arr_data,$arr_data);

                                // print_r($a);

                                $testresult_arr = []; //test result array
                                // valirable for test status for all the test
                                $test1pass_counter = 0;
                                $test1fail_counter = 0;

                                $test2pass_counter = 0;
                                $test2fail_counter = 0;

                                $test3pass_counter = 0;
                                $test3fail_counter = 0;

                                $test4pass_counter = 0;
                                $test4fail_counter = 0;

                                $test5pass_counter = 0;
                                $test5fail_counter = 0;

                                $test6pass_counter = 0;
                                $test6fail_counter = 0;

                                $test7pass_counter = 0;
                                $test7fail_counter = 0;



                                // test array list
                                $t1pass = [];
                                $t1fail = [];

                                $t2pass = [];
                                $t2fail = [];

                                $t3pass = [];
                                $t3fail = [];

                                $t4pass = [];
                                $t4fail = [];

                                $t5pass = [];
                                $t5fail = [];

                                $t6pass = [];
                                $t6fail = [];

                                $t7pass = [];
                                $t7fail = [];

                                for ($i = 2; $i <= count($arr_data); $i++) {
                                    // echo '<pre>';
                                    // print_r($arr_data[$i]);
                                    // test one
                                    if ($arr_data[$i]['C'] >= $arr_data[$i]['K']) {
                                        $arr_data[$i]['AA'] = '<lable class="text-success">Pass</lable>';
                                        $test1pass_counter++;
                                        $t1pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => '<label class="text-success">' . $arr_data[$i]['C'] . '</lable>',

                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' =>
                                            '<label class="text-success">' . $arr_data[$i]['K'] . '</lable>',
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t1pass, $t1pass_list);
                                    } elseif ($arr_data[$i]['C'] < $arr_data[$i]['K']) {
                                        $arr_data[$i]['AA'] = '<lable class="bg-danger text-white">Fail</lable>';
                                        $test1fail_counter++;
                                        $t1fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => '<label class="bg-danger text-white">' . $arr_data[$i]['C'] . '</lable>',
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => '<label class="bg-danger text-white">' . $arr_data[$i]['K'] . '</lable>',
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t1fail, $t1fail_list);
                                    }
                                    // Test two
                                    if ($arr_data[$i]['G'] == $arr_data[$i]['Y']) {
                                        $arr_data[$i]['AB'] ='<lable class="text-success">Pass</lable>';

                                        $arr_data[$i]['AG'] = '<lable class="text-success">Pass</lable>';
                                        $arr_data[$i]['AA'] ='';
                                        $test2pass_counter++;
                                        $t2pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => '<lable class="text-success">'.$arr_data[$i]['G'].'</lable>' ,
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => '<lable class="text-success">'.$arr_data[$i]['G'].'</lable>' ,
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t2pass, $t2pass_list);
                                    } if ($arr_data[$i]['G'] != $arr_data[$i]['Y']) {
                                        $arr_data[$i]['AB'] = '<lable class="bg-danger text-white">Fail';
                                        $arr_data[$i]['AG'] = '<lable class="bg-danger text-white">Fail';
                                        $arr_data[$i]['AA']='';
                                        $test2fail_counter++;
                                        $t2fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => '<label class="text-white bg-danger">' . $arr_data[$i]['G'] . '</lable>',
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' =>
                                            '<label class="text-white bg-danger">' . $arr_data[$i]['Y'] . '</lable>',
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => '<label class="text-danger">' . $arr_data[$i]['AB'] . '</lable>',
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => '<label class="text-danger">'.$arr_data[$i]['AF'].'</lable>',
                                            'Whether all POs are supported by valid PRs' => '<label class="bg-danger text-white">' . $arr_data[$i]['AG'] . '</lable>'


                                        );
                                        array_push($t2fail, $t2fail_list);
                                    }

                                    // Test three
                                    if ($arr_data[$i]['I'] == $arr_data[$i]['Z']) {
                                        $arr_data[$i]['AC'] = '<lable class="text-success">Pass</lable>';
                                        $arr_data[$i]['AA'] = '';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AG'] = '';
                                        $test3pass_counter++;
                                        $t3pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' =>'<lable class="text-success">'. $arr_data[$i]['I'].'</lable>',
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => '<lable class="text-success">'. $arr_data[$i]['Z'].'</label>',
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t3pass, $t3pass_list);
                                    }  else {
                                        
                                        $arr_data[$i]['AC'] = '<lable class="bg-danger text-white">Fail</labe>';
                                        $test3fail_counter++;
                                        $arr_data[$i]['AA'] = '';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AG'] = '';
                                        $t3fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => '<label class="text-white bg-danger">' . $arr_data[$i]['I'] . '</lable>',
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => '<label class="text-white bg-danger">' . $arr_data[$i]['Z'] . '</lable>',
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],

                                            'PR item vs PO item' => $arr_data[$i]['AB'],

                                            'PR qty vs PO qty' => '<label class="text-white bg-danger">' . $arr_data[$i]['AC'] . '</lable>',

                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t3fail, $t3fail_list);
                                    }
                                    // Test four

                                    if ($arr_data[$i]['I'] == $arr_data[$i]['T']) {
                                        $arr_data[$i]['AD'] = '<lable class="text-success">Pass</label>';
                                        $arr_data[$i]['AA'] = '';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AC'] = '';
                                         $arr_data[$i]['AG'] = '';
                                        $test4pass_counter++;
                                        $t4pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' =>'<lable class="text-success">'. $arr_data[$i]['I'].'</label>',
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' =>'<lable class="text-success">'. $arr_data[$i]['T'].'</lable>',
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );

                                        array_push($t4pass, $t4pass_list);
                                    } else {
                                        $test4fail_counter++;
                                        $arr_data[$i]['AD'] = '<lable class="bg-danger text-white">Fail</label>';
                                        $arr_data[$i]['AC'] ='';
                                        $arr_data[$i]['AA'] ='';
                                        $arr_data[$i]['AB'] ='';
                                        $arr_data[$i]['AG'] ='';
                                        $t4fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' =>'<lable class="bg-danger text-white">'.$arr_data[$i]['I'].'</lable>',
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => '<lable class="bg-danger text-white">'.$arr_data[$i]['T'].'</lable>',
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t4fail, $t4fail_list);
                                    }
                                    // test 5

                                    if ($arr_data[$i]['J'] == $arr_data[$i]['U']) {
                                        $arr_data[$i]['AE'] = 'Pass';
                                        $test5pass_counter++;
                                        $arr_data[$i]['AA'] = '';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AC'] = '';
                                         $arr_data[$i]['AG'] = ''; 
                                         $arr_data[$i]['AD'] = '';

                                        $t5pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );

                                        array_push($t5pass, $t5pass_list);
                                    } else {
                                        $test5fail_counter++;
                                        $arr_data[$i]['AE'] = '<lable class="bg-danger text-white">Fail</label>';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AC'] = '';
                                        $arr_data[$i]['AD'] = '';
                                        $arr_data[$i]['AA'] = '';
                                        $t5fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => '<lable class="bg-danger text-white">'.$arr_data[$i]['J'].'</lable>',
                                            'PO Date' => $arr_data[$i]['K'],
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => $arr_data[$i]['S'],
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => '<lable class="bg-danger text-white">'.$arr_data[$i]['U'].'</lable>',
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t5fail, $t5fail_list);
                                    }

                                    // Test 6
                                    if ($arr_data[$i]['K'] <= $arr_data[$i]['S']) {
                                        $arr_data[$i]['AF'] = '<lable class="text-success ">Pass</label>';
                                        $arr_data[$i]['AA'] = '';
                                        $arr_data[$i]['AB'] = '';
                                        $arr_data[$i]['AC'] = '';
                                        $arr_data[$i]['AD'] = '';
                                        $arr_data[$i]['AE'] = '';

                                        $test6pass_counter++;

                                        $t6pass_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' =>'<lable class="text-success">'.$arr_data[$i]['K'].'</label>',
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' =>'<lable class="text-success">'.$arr_data[$i]['S'].'</label>',
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );

                                        array_push($t6pass, $t6pass_list);
                                    } else {
                                        $test6fail_counter++;
                                        $arr_data[$i]['AF'] =  '<label class="text-white bg-danger">Fail</lable>';
                                        $arr_data[$i]['AA'] ='';
                                        $arr_data[$i]['AB'] ='';
                                        $arr_data[$i]['AC'] ='';
                                        $arr_data[$i]['AD'] ='';
                                        $arr_data[$i]['AE'] ='';
                                        $arr_data[$i]['AG'] ='';
                                        $t6fail_list = array(
                                            'S. No.' => $arr_data[$i]['A'],
                                            'PR Number' => $arr_data[$i]['B'],
                                            'PR Date' => $arr_data[$i]['C'],
                                            'PO Number' => $arr_data[$i]['D'],
                                            'Vendor Code' => $arr_data[$i]['E'],
                                            'Vendor Name' => $arr_data[$i]['F'],
                                            'Item Code' => $arr_data[$i]['G'],
                                            'Item Description' => $arr_data[$i]['H'],
                                            'PO Qty' => $arr_data[$i]['I'],
                                            'PO Rate' => $arr_data[$i]['J'],
                                            'PO Date' => '<label class="text-white bg-danger">'.$arr_data[$i]['K'].'</label>',
                                            'PO Creation Date' => $arr_data[$i]['L'],
                                            'PO Approved Date' => $arr_data[$i]['M'],
                                            'PO Creation By' => $arr_data[$i]['N'],
                                            'Release status' => $arr_data[$i]['O'],
                                            'Authorization Status' => $arr_data[$i]['P'],
                                            'Revision No.' => $arr_data[$i]['Q'],
                                            'Status of PO' => $arr_data[$i]['R'],
                                            'PO Approval date' => '<label class="text-white bg-danger">'. $arr_data[$i]['S'].'</label>',
                                            'Invoice Qty' => $arr_data[$i]['T'],
                                            'Invoice value' => $arr_data[$i]['U'],
                                            'GRN Qty' => $arr_data[$i]['V'],
                                            'Open PO Qty' => $arr_data[$i]['W'],
                                            'Any Other Important clause' => $arr_data[$i]['X'],
                                            'PR Item' => $arr_data[$i]['Y'],
                                            'PR Qty.' => $arr_data[$i]['Z'],
                                            'PR Date vs PO date' => $arr_data[$i]['AA'],
                                            'PR item vs PO item' => $arr_data[$i]['AB'],
                                            'PR qty vs PO qty' => $arr_data[$i]['AC'],
                                            'PO Qty vs Invoice Qty' => $arr_data[$i]['AD'],
                                            'PO rate vs Invoice rate' => $arr_data[$i]['AE'],
                                            'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee' => $arr_data[$i]['AF'],
                                            'Whether all POs are supported by valid PRs' => $arr_data[$i]['AG']

                                        );
                                        array_push($t6fail, $t6fail_list);
                                    }
                                    // Creating test array
                                    $test1 = array(
                                        'testlevel' => 'Test 1',
                                        'testname' => 'PR date vs PO Date',
                                        'testpass' => $test1pass_counter,
                                        'testfail' => $test1fail_counter,
                                        'passlist' => $t1pass,
                                        'faillist' => $t1fail
                                    );
                                    $test2 = array(
                                        'testlevel' => 'Test 2',
                                        'testname' => 'PR item vs PO item',
                                        'testpass' => $test2pass_counter,
                                        'testfail' => $test2fail_counter,
                                        'passlist' => $t2pass,
                                        'faillist' => $t2fail
                                    );
                                    $test3 = array(
                                        'testlevel' => 'Test 3',
                                        'testname' => 'PR qty vs PO qty',
                                        'testpass' => $test3pass_counter,
                                        'testfail' => $test3fail_counter,
                                        'passlist' => $t3pass,
                                        'faillist' => $t3fail
                                    );
                                    $test4 = array(
                                        'testlevel' => 'Test 4',
                                        'testname' => 'PO Qty vs Invoice Qty',
                                        'testpass' => $test4pass_counter,
                                        'testfail' => $test4fail_counter,
                                        'passlist' => $t4pass,
                                        'faillist' => $t4fail
                                    );
                                    $test5 = array(
                                        'testlevel' => 'Test 5',
                                        'testname' => 'PO rate vs Invoice rate',
                                        'testpass' => $test5pass_counter,
                                        'testfail' => $test5fail_counter,
                                        'passlist' => $t5pass,
                                        'faillist' => $t5fail
                                    );
                                    $test6 = array(
                                        'testlevel' => 'Test6',
                                        'testname' => 'Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee',
                                        'testpass' => $test6pass_counter,
                                        'testfail' => $test6fail_counter,
                                        'passlist' => $t6pass,
                                        'faillist' => $t6fail
                                    );
                                    $test7 = array(
                                        'testlevel' => 'Test 7',
                                        'testname' => "Whether all PO's are supported by valid PR's",
                                        'testpass' => $test2pass_counter,
                                        'testfail' => $test2fail_counter,
                                        'passlist' => $t2pass,
                                        'faillist' => $t2fail
                                    );
                                }
                                // die;


                                array_push($testresult_arr, $test1, $test2, $test3, $test4, $test5, $test6, $test7);

                                $this->session->set_userdata("po_test", $testresult_arr);
                                echo $responce = json_encode(array('message' => 'Success! The File successfully uploaded, Wait a moment for test result.', 'type' => 'success'), true);
                            }
                        }
                    }
                }
            }
        }
    }

    // Funtion to set temp result list in to the data base
    public function poresults()
    {
        $data['poresult'] = $_SESSION['po_test'];
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        $this->load->view('template/po-test-results', $data);
        $this->load->view('layout/footer');
    }

    // Function to show detils results

    public function poresultDetails()
    {
        // echo '<pre>';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST)) {
                $this->MainModel->trunctable('temp_data');
                $formdata = $_POST['data'];
                // print_r($formdata);die;
                $data = array(
                    'data' => $formdata
                );
                $res1 = $this->MainModel->insertInto('temp_data', $data);
                if ($res1 > 0) {
                    echo $responce = json_encode(array('message' => 'Success! Temp saved data', 'type' => 'success'), true);
                }
            }
        }
    }

    // Function to show selected result list 
    public function showresult()
    {
        $data = $this->MainModel->selectAll('temp_data');
        $result['result'] = json_decode($data[0]['data'], true);
        // print_r($result['result']);die;
        $this->load->view('layout/header');
        $this->load->view('team/team-sidebar');
        $this->load->view('template/po-test-results-details', $result);
        $this->load->view('layout/footer');
    }
}
