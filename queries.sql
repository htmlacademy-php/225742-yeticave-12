/**
 Добавляет данные - категории
 */

INSERT INTO categories SET code = 'boards', category = 'Доски и лыжи';
INSERT INTO categories SET code = 'attachment', category = 'Крепления';
INSERT INTO categories SET code = 'boots', category = 'Ботинки';
INSERT INTO categories SET code = 'clothing', category = 'Одежда';
INSERT INTO categories SET code = 'tools', category = 'Инструменты';
INSERT INTO categories SET code = 'other', category = 'Разное';

/**
 Добавляет данные - пользователи
 */

INSERT INTO users SET registration_date = '2019-08-01 23:43:26', email = 'renton1999@gmail.com', name = 'Марк Рентон', password = 'choose_life', contact = '+7(854)543-54-54';
INSERT INTO users SET registration_date = '2020-02-23 23:42:42', email = 'bagby1989@gmail.com', name = 'Фрэнсис Бэгби', password = 'choose_career', contact = '+7(854)521-89-09';
INSERT INTO users SET registration_date = '2020-05-13 16:32:01', email = 'kaifolom@gmail.com', name = 'Кайфолом Кайфоломыч', password = 'choose_family', contact = '+7(884)575-18-09';

/**
 Добавляет данные - лоты
 */

INSERT INTO lots SET name = '2014 Rossignol District Snowboard', description = 'Описание отсутствует..', img_link = 'img/lot-1.jpg', category_id = 1, creation_date = '2021-04-16 12:54:34', termination_date = '2021-08-01 15:00:00', start_cost = 10999, step = 500, author_id = 1 ;
INSERT INTO lots SET name = 'DC Ply Mens 2016/2017 Snowboard', description = 'Описание отсутствует..', img_link = 'img/lot-2.jpg', category_id = 1, creation_date = '2021-05-06 17:24:24', termination_date = '2021-09-10 21:00:00', start_cost = 159999, step = 1000, author_id = 2 ;
INSERT INTO lots SET name = 'Крепления Union Contact Pro 2015 года размер L/XL', description = 'Описание отсутствует..', img_link = 'img/lot-3.jpg', category_id = 2, creation_date = '2021-07-01 07:40:24', termination_date = '2021-09-03 15:00:00', start_cost = 8000, step = 550, author_id = 3 ;
INSERT INTO lots SET name = 'Ботинки для сноуборда DC Mutiny Charocal', description = 'Описание отсутствует..', img_link = 'img/lot-4.jpg', category_id = 3, creation_date = '2021-07-25 16:14:04', termination_date = '2021-09-01 10:00:00', start_cost = 10999, step = 750, author_id = 3 ;
INSERT INTO lots SET name = 'Куртка для сноуборда DC Mutiny Charocal', description = 'Описание отсутствует..', img_link = 'img/lot-5.jpg', category_id = 4, creation_date = '2021-06-12 19:04:54', termination_date = '2021-09-05 09:00:00', start_cost = 7500, step = 250, author_id = 2 ;
INSERT INTO lots SET name = 'Маска Oakley Canopy', description = 'Описание отсутствует..', img_link = 'img/lot-6.jpg', category_id = 6, creation_date = '2021-07-19 09:20:30', termination_date = '2021-09-01 12:00:00', start_cost = 5400, step = 250, author_id = 1 ;

/**
 Добавляет данные - ставки
 */

INSERT INTO bets SET creation_date = '2021-07-17 12:23:53', amount = 40000, lot_id = 3, author_id = 2;
INSERT INTO bets SET creation_date = '2021-07-18 12:53:03', amount = 50400, lot_id = 1, author_id = 3;
INSERT INTO bets SET creation_date = '2021-07-19 15:16:43', amount = 89500, lot_id = 2, author_id = 1;

SELECT code, category from categories; /* Выбирает все категории */

SELECT name, description, start_cost, img_link, category_id FROM lots WHERE winner IS NULL ORDER BY creation_date DESC; /* Выбирает все лоты, которые открыты от свежих к старым*/

SELECT l.* , category FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = 2; /* Показывает лот с id = 2 а также его категорию. */

UPDATE lots SET name = 'NEW ITEM' WHERE id = 5; /* Обновляет название лота по его id */

SELECT * FROM bets WHERE lot_id = 2 ORDER BY creation_date DESC;








