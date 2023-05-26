#!/bin/bash

# Database credentials
DB_HOST="localhost"
DB_PORT="3306"
DB_NAME="solar_panel"
DB_USER="root"
DB_PASSWORD="solarroot"

# Execute the SQL query to retrieve column names
QUERY="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$DB_NAME' AND TABLE_NAME='solar_panels';"
COLUMN_NAMES=$(mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" -D "$DB_NAME" -N -e "$QUERY")

# Print the column names
echo "$COLUMN_NAMES"

