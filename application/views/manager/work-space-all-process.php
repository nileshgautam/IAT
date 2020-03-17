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
                    <h3 class="mb-2"><?php echo $clientName ?> </h3>
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
                            $count = 0;
                            foreach ($p_data as $process) {
                                $totalworkstep = 0;
                                $totalCompleteWorkstep = 0;
                                
                        ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $process['process_id']; ?>">
                                        <h5 class="mb-0 ">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $process['process_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $process['process_id']; ?>">
                                                <span class="fas fa-angle-down mr-3"></span><?php echo $process['process_name']; ?>
                                            </button>
                                        </h5>
                                        <div class="progress md-0">
                                            <div id="process-progress<?php echo $count++; ?>" class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                                                <td><?php echo $subprocess['sub_process_name'] ?></td>
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
                                                    <tr>
                                                        <td colspan="5">
                                                            <h5>

                                                                <?php echo 'Total work-steps : ' . $totalworkstep ?>
                                                                <?php echo ', Complete work-steps : ' . $totalCompleteWorkstep ?>
                                                                <span class="progress-value" data-progress-id="<?php echo round($totalCompleteWorkstep * 100 / $totalworkstep) . '%' ?>"><?php echo ', Progress : ' . round($totalCompleteWorkstep * 100 / $totalworkstep) . '%';
                                                                                                                                                                                            $progressValue[] = round($totalCompleteWorkstep * 100 / $totalworkstep);
                                                                                                                                                                                            ?></span>
                                                            </h5>
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
                <input type="hidden" id="progressVal" value= "<?php echo json_encode($progressValue)?>">
            <?php
                        } ?>
                </div>
            </div>
        </div>







    </div>
</div>

<script>

</script>