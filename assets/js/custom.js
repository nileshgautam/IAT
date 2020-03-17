// reload windows after uploaded file

$('#reload').click(function () {
    location.reload(true);
});

// 
$(document).ready(()=>{
    let value = JSON.parse($('#progressVal').val());
    if (value != "") {    
        for (let i = 0; i < value.length; i++) {
            console.log(`${value[i]}`);
            $(`#process-progress${i}`).css('width', `${value[i]}%`);
            console.log($(`#process-progress${i}`).attr('class'))
        }
    }
    });
// $('.complete-process').text(value);