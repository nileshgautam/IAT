<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- Head Area -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="">
                    <h3 class="mb-2">New work order</h3> <a style="margin: -45px 20px;
" class="btn btn-rounded btn-danger float-right" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <!-- <a href="#" class="btn btn-rounded btn-danger">Danger</a> -->
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb float-right">
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
                <!-- <h5 class="card-header">
                    <?php echo (isset($workOrder)) ? 'Edit' : ' New';

                    ?>
                </h5> -->

                <div class="card-body">


                    <div class="row">

                        <div class="col-md-4">


                            <div class="form-group">
                                <label for="Clients">Clients</label>
                                <select name="client" id="client" placeholder="Select client" autocomplete="off" class="form-control bootstrap-select dropup">
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
                            <label for="date"> Set Date</label>

                            <div class="input-group">
                                <i id="date" class="far fa-calendar-alt text-lg" style="font-size: 2.2rem;
                                    margin: 0px 94px;"></i>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <label for="">Start Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id='start-date' name="start-date" readonly />

                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="">Target Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id='end-date' name="end-date" readonly />
                            </div>
                        </div>


                    </div>

                    <hr>
                    <div class="row my-2">
                        <h5 style="margin-left: 15px">Select Processes</h5>
                        <!-- 
                        
                        Processes Section -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div id="accordion3">
                                <?php
                                $processes = $this->MainModel->selectAll('process_master', 'process_description');
                                foreach ($processes as $process) {
                                ?>
                                    <div class="card" style="margin-bottom: 1px;">
                                        <div class="card-header" style="padding: 0.0rem 1.25rem;" id="heading<?php echo $process['id'] ?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $process['id'] ?>" aria-expanded="false" aria-controls="collapseSeven">
                                                    <span class="fas mr-3 fa-angle-down"></span><?php echo $process['process_description'] ?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo $process['id'] ?>" class="collapse show" aria-labelledby="heading<?php echo $process['id'] ?>" data-parent="#accordion3">
                                            <div class="card-body" style="padding: 0.25rem 4.25rem;">
                                                <?php
                                                $subprocess = $this->MainModel->selectAllWhere('sub_process_master', array('process_id' => $process['process_id']));
                                                if (!empty($subprocess)) {

                                                    foreach ($subprocess as $sbprocess) {
                                                        $condition = array('sub_process_id' => $sbprocess['sub_process_id']);
                                                        $risks = $this->MainModel->selectAllWhere('risk_master', $condition);
                                                        $risks_level = $this->MainModel->selectAll('status');



                                                        // $risks = $this->MainModel->getRiskbyId($sbprocess['sub_process_id']);
                                                ?>


                                                        <!-- <div class="card"> -->
                                                            <!-- <h5 class="card-header"> -->
                                                                <div class="">
                                                                    <label> <input type="checkbox" name="subprocess" data-risk-id=<?php echo json_encode($risks)?> data-sub-id="<?php echo $sbprocess['sub_process_id'] ?>" data-process-id="<?php echo $sbprocess['process_id'] ?>" class="sub_process">&nbsp;&nbsp;&nbsp;<?php echo $sbprocess['sub_process_description']; ?></label>
                                                                </div>
                                                            </h5>
                                                            <div class="card-body">


                                                                <?php if (!empty($risks)) {
                                                                    // echo '<pre>';
                                                                    // print_r($risks);
                                                                    // die;
                                                                ?>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th scope="col">#</th> -->
                                                                                <th scope="col">Risk</th>
                                                                                <th scope="col">Risk level</th>
                                                                             
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                            $risk_count=1;
                                                                            foreach ($risks as $risk) {
                                                                            ?>
                                                                                <tr>
                                                                                   
                                                                                    <td><?php echo $risk_count++. ' : ' .$risk['risk_description'] ?></td>
                                                                                  


                                                                                    <td>
                                                                                        
                                                                                    <!-- <select data-process-id="<?php echo $sbprocess['process_id'] ?>" data-sub-proecss-id="<?php echo $risk['sub_process_id']; ?>" data-risk-id="<?php echo $risk['risk_id'] ?>" name="risk-level"> -->

                                                                                    <select data-risk-id="<?php echo $risk['risk_id']?>"
                                                                                    class="set-risk-level" data-risk-subprocess-id=<?php echo $sbprocess['sub_process_id']?>
                                                                                        <?php foreach($risks_level as $rl){?>>
                                                                                            <option value="<?php echo $rl['status']?>" <?php echo ($risk['risk_level'] == $rl['status'])?'selected':''?>><?php echo $rl['status'];?></option>
                                                                                        <?php }?>
                                                                                        </select></td>
                                                            
                                                                                </tr>
                                                                        <?php }
                                                                        } else echo "<div class='' style='margin:%'>No risk.</div>"; ?>
                                                                        </tbody>
                                                                    </table>
                                                            </div>
                                                        <!-- </div> -->


                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                    <div style="display:flex; justify-content: center; padding:5px 5px;">
                        <button class="btn btn-rounded btn-primary submit-services">Apply</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- end basic form -->
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



    $(function() {
        $('#start-date').val(today);
        $('#end-date').val(today);
        $('#date').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            const start_date = start.format('DD-MM-YYYY');
            const end_date = end.format('DD-MM-YYYY');
            $('#start-date').val(start_date);
            $('#end-date').val(end_date);
        });

    });
</script>
<!-- ============================================================== -->