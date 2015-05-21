# BillSplit
BillSplit allows multiple users to collectively fund a single payment.

The application makes use of the Ripple Payment Protocol.

## Getting Started

### Dependencies
* PHP
* MySQL
* Ripple-REST API

### Setup
1. Clone repo into web direcctory
2. Run scripts/setup.sh to configure database and hot wallet address
3. Run the setupDB.sql SQL script to create necessary tables.

### Cleanup
1. Run clearDB.sql SQL script to flush/reset all data. This should only be run immediately after setup or when removing the application.
