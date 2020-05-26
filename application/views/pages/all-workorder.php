        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">work orders
                            <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
                            <a class="btn btn-primary float-right btn-space btn-xs" href="<?php echo base_url('new-work-order'); ?>"> Add New &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Client</th>
                                            <th class="border-0">Start date</th>
                                            <th class="border-0">End Date</th>
                                            <!-- <th class="border-0">Status</th> -->
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';
                                        if (!empty($worksOrders)) {
                                            $count = 1;
                                            // print_r($worksOrders);
                                            foreach ($worksOrders as $worksOrder) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++; ?>
                                                    <td>
                                                        <?php echo $worksOrder['work_order_name']; ?>
                                                    </td>
                                                    <td><?php echo $worksOrder['client_name'] ?></td>
                                                    <td>
                                                        <?php echo ddmmyy($worksOrder['start_date']);

                                                        ?>
                                                    </td>
                                                    <td><?php echo ddmmyy($worksOrder['end_date']); ?></td>

                                                    <td><a href="<?php echo base_url('AssignWorkOrder/allowcated_work_order/') . base64_encode($worksOrder['client_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order">Update</a></td>

                                                </tr>
                                        <?php }
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            $('.dataTable').dataTable();
        </script>