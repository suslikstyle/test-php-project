-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 20 2020 г., 19:50
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='таблица заказов';

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `price`) VALUES
(1, 3, 100),
(2, 3, 4500),
(3, 3, 250),
(4, 1, 950),
(5, 7, 370),
(6, 7, 720);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` char(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `password`, `name`, `surname`, `lastname`) VALUES
(1, 'test1111@t.me', 'test1', '$2y$10$Nh0rHZFwl7zna2m.cZpBWukqD7SErc155AWvt1LY2yAuBRq8prGr.', 'тест', '1', '11'),
(2, 'test22@t.me', 'test2', '$2y$10$RVWFjX8oOaTalNdfRg1HNOiw6rnbRA4yNAV7mPqF1eqoOw9RWuz16', 'еще тест', '2', '222'),
(3, 'test3@t.me', 'test3', '$2y$10$kl4Aug07AOG7UvhqImwh1eWRExPj.wdCQ15sdLiovcw2P7NpA77Qe', 'тоже тест', '3', '33'),
(4, 'test444@t.me', 'test4', '$2y$10$Ep.4aEmEwhLFhcFCv8p8kOnkJi9KfNO7Hc5flxYhpsHTgfpFy217C', 'тест', '4', '4444'),
(5, 'test55@t.me', 'test5', '$2y$10$TFw.dCr/UiWeJCxTw02BcuvqtcgDKxVqQBTnyhqptsn4vDiGSrPu6', 'тест', '5', '555555'),
(6, 'test6@t.me', 'test6', '$2y$10$fK4OmCneoG5SUiXzEzh8QOMlanw6Zb8Mg3SHBv2dBsFQpaFifrf06', 'тест6', '6', '666'),
(7, 'test777@t.me', 'test7', '$2y$10$HpBdPOW3Pc80nDpAeCCPXer.nEMb0P1NuWxfWhqeXWYHjOMTXyczO', 'тест7', '7', '7777'),
(8, 'test8@t.me', 'test8', '$2y$10$k2gDZk7VDe9uqub4.3A1SewOqSjx8lWKAzDo.RdQpV6RR3P7jtIWy', 'тест8', 'пароль: 88', '8888'),
(9, 'one@gmail.com', 'sameone', '$2y$10$5XepTRuC6LTG9wTCS6Fau.GbihKFKGQDv4HCNXya86Om8b4VtHsXq', '1', '1', '1'),
(10, 'one@gmail.com', 'sametwo', '$2y$10$/ogeS.bWCizM.3ySbSgS3.SjQ3dD9YjG/l09q.Q6WBGul4F/kXDka', '2', '2', '2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
