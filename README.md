# bark-parks
Team final project Dog Park Finder

CREATE TABLE parks (
  id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
    password VARCHAR(255)
);