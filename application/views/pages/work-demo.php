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
                    <h3 class="mb-2"><span> <?php echo ucfirst($work_order_name); ?></span> </h3>
                    <a style="margin: -28px 7px;
                                padding: 2px 5px;
                                            " class="btn btn-danger exit-btn-style float-right text-white" href="<?php echo base_url('ControlUnit/teamDashboard') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Process</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="card table-responsive">
            <table class="table display " id="table-process">
                <thead class="bg-light">
                    <tr class="border-0">
                        <!-- <th scope="col">#</th> -->
                        <th>Process</th>
                        <th>Subprocess</th>
                        <th>Risk</th>
                        <th>Risk level</th>
                        <th>Controls</th>
                        <th>Objective</th>
                        <th>Work Steps</th>
                        <th>Observations</th>
                        <th>Root cause</th>
                        <th>Recommendation</th>
                        <th>Management Action plan</th>
                        <th>Timeline for action plan</th>
                        <th>Responsibility for implementation</th>
                        <th>Action</th>
                        <!-- <th scope="col">Risk</th> -->
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($p_data)) {
                        $workOrderarr = array(
                            'id' => $work_order,
                            'workOrderName' => $work_order_name
                        );

                        // echo '<pre>';
                        // print_r($p_data);
                        $processCount = 1;
                        foreach ($p_data as $process) {
                            $processName = '';
                            foreach ($process['sub_process_data'] as $key => $subProcess) {
                                // foreach($subProcess['risk_data'] as $key=>$riskData){
                    ?>
                                <tr class="border-0">
                                    <?php if ($processName != $process['process_description']) {
                                    ?>
                                        <td rowspan="<?php echo count($process['sub_process_data']);?>"><?php echo
                                                            $processName = $process['process_description'];
                                                        ?></td>
                                    <?php } ?>
                                    <td><?php echo $subProcess['sub_process_description'] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php  }

                            ?>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
            <div>
            </div>
        </div>
    </div>




    <script>
        $(function() {
            $('#table-process').DataTable({"scrollX": true}
                
            );

        });
    </script>
    <!-- <table class="table">
   



