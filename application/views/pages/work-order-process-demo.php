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
                            'files' => ''
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

<style>
    #table-process {
        height: 70vh;
    }
</style>


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
                    <h3 class="mb-2"><span id="work-order-name"> <?php echo ucfirst($work_order_name); ?></span> </h3>
                    <button style="margin: -43px 7px;
" class="btn btn-danger float-right restore-work-steps">Exit</button>
                    <button class="float-right btn btn-success save-work-step" data-client-id='<?php echo $clientId;?>' data-client-name='<?php echo $clientName ?>' style="margin: -43px 62px;
">Save</button>



                    <hr class="divider">
                </div>
            </div>
        </div>
        <table class="table table-bordered table-responsive" id="table-process" work-order-id="<?php echo $work_order ?>" process-data='<?php echo json_encode($processData) ?>'>
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th style="width:100px">Process</th>
                    <th style="width:376px">Subprocess</th>
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
        <div>
        </div>
    </div>
</div>
<!-- </div> -->

<!-- upload file model -->

<div class="modal fade" id="viewModalCenter" tabindex="-1" role="dialog" aria-labelledby="viewModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body bg-gray">
                <form method="POST" id="uploadfiles" enctype="multipart/form-data">
                    <div class="from-group">
                        <label for="files">Choose a file:</label>
                        <input type="file" id="files" name="files" class="form-control">
                        <input type="hidden" id="row-id" name="row-id">
                    </div>
                    <div id="">
                    </div>uploaded_files
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
