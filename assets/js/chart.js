$(function () {

  // Load the Visualization API and the corechart package.


  google.charts.load('current', { 'packages': ['corechart'] });

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.


  let workorderLength = undefined;
  $.get(baseUrl + "Auditapp/getallworkorders", function (data, status) {
    let workOrders = JSON.parse(data);
    workorderLength = workOrders.length;
    console.log(workOrders.length);

    // alert("Data: " + data + "\nStatus: " + status);
  });


  function drawChart() {

    // workorderLength=2000;
    let complete = 2;
    let pending = workorderLength - complete;
    let data = google.visualization.arrayToDataTable([
      ["work order", "total", { role: "style" }],
      ["Work orders", workorderLength, "blue"],
      ["Complete", complete, "green"],
      ["Pending", pending, "tomato"]
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
      width: 1250,
      height: 200,
      bar: { groupWidth: "95%" },
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
    // var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
    chart.draw(view, options);
  }
});

// function to show the selected data
function showSelectedrow(id) {
  switch (id) {
    case 0:
     
      break;
    case 1:
      $('#selected-row').text("Total work complete");
      break;
    case 2:
      $('#selected-row').text("pending");
      break;
    default:
      text = "Looking forward to the Weekend";
  }
}


$(function(){

const totalWorkOrder=()=>{  
}

})