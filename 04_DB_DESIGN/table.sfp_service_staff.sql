CREATE TABLE `sfp_service_staff`.`staff` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `login_id` VARCHAR(45) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_id_UNIQUE` (`login_id` ASC));

ALTER TABLE `sfp_service_staff`.`staff` 
ADD COLUMN `cms_theme_id` TINYINT(1) NOT NULL DEFAULT 1 AFTER `email`,
ADD COLUMN `front_theme_id` TINYINT(1) NULL DEFAULT 1 AFTER `cms_theme_id`;


CREATE TABLE `sfp_service_staff`.`administrators` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `login_id` VARCHAR(45) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `is_super` TINYINT(1) NOT NULL DEFAULT 0,
  `name` VARCHAR(128) NOT NULL,
  `address` TEXT NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_id_UNIQUE` (`login_id` ASC));

ALTER TABLE `sfp_service_staff`.`administrators` 
ADD COLUMN `theme_id` TINYINT(1) NOT NULL DEFAULT 1 AFTER `phone`,
ADD COLUMN `created` DATETIME NULL DEFAULT NULL AFTER `theme_id`,
ADD COLUMN `modified` DATETIME NULL DEFAULT NULL AFTER `created`;

ALTER TABLE `sfp_service_staff`.`administrators` 
CHANGE COLUMN `theme_id` `cms_theme_id` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `sfp_service_staff`.`administrators` 
ADD COLUMN `front_theme_id` TINYINT(1) NOT NULL DEFAULT 1 AFTER `phone`;

CREATE TABLE `sfp_service_staff`.`theme` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  `theme_dir` VARCHAR(128) NOT NULL,
  `use` VARCHAR(45) NOT NULL DEFAULT 'Front',
  `created` DATETIME NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `theme_dir_UNIQUE` (`theme_dir` ASC));
