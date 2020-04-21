$(function () {
  // fecthing workorder data from database
  const URL = baseUrl + 'Auditapp/getCompleteWorkorders';
  $.get(URL, function (data, success) {
    let response = JSON.parse(data);
    // console.log(response);
    generatedashboard(response)
  });
  

  function groupByProcess(arr){
     //Group by array using process id as key
     let processGroup = arr.reduce((r, a) => {
       r[a.process_id] = [...r[a.process_id] || [], a];
       return r;
      }, {});

     return Object.values(processGroup); 
  }

  // function to draw charts
  function generatedashboard(response) {
    
      // let savedWorkorders = response.map(function(item){  
      let workordersData=[];
      response.forEach(item => {
        
     
      let workorder = {};  //define an empty object to be returned

      //Order saved_data using group by on process id
      let tempData = JSON.parse(item.saved_data);
      let numArray = groupByProcess(tempData);
      let numProcesses = numArray.length; //count process array in workorder
      
      
      for (let i=0;i<numProcesses;i++){
         
          let saveData = numArray[i];    
          let process_id = saveData[0].process_id;
          let obCount  = saveData.filter(x => x.observations == '').length;
          let  rcCount = saveData.filter(x => x.root_cause == '').length;
          let  reCount = saveData.filter(x => x.recommendation == '').length;
          let  mapCount = saveData.filter(x => x.management_action_plan == '').length;
          let  tapCount = saveData.filter(x => x.timeline_for_action_plan == '').length;
          let  rfiCount = saveData.filter(x => x.responsibility_for_implementation == '').length;
          let  rowCount = saveData.length;
          let  totalFields =   rowCount*6;
          let  filledFields = obCount+reCount+mapCount+ tapCount+rfiCount;
          let  percentComplete = (totalFields >0)? (filledFields*100/totalFields).toFixed(2):0;
          let  percentInComplete = (Number(100).toFixed(2)-percentComplete).toFixed(2);
         
          workorder = {
            workOrdersid:   item.work_order_id,
            workOrdersname: item.workorder_name,
            process_id:     process_id,
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
            // totalFields:    totalFields,
            // filledFields:   filledFields,
            percentComplete: percentComplete,
            percentInComplete: percentInComplete    
          }
     
      workordersData.push(workorder);
    };
      
  });
  console.log(workordersData);
  return workordersData;
    
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
     <span style="color: rgb(255, 152, 0)"> ${value.workName}</span>      
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
      // console.log(value); // 1
      let completeSteps = PERCENTAGE(value.totalcell, value.completeCell);
      let pendingTask = PERCENTAGE(value.totalcell, value.emptyCell);
      drowdonutForUnderprocessChart(completeSteps, pendingTask, value.worksteps, key);
      drowColumnChart(key);

      rows += `
      <div class=" m-5 p-2">
      <span style="color: rgb(255, 152, 0);"> ${value.workName} </span>
      <span> Total work steps ${value.worksteps} </span> 
      <div class="row">
    
    <div class="col-md-4">      
    <span id=donut-underprocess${key}>  </span>
    </div>
    <div class="col-md-8">     
   <span id=columnchart_values${key} style="width: 800px; height: 500px;"></span>
    </div>
</div>

  </div>
  <hr/>`;
    });
    underprocessWO.append(rows);
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
        width: 500,
        pieHole: 0.4,
        pieSliceTextStyle: {
          color: 'black',
        },
        title: 'Activities'
      };
      var chart = new google.visualization.PieChart(document.getElementById(`iddonut${key}`));
      chart.draw(data, options);
    }

  }

  // function for show pending process donut chart
  const drowdonutForUnderprocessChart = (complete, pending, worksteps, key) => {
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', ' Per work order'],
        ['Completed', complete],
        ['Pending', pending]

      ]);
      var options = {
        title: 'Activities',
        pieHole: 0.5,
        pieSliceTextStyle: {
          color: 'white',
        }
        // legend: 'none'
      };
      var chart = new google.visualization.PieChart(document.getElementById(`donut-underprocess${key}`));
      chart.draw(data, options);


    }

  }

  // column chart for process and sub process
  const drowColumnChart = (key) => {
    google.charts.load("current", { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['process', 'complete', 'Pending'],
        ['p1', 5, 2],
        ['p2', 6, 7,],
        ['p3', 5, 1],
        ['p4', 1, 10]
      ]);

      var options = {
        chart: {
          title: 'Company Performance',
          subtitle: 'Sales, Expenses, and Profit: 2014-2017',
        }


      };
      var chart = new google.visualization.ColumnChart(document.getElementById(`columnchart_values${key}`));
      chart.draw(data, options);

    }
  }


  // Group by function 
  const groupBy = (array, key) => {
    // Return the end result


    return array.reduce((result, currentValue) => {
      // If an array already present for key, push it to the array. Else create an array and push the object
      (result[currentValue[key]] = result[currentValue[key]] || []).push(
        currentValue
      );
      // Return the current iteration `result` value, this will be taken as next iteration `result` value and accumulate
      // console.log(result)

      return result;


    }, {}); // empty object is the initial value for result object
  };


  const checkEmpty = (obj) => {
    let result = [];
    let observationCount = 0;
    let rootcauseCount = 0;
    let recommendationCount = 0;
    let management_action_planCount = 0;
    let timeline_for_action_planCount = 0;
    let responsibility_for_implementationCount = 0;
    let emptyCell = 0;
    let totalCell = 0

    // console.log(obj.observations);

    // console.log(obj.length);
    for (let j = 0; j < obj.length; j++) {
      // obj[j].map((obj,index)=>{})
      if (obj.observations == '') {
        observationCount++
      }
      // console.log(observationCount);
      if (obj.root_cause == '') {
        rootcauseCount++
      }
      if (obj.recommendation == '') {
        recommendationCount++
      }
      if (obj.management_action_plan == '') {
        management_action_planCount++
      }
      if (obj.timeline_for_action_plan == '') {
        timeline_for_action_planCount++
      }
      if (obj.responsibility_for_implementation == '') {
        responsibility_for_implementationCount++
      }
      emptyCell = responsibility_for_implementationCount + timeline_for_action_planCount + management_action_planCount + recommendationCount + rootcauseCount + observationCount;
      totalCell = obj.length * 6;
    }

    result['emptyCell'] = emptyCell;
    result['totalCell'] = totalCell;
    result['complete'] = totalCell - emptyCell;

    console.log(result);

    // }
    // return result;
  }

  // find percentages
  const PERCENTAGE = (TOTAL, PERCENTAGE) => {
    return (PERCENTAGE * 100) / TOTAL;
  }
  // console.log()
  const processwisedata = (dataArr) => {
    // // console.log(dataArr[0]);
    // dataArr.filter(function(x){
    //   if(x.savedData[2].root_cause==''){
    //     return true;
    //   };
    // })

    // *************************
    for (let index = 0; index < dataArr.length; index++) {
      // console.log(dataArr[index]['savedData']);
      const WorkorderGrouped = groupBy(dataArr[index]['savedData'], 'process_description');
      // console.log(WorkorderGrouped);
      // let procurement = WorkorderGrouped.Procurement;
      // console.log(procurement);
      // let count = procurement.reduce(function (a, x) {
      // if (x['observation'] =='') {
      // a++;
      //         // }
      //         return a;
      //            });
      //  console.log(count);
      /// const objectArray = Object.entries(WorkorderGrouped);
      // objectArray.forEach(([key, value]) => {
      //   checkEmpty(value);
      // });
    }
    //   const element = savedWorkorders[index];
    //   // console.log(element);
    //   // Group by color as key to the person array


    //   var flags = [], output = [], l = savedWorkorders[index]['savedData'].length,
    //     i, process = [], subprocess = [], worksteps = [];
    //   // let data;
    //   for (i = 0; i < l; i++) {

    //     worksteps.push(savedWorkorders[index]['savedData'][i].step_description);
    //     // count++;
    //     // if (flags[savedWorkorders[index]['savedData'][i].sub_process_description]) continue;
    //     // flags[savedWorkorders[index]['savedData'][i].sub_process_description] = true;
    //     // subprocess.push(savedWorkorders[index]['savedData'][i].sub_process_description,savedWorkorders[index]['savedData'][i].process_id);
    //     // subprocess['totalsteps']=worksteps.length;


    //     if (flags[savedWorkorders[index]['savedData'][i].process_description]) continue;
    //     flags[savedWorkorders[index]['savedData'][i].process_description] = true;



    //     let obj = {
    //       processid: savedWorkorders[index]['savedData'][i].process_id,
    //       processDescription: savedWorkorders[index]['savedData'][i].process_description

    //     }
    //     process.push(obj);
    //   }

    //   const WorkorderGroupedByprocess_id = groupBy(savedWorkorders[index]['savedData'], 'process_description');
    //   // console.log(WorkorderGroupedByprocess_id
    //   // );

    //   // let d=Object.value(WorkorderGroupedByprocess_id)

    //   // console.log(d);

    //   const objectArray = Object.entries(WorkorderGroupedByprocess_id);

    //   objectArray.forEach(([key, value]) => {
    //     // console.log(key); // 'one'
    //     // console.log(value); // 1

    //     value.map((ob, index) => {

    //       let data = checkEmpty(ob);
    //       // console.log(data);
    //     })

    //   });

    //   // for(let j=0; j<Object.keys(WorkorderGroupedByprocess_id).length; j++){

    //   //   // console.log(WorkorderGroupedByprocess_id[j])

    //   // }

    //   output['workorderid'] = savedWorkorders[index].workOrdersid;
    //   output['workordername'] = savedWorkorders[index].workOrdersname;
    //   output['process'] = process;
    //   output['steps'] = WorkorderGroupedByprocess_id;
    //   // console.log(output);
    // }

  }

});


