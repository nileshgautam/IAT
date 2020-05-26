<!-- /.content-wrapper -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    Users
                    <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <a class="btn btn-primary float-right btn-xs btn-space" href="<?php echo base_url('new-user'); ?>"> Add new <i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create new user"></i></a>
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
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($users)) {
                                    // print_r($users);
                                    $count = 1;
                                    foreach ($users as $user) {
                                ?>
                                        <tr>
                                            <td><?php echo $count++ ?></td>
                                            <td>
                                                <?php echo $user['first_name'] . " " . $user['last_name'] ?>
                                            </td>
                                            <td> <?php echo $user['email'] ?></td>
                                            <td> <?php echo $user['phone'] ?></td>
                                            <td class="">
                                                <a href="<?php echo base_url('Auditapp/edit_user/') . $user['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-edit" title="Edit"></i></a>
                                                <!-- <a href="<?php echo base_url('Auditapp/delete_user/') . $user['user_id']; ?>" class="btn btn-outline-primary btn-xs"> <i class="fa fa-trash text-danger" aria-hidden="true" title="Delete"></i></a> -->
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