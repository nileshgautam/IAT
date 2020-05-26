<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">

        <div class="card">
            <div class="card-header">
                To Do List
                <a class="btn btn-warning float-right back-dashboard-team btn-xs" href="<?php echo base_url('member') ?>">Back</a>
            </div>
            <div class="card-body">
                <table class="table dataTable">
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

<script>
    $('.dataTable').dataTable();
    $('.back-dashboard-team').click(function(e){

    });
</script>