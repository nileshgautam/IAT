// reload windows after uploaded file

$('#reload').click(function () {
    location.reload(true);
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


// $(function () {

//     // set required data to the model
//     $('.set-data').click(function () {
//         let WorkStepsid = $(this).attr('data-work-step-id');
//         let controlid = $(this).attr('data-control-id');
//         $('#control-id').val(controlid);
//         $('#worksteps-id').val(WorkStepsid);
//     });

    // saveing worksteps
    // $('#save-worksteps-data').submit(function (e) {
    //     e.preventDefault();
    //     let error = false;
    //     let form_data = $(this).serialize();
    //     let url = baseUrl + "Auditapp/commitWorkSteps";
    //     let observations = $('#observations').val();
    //     if (observations == '') {
    //         error = true;
    //         showAlert('Please required required', 'danger');
    //     }
    //     if (error != true) {
    //         $.ajax({
    //             type: 'POST',
    //             url: url,
    //             data: form_data,
    //             success: function (responce) {
    //                 let data = JSON.parse(responce);
    //                 console.log(data);
    //                 showAlert(data.message, data.type);
    //                 setTimeout(() => {
    //                     location.reload();
    //                 }, 1000);

    //             }
    //         });
    //     }
    // });
// });

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

// updating worksteps data
$(function () {
// $('#table-work-steps').load(function(){
//     console.log('hi i am in');
// });


// workstepId

// workstepTable.load(function(){
//     CountRows(workstepTable);
// });
    // $('#workstep-data').on('blur', '.save-work-step-data', function () {
    //     let workOrderId = JSON.parse($(this).attr('data-workorder-id'));
    //     let workstepId = $(this).attr('data-work-step-id');
    //     let content = $(this).text();
    //     let data = {workOrderId: workOrderId, workstepId: workstepId, content: content }
    //     if (content != '') {
    //         $.ajax({
    //             type: 'POST',
    //             data: data,
    //             url: baseUrl + 'Auditapp/updateWorkSteps',
    //             success: function (responce) {
    //             }
    //         });

    //     }

    // });

    $('.restore-work-steps').click(function(){
confirm('Warning! Are you sure want to exit, will remove your filled data');
        if(hasData('rowData')){
            removeData('rowData');
        }
        window.location.href=baseUrl+'ControlUnit/teamDashboard';
    })

   
});


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




