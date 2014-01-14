<?php
// access control
session_start();
require_once('./login_controller.php');
$logged_in = new Login();
$lvl = $logged_in->access_level();
if ($lvl <= 0) {
    header('Location: ./login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Download Stats example</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Download Stats</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Github <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="https://github.com/bmcculley/download-tracker"><span class="glyphicon glyphicon-bookmark"> Source</a></li>
                <li><a href="https://github.com/bmcculley/download-tracker/issues"><span class="glyphicon glyphicon-exclamation-sign"> Issues</a></li>
                <li><a href="https://github.com/bmcculley/download-tracker/pulls"><span class="glyphicon glyphicon-wrench"> Pull Request</a></li>
                <li class="divider"></li>
                <li><a href="https://github.com/bmcculley/download-tracker/star"><span class="glyphicon glyphicon-star"> Star Project</a></li>
                <li><a href="https://github.com/bmcculley/download-tracker/fork"><span class="glyphicon glyphicon-new-window"> Fork Project</a></li>
              </ul>
            </li>
          </ul>
          <!-- Split button -->
          <div class="navbar-btn navbar-right">
            <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WH8N24DEJKVCE" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> <i>Buy me a</i> Coffee</a>
            <div class="btn-group">
              <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-user"> <?php echo 'Howdy, '.($_COOKIE['user']!='' ? $_COOKIE['user'] : 'Guest'); ?></button>
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="./logout.php"><span class="glyphicon glyphicon-off"> Logout</a></li>
              </ul>
            </div>
          </div>

        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="graph"></div>

      <div class="colophon">
        <p>Download Stats by <a href="http://bmcculley.github.io">bmcculley</a></p>
      </div>
    </div> <!-- /container -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/vendor/d3.js"></script>  <!-- load the d3.js library --> 

    <script>

    // Set the dimensions of the canvas / graph
    var margin = {top: 30, right: 20, bottom: 30, left: 50},  // sets the width of the margins around the actual graph area
      width = 600 - margin.left - margin.right,       // sets the width of the graph area
      height = 270 - margin.top - margin.bottom;        // sets the height of the graph area

    // Parse the date / time
    var parseDate = d3.time.format("%Y-%m-%d").parse;     // pasrses in the date / time in the format specified

    // Set the ranges
    var x = d3.time.scale().range([0, width]);          // scales the range of values on the x axis to fit between 0 and 'width'
    var y = d3.scale.linear().range([height, 0]);       // scales the range of values on the y axis to fit between 'height' and 0

    // Define the axes
    var xAxis = d3.svg.axis().scale(x)              // defines the x axis function and applies the scale for the x dimension
      .orient("bottom").ticks(5);               // tells what side the ticks are on and how many to put on the axis

    var yAxis = d3.svg.axis().scale(y)              // defines the y axis function and applies the scale for the y dimension
      .orient("left").ticks(5);               // tells what side the ticks are on and how many to put on the axis

    // Define the line
    var valueline = d3.svg.line()               // set 'valueline' to be a line
      .x(function(d) { return x(d.date); })         // set the x coordinates for valueline to be the d.date values
      .y(function(d) { return y(d.count); });         // set the y coordinates for valueline to be the d.count values

    // Adds the svg canvas
    var svg = d3.select(".graph")                 // Explicitly state where the svg element will go on the web page (graph class)
      .append("svg")                      // append 'svg' to the graph class of the web page
        .attr("width", width + margin.left + margin.right)  // Set the 'width' of the svg element
        .attr("height", height + margin.top + margin.bottom)// Set the 'height' of the svg element
      .append("g")                      // Append 'g' to the html 'body' of the web page
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")"); // in a place that is the actual area for the graph

    // Get the data
    d3.json("stats.php", function(error, data) {        // Go to the data folder (in the current directory) and read in the data.tsv file
      data.forEach(function(d) {                // For all the data values carry out the following
        d.date = parseDate(d.date);             // Parse the date from a set format (see parseDate)
        d.count = +d.count;                 // makesure d.count is a number, not a string
      });

      // Scale the range of the data
      x.domain(d3.extent(data, function(d) { return d.date; }));    // set the x domain so be as wide as the range of dates we have.
      y.domain([0, d3.max(data, function(d) { return d.count; })]); // set the y domain to go from 0 to the maximum value of d.count

      // Add the valueline path.
      svg.append("path")                    // append the valueline line to the 'path' element
        .attr("class", "line")                // apply the 'line' CSS styles to this path
        .attr("d", valueline(data));            // call the 'valueline' finction to draw the line

      // Add the X Axis
      svg.append("g")                     // append the x axis to the 'g' (grouping) element
        .attr("class", "x axis")              // apply the 'axis' CSS styles to this path
        .attr("transform", "translate(0," + height + ")") // move the drawing point to 0,height
        .call(xAxis);                   // call the xAxis function to draw the axis

      // Add the Y Axis
      svg.append("g")                     // append the y axis to the 'g' (grouping) element
        .attr("class", "y axis")              // apply the 'axis' CSS styles to this path
        .call(yAxis);                   // call the yAxis function to draw the axis

    });

    </script>
  </body>
</html>