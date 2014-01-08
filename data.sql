use autohelp;

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'A',199);
insert into card (number, series_id) values ('A100',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'B',199);
insert into card (number, series_id) values ('B100',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'C',199);
insert into card (number, series_id) values ('C100',LAST_INSERT_ID());

insert into `action_tag` (`name`, `title`, `description`) values('call','Обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('recall','Повторный обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('check','Проверка', 'Оплаченные заявки, требующие уточнения данных');
insert into `action_tag` (`name`, `title`, `description`) values('activate','Активация', 'Заявки с проверенными данными, но не оплаченные');
insert into `action_tag` (`name`, `title`, `description`) values('expire','Истечение', 'Активированные карты, у которых истекает срок действия');
insert into `action_tag` (`name`, `title`, `description`) values('cash_on_place','Оплата на месте', 'Клиенты, которые не приобрели карты и оплачивают услуги на месте');


INSERT into `service` (`title`, `description`) values ('Эвакуация', 'Возможность вызова эвакуатора неограниченное количество раз в любую точку Самары (в дальнейшем – Самарской области) в случае неисправности ТС и невозможности его дальнейшей эксплуатации');
INSERT into `service` (`title`, `description`) values ('Шиномонтаж', 'Вызов шиномонтажа неограниченное число раз, за исключением перебортовки 4 колес');
INSERT into `service` (`title`, `description`) values ('Подогев двигателя', 'Вызов службы подогрева двигателя при невозможности завестись в зимнее время');
INSERT into `service` (`title`, `description`) values ('Разблокировка замков', 'Вскрытие специалистами автомобиля при его блокировке');
INSERT into `service` (`title`, `description`) values ('Аварийный комиссар', 'Возможность вызова аварийного комиссара неограниченное число раз');
INSERT into `service` (`title`, `description`) values ('Скидки на услуги организаций-партнеров', 'От 5% и выше (перебортовка, автомойка, сервис)');



INSERT into `service_group` (`title`) values ('Техническая помощь');
SET @service_group_id= LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Зачистка клемм АКБ', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Зачистка батарей сигнализации', 'Замена батареек в брелоке сигнализации и имобилайзера');
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Разморозка замков', 'Размораживание замков автомобиля с использованием специальных жидкостей');
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Отключение нештатной сигнализации', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Разблокировка АКПП', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Отогрев различных частей автомобиля', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Разблокировка руля', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());




INSERT into `service_group` (`title`) values ('Информационная поддержка');
SET @service_group_id= LAST_INSERT_ID();
INSERT into `service` (`title`, `description`) values ('Информация о штраф стоянке', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Информация о круглосуточных автоуслугах', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Юридическая помощь', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Помощь в выборе авто', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Подбор страховой компании', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Помощь в получении автокредита', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());
INSERT into `service` (`title`, `description`) values ('Помощь при ДТП', NULL);
INSERT into `service2group` (`group_id`, `service_id`) values (@service_group_id, LAST_INSERT_ID());


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


/* begin dummies*/
INSERT into `order`(`email`, `phone`) values ('client2@ya.ru','79279876532');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'call';

INSERT into `order`(`email`, `phone`) values ('client3@ya.ru','79856328545');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'activate';

INSERT into `order`(`email`, `phone`) values ('client6@ya.ru','65432168794');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'call';

INSERT into `order`(`email`, `phone`) values ('client12@ya.ru','23216488746');
INSERT into order2action_tag (`order_id`, `action_tag_id`)
  select LAST_INSERT_ID() ,action_tag.id from action_tag where action_tag.name = 'recall';




/* end dummies */