CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeticave;

CREATE TABLE categories (
	id                      INT AUTO_INCREMENT PRIMARY KEY,
	category                VARCHAR(100) UNIQUE,
  category_code           VARCHAR(75) UNIQUE
);

CREATE TABLE lots (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
	creation_date           TIMESTAMP,
  lot_name                VARCHAR(100),
  lot_description         TEXT,
  img_link                VARCHAR(100) UNIQUE,
  start_cost              INT,
  termination_date        TIMESTAMP,
  step                    INT,
  author_id               INT,
  winner                  INT,
  category                INT
);

CREATE TABLE bets (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
  creation_date           DATETIME,
  amount                  INT,
  lot_id                  INT,
  author_id               INT,
  INDEX(amount)
);

CREATE TABLE users (
  id                      INT AUTO_INCREMENT PRIMARY KEY,
  registration_date       TIMESTAMP,
  email                   VARCHAR(100),
  name                    VARCHAR(100),
  user_password           VARCHAR(75),
  contact                 VARCHAR(150),
  INDEX (name),
  UNIQUE INDEX (email)
);



