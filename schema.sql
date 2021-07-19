CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeticave;

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	category VARCHAR(25) UNIQUE,
  category_code VARCHAR(25) UNIQUE
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
	creation_date TIMESTAMP,
  lot_name VARCHAR(50),
  lot_description VARCHAR(250),
  img_link VARCHAR(50) UNIQUE,
  start_cost INT,
  termination_date TIMESTAMP,
  step INT,
  author_id INT,
  winner INT,
  category VARCHAR(25)
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
	creation_date TIMESTAMP,
  amount INT,
  lot_id INT UNIQUE,
  author_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date TIMESTAMP,
  email VARCHAR(30) UNIQUE,
  user_name VARCHAR(25),
  user_password VARCHAR(30),
  contact VARCHAR(150),
  lots VARCHAR(50),
  bets INT
);

CREATE INDEX user_name ON users(user_name);
CREATE UNIQUE INDEX user_email ON users(email);
CREATE INDEX bets_index ON bets(creation_date, amount, lot_id, author_id);
