-- MySQL Script generated by MySQL Workbench
-- Thu Jan 28 01:27:29 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema alium
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema alium
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `alium` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE `alium` ;

-- -----------------------------------------------------
-- Table `alium`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alium`.`users` ;

CREATE TABLE IF NOT EXISTS `alium`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `cpf_cnpj` VARCHAR(20) NOT NULL,
  `email` VARCHAR(70) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `description` MEDIUMTEXT NULL,
  `profile_picture` MEDIUMTEXT NULL,
  `address` VARCHAR(45) NULL,
  `address_number` VARCHAR(10) NULL,
  `address_complement` VARCHAR(40) NULL,
  `neighborhood` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `password` VARCHAR(45) NOT NULL,
  `postal_code` VARCHAR(8) NULL,
  `role` VARCHAR(45) NULL,
  `social_media` VARCHAR(255) NULL,
  `token` VARCHAR(255) NULL DEFAULT '',
  `token_date` VARCHAR(255) NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cpf_cnpj_UNIQUE` (`cpf_cnpj` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `alium`.`services`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alium`.`services` ;

CREATE TABLE IF NOT EXISTS `alium`.`services` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `service` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `service_UNIQUE` (`service` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `alium`.`services`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alium`.`users_has_services` ;

CREATE TABLE IF NOT EXISTS `alium`.`users_has_services` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_has_services_user_idx` (`user_id` ASC),
  INDEX `fk_users_has_services_service_idx` (`service_id` ASC),
  CONSTRAINT `fk_users_has_services_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `alium`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_services_service`
    FOREIGN KEY (`service_id`)
    REFERENCES `alium`.`services` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `alium`.`feedbacks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alium`.`feedbacks` ;

CREATE TABLE IF NOT EXISTS `alium`.`feedbacks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `feedback` VARCHAR(200) NOT NULL,
  `evaluation` INT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `service_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_feedback_service_idx` (`service_id` ASC),
  INDEX `fk_feedback_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_feedback_service`
    FOREIGN KEY (`service_id`)
    REFERENCES `alium`.`services` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_feedback_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `alium`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `alium`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alium`.`images` ;

CREATE TABLE IF NOT EXISTS `alium`.`images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_image_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_image_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `alium`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

INSERT INTO `services` (`service`) VALUES ('Pintor');
INSERT INTO `services` (`service`) VALUES ('Pedreiro');
INSERT INTO `services` (`service`) VALUES ('Eletricista');
INSERT INTO `services` (`service`) VALUES ('Mecânico');
INSERT INTO `services` (`service`) VALUES ('Encanador');
