# bark-parks
Team final project Dog Park Finder

Created by Lizzie Benner and Jeff Church

This website allows users to share information about local dog parks. Anyone can view listings about parks, and registered users
can also add new information about parks or edit current information.

Create Table Statements:

CREATE TABLE parks (
  id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  park_name VARCHAR(255),
  location VARCHAR(255),
  num_ratings INT(3),
  sum_ratings INT(3),
  features TEXT,
  description TEXT
);
  
  
  
CREATE TABLE images (
  id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  parkid INT(3) NOT NULL,
  image_path VARCHAR(255)
);
  

CREATE TABLE comments (
    id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    park_id INT(3) NOT NULL,
    text TEXT,
    username VARCHAR(255)    
);

CREATE TABLE users (
    id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    password VARCHAR(255),
    delete_parks TINYINT(1) NOT NULL,
    delete_photos TINYINT(1) NOT NULL,
    delete_comments TINYINT(1) NOT NULL
);

CREATE TABLE parkadmin (
  id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  admin_key VARCHAR(255) NOT NULL
);