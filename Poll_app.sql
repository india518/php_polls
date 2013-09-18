SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `Poll_app` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `Poll_app` ;

-- -----------------------------------------------------
-- Table `mydb`.`polls`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Poll_app`.`polls` ;

CREATE  TABLE IF NOT EXISTS `Poll_app`.`polls` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `description` TEXT NOT NULL ,
  `option1` VARCHAR(255) NULL ,
  `option2` VARCHAR(255) NULL ,
  `option3` VARCHAR(255) NULL ,
  `option4` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

USE `Poll_app` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
