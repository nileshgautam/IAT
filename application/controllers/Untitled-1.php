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


    <!-- js -->
    
// $(document).ready(() => {
//     let process = $('#progressVal').val();
//     let totalsteps = $('#totalsteps').val();
//     let completeSteps = $('#completeSteps').val();
//     let value;

//     if (process != undefined || completeSteps != "" || + totalsteps != "") {
//         // console.log(process);
//         if (process != undefined) {


//             let value = JSON.parse(process);
//             let totalSteps = JSON.parse(totalsteps);
//             let compSteps = JSON.parse(completeSteps);

//             for (let i = 0; i < value.length; i++) {
//                 $(`#process-progress${i}`).css('width', `${value[i]}%`);
//                 $(`#complete-progress${i}`).text(`${value[i]}%`);
//             }
//             for (let j = 0; j < totalSteps.length; j++) {
//                 $(`#total-steps${j}`).text(`${totalSteps[j]}`);
//             }
//             for (let k = 0; k < compSteps.length; k++) {
//                 $(`#complete-steps${k}`).text(`${compSteps[k]}`);
//             }
//         }
//     }
//     // To calculate all the complete work steps
//     const totlaCard = $('.total-card').length;
//     const workOrderId = $('#work-orderid').val();
//     if (value != undefined) {
//         let completWorkorders = 0;
//         for (let progress = 0; progress < value.length; progress++) {
//             completWorkorders += parseInt(value[progress]);
//         }
//         // calculating values
//         let completeWorkOrder = completWorkorders / totlaCard;
//         $.post(baseUrl + "Auditapp/updateWorkorder", { workOrderId: workOrderId, completeWorkOrder: completeWorkOrder }, function (data, status) {
//         });
//         // console.log(completeWorkOrder);
//         // console.log(workOrderId);
//     }
//     // }

// });



<!--  -->

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
                    }
                }
                if (!is_readable($file)) {
                    echo $responce = json_encode(array('message' => 'error', "File is not readable.", 'type' => 'danger'), true);
                }

                $objPHPExcel = PHPExcel_IOFactory::load($file); //Creating file object 

                $pr_testing_sheet = $objPHPExcel->getSheetByName('PR Testing Sheet');

                $pr_testing = $pr_testing_sheet->getCellCollection();


                foreach ($pr_testing as $cellData) {

                    $column = $objPHPExcel->getSheetByName('PR Testing Sheet')->getCell($cellData)->getColumn();
                    // print_r($column);

                    $row = $objPHPExcel->getSheetByName('PR Testing Sheet')->getCell($cellData)->getRow();

                    $data_value = $objPHPExcel->getSheetByName('PR Testing Sheet')->getCell($cellData)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    $pr_arr_data[$row][$column] = $data_value;
                }
                // 
                echo '<pre>';

                // die;

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

                // print_r($pr_arr_data);
                // print_r($arr_data);

                // $a=array_merge($pr_arr_data,$arr_data);

                // print_r($a);

                for ($i = 2; $i <= count($arr_data); $i++) {
                    for ($j = 2; $j <= count($pr_arr_data); $j++) {
                        print_r('PO'. $arr_data[$i]['A']);
                        echo '<br>';
                        print_r('PR'.$pr_arr_data[$j]['A']);
                    }
                }

                die;
                $test1pass_counter = 0;
                $test1fail_counter = 0;
                $testresult_arr = [];
                $t1pass = [];
                $t1fail = [];
                // $test1 = [];
                for ($i = 2; $i <= count($arr_data); $i++) {
                    if ($arr_data[$i]['C'] < $arr_data[$i]['K']) {
                        $arr_data[$i]['Y'] = 'Pass';
                        $test1pass_counter++;
                        $t1pass_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR date vs PO Date' => $arr_data[$i]['Y'],
                            'PR item vs PO item' => $arr_data[$i]['Z']

                        );

                        array_push($t1pass, $t1pass_list);
                    } else {
                        $arr_data[$i]['Y'] = 'Fail';
                        $test1fail_counter++;
                        $t1fail_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR date vs PO Date' => $arr_data[$i]['Y'],
                            'PR item vs PO item' => $arr_data[$i]['Z']
                        );

                        array_push($t1fail, $t1fail_list);
                    }
                    
                    $test1 = array(
                        'testlevel' => 'Test 1',
                        'testname' => 'PR date vs PO Date',
                        'testpass' => $test1pass_counter,
                        'testfail' => $test1fail_counter,
                        'passlist' => $t1pass,
                        'faillist' => $t1fail
                    );
                }
                // die;
                array_push($testresult_arr, $test1);

                $this->session->set_userdata("po_test", $testresult_arr);

                echo $responce = json_encode(array('message' => 'Success! The File successfully uploaded, Wait a moment for test result.', 'type' => 'success'), true);
            }
        }
    }






    <!--  -->

    if ($arr_data[$i]['C'] < $arr_data[$i]['K']) {
                        $arr_data[$i]['AA'] = 'Pass';
                        $test1pass_counter++;
                        $t1pass_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR item vs PO item' => $arr_data[$i]['AB']

                        );
                        array_push($t1pass, $t1pass_list);
                    } elseif ($arr_data[$i]['C'] >= $arr_data[$i]['K']) {
                        $arr_data[$i]['AA'] = 'Fail';
                        $test1fail_counter++;
                        $t1fail_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR item vs PO item' => $arr_data[$i]['AB']
                        );
                        array_push($t1fail, $t1fail_list);
                    }

                    if ($arr_data[$i]['G'] == $arr_data[$i]['Y']) {
                        $arr_data[$i]['AB'] = 'Pass';
                        $test2pass_counter++;
                        $t2pass_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR item vs PO item' => $arr_data[$i]['AB']
                        );
                        array_push($t2pass, $t2pass_list);
                    }

                    if ($arr_data[$i]['G'] != $arr_data[$i]['Y']) {
                        $arr_data[$i]['AB'] = 'Fail';
                        $test2fail_counter++;
                        $t2fail_list = array(
                            'S. No.' => $arr_data[$i]['A'],
                            'PR Number' => $arr_data[$i]['B'],
                            'PR Date' => $arr_data[$i]['C'],
                            'PO Number' => $arr_data[$i]['D'],
                            'Vendor Code' => $arr_data[$i]['E'],
                            'Vendor Name' => $arr_data[$i]['F'],
                            'Item Code' => $arr_data[$i]['G'],
                            'Item Description' => $arr_data[$i]['H'],
                            'PO Qty' => $arr_data[$i]['I'],
                            'PO Date' => $arr_data[$i]['J'],
                            'PO Rate' => $arr_data[$i]['K'],
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
                            'PR item vs PO item' => $arr_data[$i]['AB']
                        );
                        array_push($t2fail, $t2fail_list);
                    }

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








    [A] => S. No.
    [B] => PR Number
    [C] => PR Date
    [D] => PO Number
    [E] => Vendor Code
    [F] => Vendor Name
    [G] => Item Code
    [H] => Item Description
    [I] => PO Qty
    [J] => PO Rate
    [K] => PO Date
    [L] => PO Creation Date
    [M] => PO Approved Date
    [N] => PO Creation By
    [O] => Release status
    [P] => Authorization Status
    [Q] => Revision No.
    [R] => Status of PO
    [S] => PO Approval date
    [T] => Invoice Qty
    [U] => Invoice value
    [V] => GRN Qty
    [W] => Open PO Qty
    [X] => Any Other Important clause
    [Y] => PR Item
    [Z] => PR Qty.

    [AA] => PR Date vs PO date
    [AB] => PR Item vs PO Item
    [AC] => PR qty vs PO qty
    [AD] => PO Qty vs Invoice Qty
    [AE] => PO rate vs Invoice rate
    [AF] => Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee
    [AG] => Whether all PO's are supported by valid PR's
    
    
    [AH] => Whether for all cancelled orders, PO are cancelled/closed in system
    [AI] => Whether any PO was altered after requisition to circumvent the approval process
    [AJ] => Whether segregation of duties exit for creation and approval of PO
    [AK] => Whether system restricts the authorized personnel to create, change, or cancel purchase orders.
    [AL] => Whether all the amendments and cancellations of POs are approved as per DOA
    [AM] => Whether any POs are split to avoid the approval from the specific authority
    [AN] => Emergency purchases and exception approval mechanism
    [AO] => Does system restricts creation of backdated POs
    [AP] => Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee
    [AQ] => Whether segregation of duties exit for creation and approval of PO
    [AR] => Whether system restricts the authorized personnel to create, change, or cancel purchase orders.



           <!-- <td><?php echo $sr++ ?></td>
                                    <td><?php echo $rowdata['PR Number'] ?></td>
                                    <td><?php echo $rowdata['PR Date'] ?></td>
                                    <td><?php echo $rowdata['PO Number'] ?></td>
                                    <td><?php echo $rowdata['Vendor Code'] ?></td>
                                    <td><?php echo $rowdata['Vendor Name'] ?></td>
                                    <td><?php echo $rowdata['Item Code'] ?></td>
                                    <td><?php echo $rowdata['Item Description'] ?></td>
                                    <td><?php echo $rowdata['PO Qty'] ?></td>
                                    <td><?php echo $rowdata['PO Date'] ?></td>
                                    <td><?php echo $rowdata['PO Rate'] ?></td>
                                    <td><?php echo $rowdata['PO Creation Date'] ?></td>
                                    <td><?php echo $rowdata['PO Approved Date'] ?></td>
                                    <td><?php echo $rowdata['PO Creation By'] ?></td>
                                    <td><?php echo $rowdata['Release status'] ?></td>
                                    <td><?php echo $rowdata['Authorization Status'] ?></td>
                                    <td><?php echo $rowdata['Revision No.'] ?></td>
                                    <td><?php echo $rowdata['Status of PO'] ?></td>
                                    <td><?php echo $rowdata['PO Approval date'] ?></td>
                                    <td><?php echo $rowdata['Invoice Qty'] ?></td>
                                    <td><?php echo $rowdata['Invoice value'] ?></td>
                                    <td><?php echo $rowdata['GRN Qty'] ?></td>
                                    <td><?php echo $rowdata['Open PO Qty'] ?></td>
                                    <td><?php echo $rowdata['Any Other Important clause'] ?></td>
                                    <td><?php echo $rowdata['PR Item'] ?></td>
                                    <td><?php echo $rowdata['PR Qty.'] ?></td>

                                    <td><?php echo $rowdata['PR Date vs PO date'] ?></td>
                                    <td><?php echo $rowdata['PR item vs PO item'] ?></td> -->
