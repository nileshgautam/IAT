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
// let process = $('#progressVal').val();
// let totalsteps = $('#totalsteps').val();
// let completeSteps = $('#completeSteps').val();
// let value;

// if (process != undefined || completeSteps != "" || + totalsteps != "") {
// // console.log(process);
// if (process != undefined) {


// let value = JSON.parse(process);
// let totalSteps = JSON.parse(totalsteps);
// let compSteps = JSON.parse(completeSteps);

// for (let i = 0; i < value.length; i++) { // $(`#process-progress${i}`).css('width', `${value[i]}%`); // $(`#complete-progress${i}`).text(`${value[i]}%`); // } // for (let j=0; j < totalSteps.length; j++) { // $(`#total-steps${j}`).text(`${totalSteps[j]}`); // } // for (let k=0; k < compSteps.length; k++) { // $(`#complete-steps${k}`).text(`${compSteps[k]}`); // } // } // } // // To calculate all the complete work steps // const totlaCard=$('.total-card').length; // const workOrderId=$('#work-orderid').val(); // if (value !=undefined) { // let completWorkorders=0; // for (let progress=0; progress < value.length; progress++) { // completWorkorders +=parseInt(value[progress]); // } // // calculating values // let completeWorkOrder=completWorkorders / totlaCard; // $.post(baseUrl + "Auditapp/updateWorkorder" , { workOrderId: workOrderId, completeWorkOrder: completeWorkOrder }, function (data, status) { // }); // // console.log(completeWorkOrder); // // console.log(workOrderId); // } // // } // }); <!-- -->

    // reading data potinging data
    public function readingpodata()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['files'])) {
    // echo '
    <pre>';    

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






                                    <!-- admin dashboard -->


                                       <!-- <div class="nav nav-tabs" id="myTab" role="tablist">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="clients-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Total Clients</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo  !empty($allclients) ? count($allclients) : '0' ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="work-order-tab" data-toggle="tab" href="#work-order" role="tab" aria-controls="work-order" aria-selected="false">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Total Work Orders</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo !empty($workOrder) ? count($workOrder) : '0' ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="false">
                    <div class="card ">
                        <div class="card-body">
                            <h5 class="text-muted">Users</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo (!empty($Users)) ? count($Users) : '0' ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade  show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                    <div class="card">
                        <div class="card-header">Clients
                            <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-client'); ?>"> Add Client &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a></div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Phone No.</th>
                                            <th class="border-0">City</th>
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';
                                        // print_r($allclients);
                                        $count = 1;
                                        if (!empty($allclients)) {
                                            foreach ($allclients  as $clients) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $clients['client_name'] ?>
                                                    </td>
                                                    <td> <?php echo $clients['email'] ?></td>
                                                    <td><?php echo $clients['contact_no'] ?></td>
                                                    <td><?php echo $clients['city'] ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('Auditapp/edit_client/') . base64_encode($clients['client_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a>
                                                     
                                                    </td>
                                                </tr>
                                        <?php }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="work-order" role="tabpanel" aria-labelledby="work-order-tap">
                    <div class="card">
                        <div class="card-header">Work order
                            <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-work-order'); ?>"> Add New &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Work orders</th>
                                            <th class="border-0">Client</th>
                                            <th class="border-0">Created date</th>
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        // echo $workOrder[0];

                                        if (!empty($workOrder)) {
                                            foreach ($workOrder  as $works) {

                                                // echo $works;

                                        ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $works['work_order_name'] ?>
                                                    </td>
                                                    <td> <?php echo $works['client_name'] ?></td>
                                                    <td>
                                                        <?php
                                                        echo ddmmyytt($works['created_date']);

                                                        ?>
                                                    </td>
                                                    <td> <a href="<?php echo base_url('AssignWorkOrder/allowcated_work_order/') . base64_encode($works['client_id']) . '/' . base64_encode($works['work_order_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order">Update</a></td>
                                                </tr>
                                        <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                    <div class="card">
                        <div class="card-header"> Users
                            <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-user'); ?>"> Add new <i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create new user"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Phone No.</th>
                                            <th class="border-0">City</th>
                                            <th class="border-0">Role</th>
                                            <th class="border-0">Action</th>
                                            <!-- <th class="border-0">Status</th> -->
                                            <!-- <th class="border-0">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';
                                        // print_r($Users);
                                        $count = 1;
                                        if (!empty($Users)) {
                                            foreach ($Users  as $employee) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $employee['first_name'] . ' ' . $employee['last_name'] ?>
                                                    </td>
                                                    <td> <?php echo $employee['email'] ?></td>
                                                    <td><?php echo $employee['phone'] ?></td>
                                                    <td><?php echo $employee['city'] ?></td>
                                                    <td><?php echo $employee['role'] ?></td>
                                                    <td> <a href="<?php echo base_url('Auditapp/edit_user/') . $employee['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a></td>

                                                </tr>
                                        <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- new client form -->


            <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Clients</h3> <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Clients</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link"><?php echo (isset($client)) ? 'Edit Client' : ' New Client' ?></a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- <?php echo '<pre>';
                    print_r($client);
                    ?> -->
            <!-- ============================================================== -->
            <!-- basic form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"> <?php echo (isset($client)) ? 'Edit Client' : ' New Client' ?> </h5>
                    <div class="card-body">
                        <form class="client-from" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtClient">Client Name</label>
                                       
                                        <input id="txtClient" type="text" name="client-name" value="<?php echo (isset($client)) ? $client[0]['client_name'] : "" ?>" placeholder="Enter client name" autocomplete="off" class="form-control" required>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtEmail">Email address</label>
                                        
                                        <input id="txtEmail" type="email" name="email" value="<?php echo (isset($client)) ? $client[0]['email'] : "" ?>" placeholder="Enter email" autocomplete="off" class="form-control" required>
                                        <label for="txtEmail" id="errorEmail" class="text-danger"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtmobile">Mobile No.</label>
                                       
                                        <input style="-moz-appearance:textfield;" id="txtmobile" type="number" name="mobile-number" maxlength="10" value="<?php echo (isset($client)) ? $client[0]['contact_no'] : "" ?>" placeholder="Enter mobile number (Text not allowed)" autocomplete="off" class="form-control" required>
                                        <label id="errormobile" class="text-danger" for="txtmobile"></label>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputgstno">GST No.</label>
                                        <input id="inputgstno" type="text" name="gst-number" value="<?php echo (isset($client)) ? $client[0]['gst_number'] : "" ?>" placeholder="Enter GST" autocomplete="off" class="form-control" required>
                                        <label id="errorgstno" class="text-danger" for='inputgstno'></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control">

                                            <?php if (!empty($country)) {

                                                foreach ($country as $countries) { ?>
                                                    <option id='<?php echo $countries['id'] ?>' <?php if (!empty($client)) {
                                                                                                    echo ($countries['name'] ==  $client[0]['country']) ? ' selected="selected"' : '';
                                                                                                } elseif ($countries['name'] == "India") {
                                                                                                    echo "selected";
                                                                                                } ?>>

                                                        <?php echo $countries['name']; ?> </option>

                                            <?php
                                                }
                                            }
                                            ?>


                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                                            <option value="<?php echo isset($client) ? $client[0]['state'] : '' ?>"><?php echo isset($client) ? $client[0]['state'] : '' ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" autocomplete="off" class="form-control">
                                            <option value="Gurgaon"><?php echo (isset($client['city'])) ? $client[0]['city'] : 'Gurgaon' ?></option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="address">Address </label>
                                    <div class="form-group">

                                        <textarea name="address" id="" cols="60" rows="4" class='form-control'><?php echo (isset($client)) ? $client[0]['address'] : "" ?></textarea>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pin-code">Zip/Pin Code</label>
                                        <input id="pin-code" type="number" name="zip" value="<?php echo (isset($client)) ? $client[0]['pin_code'] : "" ?>" placeholder="Enter zip code" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 pl-0">
                                <p class="float-right text-right">
                                    <input type="hidden" name="client_id" id='client-id' value="<?php echo (isset($client)) ? $client[0]['client_id'] : '' ?>">
                                    <button type="submit" class="btn btn-space btn-primary">Submit</button>

                                </p>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- end form -->


            <!-- user form -->

                  <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">
                        <?php echo (isset($user)) ? 'Edit User' : ' New User' ?>
                        <a style="margin: -9px 15px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    </h5>

                    <div class="card-body">
                        <form id="user-form" method="post">
                            <input type="hidden" id="user-id" name="id" value="<?php echo (isset($user) ? $user[0]['user_id'] : '') ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputUserName">First Name</label>
                                        <input id="inputUserName" type="text" name="first-name" placeholder="Enter first name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['first_name'] : "" ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last-name">Last Name</label>
                                        <input id="last-name" type="text" name="last-name" placeholder="Enter last name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['last_name'] : "" ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input-email">Email address</label>
                                        <input id="input-user-email" type="email" name="email" placeholder="Enter email" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['email'] : "" ?>" required>
                                        <label for="user-error-email" id="user-error-email" class="text-danger"></></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="selectcountry">Country</label>
                                        <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control" data-state="<?php echo (isset($user) ? $user[0]['state'] : '') ?>">
                                            <option>Select country</option>
                                            <?php if (!empty($country)) {

                                                foreach ($country as $countries) { ?>
                                                    <option id='<?php echo $countries['id'] ?>' <?php if (!empty($user)) {
                                                                                                    echo ($countries['name'] ==  $user[0]['country']) ? ' selected="selected"' : '';
                                                                                                } elseif ($countries['name'] == "India") {
                                                                                                    echo "selected";
                                                                                                }


                                                                                                ?>>

                                                        <?php echo $countries['name']; ?> </option>


                                            <?php
                                                }
                                            }
                                            ?>


                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                                            <option id='statechiled' value="<?php echo isset($user) ? $user[0]['state'] : '' ?>"><?php echo isset($user) ? $user[0]['state'] : 'Select State' ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" autocomplete="off" class="form-control">
                                            <option value="<?php echo isset($user) ? $user[0]['city'] : '' ?>"><?php echo isset($user) ? $user[0]['city'] : 'Select State' ?></option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address </label>
                                        <input id="address" type="text" name="address" placeholder="Enter address line 1" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['address'] : "" ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address-line-two">Address line 2</label>
                                        <input id="address-line-two" type="text" name="address-line-two" placeholder="Enter address line 2" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['adress_line_two'] : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile-no">Mobile No.</label>
                                        <input id="input-user-mobile" type="number" name="mobile-no" placeholder="Enter mobile no." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['phone'] : "" ?>" required>
                                        <label for="mobile-no" id="user-error-mobile" class="text-danger"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="zip-pin-code">Zip/Pin Code</label>
                                        <input id="zip-pin-code" type="text" name="zip-pin-code" placeholder="Zip/Pin Code" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['zip_pin_code'] : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="password">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input id="password" type="password" name="password" placeholder="Enter password." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['password'] : "" ?>" required>
                                            <div class="input-group-addon">
                                                <a href='#'><i class="fa fa-eye-slash" aria-hidden="true" style="padding: 10px; border: 1px solid #d3cfcf;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Role</label>
                                        <select name="role" id="role" autocomplete="off" class="form-control">
                                            <option>Select Role</option>
                                            <?php if (!empty($role)) {
                                                foreach ($role as $user_role) {
                                            ?>
                                                    <option <?php if (isset($user)) {
                                                                echo ($user_role['role'] ==  $user[0]['role']) ? ' selected="selected"' : '';
                                                            } ?>>

                                                        <?php echo $user_role['role'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 pl-0">
                                <p class="float-right text-right">
                                    <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                </p>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic form -->
        <!-- ============================================================== -->


        <!-- team dashboard -->
        
        <div class="nav nav-tabs" id="myTab" role="tablist">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="clients-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Total work orders</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"></h1>
                            <h1 class="mb-1 text-primary"><?php echo (!empty($workorder)) ? count($workorder) : '0' ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="work-order-tab" data-toggle="tab" href="#work-order" role="tab" aria-controls="work-order" aria-selected="false">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Pending</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo count($workorder) ?></h1>
                            <!-- <h1 class="mb-1 text-primary"></h1>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="complete-tab" data-toggle="tab" href="#complete" role="tab" aria-controls="complete" aria-selected="false">
                <div class="card "> 
                    <div class="card-body">
                        <h5 class="text-muted"> New</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo count($workorder) ?></h1>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                <div class="card">
                    <h5 class="card-header">Total work orders</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Assigned Date</th>
                                        <th class="border-0">Target Date</th>
                                        <!-- <th class="border-0">Status</th> -->
                                        <th class="border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // echo '<pre>';
                                    // print_r($workorder);
                                    if (!empty($workorder)) {
                                        $count = 1;
                                        $sr = 1;
                                        foreach ($workorder as $assignedTask) {
                                            $uploadedData = $this->MainModel->selectAllFromWhere('files', array('work_order_id' => $assignedTask['work_order_id']));
                                            // echo '<pre>';
                                            // print_r($uploadedData);
                                    ?>
                                            <tr>
                                                <td><?php echo $sr++ ?></td>
                                                <td>
                                                    <?php echo ucfirst($assignedTask['work_order_name']); ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo ddmmyytt($assignedTask['assgindate']);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo ddmmyy($assignedTask['target_date']);
                                                    ?>
                                                </td>
                                                <!-- <td>
                                                    <?php echo $assignedTask['work_order_id'] ==  $uploadedData[0]['work_order_id'] ? '<span class="badge badge-info">Under Process</span>' : '<span class="badge badge-warning">New</span>' ?></td>-->
                                                <td>
                                                    <a href="<?php echo base_url('Auditapp/workprocess/') . base64_encode($assignedTask['work_order_id']) ?>" title="Click to show selected processes" class="btn btn-outline-primary btn-xs">

                                                        <?php echo $assignedTask['work_status'] == 0 ? '<i class="fa fa-tasks" title="Click to complete steps"></i>' : '' ?>

                                                    </a>



                                                </td>


                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                    <!-- <tr>
                                        <td colspan="8"><a href="#" class="btn btn-outline-light float-right">View Details</a></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="work-order" role="tabpanel" aria-labelledby="work-order-tap">
                <div class="card">
                    <div class="card-header">Assigned work orders
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Client name</th>
                                        <th class="border-0">Created date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php
                                            // echo '<pre>';
                                            // print_r($workOrder);
                                            $count = 1;
                                            if (!empty($workOrder)) {
                                                foreach ($workOrder  as $works) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $works['work_order_name'] ?>
                                                    </td>
                                                    <td> <?php echo $works['client_name'] ?></td>
                                                    <td>
                                                    <?php
                                                    $date = explode("-", $works['date']);
                                                    $d = explode(" ", $date[2]);
                                                    $yy = $date[0];
                                                    $mm = $date[1];
                                                    $dd = $d[0];
                                                    $fdate = $dd . '-' . $mm . '-' . $yy;
                                                    echo $fdate ?>
                                                    </td>
                                                </tr>
                                        <?php }
                                            }
                                        ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                <div class="card">
                    <div class="card-header">Complete work orders

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Phone No.</th>
                                        <th class="border-0">City</th>
                                        <th class="border-0">Action</th>
                                        <!-- <th class="border-0">Status</th> -->
                                        <!-- <th class="border-0">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php
                                            // echo '<pre>';
                                            // print_r($Users);
                                            $count = 1;
                                            if (!empty($Users)) {
                                                foreach ($Users  as $employee) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $employee['first_name'] . ' ' . $employee['last_name'] ?>
                                                    </td>
                                                    <td> <?php echo $employee['email'] ?></td>
                                                    <td><?php echo $employee['phone'] ?></td>
                                                    <td><?php echo $employee['city'] ?></td>
                                                    <td> <a href="<?php echo base_url('Auditapp/edit_user/') . $employee['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a></td>

                                                </tr>
                                        <?php }
                                            }
                                        ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->