        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h3 class="mb-2">Work order</h3>
                            <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('ControlUnit/manager') ?>">Exit</a>
                            <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">work orders</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">All work order</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
         
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
        </div>



        <!-- 

               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">work orders
                            
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if (!empty($worksOrders)) {
                                            $count = 1;
                                            // echo '<pre>';
                                            // print_r($worksOrders);
                                            foreach ($worksOrders as $worksOrder) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++; ?>
                                                    <!-- <td><?php echo $worksOrder['client_id'] ?></td> -->
                                                    <td>
                                                       <a href="<?php echo base_url('Auditapp/workOrderprocess/').base64_encode($worksOrder['work_order_id'])?>"> <?php echo $worksOrder['work_order_name']; ?></a>
                                                    </td>
                                                
                                                    <!-- <td><?php echo $worksOrder['start_date'] ?></td>
                                                    <td><?php echo $worksOrder['end_date'] ?></td> -->
                                                    <td><span class="badge badge-brand">pending</span></td>
                                                    <td>
                                                        <!-- <a href="<?php echo base_url('Auditapp/edit_client/') .base64_encode($cilent['client_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a> 
                                                        <!-- <a href="#" class="btn btn-outline-primary btn-xs">Assign</td> 
                                                </tr>
                                        <?php }
                                        } ?>
                                        <tr>
                                            <td colspan="8">

                                                <a href="#" class="btn btn-outline-light float-right">View Details</a></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
         -->