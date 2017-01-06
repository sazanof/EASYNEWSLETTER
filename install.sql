CREATE TABLE `easynewsletter_categories` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`kat_title` VARCHAR(255) NULL DEFAULT NULL,
	`kat_descr` TEXT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_2` (`id`),
	INDEX `id` (`id`),
	INDEX `id_3` (`id`),
	INDEX `id_4` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=4
;

CREATE TABLE `easynewsletter_config` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`mailmethod` VARCHAR(255) NOT NULL DEFAULT '',
	`port` INT(5) NOT NULL DEFAULT '0',
	`smtp` VARCHAR(200) NOT NULL DEFAULT '',
	`auth` VARCHAR(5) NOT NULL DEFAULT '',
	`authuser` VARCHAR(100) NOT NULL DEFAULT '',
	`authpassword` VARCHAR(100) NOT NULL DEFAULT '',
	`sendername` VARCHAR(200) NOT NULL DEFAULT '',
	`senderemail` VARCHAR(200) NOT NULL DEFAULT '',
	`lang_frontend` VARCHAR(100) NOT NULL DEFAULT '',
	`lang_backend` VARCHAR(100) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`),
	INDEX `id` (`id`),
	INDEX `id_2` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=2
;

CREATE TABLE `easynewsletter_newsletter` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`date` DATE NOT NULL DEFAULT '0000-00-00',
	`status` INT(10) NOT NULL DEFAULT '0',
	`sent` INT(10) NOT NULL DEFAULT '0',
	`header` LONGTEXT NULL,
	`subject` TEXT NOT NULL,
	`newsletter` LONGTEXT NULL,
	`footer` LONGTEXT NULL,
	`dates` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=4
;

CREATE TABLE `easynewsletter_subscribers` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`firstname` VARCHAR(50) NULL DEFAULT NULL,
	`lastname` VARCHAR(50) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`status` INT(10) NULL DEFAULT '1',
	`blocked` INT(10) NULL DEFAULT '0',
	`lastnewsletter` VARCHAR(50) NULL DEFAULT NULL,
	`created` DATE NOT NULL DEFAULT '0000-00-00',
	`cat_id` INT(10) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=10
;
