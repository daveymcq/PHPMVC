CREATE DATABASE IF NOT EXISTS `website`;

CREATE TABLE IF NOT EXISTS `website`.`users` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                              `email` VARCHAR(255) NOT NULL, 
                                              `first_name` VARCHAR(255) NOT NULL,
                                              `last_name` VARCHAR(255) NOT NULL,
                                              `active` TINYINT(1) NOT NULL DEFAULT 0);