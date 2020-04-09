<?php
$processData = [];
if (!empty($p_data)) {
    $count = 1;
    foreach ($p_data as $process) { //for process
        foreach ($process['sub_process_data'] as $key => $subProcess) { //sub process
            foreach ($subProcess['risk_data'] as $subProcess_key => $risks) {
                foreach ($risks['control_data'] as $risk_key => $controls) {
                    foreach ($controls['work_step'] as $ws_key => $workSteps) {

                        $row = array(
                            'count'=>$count++,
                            'process_id' => $process['process_id'],
                            'processName' => $process['process_description'],
                            'subprocess_id' => $subProcess['sub_process_id'],
                            'subprocess_name' => $subProcess['sub_process_description'],
                            'risk_id' => $risks['risk_id'],
                            'riskName' => $risks['risk_description'],
                            'risklevel' => $risks['risk_level'],
                            'control_id' => $controls['control_id'],
                            'controlName' => $controls['control_description'],
                            'controlobject' => $controls['control_objectives'],
                            'workstep_id' => $workSteps['work_steps_id'],
                            'workstep_name' => $workSteps['step_description'],
                            'observations'=> '',
                            'root_cause'=>'',
                            'recommendation'=>'',
                            'management_action_plan'=>'',
                            'timeline_for_action_plan'=> '',
                            'responsibility_for_implementation'=> '',
                            'files'=> ''
                        );

                        array_push($processData, $row);
                    }
                }
            }
        }
    }
}
// echo '<pre>';
// print_r($processData);


?>




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
                    <button style="margin: -43px 7px;
" class="btn btn-danger float-right restore-work-steps">Exit</button>
                    <button class="float-right btn btn-success save-work-step" style="margin: -43px 62px;
">Save</button>

                    <hr class="divider">
                </div>
            </div>
        </div>
        <!-- <?php
                echo '<pre>';
                print_r($p_data); ?> -->
        <div class="card p-2">
            <table class="table table-bordered display " id="table-process" work-order-id="<?php echo $work_order ?>" process-data='<?php echo json_encode($processData) ?>'>
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Process</th>
                        <th >Subprocess</th>
                        <th style="width:360px">Risk</th>
                        <th>Risk level</th>
                        <th style="width:360px">Controls</th>
                        <th style="width:360px">Objective</th>
                        <th style="width:360px">Work Steps</th>
                        <th style="width:360px">Observations</th>
                        <th style="width:360px">Root cause</th>
                        <th style="width:360px">Recommendation</th>
                        <th style="width:360px">Management Action plan</th>
                        <th>Timeline for action plan</th>
                        <th>Responsibility for implementation</th>
                        <th>Files</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="process-body">
                </tbody>
            </table>
            <div>
            </div>
        </div>
    </div>
</div>

<script>

$(function () {
    $('#table-process').DataTable({
        "scrollX": true,
        "scrollY": true,
        scrollY: '50vh',
        scrollCollapse: true,
        paging: false
    });

    $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
});
</script>