    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h3 class="">Admin Dashboard </h3>
                    </div>
                </div>
            </div>
            <!-- new tab -->
            <div class="tab-vertical">
                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="clients-vertical-tab" data-toggle="tab" href="#clients-vertical" role="tab" aria-controls="home" aria-selected="true">Clients

                            <!-- <span class="badge badge-primary"><?php echo  !empty($allclients) ? count($allclients) : '0' ?></span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="work-orders-vertical-tab" data-toggle="tab" href="#work-orders-vertical" role="tab" aria-controls="profile" aria-selected="false">Work orders

                            <!-- <span class="badge badge-primary"><?php echo !empty($workOrder) ? count($workOrder) : '0' ?></span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="users-vertical-tab" data-toggle="tab" href="#users-vertical" role="tab" aria-controls="contact" aria-selected="false">Users
                            <!-- <span class="badge badge-primary"><?php echo !empty($Users) ? count($Users) : '0' ?></span> -->
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent3">
                    <div class="tab-pane fade active show" id="clients-vertical" role="tabpanel" aria-labelledby="Clients-vertical-tab">
                    <h3 class="dash-h">Client Administration</h3>

                        <div class="card">
                            <div class="card-header">
                                <a class="offset-11 btn btn-primary btn-xs" href="<?php echo base_url('new-client'); ?>"> Add New &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable" >
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
                    <div class="tab-pane fade" id="work-orders-vertical" role="tabpanel" aria-labelledby="work-orders-tab">
                    <h3 class="dash-h">Work-orders Administration</h3>
                        <!-- <h4>Work orders</h4> -->
                        <div class="card">
                            <div class="card-header">
                                <a class="offset-11 btn btn-primary btn-xs" href="<?php echo base_url('new-work-order'); ?>"> Add New &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable" id="">
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
                                                foreach ($workOrder  as $works) {
                                            ?>
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
                                                        <td> <a href="<?php echo base_url('AssignWorkOrder/allowcated_work_order/') . base64_encode($works['client_id']) . '/' . base64_encode($works['work_order_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order">Update</a></td>
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
                    <div class="tab-pane fade" id="users-vertical" role="tabpanel" aria-labelledby="users-vertical-tab">
                    <h3 class="dash-h">Users Administration</h3>

                        <div class="card">
                            <div class="card-header">
                                <a class="offset-11 btn btn-primary btn-xs" href="<?php echo base_url('new-user'); ?>"> Add new <i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create new user"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">#</th>
                                                <th class="border-0">Name</th>
                                                <th class="border-0">Email</th>
                                                <th class="border-0">Phone No.</th>
                                                <th class="border-0">City</th>
                                                <th class="border-0">Role</th>
                                                <th class="border-0">Action</th>

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
                                                            <?php echo $employee['first_name'] . ' ' . $employee['last_name'] ?>
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
    </div>
    
   <script>
        $('.dataTable').dataTable();
   </script>