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
                    <h3 class="mb-2">Work Steps</h3>
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
        <div class="row">
            <div class="card col-lg-12 mb-2">
                <!-- <h5 class="card-header drag-handle"> Risks </h5>
                <ol>
                    <?php
                    // echo '<pre>';
                    // print_r($risks);
                    if (!empty($risks)) {

                        foreach ($risks as $risk) { ?>
                            <li><?php echo $risk['risk_name']; ?></li>
                    <?php }
                    }
                    ?>
                </ol>
            <!-- </div> -->
                <div class="card col-lg-12">
                    <h5 class="card-header drag-handle"> Work Steps </h5>
                    <?php if (!empty($work_steps)) {

                        $count = 1;
                        foreach ($work_steps as $w_steps) {

                            // print_r($w_steps);
                            $files = $this->MainModel->selectAllFromWhere('files', array('work_step_id' => $w_steps['work_steps_id'], 'work_order_id' => $workorder_id));
                            //  print_r($files);
                            // echo $files[0]['work_step_id' ]."|";
                            // echo $w_steps['work_steps_id']."|";
                            // echo $files[0]['work_order_id' ]."|";
                            // echo $workorder_id;

                    ?>

                            <li class="dd-item" data-id="11">
                                <div class="dd-handle"> <span class="drag-indicator"></span>
                                    <div> <?php echo $count++ . " : " . $w_steps['steps_name'] ?> </div>
                                    <div class="dd-nodrag btn-group ml-auto">
                                        <div class="btn btn-sm btn-outline-light">
                                            <input type="checkbox" <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id &&  $files[0]['complete_status'] == 1) ? 'checked=true' : '' ?> data-check-box-id="check<?php echo $w_steps['work_steps_id'] ?>" name="check<?php echo $w_steps['work_steps_id'] ?>" class="m-2">
                                        </div>
                                        <!--  -->
                                        <button <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id) ? 'style="display:block"' : 'style="display:none"' ?> data-work-order-id="<?php echo $workorder_id ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" class="btn btn-sm btn-outline-light view-file" data-toggle="modal" data-target="#viewModalCenter">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <!-- upload files -->
                                        <button class="btn btn-sm btn-outline-light set-data" 
                                        data-work-order-id='<?php echo $workorder_id ?>' 
                                        data-process-id="<?php echo $processId ?>" 
                                        data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" data-work-steps-type='<?php echo $w_steps['mandatory_status'] ?>' data-sub-process-id='<?php echo $w_steps['sub_process_id'] ?>' data-toggle="modal" data-target="#uploadModalCenter">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                        <!-- save work steps -->
                                        <button data-checkbox-name="check<?php echo $w_steps['work_steps_id'] ?>" class="btn btn-sm btn-outline-light save-work-steps" 

                                        <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id) ? 'style="display:block"' : 'style="display:none"' ?> 

                                        <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id && $files[0]['complete_status']==1) ? 'style="display:none"' : 'style="display:block"' ?>

                                        data-workorder-id="<?php echo $workorder_id ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" >
                                            <i class="fa fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal upload files -->
    <div class="modal fade" id="uploadModalCenter" tabindex="-1" role="dialog" aria-labelledby="uploadModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalCenterLongTitle">Upload Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploaddata">
                        <input type="hidden" name="workorder-id" id="workorder-id">
                        <input type="hidden" name="process-id" id="process-id">
                        <input type="hidden" name="subprocess-id" id="subprocess-id">
                        <input type="hidden" name="filetype" id="filetyple">
                        <input type="hidden" name="worksteps-id" id="worksteps-id">
                    </form>
                    <div class="messages"></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">File</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="upload-multiple-file">
                            <tr>
                                <th scope="row">1</th>
                                <td><input id="file-name" type="text" name="file-name" class="form-control" placeholder="Enter file name" /></td>
                                <td> <input id="files" type="file" name="files" class="form-control"></td>
                                <td><textarea name="remark" id="remark" cols="" rows="" class="form-control"></textarea></td>
                                <td><button fn-name="file-name" files-name="files" remark-name="remark" class="upload-data"><i class="fa fa-upload"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"> <button style="float: right" type="button"><i class="fa fa-plus add-new float-right" title="Add New"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="reload">Close</button>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Model to view files -->

    <div class="modal fade" id="viewModalCenter" tabindex="-1" role="dialog" aria-labelledby="viewModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalCenterLongTitle">Uploaded File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-file-data">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary upload">Upload</button> -->
                    </div>

                </div>
            </div>
        </div>
    </div>