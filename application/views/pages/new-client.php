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
            <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
            </div>

            <div class="card-body">
                <form class="client-from" method="POST">
                    <div class="form-group">
                        <label for="txtClient" class="col-form-label">Name</label>
                        <input id="txtClient" type="text" name="client-name" value="<?php echo (isset($client)) ? $client[0]['client_name'] : "" ?>" placeholder="Enter client name" autocomplete="off" class="form-control" required>

                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Email address</label>

                        <input id="txtEmail" type="email" name="email" value="<?php echo (isset($client)) ? $client[0]['email'] : "" ?>" placeholder="name@example.com" autocomplete="off" class="form-control" required>
                        <small class="">We'll never share your email with anyone else.</small>
                        <!-- <label for="txtEmail" id="errorEmail" class="text-danger"></label> -->
                    </div>
                    <div class="form-group">
                        <label for="txtmobile" class="col-form-label">Mobile Number</label>
                        <input style="-moz-appearance:textfield;" id="txtmobile" type="number" name="mobile-number" maxlength="10" value="<?php echo (isset($client)) ? $client[0]['contact_no'] : "" ?>" placeholder="Mobile number (Text not allowed)" autocomplete="off" class="form-control" required>
                        <small>We'll never share your mobile with anyone else.</small>
                        <!-- <label id="errormobile" class="text-danger" for="txtmobile"></label> -->
                    </div>
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
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                            <option value="<?php echo isset($client) ? $client[0]['state'] : '' ?>"><?php echo isset($client) ? $client[0]['state'] : '' ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="city" id="city" autocomplete="off" class="form-control">
                            <option value="Gurgaon"><?php echo (isset($client['city'])) ? $client[0]['city'] : 'Gurgaon' ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="address">Address </label>
                        <textarea name="address" id="" cols="60" rows="3" class='form-control' placeholder="Address"><?php echo (isset($client)) ? $client[0]['address'] : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pin-code">Zip/Pin Code</label>
                        <input id="pin-code" type="number" name="zip" value="<?php echo (isset($client)) ? $client[0]['pin_code'] : "" ?>" placeholder="zip/pin code" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputgstno">GST No.</label>
                        <input id="inputgstno" type="text" name="gst-number" value="<?php echo (isset($client)) ? $client[0]['gst_number'] : "" ?>" placeholder="Enter GST" autocomplete="off" class="form-control" required>
                        <label id="errorgstno" class="text-danger" for='inputgstno'></label>
                    </div>

                    <div class="form-group">
                        <div class="btn-submit">
                            <input type="hidden" name="client_id" id='client-id' value="<?php echo (isset($client)) ? $client[0]['client_id'] : '' ?>">

                            <button type="submit" class="btn btn-space btn-success btn-xs">Submit</button>

                            <button type="" class="btn btn-space btn-warning btn-xs" id="back-to-admin-dashboard">Back</button>

                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>