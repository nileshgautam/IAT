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

        <div class="card">
            <!-- <?php echo '<pre>';
                    print_r($p_data); ?> -->
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Process</th>
                        <th scope="col">subprocess</th>
                        <!-- <th scope="col">Handle</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($p_data)) {
                        $processCount=1;
                        foreach ($p_data as $process) { ?>
                            <tr>
                                <th scope="row"><?php echo $processCount++?></th>
                                <td><?php echo $process['process_name'] ?></td>
                                <td>
                                    <table>
                                       <?php
                                       $subprocessCount=1;
                                        // echo '<pre>';
                                        // print_r($process['sub_process_data']);
                                        foreach ($process['sub_process_data'] as $subProcess) {
                                            // print_r($subProcess);
                                        ?>
                                            <tr>
                                               <td><a href="<?php echo base_url('Auditapp/workSteps/') . base64_encode($subProcess['sub_process_id']) . '/' . base64_encode($work_order) . '/' . base64_encode($subProcess['process_id']) ?>"><?php echo $subprocessCount++. ' : '. $subProcess['sub_process_name'] ?></a></td> 
                                            </tr>
                                        <?php }
                                        ?>
                                    </table>
                                </td>
                                <!-- <td>@mdo</td> -->
                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
            <div>


            </div>
        </div>



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
                                                <span class="fas fa-angle-down mr-3"></span><?php echo $process['process_name'] ?>
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
                                                                    <?php echo  $count++ . ' : ' . $subprocess['sub_process_name'] ?></a>

                                                                <div class="list-group-item">
                                                                    <b>Risks</b>
                                                                    <ol>
                                                                        <?php
                                                                        if (!empty($subprocess['sub_process_id'])) {
                                                                            $risk = $this->MainModel->selectAllFromWhere('risk_master', array('sub_process_id' => $subprocess['sub_process_id']));
                                                                            if (!empty($risk)) {
                                                                                foreach ($risk as $subprocessRisk) { ?>

                                                                                    <li><?php echo $subprocessRisk['risk_name'] ?></li>
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