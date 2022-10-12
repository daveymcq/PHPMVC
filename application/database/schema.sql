CREATE DATABASE IF NOT EXISTS `davidmchugh.org`;
CREATE TABLE IF NOT EXISTS `davidmchugh.org`.`users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(60),
    `first_name` VARCHAR(30),
    `last_name` VARCHAR(30),
    `phone_number` VARCHAR(12),
    `password` VARCHAR(120),
    `post_id` INT(11),
    INDEX (`post_id`)
);
CREATE TABLE IF NOT EXISTS `davidmchugh.org`.`posts` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `body` TEXT,
    `title` VARCHAR(60),
    `user_id` INT(11),
    INDEX (`user_id`)
);

CREATE DATABASE IF NOT EXISTS `php.localhost`;
CREATE TABLE IF NOT EXISTS `php.localhost`.`users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(60),
    `first_name` VARCHAR(30),
    `last_name` VARCHAR(30),
    `phone_number` VARCHAR(12),
    `password` VARCHAR(120),
    `post_id` INT(11),
    INDEX (`post_id`)
);
CREATE TABLE IF NOT EXISTS `php.localhost`.`posts` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `body` TEXT,
    `title` VARCHAR(60),
    `user_id` INT(11),
    INDEX (`user_id`)
);
