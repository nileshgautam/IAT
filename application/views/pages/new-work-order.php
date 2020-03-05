<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- Head Area -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Create work order</h3> <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('ControlUnit/dashboard') ?>">Exit</a>

                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">New</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- basic form -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">
                    <?php echo (isset($workOrder)) ? 'Edit' : ' New';
                    $services = $this->MainModel->selectAll('process_master', 'process_name');
                    ?>
                </h5>
                <!-- <?php print_r($clientid);

                        ?> -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Clients">Clients</label>
                                <select name="client" id="client" placeholder="Select client" autocomplete="off" class="form-control">
                                    <option value="">Select client</option>
                                    <?php if (!empty($clients)) {
                                        foreach ($clients as $client) { ?>

                                            <option value="<?php echo isset($clientid) ? $clientid : $client['client_id']; ?>" <?php if (!empty($clientid)) {
                                                                                                                                    echo ($clientid ==  $client['client_id']) ? ' selected="selected"' : '';
                                                                                                                                } ?>>
                                                <?php echo $client['client_name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="messageclient" id="messageclient" class="text-danger"></label>
                                <!-- <input id="inputUserName" type="text" name="name" data-parsley-trigger="change" required="" placeholder="Enter user name" autocomplete="off" class="form-control"> -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="textWork-Order-Name">Work Order Name</label>
                                <input id="textWork-Order-Name" type="text" name="Work-Order-Name" placeholder="Enter work order name" autocomplete="off" class="form-control">
                                <label for="textWork-Order-Name" id="messageworkorder" class="text-danger"></label>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php $wo_id = $this->Audit_model->getNewIDorNo("WO", 'work_order'); ?>
                                <label for="textWork-Order-id">Work Order Id</label>
                                <input id="textWork-Order-id" type="text" name="Work-Order-id" value="<?php echo $wo_id ?>" readonly required autocomplete="off" class="form-control">
                                <label for="textWork-Order-id" id="messageworkorderid" class=""></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="start-date">Start Date</label>
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input type="text" id="start-date" class="form-control datetimepicker-input" data-target="#datetimepicker4">
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>                                    
                                </div>
                                <label for="start-date" id="error-start-date" class="text-danger"></label>
                            </div>
                            <!-- <div class="form-group">
                                <label for="start-date">Start Date</label>
                                <input id="start-date" type="text" class="datepicker" name="start-date" placeholder="Enter start date" autocomplete="off" required class="form-control">
                                <label for="start-date" id="error-start-date" class="text-danger"></label>
                            </div> -->
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="start-date">End Date</label>
                                <div class="input-group date" id="datetimepicker12" data-target-input="nearest">
                                    <input type="text" id="end-date" class="form-control datetimepicker-input" data-target="#datetimepicker12">
                                    <div class="input-group-append" data-target="#datetimepicker12" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <label for="start-date" id="error-end-date" class="text-danger"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 style="margin-left: 15px">Choose Processes</h5>

                <div class="row">
                    <!-- Processes Section -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div id="accordion3">
                            <?php
                            foreach ($services as $process) {
                            ?>

                                <div class="card" style="margin-bottom: 1px;">
                                    <div class="card-header" style="padding: 0.0rem 1.25rem;" id="heading<?php echo $process['id'] ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $process['id'] ?>" aria-expanded="false" aria-controls="collapseSeven">
                                                <span class="fas mr-3 fa-angle-down"></span><?php echo $process['process_name'] ?>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse<?php echo $process['id'] ?>" class="collapse" aria-labelledby="heading<?php echo $process['id'] ?>" data-parent="#accordion3">
                                        <div class="card-body" style="padding: 0.25rem 4.25rem;">
                                            <?php
                                            $subprocess = $this->MainModel->selectAllWhere('sub_process_master', array('process_id' => $process['process_id']));
                                            if (!empty($subprocess)) {
                                                foreach ($subprocess as $sbprocess) {
                                            ?>
                                                    <div class="">
                                                        <label> <input type="checkbox" name="subprocess" data-sub-id="<?php echo $sbprocess['sub_process_id'] ?>" data-process-id="<?php echo $sbprocess['process_id'] ?>" class="sub_process">&nbsp;&nbsp;&nbsp;<?php echo $sbprocess['sub_process_name']; ?></label>
                                                    </div>

                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="box box-default col-md-12 collapsed-box mb-8">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne<?php echo $process['id'] ?>">
                                                        <h5 class="ma-0 collapse_heading" data-toggle="collapse" data-target="#collapseOne<?php echo $process['id'] ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $process['id'] ?>">
                                                            <a>
                                                                <?php echo $process['process_name'] ?>
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseOne<?php echo $process['id'] ?>" class="collapse" aria-labelledby="headingOne<?php echo $process['id'] ?>" data-parent="#accordion">
                                                        <div class="card-body c_body">
                                                            <?php
                                                            $subprocess = $this->MainModel->selectAllWhere('sub_process_master', array('process_id' => $process['process_id']));
                                                            if (!empty($subprocess)) {
                                                                foreach ($subprocess as $sbprocess) {
                                                            ?>
                                                                    <div class="">
                                                                        <input type="checkbox" name="subprocess" data-sub-id="<?php echo $sbprocess['sub_process_id'] ?>" data-process-id="<?php echo $sbprocess['process_id'] ?>" class="sub_process">&nbsp;&nbsp;&nbsp;<label><?php echo $sbprocess['sub_process_name']; ?></label>
                                                                    </div>

                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div style="display:flex; justify-content: center; padding:5px 5px;">
                    <!-- <input type="hidden" id="client_id" name="client_id" value=""> -->
                    <!-- <input type="hidden" id="company_id" name="company_id" value="<?php echo $_SESSION['company_data']['company_id']; ?>"> -->
                    <button class="btn btn-primary submit-services">Apply</button>
                    <!-- <a href="<?php echo base_url('Auditapp/company') . '#' . $client_data[0]['client_name'] ?>" class="btn btn-primary" style="float:right; margin:5px;">Back</a> -->
                </div>

            </div>
        </div>
    </div>
    <!-- end basic form -->
</div>
</div>
<!-- ============================================================== -->