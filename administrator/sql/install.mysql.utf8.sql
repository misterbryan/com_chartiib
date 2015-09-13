CREATE TABLE IF NOT EXISTS `#__chartiib_employees` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`name` VARCHAR(100) NOT NULL ,
`address` TEXT NOT NULL ,
`age` VARCHAR(20) NOT NULL ,
`notes` TEXT NOT NULL ,
`photo` VARCHAR(255) NOT NULL ,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__chartiib_posts` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`title` VARCHAR(255) NOT NULL ,
`description` TEXT NOT NULL ,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__chartiib_relations` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`id_post` INT(11) NOT NULL ,
`id_employee` INT(11) NOT NULL ,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__chartiib_hierarchy` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`level` TEXT NULL ,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

