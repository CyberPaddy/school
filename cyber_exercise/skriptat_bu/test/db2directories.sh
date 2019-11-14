#!/bin/bash

# Make sure the user does not provide parameters
if [ $# -gt 0 ]; then
  echo "Please do not provide parameters for this script"
  exit 1 ; fi

echo "This script will delete all files from this directory and makes new directory from every row of SQL SELECT query result"

# Ask user "Are you sure" for as long as user says "Y"
while ! [[ "$do_it" =~ ^(Y|y)$ ]]
do
  echo "Are you sure to execute this script? (Y/N)"
  read do_it

  if [[ "$do_it" =~ ^(N|n)$ ]]; then echo "Exitting script..." ; exit 1 ; fi
done

# Extended globbing enables the use of pattern matching operators such as !(pattern-list)
shopt -s extglob
# Remove every file from this folder exept this one
rm -fr -- !(db2directories.sh)

# Let's put MySQL command and DB name to variables
query="SELECT product_name FROM products ORDER BY product_name;"
db="K9100_2"

# Log in to MySQL, do MySQL query and save the output to $sql_output
sql_output=$(mysql -u K9100 -pM7fMqMcrHpRuRMKlJkYYizh0a5d0dw41 -h mysql.labranet.jamk.fi -D $db -e "$query" -E)

results_array=(${sql_output})
index=0
current_row=""
 
# Create directory named equal to one row from SELECT query output.
function makeDirectory {
  if [[ "$1" != "" ]]; then
    mkdir "$1"
    echo "Created directory $1"
    fi
  }

# $results_array example: "1. row db2directories.sh product_name: Counter Strike 2. row db2directories.sh product_name: SIMS 3"
# makeDirectory function happens every time when product name is fully assembled (f.ex. "SIMS_3")
for word in ${results_array[@]};
  do if [[ "$word" != "row" ]] && [[ "$word" != "db2directories.sh" ]] && [[ "$word" =~ .*[^\.]$ ]] && [[ ${#word} -lt 50 ]]; then
    if [[ "$word" == "product_name:" ]]; then
      makeDirectory $current_row
      current_row=""         # Reset current word
      index=$((index+1))      # Add one to directory count
    
    else
      
      # If $current_row already has words, put underscore between every word ("Counter_Strike")
      if [[ "$current_row" != "" ]]; then
      current_row+="_$word"
    
      else
        current_row+="$word" 
      fi
    fi
  fi
done

# Make the last directory and echo how many directories were created during the script
makeDirectory $current_row ; echo "Created "$index" directories"
