use autohelp;

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'A',199);
insert into card (number, series_id) values ('A100',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'B',199);
insert into card (number, series_id) values ('B100',LAST_INSERT_ID());

insert into card_series(starting_number, ending_number, series_type, count) values (1,200,'C',199);
insert into card (number, series_id) values ('C100',LAST_INSERT_ID());

insert into `action_tag` (title, description) values('Обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (title, description) values('Повторный обзвон', 'Первичные заявки, требующие уточнения данных и не оплаченные');
insert into `action_tag` (title, description) values('Проверка', 'Оплаченные заявки, требующие уточнения данных');
insert into `action_tag` (title, description) values('Активация', 'Заявки с проверенными данными, но не оплаченные');
insert into `action_tag` (title, description) values('Истечение', 'Активированные карты, у которых истекает срок действия');

INSERT into

