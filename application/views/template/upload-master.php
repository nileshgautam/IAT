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
                    <h3 class="mb-2">Manage</h3>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Manage</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">upload</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <label for=""><a  class="download-master">Download Existing Process</a></label>
            <form class="form-group" action="<?php echo base_url("MainWebsite/excel_reader"); ?>" method="POST" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="sample_file">Upload Master File</label>
                            <input id="sample_file" type="file" name="sample_file" data-parsley-trigger="change" required="" placeholder="Enter user name" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2" style="margin-top: 25px">

                        <button type="submit" class="btn btn-space btn-primary">Upload</button>

                    </div>
                </div>
            </form>



            <?php

            if ($this->session->flashdata("error")) {
            ?>
                <span class="text-danger">
                    <?php echo $this->session->flashdata("error"); ?>
                </span>
            <?php
            }
            if ($this->session->flashdata("success")) {
            ?>
                <span class="text-success">
                    <?php echo $this->session->flashdata("success"); ?>
                </span>
            <?php }

            ?>


        </div>
    </div>
</div>