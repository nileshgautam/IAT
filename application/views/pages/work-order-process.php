<?php
$processData = [];

if (!empty($p_data)) {
    $count = 1;
    foreach ($p_data as $process) { //for process
        foreach ($process['sub_process_data'] as $key => $subProcess) { //sub process
            foreach ($subProcess['risk_data'] as $subProcess_key => $risks) {
                foreach ($risks['control_data'] as $risk_key => $controls) {
                    foreach ($controls['work_step'] as $ws_key => $workSteps) {

                        $file_arr = '';

                        $file_data = $this->MainModel->selectAllFromWhere('files', array('work_order_id' => $work_order, 'work_step_id' => $workSteps['work_steps_id']));
                        // print_r($file_data);
                        $file_arr = $file_data[0]['file_name'];
                        $row = array(
                            'row_id' => $count++,
                            'process_id' => $process['process_id'],
                            'process_description' => $process['process_description'],
                            'subprocess_id' => $subProcess['sub_process_id'],
                            'sub_process_description' => $subProcess['sub_process_description'],
                            'risk_id' => $risks['risk_id'],
                            'risk_description' => $risks['risk_description'],
                            'risklevel' => $risks['risk_level'],
                            'control_id' => $controls['control_id'],
                            'control_description' => $controls['control_description'],
                            'control_objectives' => $controls['control_objectives'],
                            'workstep_id' => $workSteps['work_steps_id'],
                            'step_description' => $workSteps['step_description'],
                            'observations' => '',
                            'root_cause' => '',
                            'recommendation' => '',
                            'management_action_plan' => '',
                            'timeline_for_action_plan' => '',
                            'responsibility_for_implementation' => '',
                            'files' => (isset($file_arr)) ? $file_arr : ""
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
        <div class="card">
            <div class="card-header">
                <span id="work-order-name">
                    <?php echo ucfirst($work_order_name); ?>
                </span>
                <button class="btn btn-danger float-right  btn-xs btn-space restore-work-steps">Exit</button>
                <button class="float-right btn btn-success btn-xs btn-space save-work-step" data-client-id='<?php echo $clientId; ?>' data-client-name='<?php echo $clientName ?>'>Save</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="table-process" work-order-id="<?php echo $work_order ?>" process-data='<?php echo json_encode($processData) ?>'>
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th style="width:100px">Process</th>
                            <th style="width:376px !important;">Subprocess</th>
                            <th style="width:376px">Risk</th>
                            <th style="width:100px">Risk level</th>
                            <th style="width:350px">Controls</th>
                            <th style="width:350px">Objective</th>
                            <th style="width:350px">Work Steps</th>
                            <th style="width:350px">Observations</th>
                            <th style="width:350px">Root cause</th>
                            <th style="width:350px">Recommendation</th>
                            <th style="width:350px">Management Action plan</th>
                            <th style="width:100px">Timeline for action plan</th>
                            <th style="width:100px">Responsibility for implementation</th>
                            <th style="width:100px">Files</th>
                            <th style="width:38px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="process-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- </div> -->

<!-- upload file model -->

<div class="modal fade" id="viewModalCenter" tabindex="-1" role="dialog" aria-labelledby="viewModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" id="uploadfiles" enctype="multipart/form-data">
                    <div class="from-group col-md-4">
                        <label for="files">Choose a file:</label>
                        <input type="file" id="files" name="files" class="form-control">
                        <input type="hidden" id="row-id" name="row-id">
                        <input type="hidden" id="work-order-id" name="work-order-id" value="<?php echo $work_order ?>">

                    </div>

                    <div class="btn-upload">
                        <button type="submit" class="btn btn-success btn-xs btn-space">Upload</button>

                        <button type="button" class="btn btn-secondary btn-xs btn-space btn-refrash" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>