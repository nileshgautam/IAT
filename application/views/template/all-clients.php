        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">Clients
                            <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
                            <a class="btn btn-primary float-right btn-space btn-xs" href="<?php echo base_url('new-client'); ?>"> Add Client &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                        </div>

                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table dataTable">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Phone No.</th>
                                            <th class="border-0">City</th>
                                            <!-- <th class="border-0">Status</th> -->
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($clients)) {
                                            $count = 1;
                                            // print_r($clients);
                                            foreach ($clients as $cilent) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++; ?>
                                                    <td>
                                                        <?php echo $cilent['client_name']; ?>
                                                    </td>
                                                    <td><?php echo $cilent['email'] ?></td>
                                                    <td><?php echo $cilent['contact_no'] ?></td>
                                                    <td><?php echo $cilent['city'] ?></td>
                                                    <!-- <td><span class="badge badge-brand">pending</span></td> -->
                                                    <td>
                                                        <a href="<?php echo base_url('Auditapp/edit_client/') . base64_encode($cilent['client_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a>
                                                        <!-- <button data-id="<?php echo base64_encode($cilent['client_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order"  data-toggle="modal" data-target="#allWorkOrderModalCenter" >Projects</button> -->
                                                    </td>
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