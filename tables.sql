DROP SCHEMA `autohelp`;

CREATE SCHEMA `autohelp`
  DEFAULT CHARACTER SET utf8;

USE autohelp;

CREATE TABLE `order` (
  `order_id`         INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `email`            VARCHAR(256),
  `phone`            VARCHAR(16),
  `name`             VARCHAR(64),
  `second_name`      VARCHAR(64),
  `surname`          VARCHAR(64),
  `vin`              VARCHAR(17),
  `number`           VARCHAR(16),
  `trademark`        VARCHAR(64),
  `model`            VARCHAR(64),
  `color`            VARCHAR(6),
  `delivery_address` VARCHAR(256),
  `card_id`          VARCHAR(64),
  `action_tag_id`    INT(10) UNSIGNED    NOT NULL,
  `activated`        TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `start_date`       DATETIME,
  `end_date`         DATETIME,

  PRIMARY KEY (`order_id`),
  UNIQUE KEY `vin` (`vin`),
  UNIQUE KEY `number` (`number`),
  UNIQUE KEY `card_id` (`card_id`),

  FOREIGN KEY (`action_tag_id`) REFERENCES `action_tag` (`action_tag_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE `action_tag` (
  `action_tag_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`         VARCHAR(128)     NOT NULL,
  `description`   VARCHAR(256),
  PRIMARY KEY (`action_tag_id`),
  UNIQUE KEY `title` (`title`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE `services` (
  `service_id`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(128)     NOT NULL,
  `description` VARCHAR(256),
  PRIMARY KEY (`action_tag_id`),
  UNIQUE KEY `title` (`title`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE `partner` (
  `partner_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR (128),
  `address`VARCHAR(256),

  PRIMARY KEY (`partner_id`),
  UNIQUE KEY (`name`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

/* mtm */
/*CREATE TABLE `partner_service` (

)
*/

/*TODO add realtime services*/