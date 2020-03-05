
// start country
$("#country").change(function () {
    let ustate = $(this).attr('data-state');
    let state = $(this).attr('data-state');

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
                if (ustate != '') {
                    for (const element of obj) {
                        let statesname = element.name;
                        if (ustate == statesname) {
                            let stateid = element.id
                            //   console.log(stateid + " " + statesname) ;
                            populate_option(obj, stateid, statesname);
                        }
                    }
                }
                let data = populate_option(obj);
                // console.log(obj);
                $('#state').empty();
                $('#state').append(data);
                // company_responce = obj;
                $("#state").change();
            }
        },
        error: function () {
            console.log("error logind data")
        }
    });
    // alert(id);
});

// 

$("#state").change(function () {
    let state = $(this).attr('data-state');    
    let id = $(this).children("option:selected").attr('id');
    console.log(id);
    country_id = {
        c_id: id
    }

    $.ajax({
        type: "POST",
        url: baseUrl + "Auditapp/select_cities",
        data: country_id,
        success: function (comp_responce) {
            obj = JSON.parse(comp_responce)
            if (obj) {
                console.log("object")
                console.log(obj)
                let data = populate_cities(obj);
                //  console.log(data);
                $('#city').empty();
                $('#city').append(data);
                // company_responce = obj;
            }
        },
        error: function () {
            console.log("error logind data")
        }
    });
    // alert(id);
});


$("#country").change();
$("#state").change();


function populate_option(obj, id, name) {

    // console.log(obj);

    let html = '';
    for (let i = 0; i < obj.length; i++) {
        html += `<option id="${id == obj[i]['id'] ? id : obj[i]['id']}" ${obj[i]['name'] == "Haryana" ? "selected" : ""}>${name == obj[i]['name'] ? name : obj[i]['name']}</option>`
    }
    // $("#country").change();
    return html;
}

function populate_cities(obj) {

    let html = '';
    for (let i = 0; i < obj.length; i++) {
        html += `<option id="${obj[i]['state_id']}" ${obj[i]['name']=='Gurgaon'?'selected':''}>${obj[i]['name']}</option>`
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

// function to submit all the process
$('.submit-services').on('click', function () {
    let process = {};

    $('input[name="subprocess"]:checked').each(function () {
        if (process[$(this).attr('data-process-id')] === undefined) {
            process = {
                [$(this).attr('data-process-id')]: [$(this).attr('data-sub-id')],
                ...process
            };
        } else {
            process[$(this).attr('data-process-id')] = [...process[$(this).attr('data-process-id')], $(this).attr('data-sub-id')];
        }
        // $('#process').val(JSON.stringify(process))

    })

    // if{}
    let message = "Required";
    // console.log($("[type='text']"))

    let clientId = $('#client').val().trim();
    let workorderId = $('#textWork-Order-id').val().trim();
    let workOrderName = $('#textWork-Order-Name').val().trim();
    let startDate = $('#start-date').val().trim();
    let endDate = $('#end-date').val().trim();
    let error = false;

    if (clientId == "") {
        $('#messageclient').html(message)
        error = true;
    } if (workorderId == "") {
        $('#messageworkorderid').html(message)
        error = true;
    } if (workOrderName == "") {
        $('#messageworkorder').html(message)
    } if (startDate == "") {

        $('#error-start-date').html(message)
    } if (endDate == '') {
        $('#error-end-date').html(message)
        error = true;
    }
    if (ValidateDate()) {
        $('#error-end-date').html('End date should be greater from start date');
        error = true;
    }
    if (Object.keys(process).length == 0) {
        showAlert('Please choose process first', "warning");
        error = true;
    }

    let formData = { client_id: clientId, workorderId: workorderId, workOrderName: workOrderName, process: JSON.stringify(process), sdate: startDate, enddate: endDate }
    if (!error) {
        // console.log(error);
        $.ajax({
            type: 'POST',
            url: baseUrl + '/Auditapp/create_work_order',
            data: formData,
            success: function (data, success) {
                let resonce = JSON.parse(data);
                showAlert(resonce.msg, "success");
                setTimeout(() => {
                    window.location = baseUrl + "AssignWorkOrder/allowcated_work_order/" + resonce.client_id;
                }, 1000);
            }

        });
    }
});


// set required data to the model
$('.set-data').click(function () {

    let WorkOrderId = $(this).attr('data-work-order-id');
    let ProcessId = $(this).attr('data-process-id');
    let WorkStepId = $(this).attr('data-work-step-id');
    let WorkStepsType = $(this).attr('data-work-steps-type');
    let subProcessId = $(this).attr('data-sub-process-id');
    $('#workorder-id').val(WorkOrderId);
    $('#process-id').val(ProcessId);
    $('#subprocess-id').val(subProcessId);
    $('#worksteps-id').val(WorkStepId);
    $('#filetyple').val(WorkStepsType);

});

// Date formate function YYMMDD to DDMMYY
dateFormatDDMMYY = (date) => {
    let year = date.slice(0, 4);
    let month = date.slice(5, 7);
    let day = date.slice(8, 10);
    let newdate = day + "-" + month + "-" + year;
    return newdate;
}


// function to show uploaded files in mandatory
$('.view-file').click(function () {
    // e.preventDefault();
    let workid = $(this).attr('data-work-order-id');
    let workstepsid = $(this).attr('data-work-step-id');
    let form_data = new FormData();
    let html = '';

    form_data.append('workid', workid);
    form_data.append('workstepsid', workstepsid);
    $('#view-file-data').append('');
    $.ajax({
        type: 'POST',
        url: baseUrl + '/Auditapp/viewFiles',
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data, success) {
            $('#view-file-data').empty();
            let fileData = JSON.parse(data);
            // console.log(fileData);
            html += `<table class="table">
                <thead>
                    <tr>
                        <th>File Name</th>
               
                        <th>Remarks</th>
                        <th>Uploaded On</th>
                    </tr>
                </thead>
                <tbody>`
            for (const uploadfile of fileData) {
                //    console.log(uploadfile.upload_time);
                // let date = uploadfile.upload_time;

                // console.log(newdate);
                //  console.log(month);
                //  console.log(day);


                html += `
                <tr>
            <td><a href="${baseUrl + `upload/files/${uploadfile.file_name}`}"> ${uploadfile.title} </a></td>
          
            <td>${uploadfile.remarks}</td> 

            <td>${dateFormatDDMMYY(uploadfile.upload_time)}</td>`
            }

            html += `  
             </tr>
    </tbody></table>
`
            $('#view-file-data').html(html);

        }

    });
    // console.log(companyid);
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
            console.log(fileData);
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
    <td> <input id="files" type="file" name="files${iterable}" class="form-control"></td>
    <td><textarea name="remark${iterable}" id="remark" cols="" rows="" class="form-control"></textarea></td>
    <td><button type="submit" fn-name="file-name${iterable}" files-name="files${iterable}" remark-name="remark${iterable}" class="upload-data"><i class="fa fa-upload"></i></button>
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

    if (remark == '') {
        t.val('Required').css('color', 'red');
        title = true;
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

// reload windows after uploaded file

$('#reload').click(function () {
    location.reload(true);
});

// show all the workorder by client
function workOrderData(obj) {
    // console.log(obj)
    let html = '';
    for (let i = 0; i < obj.length; i++) {
        html += `<option value="${obj[i]['work_order_id']}" >${obj[i]['work_order_name']}</option>`
    }
    return html;
}

// loading all the workorder by selected client
$('#select-client').on('change', function () {
    let error = false;
    let clientId = $(this).val();
    if (clientId == " ") {
        $('#message').html('Client Required');
        error = true;
    }
    else {
        $('#message').empty();
    }
    let form_data = { id: clientId };

    if (!error) {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/Auditapp/workorders',
            data: form_data,
            success: function (data, success) {
                let obj = JSON.parse(data);

                data = workOrderData(obj);
                $('#work-order').html(data)
                // console.log(data);
            }

        });
    }
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
                                <input type="radio" name="radio-inline${name[i].id}" value="Team member" class="custom-control-input checked"><span class="custom-control-label">Team member</span>
                                </label>
                                 <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="radio-inline${name[i].id}" value="Team leader" class="custom-control-input checked"><span class="custom-control-label">Team leader</span>
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

    var role = ''
    $('#user-data').on('click','.checked',function(){
        role = $(this).val()        
    })

    $('#user-data').on('click', '.assign-task', function (e) {
        let error = false;
        let radioName = $(this).attr('data-radio-name');
        let employeesId = $(this).attr('data-employees-id');

        let radioValue = $(`input[name=${radioName}]:checked`).val();
        let clientId = $('#select-client').val().trim();
        let workorderId = $('#work-order').val().trim();
        let html = `<tr>
                      <td>${$(this).parent().parent().find('td:first').html()}</td>
                      <td>${$('#work-order option:selected').text()}</td>
                      <td>${role}</td>
                      </tr>`;
        $('#assigned-users').css('display','block');
        $('#assigned_user').append(html);
        $(this).parent().parent().remove()
        // console.log(html)
        if (clientId == '') {
            error = true;
            showAlert('Client required', 'warning');
        }
        if (workorderId == '') {
            showAlert('Work order required', 'warning');
            error = true;
        }
        // console.log(radioValue);
        if (radioValue == undefined) {
            showAlert('Select Access role required', 'danger');
            error = true;
        }
        // let form_data = new FormData();
        let form_data = { employeeId: employeesId, projectRole: radioValue, clientId: clientId, workorderId: workorderId }


        if (!error) {
            $.post(baseUrl + "AssignWorkOrder/save_assigned_work",
                form_data,
                function (data, status) {
                    let responce = JSON.parse(data);
                    showAlert(responce['msg'], responce['type']);
                });
        }
    });

    // save  worksteps 
    $('.save-work-steps').click(function () {
        let workstepsStatus = $(this).attr('data-checkbox-name');
        let workstepsid = $(this).attr('data-work-step-id');
        let workOrderId = $(this).attr('data-workorder-id');
        let checkValue = $(`input[name=${workstepsStatus}]:checked`).val();
        if (checkValue == undefined) {
            alert('Tick box is required to check');
        } else {
            checkValue = 1;
            $.post(baseUrl + "Auditapp/updateWorkSteps", { workstepsid: workstepsid, workOrderId: workOrderId, checkValue: checkValue }, function (data, status) {
                // console.log(data);
            });

        }

    });

});

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
        masterDatabase = JSON.parse(data);
        // console.log(masterDatabase);
    });
});






// date validate function
function ValidateDate() {
    var start = $('#start-date').val();
    var end = $('#end-date').val();
    var startDay = new Date(start);
    var endDay = new Date(end);
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = endDay.getTime() - startDay.getTime();
    var days = millisBetween / millisecondsPerDay;
    // Round down.
    days = Math.floor(days);
    if (days < 0) {
        return true
    } else {
        return false
    }
}
