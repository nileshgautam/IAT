<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Dashboard</h3>
                </div>
            </div>
        </div>
        <div class="tab-vertical">
            <ul class="nav nav-tabs" id="myTab3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="total-work-order-vertical-tab" data-toggle="tab" href="#total-work-order-vertical" role="tab" aria-controls="total-work-order" aria-selected="true">Total work Order</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="assign-works-vertical-tab" data-toggle="tab" href="#assign-works-vertical" role="tab" aria-controls="assign-works" aria-selected="false">Assigned works</a>
                </li> -->

            </ul>
            <div class="tab-content" id="myTabContent3">
                <div class="tab-pane fade show active" id="total-work-order-vertical" role="tabpanel" aria-labelledby="total-work-order-vertical-tab">
                    <h5 class="dash-h">Total work orders</h5>
                    <div class="card">
                        <h5 class="card-header">Total work orders</h5>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table dataTable">
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

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="tab-pane fade" id="assign-works-vertical" role="tabpanel" aria-labelledby="assign-works-vertical-tab">
                    <h3 class='dash-h'>Assigned work orders</h3>
                    <div class="card">
                        <div class="card-header">Assigned work orders
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Client name</th>
                                            <th class="border-0">Created date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
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
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <script>
            $('.dataTable').dataTable();
        </script>