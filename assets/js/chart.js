$(function () {
  // fecthing workorder data from database
  const URL = baseUrl + 'Auditapp/getCompleteWorkorders';
  $.get(URL, function (data, success) {
    let response = JSON.parse(data);
    let totalprocess = getDataProcess(response);
    workorders(totalprocess);
  });

  function groupByProcess(arr) {
    //Group by array using process id as key
    let processGroup = arr.reduce((r, a) => {
      r[a.process_id] = [...r[a.process_id] || [], a];
      return r;
    }, {});
    // console.log(Object.values(processGroup));
    return Object.values(processGroup);
  }

  // function to draw charts
  function getDataProcess(response) {
    // let savedWorkorders = response.map(function(item){  
    let workordersData = [];
    response.forEach(item => {
      let workorder = {};  //define an empty object to be returned

      //Order saved_data using group by on process id
      let tempData = JSON.parse(item.saved_data);
      let numArray = groupByProcess(tempData);
      let numProcesses = numArray.length; //count process array in workorder
      for (let i = 0; i < numProcesses; i++) {
        let saveData = numArray[i];
        let process_id = saveData[0].process_id;
        let process_description = saveData[0].process_description;
        let obCount = saveData.filter(x => x.observations == '').length;
        let rcCount = saveData.filter(x => x.root_cause == '').length;
        let reCount = saveData.filter(x => x.recommendation == '').length;
        let mapCount = saveData.filter(x => x.management_action_plan == '').length;
        let tapCount = saveData.filter(x => x.timeline_for_action_plan == '').length;
        let rfiCount = saveData.filter(x => x.responsibility_for_implementation == '').length;
        let rowCount = saveData.length;
        let totalFields = rowCount * 6;
        let emptyFields = obCount + reCount + mapCount + tapCount + rfiCount + rcCount;
        let percentInComplete = (totalFields > 0) ? (emptyFields * 100 / totalFields).toFixed(2) : 0;
        let percentComplete = (Number(100).toFixed(2) - percentInComplete).toFixed(2);

        workorder = {
          workOrdersid: item.work_order_id,
          workOrdersname: item.workorder_name,
          process_id: process_id,
          process_processName: process_description,
          //  savedData:      saveData,
          // clientid:       item.client_id,
          // clientname:     item.client_name,
          // userid:         item.user_id,
          // username:       item.user_name,
          // obCount:        obCount,
          // rcCount :       rcCount,
          // reCount :       reCount,
          // mapCount :      mapCount,
          // tapCount :      tapCount,
          // rfiCount :      rfiCount,
          // rowCount :      rowCount,
          totalFields: totalFields,
          emptyFields: emptyFields,
          percentComplete: percentComplete,
          percentInComplete: percentInComplete
        }
        // console.log(workorder);


        workordersData.push(workorder);
      };

    });
    // console.log(workordersData);

    return workordersData;

  }

  const workorders = (data) => {
    let groupdata = groupBy(data, 'workOrdersid');
    // console.log(groupdata);
    let completeworkorder = [];
    let inCompleteworkorder = [];
    for (let element in groupdata) {
      let temp = 0;
      for (let i = 0; i < groupdata[element].length; i++) {
        temp += parseFloat(groupdata[element][i].percentComplete);
      }
      let c = temp / groupdata[element].length;
      if (c == 100) {
        completeworkorder.push(groupdata[element]);
      }
      else {
        inCompleteworkorder.push(groupdata[element]);
      }// console.log('temp'+ temp);
      temp = 0;
    }

    drowcharts(completeworkorder.length, inCompleteworkorder.length);
    completeWorkordersDetails(completeworkorder);
    underProcessWorkordersDetails(inCompleteworkorder);

  }
  // drowing bar charts on manager dashboard************

  function drowcharts(completeorder, underprocess) {
    // Load the Visualization API and the corechart package.
    google.charts.load('current', { 'packages': ['corechart'] });
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
      // workorderLength=2000;
      let complete = completeorder;
      let pending = underprocess;
      let total = pending + complete;
      // var data = new google.visualization.DataTable();
      // data.addColumn('string', 'lable', { role: "style" });
      // data.addColumn('number', 'value', { role: "style" });

      // data.addRows([
      //   ["Total work order", total, "green"],
      //   ["Under process", complete, "tomato"],
      //   ["Under process", pending, "tomato"],
      // ]);


      let data = google.visualization.arrayToDataTable([

        ["Complete", "Under process", { role: "style" }],
        ["Total work order", total, "blue"],
        ["Complete", complete, "green"],
        ["Under process", pending, "tomato"]
      ]);

      var view = new google.visualization.DataView(data);
      var options = {
        title: 'Work orders Staus',
        width: 500,
        legend: { position: 'top' },
        chart: {
          title: 'Work orders complete status',
          subtitle: 'Complete and underprocess work orders'
        },
        bars: 'horizontal', // Required for Material Bar Charts.
        axes: {
          x: {
            0: { side: 'top', label: 'Percentage' } // Top x-axis.
          }
        },
        bar: { groupWidth: "50%" }
      };

      // var options = {
      //   title: "Work order report",
      //   width: 600,
      //   height: 200,
      //   bar: { groupWidth: "50%" },
      //   legend: { position: 'left'},
      //   isStacked: true
      // };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

      // var chart1 = new google.visualization.BarChart(document.getElementById('complete'));

      // The select handler. Call the chart's getSelection() method
      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var value = data.getValue(selectedItem.row, selectedItem.column);
          // showSelectedrow(selectedItem.row)
          switch (selectedItem.row) {
            case 1:
              $('.complete').attr("style", "display:block");
              $('.under-process').attr("style", "display:none");
              break;
            case 2:
              $('.complete').attr("style", "display:none");
              $('.under-process').attr("style", "display:block");

              break;
            default:
              text = "";
          }
          // alert('The user selected ' + selectedItem.row);
        }
      }
      // Listen for the 'select' event, and call my function selectHandler() when
      // the user selects something on the chart.
      google.visualization.events.addListener(chart, 'select', selectHandler);


      // google.visualization.events.addListener(chart1, 'select', selectHandler);


      chart.draw(view, options);
      // chart1.draw(view, options);

    }
  }

  function completeWorkordersDetails(data) {

    for (let i = 0; i < data.length; i++) {
      drowColumnChartcompleteprocess(data[i], i);
    }
  }

  function underProcessWorkordersDetails(data) {
    for (let i = 0; i < data.length; i++) {
      drowColumnChart(data[i], i);
    }
  }
  // column chart for process and sub process
  const drowColumnChartcompleteprocess = (data, rowid) => {
    let completeWO = $('#total-complete-order');
    let process = [];
    let complete = [];
    let incomplete = [];
    let rows = '';
    let workordersName = '';

    for (let i = 0; i < data.length; i++) {
      google.charts.load("current", { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);
      if (workordersName != data[i]['workOrdersname']) {
        rows += `<div class="">
      <span style="color: rgb(255, 152, 0)">${data[i]['workOrdersname']}</span>
      <span id="combarchart${rowid}"></span>
      </div>`;
      } workordersName = data[i]['workOrdersname'];
      process.push(data[i]['process_processName']);
      complete.push(data[i]['percentComplete']);
      incomplete.push(data[i]['percentInComplete']);
      // valuearr.push([data[i]['process_processName'], parseFloat(data[i]['percentComplete']), parseFloat(data[i]['percentInComplete'])],);
      function drawChart() {
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', 'process');
        data1.addColumn('number', 'complete');
        data1.addColumn('number', 'Pending');
        for (i = 0; i < process.length; i++)
          data1.addRow([process[i], parseFloat(complete[i]), parseFloat(incomplete[i])]);
        var options = {
          chart: {
            title: 'Incomplete Work order',
            subtitle: 'Incomplete process',
          }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById(`combarchart${rowid}`));

        chart.draw(data1, options);
      }
    }
    // console.log(valuearr);
    completeWO.append(rows);
    workordersName = '';
  }

  // column chart for under-process 
  const drowColumnChart = (data, rowid) => {

    // console.log(data);
    let underprocessWO = $('#total-underprocess-wo');
    let process = [];
    let complete = [];
    let incomplete = [];
    let rows = '';
    let workordersName = '';

    for (let i = 0; i < data.length; i++) {
      google.charts.load("current", { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);
      if (workordersName != data[i]['workOrdersname']) {
        rows += `<div class="">
      <span style="color: rgb(255, 152, 0)" class="p-2">${data[i]['workOrdersname']}</span>
      <span id="barchart${rowid}"></span>
      </div>`;
      } workordersName = data[i]['workOrdersname'];
      process.push(data[i]['process_processName']);
      complete.push(data[i]['percentComplete']);
      incomplete.push(data[i]['percentInComplete']);
      // valuearr.push([data[i]['process_processName'], parseFloat(data[i]['percentComplete']), parseFloat(data[i]['percentInComplete'])],);
      function drawChart() {
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', 'process');
        data1.addColumn('number', 'complete');
        data1.addColumn('number', 'Pending');
        for (i = 0; i < process.length; i++)
          data1.addRow([process[i], parseFloat(complete[i]), parseFloat(incomplete[i])]);
        var options = {
          chart: {
            title: 'Incomplete Work order',
            subtitle: 'Incomplete process',
          },
          width:900,
          bar: { groupWidth: "20%" }

        };
        var chart = new google.visualization.ColumnChart(document.getElementById(`barchart${rowid}`));

        chart.draw(data1, options);
      }
    }
    // console.log(valuearr);
    underprocessWO.append(rows);
    workordersName = '';



  }
  // Group by function 
  const groupBy = (array, key) => {
    // Return the end result
    return array.reduce((result, currentValue) => {
      // If an array already present for key, push it to the array. Else create an array and push the object
      (result[currentValue[key]] = result[currentValue[key]] || []).push(
        currentValue
      );
      // console.log(currentValue);

      // Return the current iteration `result` value, this will be taken as next iteration `result` value and accumulate
      // console.log(result)
      return result;
    }, {}); // empty object is the initial value for result object
  };
  // find percentages
  const PERCENTAGE = (TOTAL, PERCENTAGE) => {
    return (PERCENTAGE * 100) / TOTAL;
  }
});


