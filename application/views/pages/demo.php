<!--             
                    <div class="row">
                     
                      </div>
                      <!-- <h5 class="card-header drag-handle"> Work Steps </h5> -->
                      <?php if (!empty($workSteps)) {
                          // echo "<pre>";
                          // print_r($workSteps);
                          // die;
                          $count = 1;
                          foreach ($workSteps as $work_steps) {
  
                          }
  
                      ?>
  
                              <li class="dd-item" data-id="11">
                                  <div class="dd-handle"> <span class="drag-indicator"></span>
                                      <div> <?php echo $count++ . " : " . $w_steps['step_description'] ?> <?php if ($w_steps['mandatory_status'] == 'M') { ?>
                                              <span style="color:red">*</span>
                                          <?php } ?> <i class="fas fa-info-circle text-primary" style="font-size:18px; font-weight:600" title="Work Step info will be shown here"></i> </div>
                                          
                                      <div class="dd-nodrag btn-group ml-auto">
                                          <div class="btn btn-sm btn-outline-light">
                                              <input type="checkbox" data-work-order-id='<?php echo $workorder_id ?>' data-process-id="<?php echo $processId ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" data-work-steps-type='<?php echo $w_steps['mandatory_status'] ?>' data-sub-process-id='<?php echo $w_steps['sub_process_id'] ?>' <?php echo ($complete_status[0]['complete_status'] == 1) ? 'checked=true' . " disabled" : '' ?> data-check-box-id="check<?php echo $w_steps['work_steps_id'] ?>" name="check<?php echo $w_steps['work_steps_id'] ?>" class="m-2">
                                          </div>
                                      
                                          <button title="Click to see list of all uploaded files" <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id) && !empty($files[0]['file_name']) ? 'style="display:block"' : 'style="display:none"' ?> data-work-order-id="<?php echo $workorder_id ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" class="btn btn-sm btn-outline-light view-file" data-toggle="modal" data-target="#viewModalCenter">
                                              <i class="fa fa-eye"></i>
                                          </button>
                                          <!-- upload files -->
                                          <button title="Click to upload files(If any)" class="btn btn-sm btn-outline-light set-data" data-work-order-id='<?php echo $workorder_id ?>' data-process-id="<?php echo $processId ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>" data-work-steps-type='<?php echo $w_steps['mandatory_status'] ?>' data-sub-process-id='<?php echo $w_steps['sub_process_id'] ?>' data-toggle="modal" data-target="#uploadModalCenter">
                                              <i class="fa fa-tasks"></i>
                                          </button>
                                          <!-- save work steps -->
                                          <!-- <button data-checkbox-name="check<?php echo $w_steps['work_steps_id'] ?>" class="btn btn-sm btn-outline-light save-work-steps" <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id) ? 'style="display:block"' : 'style="display:none"' ?> <?php echo ($files[0]['work_step_id'] == $w_steps['work_steps_id'] && $files[0]['work_order_id'] == $workorder_id && $files[0]['complete_status'] == 1) ? 'style="display:none"' : 'style="display:block"' ?> data-workorder-id="<?php echo $workorder_id ?>" data-work-step-id="<?php echo $w_steps['work_steps_id'] ?>">
                                              <i class="fa fa-save"></i>
                                          </button> -->
                                      </div>
                                  </div>
                              </li> 
                 
                      <div style="text-align: right;padding: 10px 12px 10px 62px;">
                          <button class="btn btn-primary" style="width:100px" id="save_wSteps" title="Save Completed Work Steps">Save</button></div>
                  </div>
              </div>
          </div>
      </div> 
