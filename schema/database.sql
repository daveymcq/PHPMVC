CREATE DATABASE IF NOT EXISTS `website`;

CREATE TABLE IF NOT EXISTS `website`.`users` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                              `email` VARCHAR(255) NOT NULL,
                                              `password` VARCHAR(80) NOT NULL,
                                              `first_name` VARCHAR(80) NOT NULL,
                                              `last_name` VARCHAR(80) NOT NULL,
                                              `active` TINYINT(1) NOT NULL DEFAULT 0);

CREATE TABLE IF NOT EXISTS `website`.`comments` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                 `comment_body` VARCHAR(255) NOT NULL,
                                                 `commented_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                 `user_id` INT(11) NOT NULL);

CREATE TABLE IF NOT EXISTS `website`.`videos` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                               `count` INT(11) NOT NULL DEFAULT 0,
                                               `title` VARCHAR(255) NOT NULL,
                                               `uploaded_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                               `user_id` INT(11) NOT NULL);

