-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema beatbunnyproject
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema beatbunnyproject
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `beatbunnyproject` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin ;
USE `beatbunnyproject` ;

-- -----------------------------------------------------
-- Table `beatbunnyproject`.`profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`profile` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `saldo` DECIMAL ZEROFILL NULL,
  `nome` VARCHAR(45) NOT NULL,
  `nif` INT NULL,
  `isprodutor` ENUM('S', 'N') NULL,
  `imagemProfile` BLOB NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`payments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`genres`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`genres` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`albums`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`albums` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `launchdate` DATE NOT NULL,
  `review` DECIMAL ZEROFILL NULL,
  `imagemAlbum` BLOB NULL,
  `genres_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_albums_genres1_idx` (`genres_id` ASC) ,
  CONSTRAINT `fk_albums_genres1`
    FOREIGN KEY (`genres_id`)
    REFERENCES `beatbunnyproject`.`genres` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`iva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`iva` (
  `id` INT NOT NULL,
  `tax` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`musics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`musics` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
  `launchdate` DATE NOT NULL,
  `rating` DECIMAL ZEROFILL NULL,
  `lyrics` LONGTEXT NULL,
  `pvp` FLOAT NULL,
  `imagemMusica` BLOB NULL,
  `genres_id` INT UNSIGNED NOT NULL,
  `albums_id` INT UNSIGNED NOT NULL,
  `iva_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_musics_genres1_idx` (`genres_id` ASC) ,
  INDEX `fk_musics_albums1_idx` (`albums_id` ASC) ,
  INDEX `fk_musics_iva1_idx` (`iva_id` ASC) ,
  CONSTRAINT `fk_musics_genres1`
    FOREIGN KEY (`genres_id`)
    REFERENCES `beatbunnyproject`.`genres` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_musics_albums1`
    FOREIGN KEY (`albums_id`)
    REFERENCES `beatbunnyproject`.`albums` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_musics_iva1`
    FOREIGN KEY (`iva_id`)
    REFERENCES `beatbunnyproject`.`iva` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`playlists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`playlists` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `ispublica` ENUM('S', 'N') NULL DEFAULT 'N',
  `datacriacao` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`venda` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `valorTotal` FLOAT NULL,
  `profile_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_venda_users1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_venda_users1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `beatbunnyproject`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`linhavenda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`linhavenda` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `precoVenda` FLOAT NULL,
  `venda_id` INT UNSIGNED NOT NULL,
  `musics_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_linhavenda_venda_idx` (`venda_id` ASC) ,
  INDEX `fk_linhavenda_musics1_idx` (`musics_id` ASC) ,
  CONSTRAINT `fk_linhavenda_venda`
    FOREIGN KEY (`venda_id`)
    REFERENCES `beatbunnyproject`.`venda` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_linhavenda_musics1`
    FOREIGN KEY (`musics_id`)
    REFERENCES `beatbunnyproject`.`musics` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`profile_has_albums`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`profile_has_albums` (
  `profile_id` INT UNSIGNED NOT NULL,
  `albums_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`profile_id`, `albums_id`),
  INDEX `fk_profile_has_albums_albums1_idx` (`albums_id` ASC) ,
  INDEX `fk_profile_has_albums_profile1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_profile_has_albums_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `beatbunnyproject`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_has_albums_albums1`
    FOREIGN KEY (`albums_id`)
    REFERENCES `beatbunnyproject`.`albums` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`profile_has_playlists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`profile_has_playlists` (
  `profile_id` INT UNSIGNED NOT NULL,
  `playlists_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`profile_id`, `playlists_id`),
  INDEX `fk_profile_has_playlists_playlists1_idx` (`playlists_id` ASC) ,
  INDEX `fk_profile_has_playlists_profile1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_profile_has_playlists_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `beatbunnyproject`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_has_playlists_playlists1`
    FOREIGN KEY (`playlists_id`)
    REFERENCES `beatbunnyproject`.`playlists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`profile_has_musics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`profile_has_musics` (
  `profile_id` INT UNSIGNED NOT NULL,
  `musics_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`profile_id`, `musics_id`),
  INDEX `fk_profile_has_musics_musics1_idx` (`musics_id` ASC) ,
  INDEX `fk_profile_has_musics_profile1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_profile_has_musics_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `beatbunnyproject`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_has_musics_musics1`
    FOREIGN KEY (`musics_id`)
    REFERENCES `beatbunnyproject`.`musics` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beatbunnyproject`.`playlists_has_musics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beatbunnyproject`.`playlists_has_musics` (
  `playlists_id` INT UNSIGNED NOT NULL,
  `musics_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`playlists_id`, `musics_id`),
  INDEX `fk_playlists_has_musics_musics1_idx` (`musics_id` ASC) ,
  INDEX `fk_playlists_has_musics_playlists1_idx` (`playlists_id` ASC) ,
  CONSTRAINT `fk_playlists_has_musics_playlists1`
    FOREIGN KEY (`playlists_id`)
    REFERENCES `beatbunnyproject`.`playlists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_playlists_has_musics_musics1`
    FOREIGN KEY (`musics_id`)
    REFERENCES `beatbunnyproject`.`musics` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
