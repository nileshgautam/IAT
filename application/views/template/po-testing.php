<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Upload PO Data</h3>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">

                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="po-messages"></div>
        <div class="card p-10">

            <a class="download-master text-success" href="<?php echo base_url('assets/sample_data/sample_podata.xlsx')?>">Download PO Report Sample CSV file</a>
            <div class="container form-container">
                <form id="potest-data" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="po-file">PO file</label>
                        <input type="file" class="form-control mb-13" id="po-data" name="files" aria-describedby="" placeholder="upload file">
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="btn btn-primary">Submit</button>

                        <button class="btn btn-warning back">Back</button>
                    </div>

                </form>

            </div>


        </div>
    </div>


</div>