-- Active: 1690567092891@@127.0.0.1@3306@pzn_laravel_database
DROP DATABASE pzn_laravel_database;

CREATE DATABASE pzn_laravel_database;

USE pzn_laravel_database;

CREATE TABLE categories (
	id VARCHAR(100) NOT NULL PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description TEXT NULL,
	created_at TIMESTAMP
) engine innodb;