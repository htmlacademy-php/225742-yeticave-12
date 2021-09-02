CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeticave;

CREATE TABLE categories (
	id                      INT AUTO_INCREMENT PRIMARY KEY,
	category                VARCHAR(100) UNIQUE,
  code                    VARCHAR(75) UNIQUE
);

CREATE TABLE lots (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
	creation_date           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name                    VARCHAR(100),
  description             TEXT,
  img_link                VARCHAR(100) UNIQUE,
  start_cost              INT,
  termination_date        DATETIME,
  step                    INT,
  author_id               INT,
  winner                  INT,
  category_id             INT
);

CREATE TABLE bets (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
  creation_date           DATETIME,
  amount                  INT,
  lot_id                  INT,
  author_id               INT
);

CREATE TABLE users (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
  registration_date       DATETIME,
  email                   VARCHAR(100),
  name                    VARCHAR(100),
  password                VARCHAR(100),
  contact                 VARCHAR(150),
  INDEX (name),
  UNIQUE INDEX (email)
);



