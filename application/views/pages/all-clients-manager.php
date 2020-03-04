        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h3 class="mb-2">Client</h3>
                            <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Client</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">All Client</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">Clients
                            <!-- <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('ControlUnit/newClientPage'); ?>"> Add Client &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a> -->
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
                                                        <!-- <a href="<?php echo base_url('Auditapp/edit_client/') . base64_encode($cilent['client_id']); ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a> -->
                                                        <button data-id="<?php echo base64_encode($cilent['client_id']); ?>" class="btn btn-outline-primary btn-xs all-work-order"  data-toggle="modal" data-target="#allWorkOrderModalCenter" >Projects</button></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                        <tr>
                                            <td colspan="8">

                                                <a href="#" class="btn btn-outline-light float-right" >View Details</a></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

 

        <!-- Modal -->
        <div class="modal fade" id="allWorkOrderModalCenter" tabindex="-1" role="dialog" aria-labelledby="allWorkOrderModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allWorkOrderModalCenterTitle"> Total Work Orders</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="all-work-order">
                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

      