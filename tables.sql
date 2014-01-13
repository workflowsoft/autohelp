DROP SCHEMA `autohelp`;

CREATE SCHEMA `autohelp`
  DEFAULT CHARACTER SET utf8;

USE autohelp;

CREATE TABLE `card_series` (
  `id`                 INT(10) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `starting_number`    INT(10)              NOT NULL,
  `ending_number`      INT(10)              NOT NULL,
  `series_type`        ENUM ('A', 'B', 'C') NOT NULL,
  `distributing_point` VARCHAR(128),
  `comment`            VARCHAR(256),
  `count`              INT(10)              NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `card` (
  `id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number`    VARCHAR(128)     NOT NULL,
  `series_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  FOREIGN KEY (`series_id`) REFERENCES `card_series` (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

CREATE TABLE `action_tag` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(128)     NOT NULL,
  `title`       VARCHAR(128)     NOT NULL,
  `description` VARCHAR(256),
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `name` (`name`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

CREATE TABLE `order` (
  `id`                    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`                 VARCHAR(256), #email или phone должны быть обязательно, лучше оба
  `phone`                 VARCHAR(16),
  `description`           VARCHAR(256),
  `first_name`            VARCHAR(64),
  `middle_name`           VARCHAR(64),
  `last_name`             VARCHAR(64),
  `vin`                   VARCHAR(17), # Перед активацией карты vin или grn должен быть обязательно, лучше оба
  `grn`                   VARCHAR(16),
  `ts_make`               VARCHAR(64),
  `ts_model`              VARCHAR(64),
  `ts_color`              VARCHAR(6),
  `card_delivery_address` VARCHAR(256),
  `card_id`               INT(10) UNSIGNED,
  `activation_start`      DATETIME,
  `activation_end`        DATETIME,

  PRIMARY KEY (`id`),
  UNIQUE KEY `vin` (`vin`),
  UNIQUE KEY `grn` (`grn`),
  FOREIGN KEY (`card_id`) REFERENCES `card` (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

CREATE TABLE `order2action_tag` (
  `id`            INT(10)    UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`      INT(10) UNSIGNED    NOT NULL,
  `action_tag_id` INT(10) UNSIGNED    NOT NULL,
  `ation_time`    DATETIME,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  FOREIGN KEY (`action_tag_id`) REFERENCES `action_tag` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `service` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(128)     NOT NULL,
  `description` VARCHAR(256),
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


CREATE TABLE `partner` (
  `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`   VARCHAR(128),
  `address` VARCHAR(256),
  `phone`   VARCHAR(128),
  `email`   VARCHAR(128),
  `skype`   VARCHAR(128),
  `icq`     VARCHAR(128),
  `mra`     VARCHAR(128),
  PRIMARY KEY (`id`),
  UNIQUE KEY (`title`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `partner2service` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partner_id` INT(10) UNSIGNED NOT NULL,
  `service_id` INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`partner_id`) REFERENCES `partner` (`id`),
  FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `user` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fist_name`   VARCHAR(64),
  `middle_name` VARCHAR(64),
  `last_name`   VARCHAR(64),

  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `ticket` (
  `id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status`             ENUM ('draft', 'new', 'assiging', 'assigned', 'in_progress', 'done', 'rejected'),
  `comment`            VARCHAR(2048),
  `user_id`            INT(10) UNSIGNED,
  `last_status_change` DATETIME,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `role` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(128),
  `description` VARCHAR(256),

  PRIMARY KEY (`id`),
  UNIQUE KEY (`title`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user2role` (
  `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `role_id` INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `partner2ticket` (
  `id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id`          INT(10) UNSIGNED NOT NULL,
  `partner2service_id` INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`),
  FOREIGN KEY (`partner2service_id`) REFERENCES `partner2service` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


/*****************/
ALTER TABLE `order` ADD `delivery_coords` POINT;
ALTER TABLE `order` ADD `delivery_street` VARCHAR(256);


CREATE TABLE `service_group` (
  `id`    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128)     NOT NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY (`title`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `service2group` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id`   INT(10) UNSIGNED NOT NULL,
  `service_id` INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`group_id`) REFERENCES `service_group` (`id`),
  FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


ALTER TABLE `user` ADD `email` VARCHAR(128) NOT NULL UNIQUE KEY;
ALTER TABLE `user` ADD `password` VARCHAR(32);

ALTER TABLE `card` ADD `prepaid` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `ticket` ADD `payment_without_card` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE  `ticket` ADD  `order_id` INT(10) UNSIGNED;
ALTER TABLE  `ticket` ADD CONSTRAINT FOREIGN KEY  (`order_id`) REFERENCES `order` (`id`);


CREATE TABLE `ticket2service` (
  `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` INT(10) UNSIGNED NOT NULL,
  `service_id` INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`),
  FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

alter table `order` add `delivered`  TINYINT(1) NOT NULL DEFAULT 0;
delimiter //
CREATE PROCEDURE getPartnersAssignList (IN TicketId INT(10) UNSIGNED)
BEGIN
  SELECT T2.*,IFNULL(T4.`TicketsInWork`, 0) AS `Workload` FROM
    (SELECT  P.`Id` as `PartnerId`,
             P.`title` as `PartnerTitle`,
                    P.`phone` as `PartnerPhone`,
       T.`ticket_id`, GROUP_CONCAT(T.`service_id`) as `ServiceIds`,
                    GROUP_CONCAT(S.`title`) as `ServiceTitles`,
                    COUNT(T.`service_id`) AS `ServiceCoverage`
     FROM `ticket2service` T
       LEFT JOIN `partner2service` PS ON PS.`service_id` = T.`service_id`
       LEFT JOIN `service` S ON T.`service_id` = S.`id`
       LEFT JOIN `partner` P ON P.`id` = PS.`partner_id`
     GROUP BY `partner_id`) T2
    LEFT JOIN
    (SELECT  T3.`partner_id`, COUNT(*) AS `TicketsInWork` FROM
      (SELECT PS.`partner_id`, PT.`ticket_id` FROM `partner2ticket` PT
        INNER JOIN `partner2service` PS ON PS.`id` = PT.`partner2service_id`
        INNER JOIN `ticket` TK ON PT.`ticket_id` = TK.`id`
      WHERE TK.`status` IN ('assigned','assiging','in_progress')
      GROUP BY PS.`partner_id`, PT.`ticket_id`) T3
    GROUP BY T3.`partner_id`) T4 ON T4.`partner_id` = T2.`PartnerId`
    WHERE T2.`ticket_id` = TicketId
    ORDER BY `ServiceCoverage` DESC, `Workload` ASC;
END//

delimiter ;


GRANT SELECT,INSERT
ON autohelp.partner
TO partner_admin@localhost
IDENTIFIED BY 'mysql159';

GRANT SELECT,INSERT
ON autohelp.service
TO partner_admin@localhost
IDENTIFIED BY 'mysql159';
