#!/bin/bash

# Function to generate random latitude and longitude within specific city boundaries
generate_location() {
    local city=$1
    local lat
    local lng

    case $city in
        Others)
            local min_lat=28.380552
            local max_lat=39.520367
            local min_lng=-4.665033
            local max_lng=-9.484710
            ;;
        Agadir)
            local min_lat=30.380552
            local max_lat=30.520367
            local min_lng=-9.665033
            local max_lng=-9.484710
            ;;
        Casablanca)
            local min_lat=33.532506
            local max_lat=33.626447
            local min_lng=-7.732303
            local max_lng=-7.516723
            ;;
        Taghazout)
            local min_lat=30.487326
            local max_lat=30.594986
            local min_lng=-9.803003
            local max_lng=-9.524617
            ;;
        Tangier)
            local min_lat=35.737036
            local max_lat=35.824330
            local min_lng=-5.863079
            local max_lng=-5.741993
            ;;
        Tetouan)
            local min_lat=35.553739
            local max_lat=35.602157
            local min_lng=-5.405430
            local max_lng=-5.334202
            ;;
        Martil)
            local min_lat=35.594315
            local max_lat=35.654352
            local min_lng=-5.257693
            local max_lng=-5.219345
            ;;
        Mediouna)
            local min_lat=33.501768
            local max_lat=33.589466
            local min_lng=-7.609297
            local max_lng=-7.509162
            ;;
        Skhirat)
            local min_lat=33.784832
            local max_lat=33.882732
            local min_lng=-7.013392
            local max_lng=-6.907870
            ;;
        Rabat)
            local min_lat=33.984799
            local max_lat=34.064998
            local min_lng=-6.900894
            local max_lng=-6.811415
            ;;
        Marrakech)
            local min_lat=31.585290
            local max_lat=31.706030
            local min_lng=-8.053826
            local max_lng=-7.937104
            ;;
        Oujda)
            local min_lat=34.641857
            local max_lat=34.754826
            local min_lng=-1.956257
            local max_lng=-1.819980
            ;;
        Kenitra)
            local min_lat=34.228965
            local max_lat=34.350258
            local min_lng=-6.646078
            local max_lng=-6.462726
            ;;
        Atlas)
            local min_lat=31.030542
            local max_lat=31.232402
            local min_lng=-7.982743
            local max_lng=-7.726471
            ;;
        *)
            echo "Invalid city"
            return 1
            ;;
    esac

    lat=$(awk -v min=$min_lat -v max=$max_lat 'BEGIN{srand(); printf "%.6f", min+rand()*(max-min)}')
    lng=$(awk -v min=$min_lng -v max=$max_lng 'BEGIN{srand(); printf "%.6f", min+rand()*(max-min)}')

    echo "{ \"lat\": \"$lat\", \"lng\": \"$lng\" }"
}

echo "Choose the number of random locations:"
read choice

# File name to save the locations
file_name="data.json"

# Generate locations and save them to the file
echo '{
"datapoints": ' > "$file_name"
echo "[" >> "$file_name"
for ((i=0; i<choice; i++)); do
    # Generate a random city
    cities=("Others" "Agadir" "Casablanca" "Taghazout" "Tangier" "Tetouan" "Martil" "Mediouna" "Skhirat" "Rabat" "Marrakech" "Oujda" "Kenitra" "Atlas")
    random_city=${cities[$RANDOM % ${#cities[@]}]}
    generate_location "$random_city" >> "$file_name"
    if [ $i -lt $((choice-1)) ]; then
        echo "," >> "$file_name"
    fi
done
echo "]" >> "$file_name"
echo "}" >> "$file_name"

echo "Locations generated and saved to $file_name"

