-- Script to set up databases for BillSplit.

CREATE DATABASE IF NOT EXISTS billsplit;

USE billsplit;

-- table for user info
CREATE TABLE IF NOT EXISTS Users (
    user_ID int NOT NULL AUTO_INCREMENT,
    username varchar(100) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    wallet_addr varchar(255) NOT NULL,
    salt varchar(255) NOT NULL,
    PRIMARY KEY (user_ID)
    );

-- table for merchant info
CREATE TABLE IF NOT EXISTS Merchants (
    merchant_ID int NOT NULL AUTO_INCREMENT,
    username varchar(100) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    wallet_addr varchar(255) NOT NULL,
    salt varchar(255) NOT NULL,
    merchant_name varchar(255) NOT NULL,
    PRIMARY KEY (merchant_ID)
    );

-- table to hold payments info
CREATE TABLE IF NOT EXISTS Payments (
    payment_ID int NOT NULL AUTO_INCREMENT,
    merchant_ID int NOT NULL,
    payment_amount DECIMAL(20,2) NOT NULL,
    payment_unique_id varchar(255) NOT NULL,
    payment_complete TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (payment_ID)
    );

-- end of script
