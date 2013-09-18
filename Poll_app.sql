SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `Poll_app` ;
CREATE SCHEMA IF NOT EXISTS `Poll_app` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `Poll_app` ;

-- -----------------------------------------------------
-- Table `Poll_app`.`polls`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Poll_app`.`polls` ;

CREATE  TABLE IF NOT EXISTS `Poll_app`.`polls` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `description` TEXT NOT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Poll_app`.`options`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Poll_app`.`options` ;

CREATE  TABLE IF NOT EXISTS `Poll_app`.`options` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `poll_id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `votes` BIGINT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_options_polls_idx` (`poll_id` ASC) ,
  CONSTRAINT `fk_options_polls`
    FOREIGN KEY (`poll_id` )
    REFERENCES `Poll_app`.`polls` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `Poll_app` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
