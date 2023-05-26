<?php

$data = file_get_contents('data.js');
$data = json_decode($data, true);

foreach ($data as $panel) {
    echo '<li class="panel">';
    echo '<h3>' . $panel['manufacturer'] . ' ' . $panel['brand'] . '</h3>';
    echo '<p>Max Watt Power: ' . $panel['maxWattPower'] . '</p>';
    echo '<p>Voltage: ' . $panel['voltage'] . '</p>';
    echo '</li>';
}

?>