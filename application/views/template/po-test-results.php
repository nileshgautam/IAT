<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">PO Testing Result</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- <div class="row"> -->
            <?php
            // echo '<pre>';
            // print_r($poresult);
            if (!empty($poresult)) {
                foreach ($poresult as $testresult) { ?>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header mh-121">
                                <!-- <h5> <?php echo $testresult['testlevel']; ?></h5> -->
                                <h4><?php echo $testresult['testname']; ?></h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-success sapce-even">
                                    <span class="card-text text-success f-18"> Pass: <?php echo $testresult['testpass']; ?></span>
                                <span>
                                    <a href="#" class=" show-pass-list f-18" data-pass='<?php echo json_encode($testresult['passlist'], true) ?>' data-toggle="tooltip" title="Show pass list!"><i class="fas fa-eye text-success"></i></a></span>
                                    <span class="card-text text-danger f-18">Fail: <?php echo $testresult['testfail']; ?>
                                    </span>
                                <span>
                                    <a href="#" data-toggle="tooltip" title="Show Fail list!" class=" show-fail-list" data-fail='<?php echo json_encode($testresult['faillist'], true) ?>'><i class="fas fa-eye text-danger f-18"></i></a></span>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <!-- </div> -->
    </div>
</div>
</div>