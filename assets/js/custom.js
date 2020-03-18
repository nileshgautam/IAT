// reload windows after uploaded file

$('#reload').click(function () {
    location.reload(true);
});

// 
$(document).ready(() => {
    let process = $('#progressVal').val();
    let totalsteps = $('#totalsteps').val();
    let completeSteps = $('#completeSteps').val();

    if(process != "" || completeSteps != "" || + totalsteps!= ""){
    let value = JSON.parse(process);
    let totalSteps = JSON.parse(totalsteps);
    let compSteps = JSON.parse(completeSteps);
    // if (value != "" || totalSteps != "" || compSteps != "") {
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
    // To calculate all the complete work steps
    const totlaCard = $('.total-card').length;
    const workOrderId = $('#work-orderid').val();
    if (value != '') {
        let completWorkorders = 0;
        for (let progress = 0; progress < value.length; progress++) {
            completWorkorders += parseInt(value[progress]);
        }
        // calculating values
        let completeWorkOrder = completWorkorders / totlaCard;
        $.post(baseUrl + "Auditapp/updateWorkorder", {workOrderId: workOrderId, completeWorkOrder:completeWorkOrder }, function (data, status) {
        });
        console.log(completeWorkOrder);
        console.log(workOrderId);
    }
// }

});


// $('.complete-process').text(value);