#!/bin/bash
#
# Configures database connection and hot wallet address (used by BillSplit).

echo "Please make sure you are running 'scripts/setup.sh' from the directory. If your working directory is scripts, please cd to parent directory."
echo -ne "===============================\n"
echo "===== Setting up database ====="
echo "==============================="

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

echo -ne "\n\n=====================================\n"
echo "===== Configuring Ripple wallet ====="
echo "====================================="

read -p "Hot wallet address [null]: " wallet_addr

wallet_addr=${wallet_addr:-null}

sed -i "s/\$dbhost=.*/\$dbhost=\"$dbhost\"/g" api/config.php
sed -i "s/\$dbname=.*/\$dbname=\"$dbname\"/g" api/config.php
sed -i "s/\$dbuser=.*/\$dbuser=\"$dbuser\"/g" api/config.php
sed -i "s/\$dbpass=.*/\$dbpass=\"$dbpass\"/g" api/config.php
sed -i "s/\$hot_wallet=.*/\$hot_wallet=\"$wallet_addr\"/g" api/config.php

echo -ne "\n\n==================================\n"
echo "===== Configuration summary ======"
echo "=================================="

#Configured database and wallet as follows:\n"
echo "DB host: $dbhost"
echo "DB name: $dbname"
echo "DB user: $dbuser"
echo "DB pass: $dbpass"
echo "Wallet address: $wallet_addr"

