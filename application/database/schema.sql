CREATE DATABASE IF NOT EXISTS `phpmvc`;
CREATE TABLE IF NOT EXISTS `phpmvc`.`users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(60),
    `first_name` VARCHAR(30),
    `last_name` VARCHAR(30),
    `phone_number` VARCHAR(12),
    `password` VARCHAR(120),
    `post_id` INT(11),
    INDEX (`post_id`)
);
CREATE TABLE IF NOT EXISTS `phpmvc`.`posts` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `body` TEXT,
    `title` VARCHAR(60),
    `user_id` INT(11),
    INDEX (`user_id`)
);
