// PO testing

// Function to go back (dashboard) page
$('.back').click(function (e) {
    e.preventDefault();
    if (confirm('Are you sure want to go back?'))
        window.location.href = baseUrl + 'ControlUnit/teamDashboard';
});

// Submit podata for checking
$('#potest-data').submit(function (e) {
    e.preventDefault();
    let error = false;
    const files = document.querySelector('[type=file]').files;
    let formData = new FormData();
    const url = baseUrl + 'PoTesting/readingpodata';
    if (files.length == 0) {
        showAlert('Error! The PO data file is required.', 'danger');
        error = true;
    }

    // for (let i = 0; i < files.length; i++) {
    //     let file = files[i]
    formData.append('files', files[0])
    //   }

    if (!error) {
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (responce) {
                // console.log(responce)
                let data = JSON.parse(responce);
                if (data.type == 'success') {
                    showAlert(data.message, data.type);
                    setTimeout(function () {
                        window.location.href = baseUrl + 'PoTesting/poresults';
                    }, 3000);
                }
                else {
                    showAlert(data.message, data.type);
                    // console.log(data);
                }
            }
        });
    }
});

// Show test list of all Pass/Fail data
$(function () {
    // Function to show pass list
    $('.show-pass-list').on('click', function (e) {
        e.preventDefault();
        let passData = $(this).attr('data-pass');
        // passData=JSON.parse(passData);
        // let formData = new FormData();
        // formData.append("data", passData);
        let podata={data:passData};
        const url = baseUrl + 'PoTesting/poresultDetails/';
        $.post(baseUrl + 'PoTesting/poresultDetails/',
            podata,
            function (data, status) {
                let responce = JSON.parse(data);
                if(responce.type=='success')
                window.location.href = baseUrl + 'PoTesting/showresult';
            });

        // window.location.href = baseUrl + 'PoTesting/poresultDetails/' + btoa(passData);
    });

    // function to fail list
    $('.show-fail-list').on('click', function (e) {
        e.preventDefault();
        let failData = $(this).attr('data-fail');   
        let podata={data:failData};
        $.post(baseUrl + 'PoTesting/poresultDetails/',
            podata,
            function (data, status) {
                let responce = JSON.parse(data);
                // console.log(responce);
                if(responce.type=='success')
                window.location.href = baseUrl + 'PoTesting/showresult';

            });
    });

    $('#result-datatable').DataTable(
        {
            // "scrollY": 250,
            "scrollX": true
        }
    );

});