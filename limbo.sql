# Creates and populates tables for the Limbo database.
# Authors: Alex Goncalves, Brendon Boldt
# Version 1.0

# Creates (if necessary) and uses limbo_db
CREATE DATABASE IF NOT EXISTS limbo_db;
USE limbo_db;

# Creates table representing administrative users for the database
DROP TABLE users;
CREATE TABLE IF NOT EXISTS users (
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL,
	email VARCHAR(60) NOT NULL,
	pass CHAR(40) NOT NULL,
	PRIMARY KEY (user_id),
	UNIQUE (email)
);

# Creates an admin user in the users table
INSERT INTO users (username, email, pass)
    VALUES ("admin", "admin@nsa.gov", "gaze11e");

# Creates table representing items in the lost and found
DROP TABLE stuff;
CREATE TABLE IF NOT EXISTS stuff (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	item TEXT NOT NULL,
	location_id INT NOT NULL,
	description TEXT NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NOT NULL,
	room TEXT,
	owner TEXT,
	finder TEXT,
	status SET("found", "lost", "claimed") NOT NULL,
	PRIMARY KEY (id)
);


INSERT INTO stuff (item, location_id, description, create_date, update_date, room, status) VALUES
	("iPhone", 1, "6s", NOW(), NOW(), "1021", 'lost'),
	("Jacket", 1, "Navy, lightweight", NOW(), NOW(), "0005", 'lost'),
	("Laptop", 3, "MacBook Pro", NOW(), NOW(), "233", 'lost'),
	("Phone", 1, "Samsung Galaxy S6", NOW(), NOW(), "1021", 'found'),
	("Coat", 1, "White", NOW(), NOW(), "0005", 'found'),
	("Desktop", 3, "Intel i7", NOW(), NOW(), "233", 'found');

# Creates a table representing locations
DROP TABLE locations;
CREATE TABLE IF NOT EXISTS locations (
	id INT AUTO_INCREMENT NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NOT NULL,
	name TEXT NOT NULL,
	PRIMARY KEY (id)
);

# Inserts into locations all of the buildings on the Marist College campus
INSERT INTO locations (create_date, update_date, name) VALUES
	(NOW(), NOW(), "Hancock Center"),
	(NOW(), NOW(), "James A. Cannavino Library"),
	(NOW(), NOW(), "Champagnat Hall"),
	(NOW(), NOW(), "Our Lady Seat of Wisdom Chapel"),
	(NOW(), NOW(), "Cornell Boathouse"),
	(NOW(), NOW(), "Donnelly Hall"),
	(NOW(), NOW(), "Margaret M. and Charles H. Dyson Center"),
	(NOW(), NOW(), "Fontaine Hall"),
	(NOW(), NOW(), "Foy Townhouses"),
	(NOW(), NOW(), "Fulton Street Townhouses"),
	(NOW(), NOW(), "Lower Fulton Townhouses"),
	(NOW(), NOW(), "Gartland Apartments"),
	(NOW(), NOW(), "Greystone Hall"),
	(NOW(), NOW(), "Kieran Gatehouse"),
	(NOW(), NOW(), "Leo Hall"),
	(NOW(), NOW(), "Lowell Thomas Communications Center"),
	(NOW(), NOW(), "Marian Hall"),
	(NOW(), NOW(), "Marist Boathouse"),
	(NOW(), NOW(), "James J. McCann Recreational Center"),
	(NOW(), NOW(), "Mid-Rise Hall"),
	(NOW(), NOW(), "St. Ann’s Hermitage"),
	(NOW(), NOW(), "St. Peter’s"),
	(NOW(), NOW(), "Sheahan Hall"),
	(NOW(), NOW(), "Steel Plant Art Studios and Gallery"),
	(NOW(), NOW(), "Student Center"),
	(NOW(), NOW(), "Tenney Stadium"),
	(NOW(), NOW(), "Lower Townhouses"),
	(NOW(), NOW(), "Lower West Cedar Townhouses"),
	(NOW(), NOW(), "Upper West Cedar Townhouses");
