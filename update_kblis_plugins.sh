#!/bin/bash

folder_path="app/kblis/plugins"
# Code snippet to insert

code_to_insert='        if (!empty($json["machine_name"])){
            $results["machine_name"] = $json["machine_name"];
        }'

# Search pattern
search_pattern='return $results;'

# Iterate over files in the folder
for file_path in "$folder_path"/*; do
    # Check if the file is a regular file
    if [ -f "$file_path" ]; then
        # Check if both the search pattern and the code snippet exist in the file
        if grep -qF "$search_pattern" "$file_path"  && ! grep -qF "\\b$code_to_insert\\b" "$file_path" && ! grep -qF "\\b$c\\b" "$file_path"; then
            # Temporarily store the contents of the file
            tmp_file=$(mktemp)
            cp "$file_path" "$tmp_file"

            # Find the line number of the search pattern
            line_number=$(grep -nF "$search_pattern" "$tmp_file" | cut -d':' -f1)

            # Insert the code snippet above the search pattern using awk
            awk -v code="$code_to_insert" -v line="$line_number" 'NR == line { print code } { print }' "$tmp_file" > "$file_path"

            echo "Code snippet inserted successfully in $file_path"
        else
            echo "Code snippet already exists or search pattern not found in $file_path"
        fi
    fi
done