<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Client Administration
            <!-- <small>advanced tables</small> -->
        </h1>



        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">client</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <!-- <h3 class="box-title">Client Administration</h3> -->
                        <a class="offset-9 btn btn-primary float-right" href="<?php echo base_url('Auditapp/client_registration_form'); ?>"> Add Client &nbsp;&nbsp;<i class="fa fa-plus-square" id="create-client" aria-hidden="true" title="Create Client"></i></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="client" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th>Work Orders</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php if (!empty($client_list)) {
                                    for ($i = 0; $i < count($client_list); $i++) {
                                        $c_name = $client_list[$i]['client_name'];
                                ?>
                                        <tr>
                                            <td id="<?php echo $c_name ?>"><?php echo $c_name ?></td>
                                            <td><?php echo $client_list[$i]['city'] ?>
                                            </td>
                                            <td><?php echo $client_list[$i]['address'] ?></td>
                                            <td><?php echo $client_list[$i]['email'] ?></td>
                                            <td><?php echo $client_list[$i]['contact_no'] ?></td>
                                            <td><span id="<?php echo base64_encode($client_list[$i]['client_id']); ?>" class="num_btn" data-toggle="modal" data-target="#myModal"><?php echo ($this->MainModel->count('client_workorder_relationship', $client_list[$i]['client_id'])); ?></span></td>
                                            <td>

                                                <a href="<?php echo base_url('Auditapp/edit_client/') . base64_encode($client_list[$i]['id']); ?>"> <i class=" fa fa-pencil" title="Edit"></i></a>

                                                <a title="Create Work Order" href="<?php echo base_url('Auditapp/choose_services/') . base64_encode($client_list[$i]['client_id']); ?>"> <img style="height:20px" src="<?php echo base_url('assets/dist/img') . "/workorder.png"; ?>" alt=""></a>

                                            </td>

                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header row ma-0">
                <h4 class="modal-title col-sm-11" id="modal-heading"></h4>
                <button type="button" class="close col-sm-1" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body pa-0">
                <div class="content-wrapper ma-0 pa-10">
                    <div class="accordion">

                    </div>
                </div>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->

            </div>
        </div>
    </div>

    <script>
        $('#tbody tr td').on('click', '.num_btn', function() {
            let clientName = $(this).parent().parent().find('td:first').text();
            // console.log(clientName)
            if ($(this).text() != '0') {
                let id = atob($(this).attr('id'));
                let formData = {
                    client_id: id
                }
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/Auditapp/get_process_data',
                    data: formData,
                    success: function(data, success) {
                        // showAlert(data, "success");
                        // setTimeout(() => {
                        //     window.location = baseUrl + "Auditapp/company";
                        // }, 1000);
                        if (data != "") {
                            let processes = JSON.parse(data);
                            let html = '';
                            // console.log(processes);
                            for (let key in processes) {

                                let i = parseInt(key);
                                let process_html = '';
                                for (let pkey in processes[key]) {
                                    // console.log(processes[key])
                                    let j = parseInt(pkey);
                                    let sub_process_html = '';
                                    let p_name = '';
                                    for (let spkey in processes[key][pkey]) {
                                        p_name = processes[key][pkey][spkey]['process_description'];

                                        sub_process_html += `<p>${processes[key][pkey][spkey]['sub_process_description']}</p>`
                                    }
                                    process_html += `<div >
                                    <div class="card-body" id="child1">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="p_name" data-toggle="collapse" data-target="#s_process${i+1}_${j+1}">${p_name}</h5>
                                            </div>
                                            <div class = "card-body sp_name collapse"
                                    data - parent = "#child1"
                                    id = "s_process${i+1}_${j+1}" >${sub_process_html}</div>
                                            
                                        </div>                                        
                                    </div>
                                </div>`;
                                }

                                html += `<div class="box box-default collapsed-box mb-8">
                            <div class="card">
                                <div class="card-header" id="heading${i+1}">
                                    <h5 class="ma-0 collapse_heading d-inline" data-toggle="collapse" data-target="#process${i+1}" aria-expanded="true" aria-controls="process${i+1}">
                                        <a>Work Order ${i+1}</a>
                                    </h5>

                                </div>
                                <div id="process${i+1}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        ${process_html}
                        </div>
                            </div>
                        </div>`
                            }
                            // console.log(html)
                            $("#modal-heading").html(clientName);
                            $(".accordion").html(html)
                        }

                        // 
                    }

                });
            } else {
                $("#modal-heading").html(clientName);
                $(".accordion").html(`<p>No work order found please add work order to this client</p>`)
            }

        })
    </script>