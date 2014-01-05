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


CREATE TABLE `service` (
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
  `name`       VARCHAR(128),
  `address`    VARCHAR(256),

  PRIMARY KEY (`partner_id`),
  UNIQUE KEY (`name`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `partner2service` (
  `partner2service_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partner_id`         INT(10) UNSIGNED NOT NULL,
  `service_id`         INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`partner2service_id`),
  FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`),
  FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `order2action_tag` (
  `order2action_tag_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`            INT(10) UNSIGNED NOT NULL,
  `action_tag_id`       INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`order2action_tag_id`),
  FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  FOREIGN KEY (`action_tag_id`) REFERENCES `action_tag` (`action_tag_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `card_parcel` (
  `card_parcel_id` INT(10) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `start_card_id`  VARCHAR(64)          NOT NULL,
  `end_card_id`    VARCHAR(64)          NOT NULL,
  `series`         ENUM ('A', 'B', 'C') NOT NULL,
  `comment`        VARCHAR(256),

  PRIMARY KEY (`card_parcel_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `request` (
  `request_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status`     ENUM ('opened', 'in_progress', 'resolved', 'rejected'),
  `comment`    VARCHAR(256),
  `user_id`    INT(10) UNSIGNED NOT NULL,
  `timestamp`  DATETIME,

  PRIMARY KEY (`request_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user` (
  `user_id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(64),
  `second_name` VARCHAR(64),
  `surname`     VARCHAR(64),

  PRIMARY KEY (`user_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `role` (
  `role_id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(128),
  `description` VARCHAR(256),

  PRIMARY KEY (`role_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user2role` (
  `user2role_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`      INT(10) UNSIGNED NOT NULL,
  `role_id`      INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`user2role_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `request2partner2service` (
  `request2partner2services_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_id`                  INT(10) UNSIGNED NOT NULL,
  `partner2service_id`          INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`request2partner2services_id`),
  FOREIGN KEY (`request_id`) REFERENCES `request` (`request_id`),
  FOREIGN KEY (`partner2service_id`) REFERENCES `partner2service` (`partner2service_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
