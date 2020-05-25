<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="page-header">
                    <h3 class="mb-2">PO Testing Result</h3>

                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 my-10">
            <div class="container-fluid">
                <table id="result-datatable" class="table table-bordered">
                    <thead>
                        <?php
                        if (!empty($result)) {
                            $header = array_keys($result[0]);
                            // print_r($header);
                        ?>
                            <tr>
                                <?php
                                foreach ($header as $item) {
                                ?>
                                    <td><?php echo $item ?></td>
                            <?php }
                            }else{
                                ?>
                                <label for="">No data</label>  

                                <?php }
                            ?>
                            </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($result)) {
                            $sr = 1;
                            foreach ($result as $rowdata) { ?>
                                <tr>
                                    <!-- <?php
                                            echo '<pre>';
                                            print_r($rowdata); ?> -->

                                    <td><?php echo $sr++ ?></td>
                                    <td><?php echo $rowdata['PR Number'] ?></td>
                                    <td><?php echo $rowdata['PR Date'] ?></td>
                                    <td><?php echo $rowdata['PO Number'] ?></td>
                                    <td><?php echo $rowdata['Vendor Code'] ?></td>
                                    <td><?php echo $rowdata['Vendor Name'] ?></td>
                                    <td><?php echo $rowdata['Item Code'] ?></td>
                                    <td><?php echo $rowdata['Item Description'] ?></td>
                                    <td><?php echo $rowdata['PO Qty'] ?></td>
                                    <td><?php echo $rowdata['PO Rate'] ?></td>
                                    <td><?php echo $rowdata['PO Date'] ?></td>
                                    <td><?php echo $rowdata['PO Creation Date'] ?></td>
                                    <td><?php echo $rowdata['PO Approved Date'] ?></td>
                                    <td><?php echo $rowdata['PO Creation By'] ?></td>
                                    <td><?php echo $rowdata['Release status'] ?></td>
                                    <td><?php echo $rowdata['Authorization Status'] ?></td>
                                    <td><?php echo $rowdata['Revision No.'] ?></td>
                                    <td><?php echo $rowdata['Status of PO'] ?></td>
                                    <td><?php echo $rowdata['PO Approval date'] ?></td>
                                    <td><?php echo $rowdata['Invoice Qty'] ?></td>
                                    <td><?php echo $rowdata['Invoice value'] ?></td>
                                    <td><?php echo $rowdata['GRN Qty'] ?></td>
                                    <td><?php echo $rowdata['Open PO Qty'] ?></td>
                                    <td><?php echo $rowdata['Any Other Important clause'] ?></td>
                                    <td><?php echo $rowdata['PR Item'] ?></td>
                                    <td><?php echo $rowdata['PR Qty.'] ?></td>
                                    <td><?php echo $rowdata['PR Date vs PO date'] ?></td>
                                    <td><?php echo $rowdata['PR item vs PO item'] ?></td>
                                    <td><?php echo $rowdata['PR qty vs PO qty'] ?></td>
                                    <td><?php echo $rowdata['PO Qty vs Invoice Qty'] ?></td>
                                    <td><?php echo $rowdata['PO rate vs Invoice rate'] ?></td>
                                    <td><?php echo $rowdata['Whether PO is created only after entering into an agreement with vendor/approval from Purchase Committee'] ?></td>
                                    <td><?php echo $rowdata["Whether all POs are supported by valid PRs"] ?></td>


                                </tr>
                        <?php }
                        } else {
      ?>
                            <tr><td colspan="32">No Data availble</td></tr>
                            
        <?php                }?>

                    </tbody>
                </table>
                <div class="btn-flx">
                    <a class="btn btn-warning cancel-btn" href="<?php echo base_url('PoTesting/poresults') ?>">Back</a>
                </div>

            </div>

        </div>
    </div>
</div>