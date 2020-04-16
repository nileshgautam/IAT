$(function () {
  // fecthing workorder data from database
  const URL = baseUrl + 'Auditapp/getCompleteWorkorders';
  $.get(URL, function (data, success) {
    let response = JSON.parse(data);
    // console.log(response);
    generatedashboard(response)
  });

  // function to drow charts
  function generatedashboard(response) {
    let savedWorkorders = [];
    let finalrow = [];
    for (let i = 0; i < response.length; i++) {
      let workorders = {
        workOrdersid: response[i].work_order_id,
        savedData: JSON.parse(response[i].saved_data)
      }
      savedWorkorders.push(workorders)
    }
    // console.log(savedWorkorders);

    for (let j = 0; j < savedWorkorders.length; j++) {
      let observationCount = 0;
      let rootcauseCount = 0;
      let recommendationCount = 0;
      let management_action_planCount = 0;
      let timeline_for_action_planCount = 0;
      let responsibility_for_implementationCount = 0;

      savedWorkorders[j].savedData.map((ob, index) => {
        if (ob.observations == '') {
          observationCount++
        }
        if (ob.root_cause == '') {
          rootcauseCount++
        }
        if (ob.recommendation == '') {
          recommendationCount++
        }
        if (ob.management_action_plan == '') {
          management_action_planCount++
        }
        if (ob.timeline_for_action_plan == '') {
          timeline_for_action_planCount++
        }
        if (ob.responsibility_for_implementation == '') {
          responsibility_for_implementationCount++
        }
      });

      let emptyCell = responsibility_for_implementationCount + timeline_for_action_planCount + management_action_planCount + recommendationCount + rootcauseCount + observationCount;
      let totalCell = savedWorkorders[j].savedData.length * 6;
      let f = {
        workID: savedWorkorders[j].workOrdersid,
        totalcell: totalCell,
        emptyCell: emptyCell,
        completeCell: totalCell - emptyCell,
        worksteps: savedWorkorders[j].savedData.length
      };
      finalrow.push(f)
    }

    // console.log(finalrow);

    let completeWorkorders = []; // variable for storing finalcomplete workorders
    let underprocessarr = [];
    let completeWorkordercounter = 0;
    let underprocessWorkorder = 0;
    finalrow.map((obj, index) => {
      // console.log(obj);
      if (obj.totalcell == obj.completeCell) {
        completeWorkordercounter++;
        completeWorkorders.push(obj);
      } else {
        underprocessWorkorder++;
        // underprocessarr.push(JSON.stringify(obj));

        underprocessarr.push(obj);

      }
    });
    // calling dricharts funtion to show chart, passing variables are declared
    drowcharts(completeWorkordercounter, underprocessWorkorder);
    completeWorkordersDetails(completeWorkorders);
    underProcessWorkordersDetails(underprocessarr)

  }
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
      let data = google.visualization.arrayToDataTable([

        ["work order", "work-order", { role: "style" }],

        ["Complete", complete, "green"],
        ["Under process", pending, "tomato"]
      ]);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
        {
          calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation"
        },
        2]);

      var options = {
        title: "Work order report",
        width: 600,
        height: 200,
        bar: { groupWidth: "50%" },
        legend: { position: "none" },
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

      // The select handler. Call the chart's getSelection() method
      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var value = data.getValue(selectedItem.row, selectedItem.column);
          showSelectedrow(selectedItem.row)
          // alert('The user selected ' + selectedItem.row);
        }
      }
      // Listen for the 'select' event, and call my function selectHandler() when
      // the user selects something on the chart.
      google.visualization.events.addListener(chart, 'select', selectHandler);

      chart.draw(view, options);
    }
  }
  // function to show the selected bar data
  function showSelectedrow(id) {
    switch (id) {
      case 0:
        $('.complete').attr("style", "display:block");
        $('.under-process').attr("style", "display:none");
        break;
      case 1:
        $('.complete').attr("style", "display:none");
        $('.under-process').attr("style", "display:block");

        break;
      default:
        text = "";
    }
  }

  function completeWorkordersDetails(data) {

    // console.log(data.length);
    let completeWO = $('#totla-complete-order');
    let rows = '';
    const objectArray = Object.entries(data);
    // console.log(objectArray);
    objectArray.forEach(([key, value]) => {
      // console.log(value); // 1/\
      let completeSteps = PERCENTAGE(value.totalcell, value.completeCell);
      // let donut=key;
      drowdonutForCompleteChart(completeSteps, key);

      rows += `<div class="">
     <span style="color: rgb(255, 152, 0)"> ${value.workID}</span>      
     <span> Total work steps </span ><span class="text-success">
     ${value.worksteps}
     </span>
     <span id="iddonut${key}"></span>

     </div>`;
    });
    completeWO.append(rows);
  }

  function underProcessWorkordersDetails(data) {
    // console.log(data.length);
    let underprocessWO = $('#totla-underprocess-wo');
    let rows = '';
    const objectArray = Object.entries(data);
    // console.log(objectArray);
    objectArray.forEach(([key, value]) => {
      console.log(value); // 1
      let completeSteps = PERCENTAGE(value.totalcell, value.completeCell);
      let pendingTask=PERCENTAGE(value.totalcell, value.emptyCell);
      drowdonutForUnderprocessChart(completeSteps,pendingTask, value.worksteps, key);
      rows += `<div class="">
      <span style="color: rgb(255, 152, 0);">${value.workID} </span>      
      <span > Total work steps</span>${value.worksteps}<span id=donut-underprocess${key}>
      </span>
      </div>`;
    });
    underprocessWO.append(rows);
  }

  // find percentages
  const PERCENTAGE = (TOTAL, PERCENTAGE) => {
    return (PERCENTAGE * 100) / TOTAL;
  }

  // function for complete donut chart
  const drowdonutForCompleteChart = (inputdata, key) => {
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Completed'],
        ['Work order', inputdata]
      ]);

      var options = {
        title: 'Activities',
        width:500,
        pieHole: 0.4,
      };
      var chart = new google.visualization.PieChart(document.getElementById(`iddonut${key}`));
      chart.draw(data, options);
    }

  }

// function for show pending process donut chart

  const drowdonutForUnderprocessChart = (complete,pending, worksteps, key) => {
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', ' Per work order'],
        ['Completed',complete],
        ['Pending',      pending]
     
      ]);
      var options = {
        title: 'Activities',
        width:500,
        pieHole: 0.4,
      };
      var chart = new google.visualization.PieChart(document.getElementById(`donut-underprocess${key}`));
      chart.draw(data, options);
    }

  }

});


