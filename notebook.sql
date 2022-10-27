-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 28 2022 г., 01:12
-- Версия сервера: 8.0.15
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `notebook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `netebook`
--

CREATE TABLE `netebook` (
  `id` int(11) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(120) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `borndate` date DEFAULT NULL,
  `photo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `netebook`
--

INSERT INTO `netebook` (`id`, `fio`, `company`, `phone`, `email`, `borndate`, `photo`) VALUES
(1, 'Николай2', NULL, '321321', '21321', NULL, '../v1/img/upload/111.png'),
(2, 'Алексей Алексеев Алексеев', NULL, '89092222', 'mld@mail.ru', '2022-10-19', NULL),
(3, 'Николай', NULL, '321321', '21321', NULL, '../v1/img/upload/111.png'),
(4, '3213', NULL, '321321', '21321', NULL, NULL),
(5, 'Николай', NULL, '321321', '21321', NULL, '../v1/img/upload/111.png'),
(6, 'Николай2', NULL, '321321', '21321', NULL, '../v1/img/upload/111.png'),
(7, 'Николай2', NULL, '321321', '21321', NULL, '../v1/img/upload/111.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `netebook`
--
ALTER TABLE `netebook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `netebook`
--
ALTER TABLE `netebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
