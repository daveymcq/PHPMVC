CREATE DATABASE IF NOT EXISTS `phpmvc`;
CREATE TABLE IF NOT EXISTS `phpmvc`.`users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(60) NOT NULL,
    `first_name` VARCHAR(30) NOT NULL,
    `last_name` VARCHAR(30) NOT NULL,
    `phone_number` VARCHAR(12) NOT NULL
);