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
                            <h3 class="mb-2">Clients</h3>
                            <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Clients</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">New</a></li>
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
                                <form action="<?php echo (isset($client)) ? base_url('Auditapp/saveEditedClient') : base_url('Auditapp/clientPost') ?>" id="basicform" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtClient">Client Name</label>
                                                <input id="txtClient" type="text" name="client-name" value="<?php echo (isset($client)) ? $client[0]['client_name'] : "" ?>" placeholder="Enter client name" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtEmail">Email address</label>
                                                <input id="txtEmail" type="email" name="email" value="<?php echo (isset($client)) ? $client[0]['email'] : "" ?>" placeholder="Enter email" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtmobile">Mobile No.</label>
                                                <input id="txtmobile" type="text" name="mobile-number" value="<?php echo (isset($client)) ? $client[0]['contact_no'] : "" ?>" placeholder="Enter mobile number" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputEmail">GST No.</label>
                                                <input id="inputEmail" type="text" name="gst-number" value="<?php echo (isset($client)) ? $client[0]['gst_number'] : "" ?>" placeholder="Enter GST" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputUserName">Country</label>
                                                <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control">
                                                    <option value="India">India</option>
                                                    <?php if (!empty($country)) {

                                                        foreach ($country as $countries) { ?>
                                                            <option id='<?php echo $countries['id'] ?>' <?php if (!empty($client)) {
                                                                                                            echo ($countries['name'] ==  $client[0]['country']) ? ' selected="selected"' : '';
                                                                                                        } ?>>

                                                                <?php echo $countries['name']; ?> </option>

                                                    <?php
                                                        }
                                                    }
                                                    ?>


                                                </select>
                                                <!-- <input id="inputUserName" type="text" name="name" data-parsley-trigger="change" required="" placeholder="Enter user name" autocomplete="off" class="form-control"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputEmail">State</label>
                                                <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                                                    <option value="<?php echo isset($client) ? $client[0]['state'] : 'Haryana' ?>"><?php echo isset($client) ? $client[0]['state'] : 'Haryana' ?></option>
                                                </select>
                                                <!-- <option value="Haryana"> Haryana</option> -->
                                                </select>
                                                <!-- <input id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="Enter email" autocomplete="off" class="form-control"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputEmail">City</label>
                                                <select name="city" id="city" autocomplete="off" class="form-control">
                                                    <option value="Gurgaon"><?php echo (isset($client['city'])) ? $client[0]['city'] : 'Gurgaon' ?></option>
                                                </select>
                                                <!-- <input id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="Enter email" autocomplete="off" class="form-control"> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="address">Address </label>
                                            <div class="form-group">

                                                <textarea name="address" id="" cols="60" rows=""><?php echo (isset($client)) ? $client[0]['address'] : "" ?></textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pin-code">Zip/Pin Code</label>
                                                <input id="pin-code" type="text" name="zip" value="<?php echo (isset($client)) ? $client[0]['pin_code'] : "" ?>" placeholder="Enter zip code" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pl-0">
                                        <p class="float-right text-right">
                                            <input type="hidden" name="client_id" value="<?php echo (isset($client)) ? $client[0]['client_id'] : '' ?>">
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