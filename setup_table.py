import csv
import mysql.connector

# MySQL database connection details
db_config = {
    'user': 'root',
    'password': 'solarroot',
    'host': 'localhost',
    'database': 'solar_panel'
}

# Path to the CSV file
csv_file_path = '/root/auto_gpt_workspace/heatmap/solarPanelData.csv'

# MySQL table name
table_name = 'solar_panels'

# Open a connection to MySQL
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

# Read the CSV file and insert data into the MySQL table
with open(csv_file_path, 'r') as file:
    csv_data = csv.DictReader(file)
    for row in csv_data:
        manufacturer = row['manufacturer']
        brand = row['brand']
        max_watt_power = int(row['max_watt_power'])
        voltage = float(row['voltage'])

        # Insert a row into the MySQL table
        query = f"INSERT INTO {table_name} (manufacturer, brand, max_watt_power, voltage) VALUES (%s, %s, %s, %s)"
        values = (manufacturer, brand, max_watt_power, voltage)
        cursor.execute(query, values)

# Commit the changes and close the MySQL connection
conn.commit()
cursor.close()
conn.close()

