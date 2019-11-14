#!/bin/bash

shopt -s extglob
rm -fr -- !(db2directories.sh)

search="SELECT product_name FROM products ORDER BY product_id;"
db="K9100_3"

haunTulokset=$(mysql -u K9100 -pM7fMqMcrHpRuRMKlJkYYizh0a5d0dw41 -h mysql.labranet.jamk.fi -D $db -e "$search" -E)
#echo $haunTulokset

hakuTulosArray=(${haunTulokset})
productArray=()
index=0
currentItem=""
regex=".*[^\.]$"

function makeDirectory {
	if [[ "$1" != "" ]]; then
	mkdir "$1"
	echo "Created directory $1"
	fi
}

for sana in ${hakuTulosArray[@]};
	do if [[ "$sana" != "row" ]] && [[ "$sana" != "db2directories.sh" ]] && [[ "$sana" =~ $regex ]] && [[ ${#sana} -lt 50 ]]; then
		if [[ "$sana" == "product_name:" ]]; then
			makeDirectory $currentItem	
			currentItem=""
			index=$((index+1))
		else

		if [[ "$currentItem" != "" ]]; then
			currentItem+="_$sana"
		else
			currentItem+="$sana"
		fi
		fi
	fi
done

makeDirectory $currentItem
echo "Created "$index" directories"
#echo $currentItem
