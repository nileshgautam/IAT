<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">

        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2"><span> <?php echo ucfirst($work_order_name); ?></span> </h3>
                    <a style="margin: -28px 7px;
                                padding: 2px 5px;
                                            " class="btn btn-danger exit-btn-style float-right text-white" href="<?php echo base_url('ControlUnit/teamDashboard') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Process</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="card ">
            <table class="table display" id="table-process">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th scope="col">#</th>
                        <th scope="col">Process</th>
                        <th scope="col">Subprocess</th>
                        <!-- <th scope="col">Risk</th> -->
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($p_data)) {
                        $workOrderarr=array(
                            'id'=>$work_order,
                            'workOrderName'=>$work_order_name
                        );

                        // echo '<pre>';
                        // print_r($p_data);die;
                        $processCount = 1;
                        foreach ($p_data as $process) { ?>
                            <tr class="border-0">
                                <th scope="row"><?php echo $processCount++ ?></th>
                                <td><?php echo $process['process_description'] ?></td>
                                <td>
                                    <?php
                                    echo '<ol>';
                                
                                    foreach ($process['sub_process_data'] as $key => $subProcess) {
                                        // echo '<pre>';
                                        $a=json_encode($subProcess, true);
                                        $data=base64_encode($a);
                                        $work=json_encode($workOrderarr,true);
                                        echo '<li><a href='.base_url('Auditapp/riskData/').$data.'/'.base64_encode($work).'>' . $subProcess['sub_process_description'] . '</a></li>';
                                    }
                                    echo '<ol>'
                                    ?>



                                </td>
                                <!-- <td>
                                    <?php foreach ($process['sub_process_data'] as $key => $subProcess) {
                                        // echo '<pre>';
                                        if(!empty($subProcess['risk_data'])){
                                        foreach($subProcess['risk_data'] as $key => $risk ){
                                            print_r($risk['risk_description']);
                                        }
                                    }
                                        
                                    } ?>
                                </td> -->

                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
            <div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#table-process').DataTable();
        });
    </script>

    <!-- <table class="table">
    <?php
    $subprocessCount = 1;

    foreach ($process['sub_process_data'] as $key => $subProcess) {

    ?>
                                            <tr>
                                                <td><a href="#"><?php echo $subprocessCount++ . ' : ' . $subProcess['sub_process_description'] ?></a></td>

                                                <td>
                                                    <?php if ($subProcess['risk_data']) {
                                                        $riskCounter = 1;

                                                        foreach ($subProcess['risk_data'] as $risk) {
                                                            if (!empty($risk)) {
                                                                // print_r($risk);

                                                                $control = $this->MainModel->selectAllFromWhere('control_master', array('risk_id' => $risk['risk_id']));

                                                                echo '<tr>
                                                    <td class="text-danger"> Risk ' . $riskCounter++ . ': ' . $risk['risk_description'] . '</td>
                                                    <td> Level: <div>' . $risk['risk_level'] . '
                                                    </div></td>';

                                                                // echo '<pre>';
                                                                // print_r($control);
                                                                if (!empty($control)) {
                                                                    $ctrlCount = 1;
                                                                    foreach ($control as $ctrl) {
                                                                        echo '<tr>';
                                                                        echo '<td> Control ' . $ctrlCount++ . ' : <a  class="text-info" href=' . base_url('Auditapp/workSteps/') .



                                                                            base64_encode($ctrl['risk_id']) .
                                                                            '/' . base64_encode($ctrl['control_id']) . '/' .
                                                                            base64_encode($subProcess['process_id']) . '/' . base64_encode($work_order) . '/' . base64_encode($subProcess['sub_process_id']) . '>'


                                                                            . $ctrl['control_description'] . '</a></td>';
                                                                        echo '<td> Objective: ' . $ctrl['control_objectives'] . '</td>';

                                                                        echo '<tr>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo '<tr><td>No risk found</td></tr>.';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>


                                        <?php

                                    }
                                        ?>
                                    </table> -->




























    <!-- <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="accrodion-regular">
                    <div id="accordionProcess">
                        <?php
                        // echo '<pre>';

                        if (!empty($p_data)) {
                            foreach ($p_data as $process) {
                                // print_r($process);
                        ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $process['process_id'] ?>" data-toggle="collapse" title="Click here, view all the subprocess." data-target="#collapse<?php echo $process['process_id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $process['process_id'] ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link">
                                                <span class="fas fa-angle-down mr-3"></span><?php echo $process['process_description'] ?>
                                            </button>
                                            <i class="fa fa-info-circle float-right text-primary" style="font-size:18px; font-weight:600" title="Click over the process view all the subprocess respectively." aria-hidden="true"></i>
                                        </h5>
                                    </div>
                                    <div id="collapse<?php echo $process['process_id'] ?>" class="collapse" aria-labelledby="heading<?php echo $process['process_id'] ?>" data-parent="#accordionProcess">
                                        <div class="card-body">
                                            <p class="lead">
                                                <div class="card">
                                                    <h5 class="card-header">Sub Process</h5>
                                                    <div class="card-body">
                                                        <?php if (!empty($process['sub_process_data'])) {
                                                            $count = 1;
                                                            foreach ($process['sub_process_data'] as $subprocess) {
                                                                // print_r($subprocess);
                                                        ?>
                                                                <a href="<?php echo base_url('Auditapp/workSteps/') . base64_encode($subprocess['sub_process_id']) . '/' . base64_encode($work_order) . '/' . base64_encode($process['process_id']) ?>" title="Click here for uploading files and completing work steps." class="list-group-item  work_order_id">
                                                                    <?php echo  $count++ . ' : ' . $subprocess['sub_process_description'] ?></a>

                                                                <div class="list-group-item">
                                                                    <b>Risks</b>
                                                                    <ol>
                                                                        <?php
                                                                        if (!empty($subprocess['sub_process_id'])) {
                                                                            $risk = $this->MainModel->selectAllFromWhere('risk_master', array('sub_process_id' => $subprocess['sub_process_id']));
                                                                            if (!empty($risk)) {
                                                                                foreach ($risk as $subprocessRisk) { ?>

                                                                                    <li><?php echo $subprocessRisk['risk_description'] ?></li>
                                                                        <?php }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <ol>
                                                                </div>
                                                        <?php }
                                                        } ?>

                                                    </div>
                                                </div>

                                            </p>
                                    <?php  }
                            }
                                    ?>
                                        </div>
                                    </div>
                                </div>

                    </div>

                </div>
            </div>
        </div> -->

    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->