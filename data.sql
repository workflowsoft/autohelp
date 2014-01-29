use autohelp;

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'A',199);
insert into card (number, series_id) values ('A000000001',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'B',199);
insert into card (number, series_id) values ('B000000001',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'C',199);
insert into card (number, series_id) values ('C000000001',LAST_INSERT_ID());

insert into `action_tag` (`name`, `title`, `description`) values('call','Обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('recall','Повторный обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('check','Проверка', 'Оплаченные заявки, требующие уточнения данных');
insert into `action_tag` (`name`, `title`, `description`) values('activate','Активация', 'Заявки с проверенными данными, но не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('expire','Истечение', 'Активированные карты, у которых истекает срок действия');
insert into `action_tag` (`name`, `title`, `description`) values('cash_on_place','Оплата на месте', 'Клиенты, которые не приобрели карты и оплачивают услуги на месте');
insert into `action_tag` (`name`, `title`, `description`) values('delivery','Доставка', 'Клиенты, которым доставляют карту');


INSERT into `service` (`title`, `description`) values ('Эвакуация', 'Возможность вызова эвакуатора неограниченное количество раз в любую точку Самары (в дальнейшем – Самарской области) в случае неисправности ТС и невозможности его дальнейшей эксплуатации');
SET @evaq = LAST_INSERT_ID();

INSERT into `service` (`title`) values ('Расчистка парковочного места');
SET @park_clean = LAST_INSERT_ID();

INSERT into `service` (`title`) values ('Трезвый водитель');
SET @trezv = LAST_INSERT_ID();

INSERT into `service` (`title`, `description`) values ('Шиномонтаж', 'Вызов шиномонтажа неограниченное число раз, за исключением перебортовки 4 колес');
SET @shin = LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Подогев двигателя', 'Вызов службы подогрева двигателя при невозможности завестись в зимнее время');
SET @engine_unfreeze = LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Разблокировка замков', 'Вскрытие специалистами автомобиля при его блокировке');
SET @unlock_auto = LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Аварийный комиссар', 'Возможность вызова аварийного комиссара неограниченное число раз');
SET @comissar = LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Скидки на услуги организаций-партнеров', 'От 5% и выше (перебортовка, автомойка, сервис)');
SET @discount = LAST_INSERT_ID();



INSERT into `service_group` (`title`) values ('Техническая помощь');
SET @service_group_id= LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Зачистка клемм АКБ', NULL);
SET @clemm = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @clemm);

INSERT into `service` (`title`, `description`) values ('Вынуть из сугроба', NULL);
SET @sugrob = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @sugrob);

INSERT into `service` (`title`, `description`) values ('Прикурить', NULL);
SET @prikur = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @prikur);

INSERT into `service` (`title`, `description`) values ('Заменить запаску', NULL);
SET @zapas = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @zapas);

INSERT into `service` (`title`, `description`) values ('Подкачать колеса', NULL);
SET @podkach = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @podkach);

INSERT into `service` (`title`, `description`) values ('Подвоз топлива', NULL);
SET @benz = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @benz);

INSERT into `service` (`title`, `description`) values ('Замена батарей сигнализации', 'Замена батареек в брелоке сигнализации и имобилайзера');
SET @immo_batt = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @immo_batt);
INSERT into `service` (`title`, `description`) values ('Разморозка замков', 'Размораживание замков автомобиля с использованием специальных жидкостей');
SET @lock_unfreeze = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @lock_unfreeze);
INSERT into `service` (`title`, `description`) values ('Отключение нештатной сигнализации', NULL);
SET @alarm_off = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @alarm_off);
INSERT into `service` (`title`, `description`) values ('Разблокировка АКПП', NULL);
SET @trans_unlock = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @trans_unlock);
INSERT into `service` (`title`, `description`) values ('Отогрев различных частей автомобиля', NULL);
SET @defreeze = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @defreeze);
INSERT into `service` (`title`, `description`) values ('Разблокировка руля', NULL);
SET @ster_unlock = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());

INSERT into `service_group` (`title`) values ('Информационная поддержка');
SET @service_group_id= LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Информация о штраф стоянке', NULL);
SET @shtraf = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @shtraf);
INSERT into `service` (`title`, `description`) values ('Информация о круглосуточных автоуслугах', NULL);
SET @autoinfo = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @autoinfo);
INSERT into `service` (`title`, `description`) values ('Юридическая помощь', NULL);
SET @law = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @law);
INSERT into `service` (`title`, `description`) values ('Помощь в выборе авто', NULL);
SET @choose = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @choose);
INSERT into `service` (`title`, `description`) values ('Подбор страховой компании', NULL);
SET @strah = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @strah);
INSERT into `service` (`title`, `description`) values ('Помощь в получении автокредита', NULL);
SET @credit = LAST_INSERT_ID();
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, @credit);
INSERT into `service` (`title`, `description`) values ('Помощь при ДТП', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
SET @dtp = LAST_INSERT_ID();

insert into `role` (`title`, `description`) values ('client', 'Клиент');
insert into `role` (`title`, `description`) values ('operator_call', 'Обзвон клиентов для уточнения данных по карте');
insert into `role` (`title`, `description`) values ('operator_activate', 'Активация карт после оплаты');
insert into `role` (`title`, `description`) values ('dispatcher_new_ticket', 'Прием заявок на оказание услуг');
insert into `role` (`title`, `description`) values ('dispatcher_assign', 'Назначение исполнителей на заявки');
insert into `role` (`title`, `description`) values ('dispatcher_verify', 'Проверка исполнения заявки');
insert into `role` (`title`, `description`) values ('owner', 'Просмотр отчетов и аналитики');
insert into `role` (`title`, `description`) values ('admin', 'Создание пользователей, изменение списка услуг');


insert into `user` (`last_name`, `email`, `password`) values ('Тропин', 'maden@csharper.ru', MD5('qwerty123'));
SET @user_id = LAST_INSERT_ID();
insert into `user2role` (`user_id`, `role_id`) select @user_id, id from role;

insert into `user` (`last_name`, `email`, `password`) values ('Румянцев', 'altruer@gmail.com', MD5('qwerty123'));
SET @user_id = LAST_INSERT_ID();
insert into `user2role` (`user_id`, `role_id`) select @user_id, id from role;

INSERT INTO `partner` (`title`,`phone`) VALUES ('Мы сами', '------------');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @evaq);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @park_clean);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @trezv);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @shin);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @engine_unfreeze);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @unlock_auto);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @comissar);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @clemm);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @sugrob);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @prikur);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @zapas);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @podkach);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @benz);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @immo_batt);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @lock_unfreeze);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @alarm_off);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @trans_unlock);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @defreeze);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @ster_unlock);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @shtraf);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @autoinfo);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @law);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @choose);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @strah);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @credit);
INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @dtp);

INSERT INTO `partner` (`title`,`phone`) VALUES ('А911 (Николай Геннадьевич Павлихин) [12 эвакуаторов]', '+7-961-3800202');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @evaq);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Мастер на все руки (Геннадий) [3 эвакуатора]', '+7-917-9518628');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @evaq);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @unlock_auto);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @shin);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @engine_unfreeze);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Техничка (Алексей)', '+7-937-0633996');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @sugrob);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @prikur);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @zapas);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @podkach);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @benz);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @park_clean);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @trezv);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Аварийные комиссары (Георгий Геннадьевич)', '+7-927-7322862');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @comissar);

INSERT INTO `partner` (`title`,`phone`, `email`) VALUES ('Шиномонтаж на выезд район ЖД (Константин Иванов)', '+7-917-1543214', 'koleso163@list.ru');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @shin);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Мобильный шиномонтаж (Екатерина)', '+7-960-8234205');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @shin);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Август (Александр) [3 эвакуатора]', '+7-917-1075526');
SET @_partner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @shin);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @evaq);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @unlock_auto);
INSERT `partner2service` (`partner_id`,`service_id`) VALUES (@_partner, @engine_unfreeze);

INSERT INTO `partner` (`title`,`phone`) VALUES ('BEZпокраски (Евгений Петров)', '+7-927-6902673');
SET @_partner = LAST_INSERT_ID();

INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @discount);
	
INSERT INTO `partner` (`title`,`phone`) VALUES ('Auto-Spa (Артем Давыдов) [Физкультурная 105]', '+7-927-0031050');
SET @_partner = LAST_INSERT_ID();

INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @discount);

INSERT INTO `partner` (`title`,`phone`) VALUES ('Автоуслуги (Рыбакин Валерий)', '+7-846-2765675');
SET @_partner = LAST_INSERT_ID();

INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @discount);
	
INSERT INTO `partner` (`title`,`phone`) VALUES ('Кузовной ремонт в Самаре Fenix Pro Service Aвтомойка и шиномонтаж AutoLuxe (Стрельцов Игорь)', '+7-927-7485891');
SET @_partner = LAST_INSERT_ID();

INSERT `partner2service` (`partner_id`,`service_id`) 
	VALUES (@_partner, @discount);
	
/* begin dummies*/
/*
INSERT into `order`(`email`, `phone`) values ('client2@ya.ru','79279876532');
SET @Order1 = LAST_INSERT_ID();
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select @Order1 ,action_tag.id from action_tag where action_tag.name = 'call';


INSERT into `order`(`email`, `phone`) values ('client3@ya.ru','79856328545');
SET @Order2 = LAST_INSERT_ID();
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select @Order2 ,action_tag.id from action_tag where action_tag.name = 'activate';

INSERT into `order`(`email`, `phone`) values ('client6@ya.ru','65432168794');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'call';

INSERT into `order`(`email`, `phone`) values ('client12@ya.ru','23216488746');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'recall';

INSERT  into `ticket`(`status`, `comment`, `order_id`) VALUES ('new', 'ул. Степана разина первый перекресток перед палычем', @Order1);
INSERT `ticket2service`(`ticket_id`,`service_id`)
    SELECT LAST_INSERT_ID(), `id` FROM `service`
      WHERE title in ('Эвакуация','Шиномонтаж','Подогев двигателя','Разблокировка замков');
INSERT  into `ticket`(`status`, `comment`, `order_id`) VALUES ('new', 'ул. Демократическая, сразу перед кольцом рынка Шапито', @Order2);
SET @secondTicket = LAST_INSERT_ID();
INSERT `ticket2service`(`ticket_id`,`service_id`)
  SELECT @secondTicket, `id` FROM `service`
  WHERE title in ('Эвакуация','Аварийный комиссар','Юридическая помощь','Помощь при ДТП');

INSERT INTO `partner` (`title`,`phone`) VALUES ('Эвакуатор 911', '999111999');
SET @firstPartner = LAST_INSERT_ID();
INSERT `partner2service` (`partner_id`,`service_id`)
  SELECT @firstPartner, `id` FROM `service`
  WHERE title in ('Эвакуация','Разблокировка руля','Помощь при ДТП');

INSERT INTO `partner` (`title`,`phone`) VALUES ('Дыра в покрышке', '99932499');
INSERT `partner2service` (`partner_id`,`service_id`)
  SELECT LAST_INSERT_ID(), `id` FROM `service`
  WHERE title in ('Шиномонтаж','Подогев двигателя','Зачистка клемм АКБ');

INSERT INTO `partner` (`title`,`phone`) VALUES ('Не пропадешь', '99932499');
INSERT `partner2service` (`partner_id`,`service_id`)
  SELECT LAST_INSERT_ID(), `id` FROM `service`
  WHERE title in ('Юридическая помощь','Помощь при ДТП');
  
INSERT `partner2ticket` (`partner2service_id`, `ticket_id`)
    SELECT id, @secondTicket FROM partner2service
    WHERE partner2service.partner_id = @firstPartner
    */