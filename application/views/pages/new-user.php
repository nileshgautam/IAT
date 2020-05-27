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
                <?php echo (isset($user)) ? 'Edit User' : ' New User' ?>
                <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
            </div>
            <div class="card-body">
                <form id="user-form" method="post">
                    <div class="form-group">
                        <label for="inputUserName">First Name</label>
                        <input id="inputUserName" type="text" name="first-name" placeholder="Enter first name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['first_name'] : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input id="last-name" type="text" name="last-name" placeholder="Enter last name" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['last_name'] : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="input-email">Email address</label>
                        <input id="input-user-email" type="email" name="email" placeholder="Enter email" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['email'] : "" ?>" required>
                        <small id="user-error-email" class="">We'll never share your email with anyone else.</small>

                    </div>
                    <div class="form-group">
                        <label for="selectcountry">Country</label>
                        <select name="country" id="country" placeholder="Select state" autocomplete="off" class="form-control" data-state="<?php echo (isset($user) ? $user[0]['state'] : '') ?>">
                            <option>Select country</option>
                            <?php if (!empty($country)) {
                                foreach ($country as $countries) { ?>
                                    <option id='<?php echo $countries['id'] ?>' <?php if (!empty($user)) {
                 echo ($countries['name'] ==  $user[0]['country']) ? ' selected' : '';
                                                                                } 
                else {
                    echo ($countries['name'] == "India") ? "selected" : '';
                                                                                }

                             ?>>

                                        <?php echo $countries['name']; ?>
                                    </option>


                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state" placeholder="Select state" autocomplete="off" class="form-control" data-city="<?php echo (isset($user) ? $user[0]['city'] : '') ?>">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="city" id="city" autocomplete="off" class="form-control">
                            <option value="<?php echo isset($user) ? $user[0]['city'] : '' ?>"><?php echo isset($user) ? $user[0]['city'] : 'Select State' ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mobile-no">Mobile No.</label>
                        <input id="input-user-mobile" type="number" name="mobile-no" placeholder="Enter mobile no." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['phone'] : "" ?>" required>
                        <small id="user-error-mobile">We'll never share your mobile with anyone else.</small>
                    </div>

                    <div class="form-group">
                        <label for="address">Address </label>
                        <textarea name="address" id="" cols="60" rows="3" class='form-control' placeholder="Address..."><?php echo (isset($user)) ? $user[0]['address'] : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="zip-pin-code">Zip/Pin Code</label>
                        <input id="zip-pin-code" type="text" name="zip-pin-code" placeholder="Zip/Pin Code" autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['zip_pin_code'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input id="password" type="password" name="password" placeholder="Enter password." autocomplete="off" class="form-control" value="<?php echo (isset($user)) ? $user[0]['password'] : "" ?>" required>
                            <div class="input-group-addon">
                                <a href='#'><i class="fa fa-eye-slash" aria-hidden="true" style="padding: 10px; border: 1px solid #d3cfcf;"></i></a>
                            </div>
                        </div>
                    </div>
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
                    <div class="form-group py-2">
                        <div class="btn-submit">
                            <input type="hidden" id="user-id" name="id" value="<?php echo (isset($user) ? $user[0]['user_id'] : '') ?>">
                            <button type="submit" class="btn btn-space  btn-xs btn-success">Submit</button>
                            <button type="" class="btn btn-space btn-warning btn-xs " id="back-to-admin-dashboard">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- ============================================================== -->