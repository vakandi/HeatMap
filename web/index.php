<?php
$servername = "localhost";
$username = "root";
$password = "solarroot";
$dbname = "solar_panel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM solar_panels";
$result = $conn->query($sql);
?>
<!--
The code starts with defining the server credentials, such as server name, username, password, and database name.
The mysqli class is used to establish a database connection using the provided credentials.
The connection is checked, and if there's an error, the script will terminate and display the error message.
A SQL query is defined to select all records from the "solar_panels" table.
The query is executed using the query() method of the $conn object, and the result is stored in the $result variable.
-->


<!DOCTYPE html>
<html>
<head>
    <title>Solar Panel Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOURAPIKEY&libraries=visualization"></script>
    <script src="script.js"></script>
</head>

<!--
The HTML code begins with the <html> tag and includes the necessary <head> section.
The page title is set as "Solar Panel Search".
Character encoding and viewport configuration are specified.
A CSS file called "style.css" is linked.
The jQuery library is included from the Google CDN.
The Google Maps JavaScript API is included with the "YOURAPIKEY" placeholder (which should be replaced with an actual API key).
A custom JavaScript file called "script.js" is included.
The opening <body> tag marks the start of the body section.
-->

<body>
    <div class="header">
        <h1>Solar Panel Search</h1>
        <form id="search-form" class="search-form" action="search.php" method="post">
            <input type="text" name="manufacturer" placeholder="Manufacturer">
            <input type="text" name="brand" placeholder="Brand">
            <input type="text" name="max_watt_power" placeholder="Max Watt Power">
            <input type="text" name="voltage" placeholder="Voltage">
            <button type="submit" name="submit-search"><img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png"/></button>
	</form>

<!--
A <div> element with the class "header" is created.
An <h1> heading displays "Solar Panel Search".
A form is added with an id "search-form" and class "search-form". It has an action set to "search.php" and a method of "post".
The form contains several <input> elements for searching solar panels based on different criteria: manufacturer, brand, max watt power, and voltage.
A search button is added as a <button> element with the name "submit-search" and an image of a search icon.

-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('search-form');
    var resultsDiv = document.getElementById('results-search');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission

        var formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.text())
	.then(data => {
	    data = '<h2>Search Results :</h2>' + data + '<h3>End of Results </h3>' 
            resultsDiv.innerHTML = data; // Update the div with search results
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
<!--
This script section waits for the DOMContentLoaded event before executing the code.
The form and resultsDiv elements are retrieved using their IDs.
An event listener is added to the form for the submit event.
Inside the event listener, the default form submission is prevented using e.preventDefault().
A FormData object is created to gather the form data.
The fetch() function is used to send a POST request to the form's action URL with the form data.
The response is converted to text using the response.text() method.
The returned data is modified by adding heading tags and assigned to the data variable.
The data variable is assigned as the HTML content of the resultsDiv, which will update the search results in the page.
Any errors that occur during the fetch request are caught and logged to the console.
-->

    </div>

    <div class="container">
        <div class="row">
            <div class="column">
	   
<!--
	<div id="map"></div>
 -->
<!--

THE CODE BELOW IS A TEMPORARY MAP NOT YET IMPLEMENT WITH THE DATABASE INFOS

 -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap/3.3.0/css/bootstrap-theme.min.css">
<style>
#map-canvas {
        height: 500px;
        width: 100%;
        margin-top: 10px;
        margin-left: 0px;
        margin-right: 0px;
        padding: 0px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
<script>
$(document).ready(function() {
        var map, pointarray, heatmap;

        var hmData = [];

        function initialize() {
                var mapOptions = {
                        zoom: 4,
                        center: new google.maps.LatLng(41.850033, -87.6500523),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({'address': 'US'}, function(results, status) {
                        var ne = results[0].geometry.viewport.getNorthEast();
                        var sw = results[0].geometry.viewport.getSouthWest();
                        map.fitBounds(results[0].geometry.viewport);
                });
          
                $.getJSON('tmp/data.json').then(function(data) {
                        $.each(data.datapoints, function(i, datapoint) {
                                hmData.push({
                                        location: new google.maps.LatLng(datapoint.lat, datapoint.lng),
                                        weight: 1
                                });
                        });

                        var pointArray = new google.maps.MVCArray(hmData);

                        heatmap = new google.maps.visualization.HeatmapLayer({
                                data: pointArray,
                                maxIntensity: 1
                        });

                        heatmap.setMap(map);
                });
        }



        function toggleHeatmap() {
                heatmap.setMap(heatmap.getMap() ? null : map);
        }

        function changeGradient() {
                var gradient = [
                        'rgba(0, 255, 255, 0)',
                        'rgba(0, 255, 255, 1)',
                        'rgba(0, 191, 255, 1)',
                        'rgba(0, 127, 255, 1)',
                        'rgba(0, 63, 255, 1)',
                        'rgba(0, 0, 255, 1)',
                        'rgba(0, 0, 223, 1)',
                        'rgba(0, 0, 191, 1)',
                        'rgba(0, 0, 159, 1)',
                        'rgba(0, 0, 127, 1)',
                        'rgba(63, 0, 91, 1)',
                        'rgba(127, 0, 63, 1)',
                        'rgba(191, 0, 31, 1)',
                        'rgba(255, 0, 0, 1)'
                ]

                heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
        }

        function changeRadius() {
                heatmap.set('radius', heatmap.get('radius') ? null : 20);
        }

        function changeOpacity() {
                heatmap.set('opacity', heatmap.get('opacity') ? null : 0.25);
        }

        $("#toggle-heatmap").click(function() {
                toggleHeatmap();
        });

        $("#change-gradient").click(function() {
                changeGradient();
        });

        $("#change-radius").click(function() {
                changeRadius();
        });

        $("#change-opacity").click(function() {
                changeOpacity();
        });

google.maps.event.addDomListener(window, 'load', initialize);
});
</script>
<!--


Here is a breakdown of the javascript code above 

The code starts by defining variables for the map, point array, and heatmap.
hmData is an empty array that will store the heatmap data.
The initialize function sets up the map with initial options, creates a new map instance, and geocodes the address 'US' to obtain the boundaries of the US map.
Inside the initialize function, a JSON file located at 'tmp/data.json' is fetched using $.getJSON. The data from the JSON file is then iterated over, and for each data point, the latitude and longitude are used to create a location object with a weight of 1. These objects are pushed into the hmData array.
A pointArray is created using google.maps.MVCArray from the hmData array.
A new HeatmapLayer is created and assigned to the heatmap variable, with the data property set to the pointArray and maxIntensity set to 1.
The heatmap layer is then set on the map using heatmap.setMap(map).
The code defines several functions:
toggleHeatmap toggles the visibility of the heatmap layer on the map by setting its map property to null or map.
changeGradient changes the gradient colors of the heatmap layer by setting the gradient property to an array of color values.
changeRadius changes the radius of the heatmap by setting the radius property to null or 20.
changeOpacity changes the opacity of the heatmap by setting the opacity property to null or 0.25.
The code attaches click event handlers to HTML elements with the corresponding IDs, using jQuery's click function. These event handlers call the respective functions when the elements are clicked.
Lastly, a Google Maps event listener is added to execute the initialize function when the window finishes loading.
Overall, this code initializes a Google Maps instance, loads data from a JSON file to create a heatmap layer, and provides functions to toggle the visibility of the heatmap, change its gradient colors, radius, and opacity.


###########################################################################
THE CODE ABOVE IS A TEMPORARY MAP NOT YET IMPLEMENT WITH THE DATABASE INFOS
###########################################################################
-->


<div class="container">
        <ul class="nav nav-pills" role="tablist">
                <li role="presentation"><a href="tmp/dashboard.html">Home</a></li>
                <li role="presentation" class="dropdown">
		   <!--    
 <a class="dropdown-toggle" data-toggle="dropdown" href="#">Select Dataset <span class="caret"></span></a>
-->
                        <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Dataset 1</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Dataset 2</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Dataset 3</a></li>
                        </ul>
                </li>
                <li role="presentation"><a id="toggle-heatmap" href="#">Toggle Heatmap</a></li>
                <li role="presentation"><a id="change-gradient" href="#">Change Gradient</a></li>
                <li role="presentation"><a id="change-radius" href="#">Change Radius</a></li>
                <li role="presentation"><a id="change-opacity" href="#">Change Opacity</a></li>
        </ul>
        <div id="map-canvas"></div>
        <p>Currently showing: <strong>Q1, 2015</strong>&nbsp;&nbsp;Data points displayed: <strong>8,478</strong>
</div>




	    </div>


<!--

The code above represents an HTML section enclosed in a <div> container with the class "container."
Inside the container, there is an unordered list (<ul>) with the class "nav nav-pills" that serves as a navigation menu.
The first list item (<li>) represents the "Home" link, which is a hyperlink to "tmp/dashboard.html".
The second list item is a dropdown menu with the class "dropdown" (represented by another <li> element).
The commented code (<!-.... ->) was intended to display a dropdown toggle, but it is currently disabled.
Inside the dropdown menu (<ul>), there are several options represented by list items (<li>) and hyperlinks (<a>).
The remaining list items represent different actions or settings related to the heatmap functionality.
"Toggle Heatmap" link: <a> element with the id "toggle-heatmap."
"Change Gradient" link: <a> element with the id "change-gradient."
"Change Radius" link: <a> element with the id "change-radius."
"Change Opacity" link: <a> element with the id "change-opacity."
After the navigation menu, there is a <div> element with the id "map-canvas" that is likely used to display the Google Maps interface.
Lastly, there is a paragraph (<p>) that displays some information about the currently shown data.
It includes the text "Currently showing:" followed by a strong element (<strong>) that displays "Q1, 2015."
It also includes the text "Data points displayed:" followed by a strong element that displays "8,478."
Overall, this HTML code represents a section of a web page with a navigation menu, options/settings related to a heatmap feature, a container for displaying a map, and information about the currently shown data.

 -->

<div id="results-search">
</div>

<div class="column">
    <table id="panelTable">
        <thead>
            <tr>
                <th>Manufacturer</th>
                <th>Brand</th>
                <th>Max Watt Power</th>
                <th>Voltage</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["manufacturer"] . "</td>";
                    echo "<td>" . $row["brand"] . "</td>";
                    echo "<td>" . $row["max_watt_power"] . "</td>";
                    echo "<td>" . $row["voltage"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!--
A <div> element with the class "container" is created to contain the search form and the panel table.
Inside the container, a <div> with the class "row" is added to contain the two columns.
The first column contains commented out HTML code, which is not rendered on the page.
The second column contains a <table> element with the ID "panelTable".
The table has a header row (<thead>) with four columns: Manufacturer, Brand, Max Watt Power, and Voltage.
Inside the <tbody> section, a PHP block is used to loop through the result set obtained from the database query.
For each row in the result set, a new table row (<tr>) is created, and the corresponding data from the row is inserted into the table cells (<td>).
If there are no results, a single table row with a single table cell (<td>) displaying "0 results" is added.
The database connection is closed after the table is populated.
 -->



        </div>
    </div>
</body>
</html>

