#!/bin/bash

if [ $# -lt 2 ] || [ $# -gt 2 ]; then
  echo "Anna 2 argumenttia: <vaihdettava> <tuleva>"

# Jos tasan 2 argumenttia annettu
else

  # Varmistetaan haluaako varmasti tehdä muutokset
  echo "Haluatko muuttaa kaikki osumat '$1' --> '$2'? (Y/N)"
  read doit

  # Jos vastaus oli Y/y
  if [ $doit == "Y" ] || [ $doit == "y" ]; then
    pwd=$(pwd)
    find $pwd -type f -print0 | xargs -0 sed -i 's,'"$1"','"$2"',g'
    echo "Muutettu $1 --> $2"

  # Jos vastaus ei ollut Y/y
  else
    echo "Mitään ei muutettu!"
  fi
fi

