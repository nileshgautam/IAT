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
    <div class="container dashboard-content">
        <div class="card">
            <div class="card-header">
                <?php echo (isset($client)) ? 'Edit Client' : ' New Client' ?>
                <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>#clients-vertical">Exit</a>
            </div>

            <div class="card-body">
                <form class="client-from" method="POST">
                    <div class="row container">
                        <!-- <div class="col-md-6"> -->
                        <div class="form-group col-md-12">
                            <label for="txtClient" class="col-form-label">Name<span class="text-danger">*</span></label>
                            <input id="txtClient" type="text" name="client-name" value="<?php echo (isset($client)) ? $client[0]['client_name'] : "" ?>" placeholder="Enter client name" class="form-control" required>
                            <small></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtEmail">Email address<span class="text-danger">*</span></label>
                            <input id="txtEmail" type="email" name="email" value="<?php echo (isset($client)) ? $client[0]['email'] : "" ?>" placeholder="name@example.com" class="form-control" required>
                            <small id="errorEmail" class="">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtmobile">Mobile Number<span class="text-danger">*</span></label>
                            <input style="-moz-appearance:textfield;" id="txtmobile" type="number" name="mobile-number" maxlength="10" value="<?php echo (isset($client)) ? $client[0]['contact_no'] : "" ?>" placeholder="Mobile number (Text not allowed)" autocomplete="off" class="form-control" required>
                            <small id="errormobile">We'll never share your mobile with anyone else.</small>
                            <!-- </div> -->
                        </div>
                    
                    <div class="form-group col-md-12">
                        <label for="address">Address<span class="text-danger">*</span></label>
                        <textarea name="address" id="" cols="60" rows="3" class='form-control' placeholder="Address" required><?php echo (isset($client)) ? $client[0]['address'] : "" ?></textarea>
                    </div>
                    </div>

                    <!-- </div> -->
                    <div class="row container">
                        <div class="form-group col-md-4">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select name="country" id="country" placeholder="Select country" autocomplete="off" data-state='<?php echo (isset($client) ? $client[0]['state'] : '') ?>' class="form-control">
                                <?php if (!empty($country)) {
                                    foreach ($country as $countries) { ?>
                                        <option id='<?php echo $countries['id'] ?>' <?php if (isset($client)) {
                                                                                        echo ($countries['name'] ==  $client[0]['country']) ? 'selected' : '';
                                                                                    } else {
                                                                                        echo ($countries['name'] == "India") ? "selected" : '';
                                                                                    }
                                                                                    ?>>
                                            <?php echo trim($countries['name']); ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">State<span class="text-danger">*</span></label>
                            <select name="state" id="state" placeholder="Select state" autocomplete="off" data-city="<?php echo (isset($client) ? $client[0]['city'] : '') ?>" class="form-control">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City<span class="text-danger">*</span></label>
                            <select name="city" id="city" autocomplete="off" class="form-control">
                            </select>
                        </div>

<!-- 

                    </div>
                    <div class="row"> -->

                        <div class="form-group col-md-4">
                            <label for="pin-code">Zip/Pin Code <span class="text-danger">*</span></label>
                            <input id="pin-code" type="number" name="zip" value="<?php echo (isset($client)) ? $client[0]['pin_code'] : "" ?>" placeholder="zip/pin code" autocomplete="off" class="form-control" required>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputgstno">GST No. <span class="text-danger">*</span></label>
                            <input id="inputgstno" type="text" name="gst-number" value="<?php echo (isset($client)) ? $client[0]['gst_number'] : "" ?>" placeholder="Enter GST" autocomplete="off" class="form-control" required>
                            <label id="errorgstno" class="text-danger" for='inputgstno'></label>
                        </div>
                    </div>
                        <div class="btn-submit">
                            <input type="hidden" name="client_id" id='client-id' value="<?php echo (isset($client)) ? $client[0]['client_id'] : '' ?>">

                            <button type="submit" class="btn btn-space btn-success btn-xs">Submit</button>

                            <button type="button" class="btn btn-space btn-warning btn-xs" id="back-to-admin-dashboard">Back</button>

                        </div>
                </form>
            </div>

        </div>
    </div>
</div>