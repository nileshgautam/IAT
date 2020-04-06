<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="">
                    <h3 class="mb-2"><?php echo $processName . '/' . $risks['sub_process_description']; ?></h3> <a style="margin: -28px 7px;
                                padding: 2px 5px;
                                            " class="btn btn-danger exit-btn-style float-right text-white" href="http://localhost/audit-app/ControlUnit/teamDashboard">Exit</a>
                    <!-- <a href="#" class="btn btn-rounded btn-danger">Danger</a> -->
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb float-right">
                        <nav aria-label="breadcrumb">
                            <!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Work order</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">New</a></li>
                            </ol> -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="card p-2">
            <table class="table border" id="table-risk">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Risk</th>
                        <th scope="col">Risk level</th>
                        <th scope="col" >Controls/ Objective</th>
                        <!-- <th scope="col">Control Object</th>
                        <th scope="col">Work step</th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($risks)) {
                        // echo '<pre>';
                        // print_r($risks); die;
                        $countRisks = 1;
                        if(!empty($risks['risk_data'])){
                        foreach ($risks['risk_data'] as $risk) {
                            $control = $this->MainModel->getControlWorkstepByid($risk['risk_id']); ?>
                            <tr class="border-1">
                                <td><?php echo $countRisks++ ?></td>
                                <td><?php echo $risk['risk_description'] ?></td>
                                <td><?php echo $risk['risk_level'] ?></td>
                                <td><?php
                                    //  echo '<pre>';
                                    // echo '<ol>';
                                    foreach ($control as $ctrl) {
                                        //    print_r($ctrl);
                                        echo '
                            
                            <div class="row" >
    <div class="col-md-6"> <li>

    <a href=' . 
    base_url('Auditapp/workSteps/') . 
    base64_encode($ctrl['risk_id']) . '/' . 
    base64_encode($ctrl['control_id']) . '/' . 
    base64_encode($risks['sub_process_id']) . '/'.
    base64_encode($risks['process_id']) . '/'.
    base64_encode( json_encode($workorderDetails, true)).' >' . 
    
    $ctrl['control_description'] . '</a>
    
    </li></div>
    <div class="col-md-6">
    <strong>  Objective:</strong> ' . $ctrl['control_objectives'] . '
    </div> </div>';
                                        // print_r($ctrl);

                                    }
                                    echo '<ol>';
                                    ?>
                                </td>
                            </tr>
                    <?php }}
                    }
                    ?>
                </tbody>
            </table>
        </div>





    </div>
</div>
<script>
    $(function() {
     let myTable  = $('#table-risk').DataTable();

        // var myTable = $('#myTable').DataTable();
 

    });
</script>