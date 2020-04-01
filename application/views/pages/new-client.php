<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

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
                    <h3 class="mb-2">Clients</h3> <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Clients</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link"><?php echo (isset($client)) ? 'Edit Client' : ' New Client' ?></a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- <?php echo '<pre>';
                    print_r($client);
                    ?> -->
            <!-- ============================================================== -->
            <!-- basic form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"> <?php echo (isset($client)) ? 'Edit Client' : ' New Client' ?> </h5>
                    <div class="card-body">
                        <form class="client-from" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtClient">Client Name</label>
                                        <input id="txtClient" type="text" name="client-name" value="<?php echo (isset($client)) ? $client[0]['client_name'] : "" ?>" placeholder="Enter client name" autocomplete="off" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtEmail">Email address</label>
                                        <input id="txtEmail" type="email" name="email" value="<?php echo (isset($client)) ? $client[0]['email'] : "" ?>" placeholder="Enter email" autocomplete="off" class="form-control" required>
                                        <label for="txtEmail" id="errorEmail" class="text-danger"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtmobile">Mobile No.</label>
                                        <input style="-moz-appearance:textfield;" id="txtmobile" type="number" name="mobile-number" maxlength="10" value="<?php echo (isset($client)) ? $client[0]['contact_no'] : "" ?>" placeholder="Enter mobile number (Text not allowed)" autocomplete="off" class="form-control" required>
                                        <label id="errormobile" class="text-danger" for="txtmobile"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputgstno">GST No.</label>
                                        <input id="inputgstno" type="text" name="gst-number" value="<?php echo (isset($client)) ? $client[0]['gst_number'] : "" ?>" placeholder="Enter GST" autocomplete="off" class="form-control" required>
                                        <label id="errorgstno" class="text-danger" for='inputgstno'></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control">

                                            <?php if (!empty($country)) {

                                                foreach ($country as $countries) { ?>
                                                    <option id='<?php echo $countries['id'] ?>' <?php if (!empty($client)) {
                                                                                                    echo ($countries['name'] ==  $client[0]['country']) ? ' selected="selected"' : '';
                                                                                                } elseif ($countries['name'] == "India") {
                                                                                                    echo "selected";
                                                                                                } ?>>

                                                        <?php echo $countries['name']; ?> </option>

                                            <?php
                                                }
                                            }
                                            ?>


                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                                            <option value="<?php echo isset($client) ? $client[0]['state'] : '' ?>"><?php echo isset($client) ? $client[0]['state'] : '' ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" autocomplete="off" class="form-control">
                                            <option value="Gurgaon"><?php echo (isset($client['city'])) ? $client[0]['city'] : 'Gurgaon' ?></option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="address">Address </label>
                                    <div class="form-group">

                                        <textarea name="address" id="" cols="60" rows="4" class='form-control'><?php echo (isset($client)) ? $client[0]['address'] : "" ?></textarea>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pin-code">Zip/Pin Code</label>
                                        <input id="pin-code" type="number" name="zip" value="<?php echo (isset($client)) ? $client[0]['pin_code'] : "" ?>" placeholder="Enter zip code" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 pl-0">
                                <p class="float-right text-right">
                                    <input type="hidden" name="client_id" id='client-id' value="<?php echo (isset($client)) ? $client[0]['client_id'] : '' ?>">
                                    <button type="submit" class="btn btn-space btn-primary">Submit</button>

                                </p>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic form -->
        <!-- ============================================================== -->
    </div>
</div>