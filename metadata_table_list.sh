#!/usr/bin/env bash

unset username

# clear

echo "Specify database name:"

read database

STR=$'Enter username:\r'

echo "$STR"

read username

# clear

unset password

prompt="Enter Password:"
while IFS= read -p "$prompt" -r -s -n 1 char
do
    if [[ $char == $'\0' ]]
    then
        break
    fi
    prompt='*'
    password+="$char"
done

mysqldump -u $username -p$password $database --tables facilities wards visit_types visittype_wards test_types test_statuses testtype_specimentypes testtype_measures testtype_organisms test_categories specimen_types specimen_statuses roles organisms organism_drugs measures measure_types measure_ranges drugs permission_role panel_types panels> metadata.sql

clear

echo "Done!"
