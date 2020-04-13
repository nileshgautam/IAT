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
        <!-- <div class="row"> -->
            <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                <!-- <div class="page-header">
                    <h3 class="mb-2">User</h3> <a style="margin: -45px 20px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    <p class="pageheader-text">Lorem ipsum dolor sit ametllam fermentum ipsum eu porta consectetur adipiscing elit.Nullam vehicula nulla ut egestas rhoncus.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">User</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link"><?php echo (isset($user)) ? 'Edit User' : ' New User' ?></a></li>
                            </ol>
                        </nav>
                    </div>
                </div> -->
            <!-- </div> -->
        <!-- </div> -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">
                        <?php echo (isset($user)) ? 'Edit User' : ' New User' ?>
                        <a style="margin: -9px 15px;
" class="btn btn-danger float-right text-white" href="<?php echo base_url('dashboard') ?>">Exit</a>
                    </h5>

                    <div class="card-body">
                        <form id="user-form" method="post">
                            <input type="hidden" id="user-id" name="id" value="<?php echo (isset($user) ? $user[0]['user_id'] : '') ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputUserName">First Name</label>
                                        <input id="inputUserName" type="text" name="first-name" placeholder="Enter first name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['first_name'] : "" ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last-name">Last Name</label>
                                        <input id="last-name" type="text" name="last-name" placeholder="Enter last name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['last_name'] : "" ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input-email">Email address</label>
                                        <input id="input-user-email" type="email" name="email" placeholder="Enter email" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['email'] : "" ?>" required>
                                        <label for="user-error-email" id="user-error-email" class="text-danger"></></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="selectcountry">Country</label>
                                        <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control" data-state="<?php echo (isset($user) ? $user[0]['state'] : '') ?>">
                                            <option>Select country</option>
                                            <?php if (!empty($country)) {

                                                foreach ($country as $countries) { ?>
                                                    <option id='<?php echo $countries['id'] ?>' <?php if (!empty($user)) {
                                                                                                    echo ($countries['name'] ==  $user[0]['country']) ? ' selected="selected"' : '';
                                                                                                } elseif ($countries['name'] == "India") {
                                                                                                    echo "selected";
                                                                                                }


                                                                                                ?>>

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
                                        <label for="state">State</label>
                                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control">
                                            <option id='statechiled' value="<?php echo isset($user) ? $user[0]['state'] : '' ?>"><?php echo isset($user) ? $user[0]['state'] : 'Select State' ?></option>
                                        </select>
                                        <!-- <input id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="Enter email" autocomplete="off" class="form-control"> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" autocomplete="off" class="form-control">
                                            <option value="<?php echo isset($user) ? $user[0]['city'] : '' ?>"><?php echo isset($user) ? $user[0]['city'] : 'Select State' ?></option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address </label>
                                        <input id="address" type="text" name="address" placeholder="Enter address line 1" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['address'] : "" ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address-line-two">Address line 2</label>
                                        <input id="address-line-two" type="text" name="address-line-two" placeholder="Enter address line 2" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['adress_line_two'] : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile-no">Mobile No.</label>
                                        <input id="input-user-mobile" type="number" name="mobile-no" placeholder="Enter mobile no." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['phone'] : "" ?>" required>
                                        <label for="mobile-no" id="user-error-mobile" class="text-danger"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="zip-pin-code">Zip/Pin Code</label>
                                        <input id="zip-pin-code" type="text" name="zip-pin-code" placeholder="Zip/Pin Code" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['zip_pin_code'] : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="password">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input id="password" type="password" name="password" placeholder="Enter password." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['password'] : "" ?>" required>
                                            <div class="input-group-addon">
                                                <a href='#'><i class="fa fa-eye-slash" aria-hidden="true" style="padding: 10px; border: 1px solid #d3cfcf;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Role</label>
                                        <select name="role" id="role" autocomplete="off" class="form-control">
                                            <option>Select Role</option>
                                            <?php if (!empty($role)) {
                                                foreach ($role as $user_role) {
                                            ?>
                                                    <option <?php if (isset($user)) {
                                                                echo ($user_role['role'] ==  $user[0]['role']) ? ' selected="selected"' : '';
                                                            } ?>>

                                                        <?php echo $user_role['role'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 pl-0">
                                <p class="float-right text-right">
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
<!-- ============================================================== -->