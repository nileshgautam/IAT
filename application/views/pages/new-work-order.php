<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- Head Area -->
        <!-- <div class="row"> -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
             
                    <h3 class="mb-2">New work order</h3> <a class="btn btn-danger float-right e-btn" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <hr class="mt-0">
                
            </div>
        <!-- </div> -->

        <!-- basic form -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mt-0">
                <!-- <h5 class="card-header">
                    <?php echo (isset($workOrder)) ? 'Edit' : ' New';

                    ?>
                </h5> -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
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
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="textWork-Order-Name">Work Order Name</label>
                                <input id="textWork-Order-Name" type="text" name="Work-Order-Name" placeholder="Enter work order name" autocomplete="off" class="form-control">
                                <label for="textWork-Order-Name" id="messageworkorder" class="text-danger"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php $wo_id = $this->Audit_model->getNewIDorNo("WO", 'work_order'); ?>
                                <!-- <label for="textWork-Order-id">Work Order Id</label> -->
                                <input id="textWork-Order-id" type="hidden" name="Work-Order-id" value="<?php echo $wo_id ?>" required autocomplete="off" class="form-control">
                                <!-- <label for="textWork-Order-id" id="messageworkorderid" class=""></label> -->
                                <label for="">Date (start and end date)</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" id="start-date" placeholder="Start date" set-date-format="dd/mm/yyyy" class="input-sm form-control" name="start" />

                                    <input type="text" id="end-date" placeholder="End date" class="input-sm form-control" name="end" />
                                </div>
                            </div>
                        </div>
                    </div>

                        <h5 class="heading-process">Processes</h5>
                
                    <hr class="h-line">
                    <div class="tab-outline">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <?php
                            $count = 0;
                            for ($i = 0; $i < count($processes); $i++) {
                                if ($count == 0) { ?>
                                    <li class="nav-item ">
                                        <a class="nav-link active" id="tab-outline-<?php echo $i; ?>" data-toggle="tab" href="#outline-<?php echo $i ?>" role="tab" aria-controls="tab<?php echo $i ?>" aria-selected="true"> <?php print_r($processes[$i]['process_description']); ?></a>
                                        <div class="arrow-down"></div>
                                    </li>
                                <?php  } else { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-outline-<?php echo $i; ?>" data-toggle="tab" href="#outline-<?php echo $i ?>" role="tab" aria-controls="tab<?php echo $i ?>" aria-selected="true"> <?php print_r($processes[$i]['process_description']); ?></a>
                                        <div class="arrow-down"></div>
                                    </li>
                            <?php }
                                $count++;
                            }
                            ?>

                        </ul>
                        <div class="tab-content border-0" id="myTabContent2">
                            <?php
                            $subp_count = 0;
                            $tableName = 'sub_process_master';
                            for ($i = 0; $i < count($processes); $i++) {
                                $condition = array('process_id' => $processes[$i]['process_id']);
                                $subprocess = $this->MainModel->selectAllFromWhere($tableName, $condition);
                                if ($subp_count == 0) {
                            ?>
                                    <div class="tab-pane fade show active" id="outline-<?php echo $i ?>" role="tabpanel" aria-labelledby="tab-outline-<?php echo $i ?>">
                                        <div class="row">
                                            <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <h5>Sub-Process(Option)</h5>
                                                <div class="sub-process-container ">
                                                    <ul class="subprocess-item" spid='<?php echo $processes[$i]['process_id'] ?>' id='<?php echo $processes[$i]['process_id'] ?>'>
                                                        <?php if (!empty($subprocess)) {
                                                            foreach ($subprocess as $item) {
                                                                $condition = array('sub_process_id' => $item['sub_process_id']);
                                                                $risks = $this->MainModel->selectAllWhere('risk_master', $condition);
                                                        ?>
                                                                <li class="sub-item remove-item" 
                                                                data-process-name="<?php echo $processes[$i]['process_description'] ?>"
                                                                data-toggle="tooltip" title="Single Click show risk!, Double Click select sub-process" data-risk='<?php echo json_encode($risks) ?>' data-spid=<?php echo $item['sub_process_id'] ?> data-process-id='<?php echo $item['process_id'] ?>'>
                                                                    <?php echo $item['sub_process_description'] ?>
                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class='backword-forword'>
                                                    <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-forward"></i></div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-backward"></i> </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <h5 class="">Selected Sub-Process</h5>
                                                <div class="sub-process-container">
                                                    <ul class="selected-subprocess" sspid="<?php echo $processes[$i]['process_id']; ?>">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php  } else { ?>
                                    <div class="tab-pane fade " id="outline-<?php echo $i ?>" role="tabpanel" aria-labelledby="tab-outline-<?php echo $i ?>">
                                        <div class="row">
                                            <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <h5>Sub-Process(Option)</h5>
                                                <div class="sub-process-container">
                                                    <ul class="subprocess-item select-option" spid='<?php echo $processes[$i]['process_id'] ?>'>
                                                        <?php if (!empty($subprocess)) {
                                                            foreach ($subprocess as $item) {

                                                                // print_r($item);
                                                                $condition = array('sub_process_id' => $item['sub_process_id']);
                                                                $risks = $this->MainModel->selectAllWhere('risk_master', $condition);
                                                        ?>


                                                                <li class="sub-item remove-item" 
                                                                data-process-name="<?php echo $processes[$i]['process_description'] ?>"
                                                                data-toggle="tooltip" title="Single Click show risk!, Double Click select sub-process"
                                                                data-risk='<?php echo json_encode($risks) ?>' data-spid=<?php echo $item['sub_process_id'] ?> data-process-id="<?php echo $item['process_id'] ?>">
                                                                    <?php echo $item['sub_process_description'] ?>
                                                                </li>



                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class='backword-forword'>
                                                    <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-forward"></i></div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-backward"></i> </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <h5 class="">Selected Sub-Process</h5>
                                                <div class="sub-process-container">
                                                    <ul class="selected-subprocess" sspid="<?php echo $processes[$i]['process_id']; ?>">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                <?php }
                                $subp_count++;
                            } ?>
                    </div>
                </div>

                <div id='risk-control' class="container hide">
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Risk</h5>
                            <div class='sub-process-container'>

                                <ol id="risk-container">

                                </ol>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <h5>Control</h5>
                            <div class='sub-process-container'>
                                <ol id="control-container">


                                </ol>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <h5>Control Objective</h5>
                            <div class='sub-process-container'>
                                <ol id="control-bojective-container">
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="ssubprocess-container">

                <h3>Total selected processes</h3>

                        <div class="col-md-6 sub-process-container" id="ssubp-element">

                        </div>
                    

                </div> -->


                <div class='btn-apply'>
                    <button class="btn apply btn-success submit-services">Apply</button>

                    <!-- <button type="button" class="btn apply btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Apply</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    const today = () => {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;
        return today;
    }

    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy'
    });
</script>
<!-- ============================================================== -->


<!-- modal for apply btn -->



<!-- Large modal -->




