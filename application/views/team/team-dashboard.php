<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Dashboard</h3>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav nav-tabs" id="myTab" role="tablist">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="clients-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Total work orders</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"></h1>
                            <h1 class="mb-1 text-primary"><?php echo (!empty($workorder)) ? count($workorder) : '0' ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="work-order-tab" data-toggle="tab" href="#work-order" role="tab" aria-controls="work-order" aria-selected="false">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Pending</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo count($workorder) ?></h1>
                            <!-- <h1 class="mb-1 text-primary"></h1>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="complete-tab" data-toggle="tab" href="#complete" role="tab" aria-controls="complete" aria-selected="false">
                <div class="card "> 
                    <div class="card-body">
                        <h5 class="text-muted"> New</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo count($workorder) ?></h1>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                <div class="card">
                    <h5 class="card-header">Total work orders</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
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
                                    <!-- <tr>
                                        <td colspan="8"><a href="#" class="btn btn-outline-light float-right">View Details</a></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="work-order" role="tabpanel" aria-labelledby="work-order-tap">
                <div class="card">
                    <div class="card-header">Assigned work orders
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Client name</th>
                                        <th class="border-0">Created date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php
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
                                        ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                <div class="card">
                    <div class="card-header">Complete work orders

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Phone No.</th>
                                        <th class="border-0">City</th>
                                        <th class="border-0">Action</th>
                                        <!-- <th class="border-0">Status</th> -->
                                        <!-- <th class="border-0">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php
                                            // echo '<pre>';
                                            // print_r($Users);
                                            $count = 1;
                                            if (!empty($Users)) {
                                                foreach ($Users  as $employee) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $employee['first_name'] . ' ' . $employee['last_name'] ?>
                                                    </td>
                                                    <td> <?php echo $employee['email'] ?></td>
                                                    <td><?php echo $employee['phone'] ?></td>
                                                    <td><?php echo $employee['city'] ?></td>
                                                    <td> <a href="<?php echo base_url('Auditapp/edit_user/') . $employee['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a></td>

                                                </tr>
                                        <?php }
                                            }
                                        ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>