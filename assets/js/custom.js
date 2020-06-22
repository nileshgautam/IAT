// reload windows after uploaded file
$('#reload').click(function () {
    location.reload(true);
});

$('.btn-refrash').click(function () {
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
                else if (data.role == 'Team leader') {
                    window.location.href = baseUrl + 'manager';
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

// function for client form validation
$(function () {
    var error = false;
    let preText = $('#errormobile').text();
    let emailPreText = $('#errorEmail').text();

    // function to validate mobile number
    $('#txtmobile').on('keyup change', function () {
        // alert('hi');
        const MOBILENUMBER = $(this).val();
        let validate = validateMobileNumber(MOBILENUMBER);
        // console.log(validate);

        if (validate == false) {
            $('#errormobile').addClass("text-danger");
            $('#errormobile').text('Enter valid mobile number, i.e.: 999-999-9999, It should be 10 digits only.');
            $('#errormobile').focus();
            error = true;
        }
        else if (validate == true) {
            $('#errormobile').text(preText);
            $('#errormobile').removeClass("text-danger");


            error = false;
        }
    });

    // function to validate GST number should be 10 digit only.

    // $('#inputgstno').on('change', function () {
    //     const GSTNO = $(this).val();
    //     let validate = gstNumberValidate(GSTNO);
    //     console.log(validate);
    //     if (validate != undefined) {
    //         $('#errorgstno').text(validate);
    //         $('#errorgstno').addClass("text-danger");
    //         error = true;
    //     }
    //     else {
    //         console.log(validate);
    //     }
    // });

    // function for email validation

    $('#txtEmail').on('keyup change', function () {
        const EMAIL = $(this).val();
        let validate = validateEmail(EMAIL);
        if (validate == false) {
            $('#errorEmail').text('Enter valid email id, i.e. example@example.example.');
            $('#errorEmail').addClass("text-danger");
            $('#errorEmail').focus();


            error = true;
        }
        else if (validate == true) {
            $('#errorEmail').text(emailPreText);
            $('#errorEmail').removeClass('text-danger');
            error = false;
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
            showAlert('Warning!  (*) field are required', 'warning');
            error = true;
        }
    });
});

//funtion for user form validation
$(function () {

    let error = false;
    let emailPretext = $('#user-error-email').text();
    let mobilePretext = $('#user-error-mobile').text();

    $('#input-user-email').on('keyup change', function () {
        const EMAIL = $(this).val();
        const EMAILRESPONCE = validateEmail(EMAIL);
        if (EMAILRESPONCE == false) {
            $('#user-error-email').text('Enter valid email id, i.e. example@example.example.');
            $('#user-error-email').addClass('text-danger');
            error = true;
        }
        else if (EMAILRESPONCE == true) {
            $('#user-error-email').text(emailPretext);
            $('#user-error-email').removeClass('text-danger');
            error = false;
        }
    });

    $('#input-user-mobile').on('keyup change', function () {
        const MOBILENUMBER = $(this).val();
        const MOBILERESPONCE = validateMobileNumber(MOBILENUMBER);
        if (MOBILERESPONCE == false) {
            $('#user-error-mobile').text('Enter valid mobile number, i.e.: 999-999-9999, It should be 10 digits only.');
            $('#user-error-mobile').addClass('text-danger');
            error = true;
        }
        else if (MOBILERESPONCE == true) {
            $('#user-error-mobile').text(mobilePretext);
            $('#user-error-mobile').removeClass('text-danger');
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
            showAlert('Warning!  (*) field are required', 'warning');
            error = true;
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
});

// Function for Exit button to remove local storage data 
$(function () {
    $('.restore-work-steps').click(function () {
        confirm('Warning! Are you sure want to exit, will remove your filled data');
        if (hasData('rowData')) {
            removeData('rowData');
        }
        window.location.href = baseUrl + 'ControlUnit/teamDashboard';
    })
});

// Function to load workorder and list of all the required stuff
$(function () {
    let data = $('#table-process').attr('process-data');

    let workstepTablebody = $('#process-body');
    let table=$('#table-process');

    let workorderId = $('#table-process').attr('work-order-id');
    let totalRows = [];
    if (data != undefined) {
        let serverResponce = JSON.parse(data);
        let rowData = hasData('rowData'); // checking data in local storeage
        if (rowData == false) {
            let form_data = {
                workOrderId: workorderId
            };
            $.ajax({
                type: 'GET',
                data: form_data,
                url: baseUrl + 'Auditapp/getSavedWorkSteps',
                success: function (response) {
                    let rows = JSON.parse(response);
                    // console.log(rows);
                    if (rows.responase != 'false') {
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
            totalRows = JSON.parse(localStorage.getItem('rowData'));
            loadTable(totalRows);
        }

    }
    // function to generate table rows 
    function loadTable(list) {
        let len = list.length;
        let options;
        workstepTablebody.empty();
        for (let i = 0; i < len; i++) {
            let row = $(` <tr >
                    <td class="content">${list[i].row_id}</td>
                    <td colspan="1">${list[i].process_description}</td>
                    <td colspan="1">${list[i].sub_process_description}</td>
                    <td colspan="1">${list[i].risk_description}</td>
                    <td> <select class="form-control risk-level" value="${list[i].risk_level}">
                    </select></td>
                    <td  style="width:363px">${list[i].control_description}</td>
                    <td>${list[i].control_objectives}</td>
                    <td class="content">${list[i].step_description}</td>
                    <td contenteditable="true" class="observations">${list[i].observations}</td>
                    <td contenteditable="true" class="root-cause">${list[i].root_cause}</td>
                    <td contenteditable="true" class="recommendation">${list[i].recommendation}</td>
                    <td contenteditable="true" class="management-action-plan">${list[i].management_action_plan}</td>
                    <td class="date" style="width:100px"> <input class="timeline-for-action-plan" placeholder="DD/MM/YYYY"   value="${list[i].timeline_for_action_plan}"/> </td>
                    <td contenteditable="true" class="responsibility-for-implementation">${list[i].responsibility_for_implementation}</td>
                    <td class="files"><a href="${baseUrl + 'upload/files/' + list[i].files}">${list[i].files}</a></td>
                    <td style="width:38px">
                        <button class="btn btn-sm btn-outline-light uploadfile" data-toggle="modal" data-target="#viewModalCenter" data-workstep-id='${list[i].workstep_id}' data-row-id='${list[i].row_id}'> 
                        <i class="fa fa-upload"></i>
                        </button>
                    </td>
            </tr>`);

            // appending rows 
            // TOTALROWS=row;
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
            timelineForactionplan.datepicker({
                format: 'dd/mm/yyyy'
            });

            let responsibilityForImplementation = row.find('.responsibility-for-implementation');
            responsibilityForImplementation.data("id", list[i].row_id);
            responsibilityForImplementation.data("item_key", 'responsibility_for_implementation');
            responsibilityForImplementation.keyup(cellKeyUP);

            let risk_level = row.find('.risk-level');
            risk_level.data("id", list[i].row_id);
            risk_level.data("item_key", 'risk_level');

            $.post(baseUrl + "Auditapp/getRisklevel", function (data, status) {
                RISKLEVEL = JSON.parse(data);
                options = RISKLEVEL.map((rl) => {
                    let optionTemplate
                    if (rl.status == list[i].risk_level) {
                        optionTemplate = $(`<option value="${rl.status}" selected>${rl.status}</option>`);
                    } else {
                        optionTemplate = $(`<option value="${rl.status}">${rl.status}</option>`);
                    }
                    // console.log(optionTemplate);
                    return optionTemplate;
                });
                risk_level.append(options)
            });
            risk_level.change(package_onchange);

            // risk_level.append(options);
        }

        table.DataTable({
            scrollX: true,
            scrollY: '50vh',
            "ordering": false,
            "searching": false,
            "paging": false,
            "info": false
        });
    }

    function package_onchange() {
        let rikslevel = $(this);
        // console.log(rikslevel);
        let item_key = rikslevel.data('item_key');
        // console.log(item_key);
        let cellData_id = rikslevel.data('id');
        // console.log(cellData_id);

        let item = totalRows.find((item) => item.row_id == cellData_id);

        // item[item_key] = escape(rikslevel.val());
        item[item_key] = escape(rikslevel.val());



        // removeSpecialChar(

        // console.log(item[item_key]);

        localStorage.setItem('rowData', JSON.stringify(totalRows));

    }

    function cellKeyUP() {
        let cellData = $(this);
        let Id = cellData.data('id');
        let item_key = cellData.data('item_key');
        let item = totalRows.find((item) => item.row_id == Id);
        // item[item_key] = escape(cellData.text());
        item[item_key] = removeSpecialChar(cellData.text());

        localStorage.setItem('rowData', JSON.stringify(totalRows));
    }

    function onChange() {
        let cellData = $(this);
        let item_key = cellData.data('item_key');
        let cellData_id = cellData.data('id');
        let item = totalRows.find((item) => item.row_id == cellData_id);
        item[item_key] = removeSpecialChar(cellData.val());
        localStorage.setItem('rowData', JSON.stringify(totalRows));
    }

    function uploadFileKey() {
        let cellData = $(this);
        let cellData_id = cellData.data('id');
        $('#row-id').val(cellData_id);
        let wid = cellData.attr('data-workstep-id');
        $('#row-id').attr('ctrl_id', wid);
    }


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
            let ctrl_id = $('#row-id').attr('ctrl_id');
            form_data.append("workstepId", ctrl_id);

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

                    if (message['file_name']) {

                        let filesData = message['file_name'];

                        let rowID = $('#row-id').val();

                        // console.log(filesData)

                        let items = totalRows.find((item) => item.row_id == rowID);


                        items['files'] = filesData;

                        localStorage.setItem('rowData', JSON.stringify(totalRows));

                        showAlert(message['msg'], message['type']);
                    }
                    else {
                        showAlert(message['msg'], message['type']);
                    }

                }
            });
        }
    });

    // function to save data into the database
    $('.save-work-step').on('click', function () {
        clientID = $(this).attr('data-client-id');
        clientName = $(this).attr('data-client-name');
        let Check = hasData('rowData');
        let workorderName = $('#work-order-name').text().trim();
        if (Check == true) {
            tableData = retriveData('rowData');
            let workstepData = JSON.parse(tableData);
            // console.log(workstepData);

            let data = {
                workOrderId: workorderId,
                workorderName: workorderName,
                clientId: clientID,
                clientName: clientName,
                workstepData: workstepData
            }

            if (confirm('Are you sure, you filled all field?')) {
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
                showAlert('Please Fill all field First', 'warning');
            }
        }
    });
});

// for moving one container to another
$(function () {
    $('.subprocess-item').on('click', '.sub-item', function () {
        let controlData = '';
        let controlObjective = '';
        let riskData = '';
        let subProcessId = $(this).attr('data-spid');
        let rdata = JSON.parse($(this).attr('data-risk'));
        let rcontainer = $('#risk-control').hasClass('hide');
        // console.log(rdata);
        // console.log(rcontainer);
        if (subProcessId != '') {
            for (let r = 0; r < rdata.length; r++) {
                // console.log(data[i]);
                riskData += `
                <li>${rdata[r].risk_description}
                <input type="radio" id="risk${rdata[r].risk_id}" name="risk" value="${rdata[r].risk_level}">
                <label for="">${rdata[r].risk_level}</label>
            </li>
                `;
            }

            $.ajax({
                type: 'POST',
                url: baseUrl + 'Auditapp/get_riskControl',
                data: { id: subProcessId },
                success: function (responce) {
                    let data = JSON.parse(responce);
                    // console.log(data);
                    // for(let r=0; i<data.length)
                    for (let i = 0; i < data.length; i++) {
                        controlData += `
                        <li><span>${data[i].control_description}</span>
                    </li>
                        `;
                        controlObjective += `
                        <li><span>${data[i].control_objectives}</span>

                    </li>
                        `;
                    }
                    // console.log(data);
                    if (rcontainer == true) {
                        // console.log('hi')
                        $('#risk-container').empty();
                        $('#control-container').empty();
                        $('#control-bojective-container').empty();

                        $('#risk-container').html(riskData);
                        $('#control-container').html(controlData);
                        $('#control-bojective-container').html(controlObjective);
                        $("#risk-control").removeClass("hide").addClass("show");
                    }
                    else {
                        // $("#risk-control").hide();
                        $("#risk-control").removeClass("show").addClass("hide");
                    }
                }
            })
        }
    });

    $('.selected-subprocess').on('click', '.remove-item', function () {
        let controlData = '';
        let controlObjective = '';
        let riskData = '';
        let subProcessId = $(this).attr('data-spid');
        let rdata = JSON.parse($(this).attr('data-risk'));
        let rcontainer = $('#risk-control').hasClass('hide');
        // console.log(rdata);
        // console.log(rcontainer);
        if (subProcessId != '') {
            for (let r = 0; r < rdata.length; r++) {
                // console.log(data[i]);
                riskData += `
                <li>${rdata[r].risk_description}
                <input type="radio" id="risk${rdata[r].risk_id}" name="risk" value="${rdata[r].risk_level}">
                <label for="">${rdata[r].risk_level}</label>
            </li>
                `;
            }

            $.ajax({
                type: 'POST',
                url: baseUrl + 'Auditapp/get_riskControl',
                data: { id: subProcessId },
                success: function (responce) {
                    let data = JSON.parse(responce);
                    // console.log(data);
                    // for(let r=0; i<data.length)
                    for (let i = 0; i < data.length; i++) {
                        controlData += `
                    <li><span>${data[i].control_description}</span>
                    </li>`;
                        controlObjective += `<li><span>${data[i].control_objectives}<span></li>`;
                    }
                    // console.log(data);
                    if (rcontainer == true) {
                        // console.log('hi')
                        $('#risk-container').empty();
                        $('#control-container').empty();
                        $('#control-bojective-container').empty();
                        $('#risk-container').html(riskData);
                        $('#control-container').html(controlData);
                        $('#control-bojective-container').html(controlObjective);
                        $("#risk-control").removeClass("hide").addClass("show");
                    }
                    else {
                        // $("#risk-control").hide();
                        $("#risk-control").removeClass("show").addClass("hide");
                    }
                }
            })
        }
    });
    let sspObj = {}; // selected sub process global object
    let ssubpArr = [];//selected subprocess global array
    $('.subprocess-item').on('dblclick', '.sub-item', function () {
        // console.log(ssubpArr)
        let temp = (this);
        // console.log(temp);
        $(this).parent().parent().parent().siblings().children(1).children('ul').append(temp); // element move to selected box
        // $('.ssubp-element').append(this);
        let processId = $(temp).attr('data-process-id'); //process id
        let spId = $(temp).attr('data-spid');// sub process id
        let risk = JSON.parse($(temp).attr('data-risk')); // sub process risk data risk data
        let spname = $(temp).text().trim(); // sub process name
        // console.log(spname);
        let processName = $(temp).attr('data-process-name').trim();
        sspObj = {
            spId: spId,
            spname: spname,
            processId: processId,
            processname: processName,
            riskData: risk
        };

        let lsd = JSON.parse(retriveData('sspdata'));
        // console.log(lsd);
        if (lsd != null) {
            if (lsd.length == 0) {
                ssubpArr = [];
                removeData('sspdata');
                ssubpArr.push(sspObj);

            } else {
                ssubpArr.push(sspObj);
            }
        } else {
            ssubpArr.push(sspObj);
        }
        // console.log(ssubpArr)
        saveData("sspdata", ssubpArr); //selected sub process data save on localstorage
    });
    // console.log(ssp);
    $('.selected-subprocess').on('dblclick', '.remove-item', function () {
        let temp = $(this);
        let spId = $(temp).attr('data-spid');// sub process id
        // console.log(spId);
        $(this).parent().parent().parent().siblings().children(0).children('ul').append(temp);
        let ckecklocal = hasData('sspdata');

        if (ckecklocal == true) {
            let localStorageData = retriveData('sspdata');
            removeData('sspdata');
            // let c = hasData('sspdata');
            // console.log(c);
            let itemarr = JSON.parse(localStorageData);
            // console.log(itemarr);
            const idToRemove = spId;
            const filteredsubprocess = itemarr.filter((item) => item.spId !== idToRemove);
            // console.log(filteredsubprocess);
            saveData("sspdata", filteredsubprocess);

        }
    });
    // function to submit all the process
    $('.submit-services').on('click', function () {
        // let proceesId = [];
        let process = {};
        let spdata = {};
        let checkdata = hasData('sspdata');
        if (checkdata) {
            let sspdata = JSON.parse(retriveData('sspdata'));

            // sspdata.forEach(e => {
            //     let processName = e.processname;
            //     let subprocessname = e.spname;
            //     // console.log(processName)

            //     if(spdata[processName]===undefined){
            //         spdata = {
            //             [processName]: {spname: [subprocessname]},
            //             ...spdata
            //         };                    
            //     }
            //     else{
            //         spdata[processName]= { spname: [subprocessname], ...spdata[processName]};

            //     }

            //     });

            //     console.log(spdata);




            // console.log(sspdata);
            sspdata.forEach(e => {
                let processid = e.processId;
                let subpid = e.spId;
                let riskData = e.riskData;
                // let processName = e.processname;
                // let subprocessname = e.spname;
                // console.log(processid);
                // console.log(subpid);
                // console.log(riskData);
                if (process[processid] === undefined) {
                    process = {
                        [processid]: { [subpid]: riskData },
                        ...process,
                    };
                    // spdata = {
                    //     [processName]: [subprocessname],
                    //     ...spdata
                    // };

                } else {
                    // console.log(process);
                    process[processid] = { [subpid]: riskData, ...process[processid] };
                    // spdata[processName] = {
                    //     [subprocessname]: [subprocessname],
                    //     ...spdata
                    // };
                }

            });
        }
        // console.log(spdata);
        saveData('spdata', process);
        let message = "Required";
        // console.log($("[type='text']"))
        let clientId = $('#client').val().trim();
        let workorderId = $('#textWork-Order-id').val().trim();
        let workOrderName = $('#textWork-Order-Name').val().trim();
        let startDate = $('#start-date').val().trim();
        let endDate = $('#end-date').val().trim();
        let error = false;
        // console.log(`start date ${startDate} nd date ${endDate}`);

        if (clientId == "") {
            $('#messageclient').html(message)
            $('#client').focus();
            error = true;
        } if (workorderId == "") {
            $('#messageworkorderid').html(message)
            error = true;
        } if (workOrderName == "") {
            $('#messageworkorder').html(message)
            $('#textWork-Order-Name').focus();
            error = true;
        }
        if (startDate == '') {
            $('#start-date').focus();
            error = true;
        }
        if (Object.keys(process).length == 0) {
            showAlert('Please choose process first', "warning");
            error = true;
        }

        // console.log(process);

        if (error != true) {
            let formData = { client_id: clientId, workorderId: workorderId, workOrderName: workOrderName, process: JSON.stringify(process), sdate: startDate, enddate: endDate };
            // console.log(formData);
            // console.log(error);
            $.ajax({
                type: 'POST',
                url: baseUrl + 'Auditapp/create_work_order',
                data: formData,
                success: function (data, success) {
                    // ssubpArr = [];
                    // saveData('sspdata', ssubpArr);
                    // removeData('sspdata'); //Removeing loacl storage object 
                    let resonce = JSON.parse(data);
                    // console.log(resonce);
                    showAlert(resonce.msg, "success");
                    // console.log(baseUrl + "AssignWorkOrder/allowcated_work_order/" + btoa(resonce.client_id));

                    setTimeout(() => {
                        window.location = baseUrl + "ControlUnit/selectedSubprocess/" + btoa(resonce.client_id) + '/' + btoa(resonce.work_order_id);
                    }, 1000);
                }

            });
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.assign-workorder').click(function () {
        let client_id = $(this).attr('data-clientid');
        let work_order_id = $(this).attr('data-wid');
        // console.log(client_id);
        // console.log(work_order_id);
        window.location = baseUrl + "AssignWorkOrder/allowcated_work_order/" + client_id + '/' + work_order_id;
    });
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

// function for back button

$(function () {
    $('#back-to-admin-dashboard').click(function () {
        window.location.href = baseUrl + 'dashboard';
    });
})

// functiont to RemoveSpecialChar
function removeSpecialChar(value) {
    result = value.replace(/[^\w\s]/gi, '');
    return result;
}