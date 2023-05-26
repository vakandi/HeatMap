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
//The code above sets up the necessary credentials for connecting to the MySQL database server.
//The variables $servername, $username, $password, and $dbname store the server name, username, password, and database name respectively.
//The new mysqli() constructor is used to create a new connection object $conn to the database server.
//The connection is checked for errors using the connect_error property of the connection object. If there is an error, the script terminates and displays the error message.
//
// Prepare the SQL statement
$sql = "SELECT * FROM solar_panels WHERE ";
$conditions = array();

//
//A SQL query string is initialized with the SELECT statement to retrieve all columns from the "solar_panels" table.

// Check if the manufacturer field is set
if (!empty($_POST["manufacturer"])) {
    $manufacturer = $_POST["manufacturer"];
    $conditions[] = "manufacturer LIKE '%$manufacturer%'";
}
//This block checks if the "manufacturer" field is set and not empty in the submitted form data ($_POST).
//If it is set and not empty, the manufacturer value is stored in the variable $manufacturer.
//A condition string is added to the $conditions array, specifying that the "manufacturer" column should be searched for a partial match of the manufacturer value.
// Check if the brand field is set
if (!empty($_POST["brand"])) {
    $brand = $_POST["brand"];
    $conditions[] = "brand LIKE '%$brand%'";
}

// Check if the max watt power field is set
if (!empty($_POST["max_watt_power"])) {
    $maxWattPower = $_POST["max_watt_power"];
    $conditions[] = "max_watt_power LIKE '%$maxWattPower%'";
}

// Check if the voltage field is set
if (!empty($_POST["voltage"])) {
    $voltage = $_POST["voltage"];
    $conditions[] = "voltage LIKE '%$voltage%'";
}

// Combine the conditions using OR operator
if (!empty($conditions)) {
    $sql .= implode(" OR ", $conditions);
} else {
    // No search parameters provided, fetch all records
    $sql = "SELECT * FROM solar_panels";
}
//This block above checks if any conditions were added to the $conditions array.
//If conditions exist, they are combined using the implode() function with the " OR " separator and appended to the SQL query string $sql.
//If no conditions were added (i.e., no search parameters were provided), the SQL query string is reset to select all records from the "solar_panels" table.
//
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table id="panelTable">
            <thead>
                <tr>
                    <th>Manufacturer</th>
                    <th>Brand</th>
                    <th>Max Watt Power</th>
                    <th>Voltage</th>
                </tr>
            </thead>
            <tbody>';
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["manufacturer"] . "</td>";
        echo "<td>" . $row["brand"] . "</td>";
        echo "<td>" . $row["max_watt_power"] . "</td>";
        echo "<td>" . $row["voltage"] . "</td>";
        echo "</tr>";
    }
    echo '</tbody>
        </table>';
} else {
    echo "0 results";
}
//The SQL query is executed using the query() method of the connection object, and the result is stored in the variable $result.
//If the result contains one or more rows (i.e., $result->num_rows > 0), the code enters the if block.
//Inside the if block, an HTML table structure is echoed, with table headers for "Manufacturer," "Brand," "Max Watt Power," and "Voltage."
//The data retrieved from each row of the result set is fetched using the fetch_assoc() method, and the corresponding values are displayed in table rows (<tr>) and table cells (<td>).
//Finally, the table body (</tbody>) and table structure (</table>) are closed.
//If the result is empty (i.e., no matching rows), the script echoes "0 results" indicating no records were found.


$conn->close();
//The database connection is closed using the close() method of the connection object $conn.
//This ensures that the connection to the database server is properly closed and resources are freed.
?>

