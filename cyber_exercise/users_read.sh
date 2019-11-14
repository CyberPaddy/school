#!/bin/bash

if [ $# -eq 0 ]
	then
		search="SELECT * FROM users;"
else
	search="$1"
fi

db="K9100_2"

haunTulokset=$(mysql -u K9100 -pM7fMqMcrHpRuRMKlJkYYizh0a5d0dw41 -h mysql.labranet.jamk.fi -D $db -e "$search")

echo $haunTulokset
