// reload windows after uploaded file
$('#reload').click(function () {
    location.reload(true);
});


// login function
$(function () {
    // setting userdata into the login form
    if (hasData("remember_me")) {
        var data = JSON.parse(localStorage.getItem("remember_me"));
        $('#username').val(data.username);
        $('#password').val(data.password);
        $('#remember_me').prop('checked', true);
    }

    //login function
    $('.login-from').submit(function (e) {
        e.preventDefault();

        console.log('hi');
        let form_data = $(this).serialize();
        let username = $('#username').val();
        let password = $('#password').val();
        // let message;
        $.ajax({
            type: 'POST',
            url: baseUrl + 'Login/auth',
            data: form_data,
            success: function (responce) {
                let data = JSON.parse(responce);
                // console.log(data.msg);
                if (data.msg == 'true') {
                    if (data.remember_me == 1) {
                        var arr = { "username": username, "password": password };
                        saveData("remember_me", arr);
                    }
                    else if (data.remember_me == 0) {
                        removeData('remember_me');
                    }
                }
                if (data.role == 'Admin') {
                    window.location.href = baseUrl + 'admin';
                }
                else if (data.role == 'Team member') {
                    window.location.href = baseUrl + 'member';
                }
                else if (data.role == 'Manager') {
                    window.location.href = baseUrl + 'manager';
                }


                else {
                    showAlert(data.msg, data.type);
                }
            }
        });
    });
});

// 
$(document).ready(() => {
    let process = $('#progressVal').val();
    let totalsteps = $('#totalsteps').val();
    let completeSteps = $('#completeSteps').val();
    let value;

    if (process != undefined || completeSteps != "" || + totalsteps != "") {
        // console.log(process);
        if (process != undefined) {


            let value = JSON.parse(process);
            let totalSteps = JSON.parse(totalsteps);
            let compSteps = JSON.parse(completeSteps);

            for (let i = 0; i < value.length; i++) {
                $(`#process-progress${i}`).css('width', `${value[i]}%`);
                $(`#complete-progress${i}`).text(`${value[i]}%`);
            }
            for (let j = 0; j < totalSteps.length; j++) {
                $(`#total-steps${j}`).text(`${totalSteps[j]}`);
            }
            for (let k = 0; k < compSteps.length; k++) {
                $(`#complete-steps${k}`).text(`${compSteps[k]}`);
            }
        }
    }
    // To calculate all the complete work steps
    const totlaCard = $('.total-card').length;
    const workOrderId = $('#work-orderid').val();
    if (value != undefined) {
        let completWorkorders = 0;
        for (let progress = 0; progress < value.length; progress++) {
            completWorkorders += parseInt(value[progress]);
        }
        // calculating values
        let completeWorkOrder = completWorkorders / totlaCard;
        $.post(baseUrl + "Auditapp/updateWorkorder", { workOrderId: workOrderId, completeWorkOrder: completeWorkOrder }, function (data, status) {
        });
        // console.log(completeWorkOrder);
        // console.log(workOrderId);
    }
    // }

});
// function for client form
$(function () {
    var error = false;
    // function to validate mobile number
    $('#txtmobile').on('change', function () {
        // alert('hi');
        const MOBILENUMBER = $(this).val();
        // console.log(MOBILENUMBER);
        let validate = validateMobileNumber(MOBILENUMBER);
        // console.log(validate);
        if (validate == false) {
            $('#errormobile').text('Number should be 10 digits only.');
            error = true;
        }
    });

    // function to validate GST number should be 10 digit only.

    // $('#inputgstno').on('change', function () {
    //     const GSTNO = $(this).val();
    //     let validate = gstNumberValidate(GSTNO);
    //     console.log(validate);
    //     if (validate != undefined) {
    //         $('#errorgstno').text(validate);
    //         error = true;
    //     }
    //     else {
    //         console.log(validate);
    //     }
    // });
    // function for email validation

    $('#txtEmail').on('change', function () {
        const EMAIL = $(this).val();
        let validate = validateEmail(EMAIL);
        if (validate == false) {
            $('#errorEmail').text('invalid! email');
            error = true;
        }
    });

    let url = undefined;
    $('.client-from').submit(function (e) {

        e.preventDefault();
        let form_data = $(this).serialize();
        // console.log('hi');
        let clientId = $('#client-id').val();
        // console.log(clientId);
        if (clientId == '') {
            url = baseUrl + "Auditapp/clientPost";
        } else {
            url = baseUrl + "Auditapp/saveEditedClient";
        }
        // console.log(clientId);
        // console.log(url);

        if (error != true) {
            // console.log(error);
            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                success: function (responce) {
                    // console.log(responce);
                    let data = JSON.parse(responce);
                    // console.log(data);
                    // console.log(baseUrl+data.path);
                    showAlert(data.message, data.type);
                    if (data.path != undefined)
                        setTimeout(() => {
                            window.location.href = baseUrl + data.path
                        }, 1000);

                }
            });
        }
        else {
            // console.log(error);
            error = 'error';
            showAlert(error, 'danger');
        }
    });
});
//funtion for users

$(function () {
    let error = false;
    $('#input-user-email').on('change', function () {
        const EMAIL = $(this).val();
        const EMAILRESPONCE = validateEmail(EMAIL);
        if (EMAILRESPONCE == false) {
            $('#user-error-email').text('Enter valid email id, i.e. example@example.example.');
            error = true;
        }
        else {
            $('#user-error-email').empty();
            error = false;
        }
    });

    $('#input-user-mobile').on('change', function () {
        const MOBILENUMBER = $(this).val();
        const MOBILERESPONCE = validateMobileNumber(MOBILENUMBER);
        if (MOBILERESPONCE == false) {
            $('#user-error-mobile').text('Enter valid mobile number, i.e.: 9999999999, It should be 10 digits only.');
            error = true;
        }
        else {
            $('#user-error-mobile').empty();
            error = false;
        }
    });

    $('#user-form').submit(function (e) {
        e.preventDefault();
        let form_data = $(this).serialize();
        // console.log('hi');
        const USERID = $('#user-id').val();
        // console.log(clientId);
        if (USERID == '') {
            url = baseUrl + "Auditapp/user_post";
        } else {
            url = baseUrl + "Auditapp/user_editpost";
        }


        // console.log(USERID);
        // console.log(url);

        if (error != true) {
            // console.log(error);
            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                success: function (responce) {
                    // console.log(responce);
                    let data = JSON.parse(responce);
                    // console.log(data);
                    // console.log(baseUrl+data.path);
                    showAlert(data.message, data.type);
                    if (data.path != undefined)
                        setTimeout(() => {
                            window.location.href = baseUrl + data.path
                        }, 1000);

                }
            });
        }
        else {
            // console.log(error);
            showAlert(error, 'danger');
        }
    });

});

$(function () {
    $('.filter-risk-data').on('click', function (e) {
        e.preventDefault();
        let riskData = atob($(this).attr('data-risk'));
        let risk = JSON.parse(riskData);

        if (riskData != '') {
            $.ajax({
                type: 'POST',
                url: baseUrl + 'Auditapp/riskData/' + JSON.stringify(risk),
                success: function (responce) {
                }
            });
        }

        // alert('You clicked on Sub process')
    });
})



// function for Exit button to remove local storage data 
$(function () {
    $('.restore-work-steps').click(function () {
        confirm('Warning! Are you sure want to exit, will remove your filled data');
        if (hasData('rowData')) {
            removeData('rowData');
        }
        window.location.href = baseUrl + 'ControlUnit/teamDashboard';
    })
})



// function to move assignment page



$(function () {
    let data = $('#table-process').attr('process-data');
    let workstepTablebody = $('#process-body');
    let workorderId = $('#table-process').attr('work-order-id');
    let totalRows = [];
    if (data != undefined) {
        let serverResponce = JSON.parse(data);
        let rowData = hasData('rowData');
        if (rowData == false) {
            // let rows = undefined;
            let form_data = {
                workOrderId: workorderId
            };

            $.ajax({
                type: 'GET',
                data: form_data,
                url: baseUrl + 'Auditapp/getSavedWorkSteps',
                success: function (response) {
                    let rows = JSON.parse(response);
                    if (rows.empty != 'false') {

                        totalRows = JSON.parse(rows.saved_data);
                        // console.log(totalRows);
                        localStorage.setItem('rowData', JSON.stringify(totalRows));
                        loadTable(totalRows);
                    } else {
                        localStorage.setItem('rowData', JSON.stringify(serverResponce));
                        totalRows = serverResponce;
                        loadTable(totalRows);
                    }
                }

            });
        }
        else {
            removeData('rowData');
            localStorage.setItem('rowData', JSON.stringify(serverResponce));
            totalRows = JSON.parse(localStorage.getItem('rowData'));
            loadTable(totalRows);
        }

    }
    function loadTable(list) {
        let len = list.length;
        // let Sr = 1;

        console.log(list);


        workstepTablebody.empty();
        for (let i = 0; i < len; i++) {
            let row = $(` <tr>
                    <td class="content">${list[i].count}</td>
                    <td>${list[i].processName}</td>
                    <td>${list[i].subprocess_name}</td>
                    <td>${list[i].riskName}</td>
                    <td>${list[i].risklevel}</td>
                    <td>${list[i].controlName}</td>
                    <td>${list[i].controlobject}</td>
                    <td class="content">${list[i].workstep_name}</td>
                    <td contenteditable="true" class="observations">${list[i].observations}</td>
                    <td contenteditable="true" class="root-cause">${list[i].root_cause}</td>
                    <td contenteditable="true" class="recommendation">${list[i].recommendation}</td>
                    <td contenteditable="true" class="management-action-plan">${list[i].management_action_plan}</td>
                    <td>     <input id="datepicker" class="timeline-for-action-plan" width="276" value="${list[i].timeline_for_action_plan}"/> </td>
                    <td contenteditable="true" class="responsibility-for-implementation">${list[i].responsibility_for_implementation}</td>
                    <td class="files">${list[i].files}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-light uploadfile" data-toggle="modal" data-target="#viewModalCenter" data-control-id='${list[i].count}'> 
                        <i class="fa fa-upload"></i>
                        </button>
                    </td>
            </tr>`);



            // appending rows 
            workstepTablebody.append(row);
            let uploadFile = row.find('.uploadfile');
            uploadFile.data("id", list[i].row_id);
            uploadFile.click(uploadFileKey);


            let observationsText = row.find('.observations');
            observationsText.data("id", list[i].row_id);
            observationsText.data("item_key", 'observations');
            observationsText.keyup(cellKeyUP);

            let rootCause = row.find('.root-cause');
            rootCause.data("id", list[i].row_id);
            rootCause.data("item_key", 'root_cause');
            rootCause.keyup(cellKeyUP);

            let recommendation = row.find('.recommendation');
            recommendation.data("id", list[i].row_id);
            recommendation.data("item_key", 'recommendation');
            recommendation.keyup(cellKeyUP);

            let managementActionPlan = row.find('.management-action-plan');
            managementActionPlan.data("id", list[i].row_id);
            managementActionPlan.data("item_key", 'management_action_plan');
            managementActionPlan.keyup(cellKeyUP);

            let timelineForactionplan = row.find('.timeline-for-action-plan');
            timelineForactionplan.data("id", list[i].row_id);
            timelineForactionplan.data("item_key", 'timeline_for_action_plan');
            timelineForactionplan.blur(onChange);

            let responsibilityForImplementation = row.find('.responsibility-for-implementation');
            responsibilityForImplementation.data("id", list[i].row_id);
            responsibilityForImplementation.data("item_key", 'responsibility_for_implementation');
            responsibilityForImplementation.keyup(cellKeyUP);

        }
    }


    function cellKeyUP() {
        let cellData = $(this);
        let Id = cellData.data('id');
        let item_key = cellData.data('item_key');
        let item = totalRows.find((item) => item.row_id == Id);
        // console.log(totalRows);
        // console.log(Id);
        // console.log(item_key);
        item[item_key] = cellData.text();
        localStorage.setItem('rowData', JSON.stringify(totalRows));
    }

    function onChange() {
        let cellData = $(this);
        let item_key = cellData.data('item_key');
        let cellData_id = cellData.data('id');
        let item = totalRows.find((item) => item.row_id == cellData_id);
        item[item_key] = cellData.val();
        localStorage.setItem('rowData', JSON.stringify(totalRows));
    }

    function uploadFileKey() {
        let cellData = $(this);
        let cellData_id = cellData.data('id');
        $('#row-id').val(cellData_id);
    }




});










// function to save data into the database
$('.save-work-step').on('click', function () {

    // console.log(totalRows);


    let Check = hasData('rowData');
    if (Check == true) {
        tableData = retriveData('rowData');

        let workstepData = JSON.parse(tableData);
        console.log(workstepData[0].observations);

        let data = {
            workOrderId: workOrderId,
            processid: processid,
            subprocessid: subprocessid,
            riskid: riskid,
            controlid: controlid,
            workstepData: workstepData
        }

        if (workstepData[0].observations) {
            $.ajax({
                type: 'POST',
                data: data,
                url: baseUrl + 'Auditapp/commitWorkSteps',
                success: function (response) {
                    let message = JSON.parse(response);
                    showAlert(message['message'], message['type']);
                    removeData('rowData');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });

        } else {
            showAlert('Please Fill data First', 'warning');
        }
    }
});

// uploadfile
$('#uploadfiles').submit(function (e) {
    e.preventDefault();
    let error = false;
    let files = $('#files').val();

    if (files == '') {
        error = true;
        showAlert('Please select file', 'danger');
    }
    // alert(files);
    if (error != true) {
        let form_data = new FormData(this);
        let workOrderId = $('#workorder-id').val();
        let workstepId = $('#worksteps-id').val();
        form_data.append("workOrderId", workOrderId);
        form_data.append("workstepId", workstepId);
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
                if (message['files'] != '') {
                    let filesData = message['files'];
                    let rowID = $('#row-id').val();
                    // console.log()

                    let items = totalRows.find((item) => item.row_id == rowID);
                    items['files'] = filesData[0]['file_name'];
                    localStorage.setItem('rowData', JSON.stringify(totalRows));
                    let path = `<div><a href="${baseUrl + 'upload/files/' + filesData[0]['file_name']}"> ${filesData[0]['file_name']} <a><div>`
                    $('#uploaded_files').append(path);
                    showAlert(message['msg'], message['type']);
                }

            }
        });
    }

});


























// function for local Storage

// Local storage function
function retriveData(FILE_KEY) {
    return localStorage.getItem(FILE_KEY);
}
function saveData(FILE_KEY, data) {
    localStorage.setItem(FILE_KEY, JSON.stringify(data));
}
function hasData(FILE_KEY) {
    return localStorage.hasOwnProperty(FILE_KEY) ? true : false;
    // localStorage 
}

function removeData(FILE_KEY) {
    localStorage.removeItem(FILE_KEY);
    // localStorage 
}



