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
                    <h3 class="mb-2">Process</h3>
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
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="accrodion-regular">
                    <div id="accordionProcess">

                        <?php
                        // echo '<pre>';
                        // print_r($p_data);
                        if (!empty($p_data)) {
                            foreach ($p_data as $process) {
                                // print_r($process);
                        ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $process['process_id'] ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $process['process_id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $process['process_id'] ?>">
                                                <span class="fas fa-angle-down mr-3"></span><?php echo $process['process_name'] ?>
                                            </button>
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
                                                                <a href="<?php echo base_url('Auditapp/workSteps/') . base64_encode($subprocess['sub_process_id']) . '/' . base64_encode($work_order) . '/' . base64_encode($process['process_id']) ?>" class="list-group-item  work_order_id">
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
                                            <!-- <p> Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p> -->
                                            <!-- <a href="#" class="btn btn-secondary">Go somewhere</a> -->
                                        </div>
                                    </div>
                                </div>
                        <?php  }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- end basic form -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- end nestable list  -->
        <!-- ============================================================== -->
    </div>
</div>
</div>

<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->