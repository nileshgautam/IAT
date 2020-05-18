<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid card dashboard-content">
        <h1>Selected Process and sub-process</h1>
        <table class="table table-bordered" id="selected-process">
            <thead id="sspheader">
            </thead>
            <tbody id="ssubprocess">
            </tbody>
        </table>
        <div class="btn-container">
            <button type="button" data-wid='<?php echo $workid; ?>' data-clientid='<?php echo $clientid; ?>' class="btn btn-success assign-workorder">Next</button>
        </div>
    </div>
</div>
<!-- </div> -->
<!-- upload file model -->
<script>
    //    let html='';
    let items = JSON.parse(localStorage.getItem('sspdata'));
    let sspdata = JSON.parse(localStorage.getItem('spdata'));
    // console.log(sspdata);

    // sspdata.forEach(e=>{
    //     console.log(e)
    // })
    let header = `<tr>`;
    let body = `<tr>`;
    // for (i in sspdata) {
    //     header += `
    //                 <th scope="col">${i}</th>`;
    //     for (j in i) {
    //         body += `<tr>
    //                  <td scope="col">${j}</td>
    //                  <>`;
    //         // console.log(j);
    //     }
    //     // body = `</tr>`;
    //     // console.log(i)
    // }
    // header += `</tr>`;






    // localStorage.removeItem('sspdata');
    // console.log(items);
    // console.log(JSON.parse(items));
    // let header = `<tr>`;
    // let body = `<tr>`;
    // let list = [];
    // let cp;
    // let cpc = 0;
    if (items.length != 0) {
        let currentprocess;
        let csp;
        items.forEach(e => {
            // console.log(e)
            // console.log(e.processname);
            // console.log(e.spname);
            if (currentprocess != e.processname) {
                currentprocess = e.processname;
                header += `
                    <th scope="col">${currentprocess}</th>`;
                // if (csp != e.spname) {
                //     csp=e.spname
                body += `
                    <td scope="col">${e.spname}</td>`;
                // }

                // cpc++
            }
            // body += `
            // <td scope="col">${e.spname}</td>`;
        });
        header += `</tr>`
        body += `</tr>`

    }


    // $('#selected-subprocess').append(ssp);
    if (header != '') {
        $('#selected-subprocess').empty();
        $('#sspheader').html(header);
        $('#ssubprocess').html(body);
    }


    // let ssubpArr = [];
    // saveData('sspdata', ssubpArr);
</script>