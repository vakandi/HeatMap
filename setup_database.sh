#!/bin/bash
# Database credentials
DB_NAME="solar_panel"
DB_USER="solar"
DB_PASSWORD="solar"
root_password="solarroot"

service mariadb start

new_password="solarroot"

# Command to change the root password
mysql_command="ALTER USER 'root'@'localhost' IDENTIFIED BY '$root_password';"
mysql -u root -p -e "$mysql_command"


# Create the database
mysql -u root -p"solarroot" -e "CREATE DATABASE $DB_NAME;"

mysql -u root -p"solarroot" -e "CREATE TABLE solar_panel.solar_panels (
  manufacturer VARCHAR(255),
  brand VARCHAR(255),
  max_watt_power INT,
  voltage INT
);
"

# Create the user and grant privileges
mysql -u root -p"solarroot" -e "CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';"
#mysql -u root -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';"
mysql -u root -p"solarroot" -e "GRANT ALL PRIVILEGES ON *.* TO '$DB_USER'@'%' IDENTIFIED BY '$DB_PASSWORD';"

mysql -u root -p"solarroot" -e "FLUSH PRIVILEGES;"

python3 setup_table.py 


##############################
# CHANGE THE FILE PATH BELOW #
#############################
# FROM ./solarPanelData.csv
# To the path you are currently
# on
# example : 
# C:\Users\imane\Documents\heatmap\solarPanelData.csv
######################################################
#
mysql -u root -p'solarroot' -e "LOAD DATA INFILE './solarPanelData.csv' INTO TABLE solar_panel.solar_panels FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS (manufacturer,brand,max_watt_power,voltage)" solar_panel


# Output success message
echo -e "\n\n\nDatabase '$DB_NAME' created with user '$DB_USER' and password '$DB_PASSWORD'."
