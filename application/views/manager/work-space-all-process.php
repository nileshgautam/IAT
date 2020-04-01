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
                    <h3 class="mb-2"><?php echo $clientName ?> </h3>  <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('ControlUnit/manager') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Process</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link"><?php echo $workOrdername ?></a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="section-block">

                <div class="accrodion-regular">
                    <div id="accordion">
                        <?php
                        if (!empty($p_data)) {
                            $progressValue = [];
                            $totalStepsValue = [];
                            $completeStpesValue = [];
                            $count = 0;
                            $processBar = 0;
                            $completeSteps = 0;
                            $totalSteps = 0;
                            foreach ($p_data as $process) {
                                $totalworkstep = 0;
                                $totalCompleteWorkstep = 0;

                        ?>
                                <div class="card total-card">
                                    <div class="card-header" id="heading<?php echo $process['process_id']; ?>">
                                    <h5 class="mb-0 ">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $process['process_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $process['process_id']; ?>">
                                                            <span class="fas fa-angle-down mr-3"></span><?php echo $process['process_description']; ?>
                                                        </button>
                                                    </h5>    
                                    <table class="table">
                                            <tr>
                                              
                                                   
                                                
                                                <td>Total steps : <span id="total-steps<?php echo $totalSteps++; ?>" class="badge badge-info">0</span></td>
                                                <td>Complete steps : <span id="complete-steps<?php echo $completeSteps++; ?>" class="badge badge-success">0</span></td>
                                                <td>Progress : <span id="complete-progress<?php echo $processBar++; ?>" class="badge badge-success">0%</span>

                                                    <!-- <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> -->

                                                    <div class="progress progress-sm">
                                                        <div id="process-progress<?php echo $count++; ?>" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="collapse<?php echo $process['process_id']; ?>" class="collapse show" aria-labelledby="heading<?php echo $process['process_id']; ?>" data-parent="#accordion3">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Sub process</th>
                                                        <th scope="col">Work steps</th>
                                                        <th scope="col">Complete steps</th>
                                                        <th scope="col">%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $subCount = 1;
                                                    foreach ($process['sub_process_data'] as $subprocess) {
                                                        $result = $this->MainModel->workstepCount($work_order, $subprocess['process_id'], $subprocess['sub_process_id']);
                                                        if (!empty($result)) {


                                                            // print_r($result);
                                                            // print_r($result);
                                                    ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $subCount++ ?></th>
                                                                <td><?php echo $subprocess['sub_process_description'] ?></td>
                                                                <td><?php $totalworkstep += $result[0]['totalSteps'];
                                                                    echo $result[0]['totalSteps'] ?></td>
                                                                <td><?php $totalCompleteWorkstep += $result[1]['completeSteps'];
                                                                    echo $result[1]['completeSteps'] ?></td>
                                                                <td><?php echo round($result[1]['completeSteps'] * 100 / $result[0]['totalSteps']); ?></td>

                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <?php $Workprogrss = round($totalCompleteWorkstep * 100 / $totalworkstep); ?>
                                                    <tr>
                                                      
                                               
                                                        <td colspan="5" style="padding:5px">

                                                            <?php echo '<i class="fa fa-tasks text-info" data-toggle="tooltip" data-placement="bottom" title data-original-title="Total work steps" aria-hidden="true"> <span class="p-2">:'.$totalworkstep.'</span></i>';
                                                            $totalStepsValue[] = $totalworkstep ?>

                                                            <?php echo '<i class="fas fa-check-square text-success" data-toggle="tooltip" data-placement="top" title data-original-title="complete steps"><span class="p-2">:'.$totalCompleteWorkstep.'</span></i>';
                                                            $completeStpesValue[] = $totalCompleteWorkstep; ?>
                                                            
                                                            <?php echo '<i class="fas fa-chart-line text-success

" data-toggle="tooltip" data-placement="right" title data-original-title="complete work progress"><span class="p-2">:'.$Workprogrss.'%</span></i>';
                                                            $progressValue[] = $Workprogrss;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                    </div>
                <?php }
                ?>
                <input type="hidden" id="progressVal" value="<?php echo json_encode($progressValue) ?>">
                <input type="hidden" id="totalsteps" value="<?php echo json_encode($totalStepsValue) ?>">
                <input type="hidden" id="completeSteps" value="<?php echo json_encode($completeStpesValue) ?>">
                <input type="hidden" id="work-orderid" value="<?php echo $work_order;?>">
            <?php
                        } ?>
                </div>
            </div>
        </div>

    </div>
</div>