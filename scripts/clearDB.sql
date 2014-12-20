-- Clears data used by BillSplit.

CREATE DATABASE IF NOT EXISTS billsplit;

USE billsplit;

DROP TABLE Users;
DROP TABLE Merchants;
DROP TABLE Payments;

DELETE DATABASE billsplit;
