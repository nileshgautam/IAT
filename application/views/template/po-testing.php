<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container dashboard-content">

        <div class="card">
            <div class="card-header">
                Upload PO Data
                <a class="download-master text-success float-right" title="Download PO data Sample/format file" data-toggle="tooltip" href="<?php echo base_url('assets/sample_data/sample_podata.xlsx') ?>">
               <span>Download sample file for PO test</span> <i class="fas fa-download"></i>
            </a>

            </div>
            <div class="card-body">
                <div class="po-messages"></div>

                   
                    <div class="container form-container">
                        <form id="potest-data" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="po-file"> Choose PO file</label>
                                <input type="file" class="form-control mb-13" id="po-data" name="files" aria-describedby="" placeholder="upload file">
                            </div>
                            <div class="form-btn">
                                <button type="submit" class="btn btn-primary btn-space btn-xs">Submit</button>
                                <button class="btn btn-warning back btn-space  btn-xs">Back</button>
                            </div>

                        </form>



                </div>
            </div>
        </div>




    </div>


</div>