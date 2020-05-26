<div class="dashboard-wrapper">
    <div class="container  dashboard-content">
        <div class="card">
            <div class="card-header">
                Assign Work Order
                <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-4">
                    <label for="select-client"> Select Client</label> &nbsp;<label for="message" id=message></label>
                    <select id="select-client" class="form-control">
                        <!-- <option>Select client</option> -->
                        <?php if (!empty($clients)) {
                            // print_r($clients);
                            foreach ($clients as $item) { ?>
                                <option value="<?php echo
                                                    base64_encode($item['client_id']) ?>" <?php if (!empty($clientid)) {
                                                                                                echo ($clientid ==  $item['client_id']) ? ' selected="selected"' : '';
                                                                                            } ?>>
                                    <?php echo $item['client_name'] ?>
                                </option>
                        <?php }
                        } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="work-order"> Select Work Order</label>
                    <select id="work-order" class="form-control" aria-placeholder="select work order" data-workorderid="<?php echo $workid ?>">
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <!-- <div id="search-user" style="padding:10px; display:flex;"> -->
                    <label for="users"> Search Employees </label>
                    <!-- </div> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class=" fa fa-search"></i></span>
                        </div>
                        <input type="text" name="users" id="search-users" placeholder="Search employess" class="form-control">
                    </div>

                </div>
            </div>
        <div class="card-users" id="assigned-users" style="padding-bottom:20px;display:none">
            <p class="ml-20">Assigned Employee</p>
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>Employees</th>
                        <th>Work Order</th>
                        <th>Assigned As</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody id="assigned_user">
                </tbody>
            </table>
        </div>

        <div class="card-users" id="card-users">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>Employees</th>
                        <th>Access As</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user-data">
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
