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
                    <h3 class="mb-2">Work Steps</h3> <a style="margin: -28px 7px;
    padding: 2px 5px;
" class="btn btn-danger exit-btn-style float-right text-white" href="<?php echo base_url('ControlUnit/teamDashboard') ?>">Exit</a>
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

        <div class="card">
            <!-- <?php echo $riskId; ?> -->
        
                <table class="display table-responsive" id="table-work-steps">
                    <thead class="bg-light">
                        <tr class="botder-0">
                            <th>Work Steps</th>
                            <th>Observations</th>
                            <th>Root cause</th>
                            <th>Recommendation</th>
                            <th>Management Action plan</th>
                            <th>Timeline for action plan</th>
                            <th>Responsibility for implementation</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $workstepscount = 1;
                        foreach ($workSteps as $worksteps) {

                            $files = $this->MainModel->selectAllFromWhere('complete_work_steps', array('work_step_id' => $worksteps['work_steps_id'], 'work_order_id' => $workorderId));


                            echo '<tr>';
                            echo ' <td>' . $workstepscount++ . ' : ' . $worksteps['step_description'] . '</td>';
                            echo '<td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>';

                            echo ' <td><div>
                           <button  class="btn btn-sm btn-outline-light set-data " data-toggle="modal" data-target="#uploadModalCenter" data-work-step-id=' . $worksteps['work_steps_id'] . ' data-control-id=' . $worksteps['control_id'] . '>
                            <i class="fa fa-tasks"></i>
                        </button>
                        </div>
                            </td>';

                            echo  '</tr>';
                        }
                        ?>



                    </tbody>
                </table>
            <!-- </div> -->
        </div>



        <!-- Modal upload files -->
        <div class="modal fade" id="uploadModalCenter" tabindex="-1" role="dialog" aria-labelledby="uploadModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalCenterLongTitle">Data required</h5>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="messages"></div> -->

                        <form id="save-worksteps-data">
                            <?php
                            echo '<input type="hidden" name="workorder-id" id="workorder-id" value=' . $workorderId . '>
                            <input type="hidden" name="process-id" id="process-id" value=' . $processid . '>
                            <input type="hidden" name="subprocess-id" id="subprocess-id" value=' . $subProceseid . '>
                            <input type="hidden" name="risk-id" id="risk-id" value=' . $riskId . '>
                         
                            <input type="hidden" name="control-id" id="control-id">
                            <input type="hidden" name="worksteps-id" id="worksteps-id">';
                            ?>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observations">Observations</label>
                                    <textarea class="form-control" name="observations" id="observations" rows="1" spellcheck="false"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rootcause">Root cause</label>
                                    <textarea class="form-control" name="rootcause" id="rootcause" rows="1" spellcheck="false"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date">Timeline for action plan</label>
                                    <input type="date" id="date" name="date" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="responcibility-implementation">Responsibility for implementation</label>
                                    <input type="text" id="responcibility-implementation" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recommendation">Recommendation</label>
                                <textarea class="form-control" name="recommendation" id="recommendation" rows="1" spellcheck="false"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="management-action-plan">Management Action plan</label>
                                <textarea id="management-action-plan" name="management-action-plan" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">upload file</label>
                                <button type="button" class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#viewModalCenter"><i class="fa fa-upload"></i></button>
                            </div>
                            <div id="uploaded_files">

                            </div>

                            <div class="modal-footer">
                                <div class="form-group float-right">
                                    <button type="button" class="btn btn-secondary" id="reload">Close</button>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <!-- Model to view files --->

        <div class="modal fade" id="viewModalCenter" tabindex="-1" role="dialog" aria-labelledby="viewModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body bg-gray">
                        <form method="POST" id="uploadfiles" enctype="multipart/form-data">
                            <div class="from-group">
                                <label for="files">Choose a file:</label>
                                <input type="file" id="files" name="files" class="form-control">
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
    <!-- <style>
            .upload-btn-wrapper {
                position: relative;
                overflow: hidden;
                display: inline-block;
            }

            .btn-upload {
                border: 2px solid gray;
                color: gray;
                background-color: white;
                padding: 8px 22px;
                /* border-radius: 8px; */
                font-size: 11px;
                font-weight: bold;
            }

            .upload-btn-wrapper input[type=file] {
                font-size: 100px;
                position: absolute;
                left: 0;
                top: 0;
                opacity: 0;
            }
        </style> -->

    <script>
        $(document).ready(function() {
            $('#table-work-steps').DataTable();
        });
    </script>