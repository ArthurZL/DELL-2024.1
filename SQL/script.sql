DROP DATABASE IF EXISTS dell;
CREATE DATABASE IF NOT EXISTS dell;
USE dell;

CREATE TABLE userr (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14) NOT NULL,
    name VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    lvl_access INT NOT NULL
);

CREATE TABLE bet (
    bet_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    registration_id INT NOT NULL,
    edition_id INT NOT NULL,
    number INT NOT NULL
);

CREATE TABLE registration (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    registration_nr INT NOT NULL,
    edition_id INT NOT NULL
);

CREATE TABLE edition (
    edition_id INT AUTO_INCREMENT PRIMARY KEY,
    year INT NOT NULL
);

ALTER TABLE bet ADD FOREIGN KEY (user_id) REFERENCES userr(user_id);
ALTER TABLE bet ADD FOREIGN KEY (edition_id) REFERENCES edition(edition_id);
ALTER TABLE registration ADD FOREIGN KEY (edition_id) REFERENCES edition(edition_id);

ALTER TABLE userr ADD UNIQUE (cpf);
ALTER TABLE registration ADD UNIQUE (registration_nr);
ALTER TABLE edition ADD UNIQUE (year);