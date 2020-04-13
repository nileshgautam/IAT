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
                            <h5 class="text-muted">Total Clients</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo  !empty($allclients)? count($allclients):'0' ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="work-order-tab" data-toggle="tab" href="#work-order" role="tab" aria-controls="work-order" aria-selected="false">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Total Work Orders</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo !empty($workOrder)? count($workOrder):'0' ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="false">
                    <div class="card ">
                        <div class="card-body">
                            <h5 class="text-muted">Users</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1 text-primary"><?php echo (!empty($Users))?count($Users):'0'?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade  show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                    <div class="card">
                        <div class="card-header">Clients
                            <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-client'); ?>"> Add Client &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a></div> 
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';
                                        // print_r($allclients);
                                        $count = 1;
                                        if (!empty($allclients)) {
                                            foreach ($allclients  as $clients) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $clients['client_name'] ?>
                                                    </td>
                                                    <td> <?php echo $clients['email'] ?></td>
                                                    <td><?php echo $clients['contact_no'] ?></td>
                                                    <td><?php echo $clients['city'] ?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('Auditapp/edit_client/') . base64_encode($clients['client_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a>
                                                        <!-- <button data-id="<?php echo base64_encode($clients['client_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order"  data-toggle="modal" data-target="#allWorkOrderModalCenter" >Projects</button> -->
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
                <div class="tab-pane fade" id="work-order" role="tabpanel" aria-labelledby="work-order-tap">
                    <div class="card">
                        <div class="card-header">Work order
                        <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-work-order'); ?>"> Add New &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                                    </div>   
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Work orders</th>
                                            <th class="border-0">Client</th>
                                            <th class="border-0">Created date</th>
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
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
                                                    echo ddmmyytt($works['created_date']);
                                                    
                                                    ?>
                                                    </td>
                                                    <td>  <a href="<?php echo base_url('AssignWorkOrder/allowcated_work_order/').base64_encode($works['client_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order">Update</a></td>
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
                <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                    <div class="card">
                        <div class="card-header"> Users
                        <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('new-user'); ?>"> Add new <i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create new user"></i></a>
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
                                            <th class="border-0">Role</th>
                                            <th class="border-0">Action</th>
                                            <!-- <th class="border-0">Status</th> -->
                                            <!-- <th class="border-0">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';
                                        // print_r($Users);
                                        $count = 1;
                                        if (!empty($Users)) {
                                            foreach ($Users  as $employee) { ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php echo $employee['first_name'].' ' .$employee['last_name']?>
                                                    </td>
                                                    <td> <?php echo $employee['email'] ?></td>
                                                    <td><?php echo $employee['phone'] ?></td>
                                                    <td><?php echo $employee['city'] ?></td>
                                                    <td><?php echo $employee['role'] ?></td>
                                                    <td> <a href="<?php echo base_url('Auditapp/edit_user/') . $employee['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a></td>

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