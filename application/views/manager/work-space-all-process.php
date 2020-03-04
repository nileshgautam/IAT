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
                    <h3 class="mb-2"><?php echo $clientName ?></h3>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Process</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header"><?php echo $workOrdername; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">Process</th>
                                        <th class="border-0">Total Sub process</th>
                                        <th class="border-0">Compalete Subprocess</th>
                                        <th class="border-0">%</th>
                                        <!-- <th class="border-0">Status</th> -->
                                        <!-- <th class="border-0">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($p_data)) {
                                        $count = 1;
                                        // print_r($clients);
                                        foreach ($p_data as $process) {
                                    ?>
                                            <tr>
                                                <td><?php echo $count++; ?>
                                                <td>
                                                    <?php echo $process['process_name']; ?>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="8">

                                            <a href="#" class="btn btn-outline-light float-right">View Details</a></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>



        <!-- ============================================================== -->
        <!-- end basic form -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- end nestable list  -->
        <!-- ============================================================== -->
    </div>
</div>


<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->