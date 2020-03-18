<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">


        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">To Do List</h3>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Assigned task</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">To-do-list</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Work orders</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Assigned Date</th>
                                        <th class="border-0">Target Date</th>
                                        <th class="border-0">Status</th>
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
                                                <td>
                                                    <?php echo $assignedTask['work_order_id'] ==  $uploadedData[0]['work_order_id'] ? '<span class="badge badge-info">Under Process</span>' : '<span class="badge badge-warning">New</span>' ?></td>
                                                <td><a href="<?php echo base_url('Auditapp/workprocess/') . base64_encode($assignedTask['work_order_id']) ?>" title="Click to show selected processes" class="btn btn-outline-primary btn-xs"><?php echo $assignedTask['work_status'] == 0 ? 'Start' : '' ?></td>
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
        </div>
    </div>
</div>