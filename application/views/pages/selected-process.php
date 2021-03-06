<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container dashboard-content">
        <div class="card">

            <div class="card-header">
                Selected Process and sub-process
                <a class="btn btn-danger float-right btn-space btn-xs" href="<?php echo base_url('dashboard') ?>">Exit</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="selected-process">
                    <thead id="sspheader">
                    </thead>
                </table>
                <div class="btn-container">
                    <button type="button" data-wid='<?php echo $workid; ?>' data-clientid='<?php echo $clientid; ?>' class="btn btn-success assign-workorder btn-xs">Next</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- </div> -->
<!-- upload file model -->
<script>
    let items = JSON.parse(localStorage.getItem('sspdata'));

    items.forEach(e => {
        console.log(e.processname)
    });

    let html = ``;

    let currentProcess = '';

    items.forEach(item => {
        if (currentProcess != item.processname) {
            currentProcess = item.processname;
            html += `<tr>
            <th colspan="2" scope="col">${item.processname}</th>
            </tr>`;
        }

        html += `<tr><td></td><td scope="col">${item.spname}</td></tr>`;
    });


    // console.log(html);
    if (html != '') {
        $('#selected-subprocess').empty();
        $('#sspheader').html(html);

    }
</script>