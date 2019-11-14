orig_db='K9100_2'
bu_db='K9100_3'
db_file=$orig_db'.sql'

echo Kopioidaan $orig_db tietokanta $bu_db tietokantaan
mysqldump -u K9100 -pmysqldump -u K9100 -pM7fMqMcrHpRuRMKlJkYYizh0a5d0dw41 $orig_db -h mysql.labranet.jamk.fi > $db_file
mysql -u K9100 -pmysqldump -u K9100 -pM7fMqMcrHpRuRMKlJkYYizh0a5d0dw41 $bu_db -h mysql.labranet.jamk.fi < $db_file
