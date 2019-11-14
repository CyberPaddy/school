#!/bin/bash

cd skriptat
./bu.sh && ./db.sh && ./prod.sh
cd ..
echo "Varmuuskopio tehty onnistuneesti!"
