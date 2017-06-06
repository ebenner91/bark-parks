# bark-parks
Team final project Dog Park Finder

Your website should have the following features:

Separates all database/business logic using the MVC pattern.
-

Routes all URLs and leverages a templating language using the Fat-Free framework.
-

Has a clearly defined database layer using PDO and prepared statements.
-

Data can be viewed, added, updated, and deleted.
-

Has a history of commits from both team members to a Git repository.
-

Uses OOP, and defines multiple classes, including at least one inheritance relationship.
- We used a Park class to create park entries on the website, User class to create users,
and an AdminUser class which extends User to create administrative users with extra admin permissions.
A database access class is also used as part of MVC to cintain all database access methods.

Contains full Docblocks for all PHP files.
-

Has full validation on the client side through JavaScript and server side through PHP.
-

Incorporates jQuery and Ajax.
-

BONUS:  Utilizes an API

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

