// country state, city and role 

$(function () {
    // select all the  country
    $("#country").change(function () {
        let sstate = $(this).attr('data-state');
        // let state = $(this).attr('data-state');
        let id = $(this).children("option:selected").attr('id');

        country_id = {
            c_id: id
        }
        $.ajax({
            type: "POST",
            url: baseUrl + "Auditapp/select_state",
            data: country_id,
            success: function (comp_responce) {
                obj = JSON.parse(comp_responce)
                if (obj) {
                    // console.log(obj)
                    let data = populate_option(obj, id, sstate);
                    // console.log(id);
                    $('#state').empty();
                    $('#state').append(data);
                    // company_responce = obj;
                    $("#state").change();
                }
            },
            error: function () {
                console.log("error loading data");
            }
        });
        // alert(id);
    });


    // select all the  state
    $("#state").change(function () {
        let s_city = $(this).attr('data-city');
        let id = $(this).children("option:selected").attr('id');
        // console.log(id);
        // console.log(s_city);

        state_id = {
            c_id: id
        }

        $.ajax({
            type: "POST",
            url: baseUrl + "Auditapp/select_cities",
            data: state_id,
            success: function (comp_responce) {
                obj = JSON.parse(comp_responce)
                if (obj) {
                    // console.log("object")
                    // console.log(obj)
                    let data = populate_cities(obj, id, s_city);
                    //  console.log(data);
                    $('#city').empty();
                    $('#city').append(data);
                    // company_responce = obj;
                }
            },
            error: function () {
                console.log("error loading data")
            }
        });
        // alert(id);
    });
    // for auto triger
    $("#country").change();
    $("#state").change();

    //  Function for populate states
    function populate_option(obj, id, ss) {

        // console.log(obj);

        let html = '';
        for (let i = 0; i < obj.length; i++) {
            if (ss != '') {
                html += `<option id="${id == obj[i]['id'] ? id : obj[i]['id']}" ${obj[i]['name'] == ss ? "selected" : ""}>${name == obj[i]['name'] ? name : obj[i]['name']}</option>`;
            } else {
                html += `<option id="${id == obj[i]['id'] ? id : obj[i]['id']}" ${obj[i]['name'] == "Haryana" ? "selected" : ""}>${name == obj[i]['name'] ? name : obj[i]['name']}</option>`;
            }
        }
        // $("#country").change();
        return html;
    }
    // Function to show list of all the city
    function populate_cities(obj, id, s_city) {

        let html = '';

        for (let i = 0; i < obj.length; i++) {
            if (s_city != '') {
                html += `<option id="${id == obj[i]['id'] ? id : obj[i]['id']}" ${obj[i]['name'] == s_city ? "selected" : ""}>${name == obj[i]['name'] ? name : obj[i]['name']}</option>`;

            } else {
                html += `<option id="${id == obj[i]['id'] ? id : obj[i]['id']}" ${obj[i]['name'] == 'Gurgaon' ? "selected" : ""}>${name == obj[i]['name'] ? name : obj[i]['name']}</option>`;
            }
        }
        return html;
    }

    // end coutnry data
    $('#client').change(function () {
        let client = $(this).children("option:selected").attr('data');
        $('#company-id').val(client);
    });


    $('#role').change(function () {
        let client = $(this).children("option:selected").attr('data');
        $('#user-role').val(client);

    });
    // Date formate function YYMMDD to DDMMYY
    dateFormatDDMMYY = (date) => {
        let year = date.slice(0, 4);
        let month = date.slice(5, 7);
        let day = date.slice(8, 10);
        let newdate = day + "-" + month + "-" + year;
        return newdate;
    }

});
// work-orders
$('.work-orders').on('click', function (e) {
    e.preventDefault();
    let workOrderId = $(this).attr('data-id');
    let form_data = new FormData()
    form_data.append('workid', workOrderId)
    // alert(workOrderId);
    let html = '';
    $.ajax({
        type: 'POST',
        url: baseUrl + '/Auditapp/workprocess',
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data, success) {
            let fileData = JSON.parse(data);
            // console.log(fileData);
            for (process in fileData) {
                html += `
             <div class="col-md-12">
              <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">${fileData[process].process_name}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  The body of the box
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
                `;
                // document.write(process.id + "<br >");
            }
            $('#process').html(html);
        }
    });

});

let iterable = 1;
$('.add-new').on('click', function () {

    // alert('hello');
    let newRow = `<tr>
    <td>${iterable + 1}</td>
    <td><input id="file-name" type="text" name="file-name${iterable}" class="form-control" placeholder="Enter file name" /></td>
    <td> 
    <div class="upload-btn-wrapper">
    <button class="btn-upload">Choose a file</button>
    <input id="files" type="file" name="files${iterable}" class="form-control">
    </div></td>
    <td><textarea name="remark${iterable}" id="remark" cols="" rows="" class="form-control"></textarea></td>
    <td><button type="submit" fn-name="file-name${iterable}" files-name="files${iterable}" remark-name="remark${iterable}" class="upload-data"><i class="fa fa-save"></i></button>
    </td>
</tr>`;
    $('#upload-multiple-file').append(newRow);
    iterable++;
});

$('#upload-multiple-file').on('click', '.upload-data', function () {
    let fileTitle = $(this).attr('fn-name');
    let filesname = $(this).attr('files-name');
    let remarktxt = $(this).attr('remark-name');

    let t = $('[name=' + fileTitle + ']');
    let f = $('[name=' + filesname + ']');
    let r = $('[name=' + remarktxt + ']');
    let error = false;
    let title = t.val();
    //let files = f.val();
    let remark = r.val();
    let f_type = $('#filetyple').val();
    if (f_type != 'NM') {
        if (remark == '' && f[0].files[0] == undefined && title == "") {
            showAlert('All fields are Mandatory for this step', 'danger');
            error = true;
        }
    }
    else if (remark == '' && f[0].files[0] == undefined && title == "") {
        showAlert('All fields are empty, remarks required', 'warning');
        error = true;
    } else if (f[0].files[0] == undefined && title != "") {
        showAlert('You are giving a file name, Please choose a file first', 'warning');
        error = true;
    }

    // if(f[0].files[0]==undefined){
    //     f.val('Required').css('color', 'red');
    //     error =true;
    // }


    if (!error) {
        let form_data = new FormData(uploaddata);
        form_data.append("title", title);

        form_data.append("files", f[0].files[0]);
        form_data.append("remark", remark);
        $.ajax({
            method: "POST",
            url: baseUrl + "Upload_files/Upload_file",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                // console.log(data);
                let message = JSON.parse(data);
                showAlert(message['msg'], message['type']);

            }
        });
    }

});

// show all the workorder by client
function workOrderData(obj) {
    let html = '';
    // console.log(obj)
    if (obj != '') {
        // console.log(obj)
        for (let i = 0; i < obj.length; i++) {
            html += `<option value="${obj[i]['work_order_id']}">${obj[i]['work_order_name']}</option>`;
        }
        return html;
    }
}

// loading all the workorder by selected client
$('#select-client').on('change', function () {
    let workorderid = $('#work-order').attr('data-workorderid');
    let clientId = $(this).val();
    let error = false;
    console.log(workorderid);

    if (clientId == "") {
        $('#message').html('Client Required');
        error = true;
    }

    if (!workorderid) {
        if (!error) {
            let form_data = { id: clientId };
            $.ajax({
                type: 'POST',
                url: baseUrl + '/Auditapp/workorders',
                data: form_data,
                success: function (data, success) {
                    let workorder = '';
                    let obj = JSON.parse(data);
                    if (obj != false) {
                        workorder = workOrderData(obj);
                    } else {
                        workorder = '<option>No-workorder</option>';
                    }
                    // console.log(workorder);
                    $('#work-order').html(workorder);
                }
            });
        }
        // console.log('blnk')
    } else {
        let form_data = { id: clientId, wid: workorderid };
        $.ajax({
            type: 'POST',
            url: baseUrl + '/Auditapp/getworkorder',
            data: form_data,
            success: function (data, success) {
                let workorder = '';
                let obj = JSON.parse(data);
                if (obj != false) {
                    workorder = workOrderData(obj);
                } else {
                    workorder = '<option>No-workorder</option>';
                }
                // console.log(workorder);
                $('#work-order').html(workorder);
            }
        });

        console.log('filled')

    }
    // console.log(atob(clientId));


});

$('#select-client').change();

let allEmployees = []; //Golble variable for store all the employess data
// loading employees data from database 
$(document).ready(() => {
    // Getting user data from the data base
    $.get(baseUrl + "Auditapp/allemployees", function (data, status) {
        allEmployees = JSON.parse(data);
        // console.log(obj);
    });
    //  Searching employees in to the array comes from database
    $('#search-users').on('change keyup', function () {
        $('#card-users').show();
        let searchData = $(this).val().trim();
        if (searchData != '') {
            let name = allEmployees.filter(e => (e.first_name + " " + e.last_name).toLowerCase().includes(searchData.toLowerCase())); //filtering data from array comes from users table intot the database.
            // console.log(name);
            let html = '';
            for (let i = 0; i < name.length; i++) {

                // console.log(name)
                html += `<tr>
                        <td>${name[i].first_name} ${name[i].last_name}</td>
                            <td>
                             <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="radio-inline${name[i].id}" value="Team member" class="custom-control-input checked" ${name[i].role == 'Team member' ? "checked" : ''}><span class="custom-control-label">Team member</span>
                                </label>
                                 <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="radio-inline${name[i].id}" value="Team leader" class="custom-control-input checked" ${name[i].role == 'Manager' ? "checked" : ''}><span class="custom-control-label">Team leader</span>
                                </label>
                                </td>
                                <td><button data-employees-id='${name[i].user_id}' data-radio-name="radio-inline${name[i].id}" class="btn btn-outline-primary btn-xs assign-task">Update</button></td>
                            </tr>`
            }

            $('#user-data').html(html);
        }
        else {
            $('#user-data').empty();
        }
    });

    // var role = ''
    // $('#user-data').on('click', '.checked', function () {
    //     role = $(this).val()
    //     console.log(role);
    // });

    $('#user-data').on('click', '.assign-task', function (e) {
        e.preventDefault();
        let error = false;
        let username = $(this).parent().parent().find('td:first').html();
        let selectedWorkorder = $('#work-order option:selected').text();
        let radioName = $(this).attr('data-radio-name');
        let employeesId = $(this).attr('data-employees-id');
        let radioValue = $(`input[name=${radioName}]:checked`).val();
        let clientId = $('#select-client').val().trim();
        let workorderId = $('#work-order').val().trim();
        let html = `<tr>
        <td>${username}</td>
        <td>${selectedWorkorder}</td>
        <td>${radioValue}</td>
        </tr>`;

        // console.log(username);
        // console.log(selectedWorkorder);
        // console.log(radioName)
        // console.log(employeesId)
        // console.log(radioValue)
        // console.log(clientId)
        // console.log(workorderId)

        if (clientId == '') {
            error = true;
            showAlert('Client is required', 'warning');
        }
        if (workorderId == '') {
            showAlert('Work order is required', 'warning');
            error = true;
        }
        // console.log(radioValue);
        if (radioValue == undefined) {
            showAlert('Access role is required', 'danger');
            error = true;
        }
        // let form_data = new FormData();
        let form_data = { employeeId: employeesId, projectRole: radioValue, clientId: atob(clientId), workorderId: workorderId }
        if (!error) {
            $.post(baseUrl + "AssignWorkOrder/save_assigned_work",
                form_data,
                function (data, status) {
                    let responce = JSON.parse(data);
                    if (responce.status == 'A') {
                        showAlert(responce['msg'], responce['type']);
                    }
                    else if (responce.status == 'Y') {
                        showAlert(responce['msg'], responce['type']);
                        $('#assigned-users').css('display', 'block');
                        $('#assigned_user').append(html);
                        $('#search-users').val('');
                        $('#card-users').hide();
                        $(this).parent().parent().remove();
                    }
                    else if (responce.status == 'E') {
                        showAlert(responce['msg'], responce['type']);
                    }
                });
        }
    });

    // // save  worksteps 
    // $('.save-work-steps').click(function () {
    //     let workstepsStatus = $(this).attr('data-checkbox-name');
    //     let workstepsid = $(this).attr('data-work-step-id');
    //     let workOrderId = $(this).attr('data-workorder-id');
    //     let checkValue = $(`input[name=${workstepsStatus}]:checked`).val();
    //     if (checkValue == undefined) {
    //         alert('Tick box is required to check');
    //     } else {
    //         checkValue = 1;
    //         $.post(baseUrl + "Auditapp/updateWorkSteps", { workstepsid: workstepsid, workOrderId: workOrderId, checkValue: checkValue }, function (data, status) {
    //             // console.log(data);
    //         });
    //     }
    // });

});

$(function () {
    // showing all the project by clients
    $('.all-work-order').on('click', function () {
        let clientId = $(this).attr('data-id');
        // alert(atob(clientId));
        let html = `<div class="all-work-orders row">
    <div class="col-md-4">Work orders</div>
</div>`

        if (clientId != '') {
            $.post(baseUrl + "Auditapp/workorders", { id: atob(clientId) }, function (data, status) {

                let allworkOrders = JSON.parse(data);

                // console.log(allworkOrders);
                let count = 1;
                for (work of allworkOrders) {
                    html += `<div class="col-md-4">${count++} : ${work.work_order_name}</div>`
                }

                $('#all-work-order').html(html);

            });

        }
    });

    // function to download process master from database
    $('.download-master').click(function () {
        $.get(baseUrl + "Auditapp/downlodDatabaseMaster", function (data, status) {
            window.location.href = data;
        });
    });

    //Save Work Steps Complete status
    $('#save_wSteps').click(() => {
        let check_steps_data = [];
        let w_id = $('input[type="checkbox"]:checked').each(function () {
            let data = {
                work_step_id: $(this).attr('data-work-step-id'),
                order_id: $(this).attr('data-work-order-id'),
                process_id: $(this).attr('data-process-id'),
                subprocess_id: $(this).attr('data-sub-process-id'),
                mandatory_type: $(this).attr('data-work-steps-type'),
            }
            check_steps_data.push(data);
        });
        if (check_steps_data.length == 0) {
            showAlert('No Work Step is chose for save', 'danger');
        } else {

            $.post(baseUrl + "Auditapp/saveWorkSteps", { data: JSON.stringify(check_steps_data) }, function (data, status) {
                let response = JSON.parse(data);
                showAlert(response['msg'], response['status']);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
        }
        // console.log(check_steps_data)
    });
})

// show password
$(document).ready(function () {
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
});
