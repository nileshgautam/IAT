<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">

        <div class="card">
            <?php
                    echo '<pre>';
                    print_r($risks); ?>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Process</th>
                        <th scope="col">Sub process</th>
                        <th scope="col">Risk</th>
                        <th scope="col">Risk level</th>
                        <th scope="col">Control</th>
                        <th scope="col">Control Object</th>
                        <th scope="col">Work step</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($risks)) {
                        $countRisks = 1;
                        foreach ($risks as $risk) { ?>

                            <tr>
                                <th scope="row"><?php echo $countRisks++; ?></th>
                                <td><?php echo $risk['process_description']; ?></td>
                                <td><?php echo $risk['sub_process_description']; ?></td>
                                <td><?php echo $risk['risk_description']; ?></td>
                                <td><?php echo $risk['risk_level']; ?></td>
                                <td><?php echo $risk['control_name']; ?></td>
                                <td><?php echo $risk['ctrl_obj_name']; ?></td>
                                <td><?php echo $risk['step_description']; ?></td>
                                <!-- <td><?php echo $risk['sub_process_description']; ?></td> -->
                              
                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>