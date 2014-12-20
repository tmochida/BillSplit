#!/bin/bash
#
# Configures database connection and hot wallet address (used by BillSplit).

echo "===== Setting up database ====="

read -p "Database host [localhost]: " dbhost

read -p "Database name [billsplit]: " dbname

read -p "Database user [billsplit]: " dbuser

stty -echo
read -p "Database password [ripple]: " dbpass
stty echo

dbhost=${dbhost:-localhost}
dbname=${dbname:-billsplit}
dbuser=${dbuser:-billsplit}
dbpass=${dbpass:-ripple}


echo -ne "\n===== Configuring Ripple wallet ====="

read -p "Hot wallet address: " wallet_addr

echo -ne "\n"

echo "DB host: $dbhost"
echo "DB name: $dbname"
echo "DB user: $dbuser"
echo "DB pass: $dbpass"
echo "Wallet address: $wallet_addr"


sed -i "s/\$dbhost=.*/\$dbhost=\"$dbhost\"/g" api/dbconfig.php 
sed -i "s/\$dbname=.*/\$dbname=\"$dbname\"/g" api/dbconfig.php 
sed -i "s/\$dbuser=.*/\$dbuser=\"$dbuser\"/g" api/dbconfig.php 
sed -i "s/\$dbpass=.*/\$dbpass=\"$dbpass\"/g" api/dbconfig.php 
