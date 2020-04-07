<?php  $data= array(
            'workOrderId' =>  $workorderId,
            'subprocessid' => $subProceseid,
            'processid' => $processid,
            'controlid' =>  $controlId,
            'riskid' => $riskId,
            'serverResponce' => json_encode($workSteps)
        );
        ?>

<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Work Steps</h3>
                    <button style="margin: -43px 7px;
" class="btn btn-danger float-right restore-work-steps">Exit</button>
                    <button class="float-right btn btn-success save-work-step" style="margin: -43px 62px;
">Save</button>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Sub process</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Work Steps</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-2">

        <input type="hidden" id="control-data" value="
        <?php json_encode($data) ?> ">

            <table class="display table-responsive" id="table-work-steps">
                <thead class="bg-light">
                    <tr class="botder-0">
                        <th>#</th>
                        <th style="width: 20%">Work Steps</th>
                        <th>Observations</th>
                        <th>Root cause</th>
                        <th>Recommendation</th>
                        <th>Management Action plan</th>
                        <th>Timeline for action plan</th>
                        <th>Responsibility for implementation</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="workstep-data">
                </tbody>
            </table>
        </div>

    </div>

    <!-- Model to upload files --->

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
                        <div id="uploaded_files">
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        label {
            display: block;
            font: 1rem 'Fira Sans', sans-serif;
        }

        input,
        label {
            margin: .4rem 0;
        }
    </style>

    <script>
        $(document).ready(function() {

            let workOrderId = <?php echo $workorderId ?>;
            let subprocessid = '<?php echo $subProceseid ?>';
            let processid = '<?php echo $processid ?>';
            let controlid = '<?php echo $controlId ?>';
            let riskid = '<?php echo $riskId ?>';
            let workStepTable = $('#table-work-steps').DataTable();
            let workstepTablebody = $('#workstep-data');
            let serverResponce = <?php echo json_encode($workSteps) ?>;
            let totalRows = [];
            let uniqeId = 1;

            let rowData = hasData('rowData');
            if (rowData == false) {
                let rows = undefined;
                let form_data = {
                    workOrderId: workOrderId,
                    controlid: controlid
                };
                $.ajax({
                    type: 'GET',
                    data: form_data,
                    url: baseUrl + 'Auditapp/getSavedWorkSteps',
                    success: function(response) {
                        let rows = JSON.parse(response);
                        // console.log(rows);
                        // console.log();
                        if (rows.empty != 'false') {
                            totalRows = JSON.parse(rows.saved_data);
                            localStorage.setItem('rowData', JSON.stringify(totalRows));
                            loadTable(totalRows);
                        } else {
                            // console.log(serverResponce);
                            for (let i = 0; i < serverResponce.length; i++) {
                                let ob = {
                                    row_id: uniqeId++,
                                    work_stepsName: serverResponce[i]['step_description'],
                                    observations: '',
                                    root_cause: '',
                                    recommendation: '',
                                    management_action_plan: '',
                                    timeline_for_action_plan: '',
                                    responsibility_for_implementation: '',
                                    files: ''
                                }
                                totalRows.push(ob);
                            }
                            localStorage.setItem('rowData', JSON.stringify(totalRows));
                            loadTable(totalRows);
                        }
                    }
                });
            } else {
                totalRows = JSON.parse(localStorage.getItem('rowData'));
                // console.log(responce);
                loadTable(totalRows);
            }

            function loadTable(list) {
                let len = list.length;
                // let Sr = 1;
                workstepTablebody.empty();
                for (let i = 0; i < len; i++) {
                    let row = $(` <tr>
                        <td class="content">${list[i].row_id}</td>
                        <td class="content">${list[i].work_stepsName}</td>
                        <td contenteditable="true" class="observations">${list[i].observations}</td>
                        <td contenteditable="true" class="root-cause">${list[i].root_cause}</td>
                        <td contenteditable="true" class="recommendation">${list[i].recommendation}</td>
                        <td contenteditable="true" class="management-action-plan">${list[i].management_action_plan}</td>
                        <td><input type="date" class="timeline-for-action-plan" value="${list[i].timeline_for_action_plan}"></td>
                        <td contenteditable="true" class="responsibility-for-implementation">${list[i].responsibility_for_implementation}</td>
                        
                        <td class="files">${list[i].files}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-light uploadfile" data-toggle="modal" data-target="#viewModalCenter" data-control-id='${list[i].row_id}'> 
                            <i class="fa fa-upload"></i>
                            </button>
                        </td>
                </tr>`);
                    // appending rows 
                    workstepTablebody.append(row);


                    let uploadFile = row.find('.uploadfile');
                    uploadFile.data("id", list[i].row_id);
                    uploadFile.click(uploadFileKey);


                    let observationsText = row.find('.observations');
                    observationsText.data("id", list[i].row_id);
                    observationsText.data("item_key", 'observations');
                    observationsText.keyup(cellKeyUP);

                    let rootCause = row.find('.root-cause');
                    rootCause.data("id", list[i].row_id);
                    rootCause.data("item_key", 'root_cause');
                    rootCause.keyup(cellKeyUP);

                    let recommendation = row.find('.recommendation');
                    recommendation.data("id", list[i].row_id);
                    recommendation.data("item_key", 'recommendation');
                    recommendation.keyup(cellKeyUP);

                    let managementActionPlan = row.find('.management-action-plan');
                    managementActionPlan.data("id", list[i].row_id);
                    managementActionPlan.data("item_key", 'management_action_plan');
                    managementActionPlan.keyup(cellKeyUP);

                    let timelineForactionplan = row.find('.timeline-for-action-plan');
                    timelineForactionplan.data("id", list[i].row_id);
                    timelineForactionplan.data("item_key", 'timeline_for_action_plan');
                    timelineForactionplan.blur(onChange);

                    let responsibilityForImplementation = row.find('.responsibility-for-implementation');
                    responsibilityForImplementation.data("id", list[i].row_id);
                    responsibilityForImplementation.data("item_key", 'responsibility_for_implementation');
                    responsibilityForImplementation.keyup(cellKeyUP);

                }
            }

            function cellKeyUP() {
                let cellData = $(this);
                let Id = cellData.data('id');
                let item_key = cellData.data('item_key');
                let item = totalRows.find((item) => item.row_id == Id);
                // console.log(totalRows);
                // console.log(Id);
                // console.log(item_key);
                item[item_key] = cellData.text();
                localStorage.setItem('rowData', JSON.stringify(totalRows));
            }

            function onChange() {
                let cellData = $(this);
                let item_key = cellData.data('item_key');
                let cellData_id = cellData.data('id');
                let item = totalRows.find((item) => item.row_id == cellData_id);
                item[item_key] = cellData.val();
                localStorage.setItem('rowData', JSON.stringify(totalRows));
            }

            function uploadFileKey() {
                let cellData = $(this);
                let cellData_id = cellData.data('id');
                $('#row-id').val(cellData_id);
            }
            $('.save-work-step').on('click', function() {

                // console.log(totalRows);


                let Check = hasData('rowData');
                if (Check == true) {
                    tableData = retriveData('rowData');

                    let workstepData = JSON.parse(tableData);
                    console.log(workstepData[0].observations);

                    let data = {
                        workOrderId: workOrderId,
                        processid: processid,
                        subprocessid: subprocessid,
                        riskid: riskid,
                        controlid: controlid,
                        workstepData: workstepData
                    }

                    if (workstepData[0].observations) {
                        $.ajax({
                            type: 'POST',
                            data: data,
                            url: baseUrl + 'Auditapp/commitWorkSteps',
                            success: function(response) {
                                let message = JSON.parse(response);
                                showAlert(message['message'], message['type']);
                                removeData('rowData');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        });

                    } else {
                        showAlert('Please Fill data First', 'warning');
                    }
                }
            });

            $('#uploadfiles').submit(function(e) {
                e.preventDefault();
                let error = false;
                let files = $('#files').val();

                if (files == '') {
                    error = true;
                    showAlert('Please select file', 'danger');
                }
                // alert(files);
                if (error != true) {
                    let form_data = new FormData(this);
                    let workOrderId = $('#workorder-id').val();
                    let workstepId = $('#worksteps-id').val();
                    form_data.append("workOrderId", workOrderId);
                    form_data.append("workstepId", workstepId);
                    $.ajax({
                        method: "POST",
                        url: baseUrl + "Upload_files/Upload_file",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            // console.log(data);
                            let message = JSON.parse(data);
                            if (message['files'] != '') {
                                let filesData = message['files'];
                                let rowID = $('#row-id').val();
                                // console.log()

                                let items = totalRows.find((item) => item.row_id == rowID);
                                items['files'] = filesData[0]['file_name'];
                                localStorage.setItem('rowData', JSON.stringify(totalRows));
                                let path = `<div><a href="${baseUrl + 'upload/files/' + filesData[0]['file_name']}"> ${filesData[0]['file_name']} <a><div>`
                                $('#uploaded_files').append(path);
                                showAlert(message['msg'], message['type']);
                            }



                        }
                    });
                }

            });

        });

        // Local storage function
        function retriveData(FILE_KEY) {
            return localStorage.getItem(FILE_KEY);
        }

        function saveData(FILE_KEY, data) {
            localStorage.setItem(FILE_KEY, JSON.stringify(data));
        }

        function hasData(FILE_KEY) {
            return localStorage.hasOwnProperty(FILE_KEY) ? true : false;
            // localStorage 
        }

        function removeData(FILE_KEY) {
            localStorage.removeItem(FILE_KEY);
            // localStorage 
        }
    </script>