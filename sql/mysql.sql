SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `mydb`.`genetic`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `course` INT NULL ,
  `name` CHAR NULL ,
  `description` CHAR NULL ,
  `timecreated` INT NULL ,
  `timemodified` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'tabla del modulo a implementar';


-- -----------------------------------------------------
-- Table `mydb`.`genetic_ty`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_ty` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_headercards`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_headercards` (
  `id` INT NOT NULL ,
  `id_genetic` INT NULL ,
  `ty` INT NULL ,
  `datecreated` INT NULL ,
  `genetic_id` INT NULL ,
  `genetic_ty_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_headercards_genetic`
    FOREIGN KEY (`genetic_id` )
    REFERENCES `mydb`.`genetic` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_headercards_genetic_ty`
    FOREIGN KEY (`genetic_ty_id` )
    REFERENCES `mydb`.`genetic_ty` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_headercards_genetic` ON `mydb`.`genetic_headercards` (`genetic_id` ASC) ;

CREATE INDEX `fk_genetic_headercards_genetic_ty` ON `mydb`.`genetic_headercards` (`genetic_ty_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_subdomains`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_subdomains` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `iddom` INT NULL ,
  `name` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_sources`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_sources` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idcard` INT NULL ,
  `srcterm` CHAR NULL ,
  `srcdefinition` CHAR NULL ,
  `srccontext` CHAR NULL ,
  `srcexpression` CHAR NULL ,
  `srcrv` CHAR NULL ,
  `srcnotes` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_cards`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_cards` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idgenetic` INT NULL ,
  `idheader` INT NULL ,
  `isolang` CHAR NULL ,
  `term` CHAR NULL ,
  `gramcat` CHAR NULL ,
  `definition` CHAR NULL ,
  `context` CHAR NULL ,
  `expression` CHAR NULL ,
  `notes` CHAR NULL ,
  `genetic_sources_id` INT NULL ,
  `genetic_headercards_id` INT NULL ,
  `weighting_mark` CHAR NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_cards_genetic_sources`
    FOREIGN KEY (`genetic_sources_id` )
    REFERENCES `mydb`.`genetic_sources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_cards_genetic_headercards`
    FOREIGN KEY (`genetic_headercards_id` )
    REFERENCES `mydb`.`genetic_headercards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_cards_genetic_sources` ON `mydb`.`genetic_cards` (`genetic_sources_id` ASC) ;

CREATE INDEX `fk_genetic_cards_genetic_headercards` ON `mydb`.`genetic_cards` (`genetic_headercards_id` ASC) ;

CREATE FULLTEXT INDEX `index6` ON `mydb`.`genetic_cards` (`definition` ASC, `context` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_authors`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_authors` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` CHAR NULL ,
  `name` CHAR NULL ,
  `surname` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_rel_headerautor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_rel_headerautor` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idheadercard` INT NULL ,
  `idauthor` INT NULL ,
  `genetic_authors_id` INT NULL ,
  `genetic_headercards_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_rel_headerautor_genetic_authors1`
    FOREIGN KEY (`genetic_authors_id` )
    REFERENCES `mydb`.`genetic_authors` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_rel_headerautor_genetic_headercards1`
    FOREIGN KEY (`genetic_headercards_id` )
    REFERENCES `mydb`.`genetic_headercards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_rel_headerautor_genetic_authors1` ON `mydb`.`genetic_rel_headerautor` (`genetic_authors_id` ASC) ;

CREATE INDEX `fk_genetic_rel_headerautor_genetic_headercards1` ON `mydb`.`genetic_rel_headerautor` (`genetic_headercards_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_be`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_be` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_rel_hearderbe`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_rel_hearderbe` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idheadercard` INT NULL ,
  `idbe` INT NULL ,
  `genetic_be_id` INT NULL ,
  `genetic_headercards_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_rel_hearderbe_genetic_be1`
    FOREIGN KEY (`genetic_be_id` )
    REFERENCES `mydb`.`genetic_be` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_rel_hearderbe_genetic_headercards1`
    FOREIGN KEY (`genetic_headercards_id` )
    REFERENCES `mydb`.`genetic_headercards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_rel_hearderbe_genetic_be1` ON `mydb`.`genetic_rel_hearderbe` (`genetic_be_id` ASC) ;

CREATE INDEX `fk_genetic_rel_hearderbe_genetic_headercards1` ON `mydb`.`genetic_rel_hearderbe` (`genetic_headercards_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fileimage` CHAR NULL ,
  `srcimage` CHAR NULL ,
  `titleimage_es` CHAR NULL ,
  `titleimage_en` CHAR NULL ,
  `titleimage_de` CHAR NULL ,
  `titleimage_fr` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_videos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_videos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `filevideo` CHAR NULL ,
  `srcvideo` CHAR NULL ,
  `titlevideo_es` CHAR NULL ,
  `titlevideo_en` CHAR NULL ,
  `titlevideo_de` CHAR NULL ,
  `titlevideo_fr` CHAR NULL ,
  `audiolang` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_images_has_genetic_cards`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_images_has_genetic_cards` (
  `genetic_images_id` INT NULL ,
  `id` INT NOT NULL ,
  `genetic_headercards_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_images_has_genetic_cards_genetic_images1`
    FOREIGN KEY (`genetic_images_id` )
    REFERENCES `mydb`.`genetic_images` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_images_has_genetic_cards_genetic_headercards1`
    FOREIGN KEY (`genetic_headercards_id` )
    REFERENCES `mydb`.`genetic_headercards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_images_has_genetic_cards_genetic_images1` ON `mydb`.`genetic_images_has_genetic_cards` (`genetic_images_id` ASC) ;

CREATE INDEX `fk_genetic_images_has_genetic_cards_genetic_headercards1` ON `mydb`.`genetic_images_has_genetic_cards` (`genetic_headercards_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_videos_has_genetic_cards`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_videos_has_genetic_cards` (
  `genetic_cards_id` INT NULL ,
  `genetic_videos_id` INT NULL ,
  `id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_videos_has_genetic_cards_genetic_cards1`
    FOREIGN KEY (`genetic_cards_id` )
    REFERENCES `mydb`.`genetic_cards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_videos_has_genetic_cards_genetic_videos1`
    FOREIGN KEY (`genetic_videos_id` )
    REFERENCES `mydb`.`genetic_videos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_videos_has_genetic_cards_genetic_cards1` ON `mydb`.`genetic_videos_has_genetic_cards` (`genetic_cards_id` ASC) ;

CREATE INDEX `fk_genetic_videos_has_genetic_cards_genetic_videos1` ON `mydb`.`genetic_videos_has_genetic_cards` (`genetic_videos_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_remission`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_remission` (
  `id` INT NOT NULL ,
  `remission` CHAR NULL ,
  `rem_type` CHAR NULL ,
  `idcard` INT NULL ,
  `genetic_cards_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_remission_genetic_cards1`
    FOREIGN KEY (`genetic_cards_id` )
    REFERENCES `mydb`.`genetic_cards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_remission_genetic_cards1` ON `mydb`.`genetic_remission` (`genetic_cards_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_headercards_has_genetic_subdomains`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_headercards_has_genetic_subdomains` (
  `genetic_subdomains_id` INT NULL ,
  `genetic_headercards_id` INT NULL ,
  `id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_headercards_has_genetic_subdomains_genetic_subdomai1`
    FOREIGN KEY (`genetic_subdomains_id` )
    REFERENCES `mydb`.`genetic_subdomains` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_headercards_has_genetic_subdomains_genetic_headerca1`
    FOREIGN KEY (`genetic_headercards_id` )
    REFERENCES `mydb`.`genetic_headercards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_headercards_has_genetic_subdomains_genetic_subdomai1` ON `mydb`.`genetic_headercards_has_genetic_subdomains` (`genetic_subdomains_id` ASC) ;

CREATE INDEX `fk_genetic_headercards_has_genetic_subdomains_genetic_headerca1` ON `mydb`.`genetic_headercards_has_genetic_subdomains` (`genetic_headercards_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_audio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_audio` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fileaudio` CHAR NULL ,
  `lang` INT NULL ,
  `srcaudio` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_lang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_lang` (
  `id` INT NOT NULL ,
  `language` CHAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_lang_has_genetic`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_lang_has_genetic` (
  `genetic_lang_id` INT NULL ,
  `genetic_id` INT NULL ,
  `id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_lang_has_genetic_genetic_lang1`
    FOREIGN KEY (`genetic_lang_id` )
    REFERENCES `mydb`.`genetic_lang` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_lang_has_genetic_genetic1`
    FOREIGN KEY (`genetic_id` )
    REFERENCES `mydb`.`genetic` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_lang_has_genetic_genetic_lang1` ON `mydb`.`genetic_lang_has_genetic` (`genetic_lang_id` ASC) ;

CREATE INDEX `fk_genetic_lang_has_genetic_genetic1` ON `mydb`.`genetic_lang_has_genetic` (`genetic_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`genetic_cards_has_genetic_audio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`genetic_cards_has_genetic_audio` (
  `genetic_cards_id` INT NULL ,
  `genetic_audio_id` INT NULL ,
  `id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_genetic_cards_has_genetic_audio_genetic_cards1`
    FOREIGN KEY (`genetic_cards_id` )
    REFERENCES `mydb`.`genetic_cards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_genetic_cards_has_genetic_audio_genetic_audio1`
    FOREIGN KEY (`genetic_audio_id` )
    REFERENCES `mydb`.`genetic_audio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_genetic_cards_has_genetic_audio_genetic_cards1` ON `mydb`.`genetic_cards_has_genetic_audio` (`genetic_cards_id` ASC) ;

CREATE INDEX `fk_genetic_cards_has_genetic_audio_genetic_audio1` ON `mydb`.`genetic_cards_has_genetic_audio` (`genetic_audio_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
