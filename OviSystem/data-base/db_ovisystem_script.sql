-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_ovisystem
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_ovisystem
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_ovisystem` DEFAULT CHARACTER SET utf8 ;
USE `db_ovisystem` ;

-- -----------------------------------------------------
-- Table `db_ovisystem`.`users_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`users_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Users_Users_Categories_idx` (`type_id` ASC) VISIBLE,
  CONSTRAINT `fk_Users_Users_Categories`
    FOREIGN KEY (`type_id`)
    REFERENCES `db_ovisystem`.`users_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`flocks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`flocks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  INDEX `fk_Lotes_Users1_idx` (`users_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Lotes_Users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `db_ovisystem`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`sheeps`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`sheeps` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `flocks_id` INT NOT NULL,
  `mother_id` INT NULL,
  `father_id` INT NULL,
  `number` INT NULL,
  `eartag` VARCHAR(45) NULL,
  `sex` VARCHAR(45) NULL,
  `pregnancy` TINYINT(1) NULL DEFAULT 0,
  `birthdate` DATE NULL,
  `breed` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  INDEX `fk_Ovelha_Lotes1_idx` (`flocks_id` ASC) VISIBLE,
  CONSTRAINT `fk_Ovelha_Lotes1`
    FOREIGN KEY (`flocks_id`)
    REFERENCES `db_ovisystem`.`flocks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`diseases`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`diseases` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sheeps_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `situation` VARCHAR(255) NULL,
  `veterinarian` VARCHAR(255) NULL,
  `treatment` VARCHAR(255) NULL,
  `observation` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Diseases_Sheeps1_idx` (`sheeps_id` ASC) VISIBLE,
  CONSTRAINT `fk_Diseases_Sheeps1`
    FOREIGN KEY (`sheeps_id`)
    REFERENCES `db_ovisystem`.`sheeps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`wounds`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`wounds` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sheeps_id` INT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `date` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NULL,
  `situation` VARCHAR(255) NULL,
  `severity` VARCHAR(255) NULL,
  `treatment` VARCHAR(255) NULL,
  `observation` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Wounds_Sheeps1_idx` (`sheeps_id` ASC) VISIBLE,
  CONSTRAINT `fk_Wounds_Sheeps1`
    FOREIGN KEY (`sheeps_id`)
    REFERENCES `db_ovisystem`.`sheeps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`vaccines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`vaccines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sheeps_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `aplication_date` DATE NOT NULL,
  `dose` VARCHAR(255) NULL,
  `aplicator` VARCHAR(255) NULL,
  `observation` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Vaccines_Sheeps1_idx` (`sheeps_id` ASC) VISIBLE,
  CONSTRAINT `fk_Vaccines_Sheeps1`
    FOREIGN KEY (`sheeps_id`)
    REFERENCES `db_ovisystem`.`sheeps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`deworming`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`deworming` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sheeps_id` INT NOT NULL,
  `vermifuge` VARCHAR(255) NOT NULL,
  `aplication_date` DATE NOT NULL,
  `next_aplication` DATE NULL,
  `dose` VARCHAR(255) NULL,
  `via` VARCHAR(255) NULL,
  `aplicator` VARCHAR(255) NULL,
  `observation` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Deworming_Sheeps1_idx` (`sheeps_id` ASC) VISIBLE,
  CONSTRAINT `fk_Deworming_Sheeps1`
    FOREIGN KEY (`sheeps_id`)
    REFERENCES `db_ovisystem`.`sheeps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`faqs_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`faqs_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`faqs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`faqs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `faqs_categories_id` INT NOT NULL,
  `question` VARCHAR(255) NOT NULL,
  `answer` VARCHAR(255) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`, `faqs_categories_id`),
  INDEX `fk_Faqs_Faqs_Categories1_idx` (`faqs_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_Faqs_Faqs_Categories1`
    FOREIGN KEY (`faqs_categories_id`)
    REFERENCES `db_ovisystem`.`faqs_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_ovisystem`.`treatments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_ovisystem`.`treatments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sheeps_id` INT NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `medications` VARCHAR(255) NULL,
  `dose_frequency` VARCHAR(255) NULL,
  `veterinarian` VARCHAR(255) NULL,
  `observations` VARCHAR(255) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Treatments_Sheeps1_idx` (`sheeps_id` ASC) VISIBLE,
  CONSTRAINT `fk_Treatments_Sheeps1`
    FOREIGN KEY (`sheeps_id`)
    REFERENCES `db_ovisystem`.`sheeps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
