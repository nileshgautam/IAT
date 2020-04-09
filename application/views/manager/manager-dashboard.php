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

<!-- <?php echo'<pre>';  
print_r($completeSteps)?> -->

        <div class="nav nav-tabs" id="myTab" role="tablist">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="clients-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Total work orders</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo  !empty($workOrders) ? count($workOrders) : '0' ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="work-order-tab" data-toggle="tab" href="#work-order" role="tab" aria-controls="work-order" aria-selected="false">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Total Work Orders</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo !empty($workorders[0]['total']) ? $workorders[0]['total'] : '0' ?></h1>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="complete-workorder-tab" data-toggle="tab" href="#complete-workorder" role="tab" aria-controls="complete-workorder" aria-selected="false">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="text-muted">Complete work orders</h5>
                        <div class="metric-value d-inline-block">
                            <h1 class="mb-1 text-primary"><?php echo  !empty($workOrder) ? count($workOrder) : '0' ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                <div class="card">
                    <h5 class="card-header">All Work orders
                    </h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Clinets</th>
                                        <th class="border-0">Work orders</th>
                                        <th class="border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // echo '<pre>';
                                    // print_r($workOrders);
                                    $count = 1;
                                    if (!empty($workOrders)) {
                                        foreach ($workOrders  as $workorder) { ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td>
                                                    <?php echo $workorder['client_name'] ?>
                                                </td>
                                                <td> <?php echo $workorder['work_order_name'] ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('Auditapp/workOrderprocess/') . base64_encode($workorder['work_order_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-tasks" title="Check progress"></i></a>

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
            </div>
       
            <div class="tab-pane fade" id="complete-workorder" role="tabpanel" aria-labelledby="complete-workorder-tab">
                <div class="card">
                    <h5 class="card-header"> Complete

                    </h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Clinets</th>
                                        <th class="border-0">Work orders</th>
                                        <th class="border-0">Complete status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // // echo '<pre>';
                                    // print_r($workOrder);
                                    $count = 1;
                                    if (!empty($workOrder)) {
                                        foreach ($workOrder  as $completeWork) { ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td>
                                                    <?php echo $completeWork['client_name'] ?>
                                                </td>
                                                <td> <?php echo $completeWork['work_order_name'] ?></td>
                                                <td> <?php echo $completeWork['complete_status']. '% <div class="progress progress-sm">
                                                        <div id="process-progress<?php echo $count++; ?>" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:'.$completeWork['complete_status'].'%"></div>
                                                    </div>' ?></td>
                                           
                                            </tr>
                                    <?php }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>