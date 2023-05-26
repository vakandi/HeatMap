# Solar Panel Search

## Description
This is a PHP script that connects to a MySQL database and retrieves data from the "solar_panels" table. It provides a search form to filter solar panels based on manufacturer, brand, max watt power, and voltage. The search results are displayed in a table.

## Prerequisites
- PHP
- MySQL (or mariadb)
- Apache server (or basic php)
- `pip install mysql-connector-python`

## Installation
1. Clone the repository or download the files.
2. Change the lines 13 in `setup_table.py` to match the path of the file `solarPanelData.csv` (example : `C:\Users\test\Documents\heatmap\solarPanelData.csv`)
3. Change the lines 48 in `setup_database.sh` to match the path of the file `solarPanelData.csv`  
4. Create a MySQL database and import the database by running the script `setup_database.sh` to create the necessary table.
5. Update the database credentials in the `index.php` file (`$servername`, `$username`, `$password`, `$dbname`).
6. Place the files in your web server directory (e.g., htdocs for XAMPP).
7. Access the website through the browser (e.g., http://localhost/index.php).

## Usage
1. Open the index.php in a web browser.
2. Fill in the search criteria in the form (manufacturer, brand, max watt power, voltage).
3. Click the search button.
4. The search results will be displayed in a table below the form.
5. The Map will be displaying the location of the solar panels from the database (Features coming soon..)

## License
This project is licensed under the [UM6P](LICENSE).
