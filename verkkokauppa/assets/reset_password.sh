#!/bin/bash

if [ $# -eq 1 ]; then

  # Varmistetaan haluaako varmasti tehdä muutokset
  echo "Haluatko varmasti resetoida käyttäjän $1 salasanan? (Y/N)"
  read doit

  # Jos vastaus oli Y/y
  if [ $doit == "Y" ] || [ $doit == "y" ]; then
    /home/K9100/public_html/tietokannat/users_read.sh "UPDATE users SET passwd=AES_ENCRYPT('Vaihda123', '*NOT_REAL_KEY*') where username like '$1'"
    echo "Käyttäjän $1 salasana on resetoitu."
  fi
else
  echo "Käyttö: ./reset_password.sh <käyttäjätunnus>"
fi
