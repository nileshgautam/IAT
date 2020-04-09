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

        <div class="card table-responsive">
            <table class="table table-bordered display " id="table-process">
                <thead class="bg-light">
                    <tr class="border-1">
                        <!-- <th scope="col">#</th> -->
                        <th>Process</th>
                        <th>Subprocess</th>
                        <th>Risk</th>
                        <th>Risk level</th>
                        <th>Controls</th>
                        <th>Objective</th>
                        <th>Work Steps</th>
                        <th>Observations</th>
                        <th>Root cause</th>
                        <th>Recommendation</th>
                        <th>Management Action plan</th>
                        <th>Timeline for action plan</th>
                        <th>Responsibility for implementation</th>
                        <th>Action</th>
                        <!-- <th scope="col">Risk</th> -->
                    </tr>
                </thead>
                <tbody>

                    <?php


                    // echo $totalWorkStep;

                    // echo '<pre>';
                    //   print_r($p_data);



                    if (!empty($p_data)) {


                        // $workOrderarr = array(
                        //     'id' => $work_order,
                        //     'workOrderName' => $work_order_name
                        // );



                        $mainCount = 0;
                        $rcount = 0;
                        $ctrlCount = 0;
                        $workStepCount = 0;

                        foreach ($p_data as $process) { //for process
                            $processName = '';


                            foreach ($process['sub_process_data'] as $key => $subProcess) { //sub process
                                $subprocessName = '';

                                $riskCount = $countRow[$key];
                                // print_r($key);
                                foreach ($subProcess['risk_data'] as $subProcess_key => $risks) {
                                    $riskname = '';
                                    $risklevel = '';
                                    $rcount++;
                                    // print_r($risks);


                                    // for risk
                                    foreach ($risks['control_data'] as $risk_key => $controls) {

                                        $controlsName = '';
                                        $controlObj = '';
                                        $ctrlCount = count($risks['control_data']);

                                        // print_r($ctrlCount);
                                        // for control
                                        $workStepCount += count($controls['work_step']);
                                        $mainCount=count($controls['work_step']);
                                        print_r($mainCount);
                                        // echo '<br/>';
                                        // print_r($workStepCount);

                                        foreach ($controls['work_step'] as $ws_key => $workSteps) {
                                            // $riskCount++;
                                            $workStepName = '';


                                            if ($rcount == $ctrlCount) {
                                                $rcount = $workStepCount;
                                                $ctrlCount = $workStepCount;
                                            } else if ($rcount < $ctrlCount) {
                                                $rcount = $workStepCount;
                                                $ctrlCount = $mainCount;
                                            }


                                            // for worksteps
                    ?>
                                            <tr class="border-0">





                                                <?php if ($processName != $process['process_description']) {
                                                ?>
                                                    <td rowspan="<?php echo $totalWorkStep ?>">
                                                        <?php
                                                        $processName = $process['process_description'];
                                                        echo $processName;
                                                        ?></td>

                                                <?php } ?>
                                                <?php if ($subprocessName != $subProcess['sub_process_description']) {
                                                ?>
                                                    <td rowspan="<?php echo $rcount ?>">
                                                        <?php
                                                        echo $rcount;
                                                        $subprocessName = $subProcess['sub_process_description'];
                                                        echo $subprocessName;
                                                        ?></td>

                                                <?php } ?>



                                                <?php if ($riskname != $risks['risk_description']) {
                                                ?>
                                                    <td rowspan="<?php echo $mainCount ?>">
                                                        <?php
                                                        echo $workStepCount;
                                                        $riskname = $risks['risk_description'];
                                                        echo $riskname;
                                                        ?></td>
                                                    <td rowspan="<?php echo $mainCount ?>">
                                                        <?php
                                                        echo $rcount;
                                                        $risklevel =  $risks['risk_level'];
                                                        echo $risklevel;
                                                        ?></td>

                                                <?php } ?>

                                                <?php if ($controlsName != $controls['control_description']) {
                                                ?>
                                                    <td rowspan="<?php echo $mainCount ?>">
                                                        <?php
                                                        echo $mainCount;
                                                        $controlsName = $controls['control_description'];
                                                        echo $controlsName;
                                                        ?></td>
                                                    <td class="border-1" rowspan="<?php echo $mainCount ?>"><?php echo $controls['control_objectives']; ?></td>

                                                <?php } ?>

                                                <td class="border-1" rowspan=""><?php echo $workSteps['step_description']; ?></td>
                                            </tr>


                    <?php }
                                    }
                                                        $workStepCount=0;
                                }
                            }
                        }
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
            $('#table-process').DataTable({
                    "scrollX": true
                }

            );

        });
    </script>
    <!-- <table class="table">
   