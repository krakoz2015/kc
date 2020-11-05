-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 05 2020 г., 23:25
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `api_users`
--

CREATE TABLE `api_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `api_users`
--

INSERT INTO `api_users` (`id`, `username`, `password`, `created`) VALUES
(7, 'user1', 'MTIzNDU2', 1604606545);

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `full_name`, `status`) VALUES
(1, 'kctest00202', 'Bernardo Santini', 0),
(2, 'kctest00213', 'George Quebedo', 0),
(5, 'kctest00208', 'Rob Shnneider', 0),
(6, 'kctest00220', 'Terry Cruz', 0),
(7, 'kctest00209', 'David Smith', 0),
(8, 'kctest00301', 'David Smith1', 0),
(9, 'kctest00302', 'David Smith2', 0),
(10, 'kctest00303', 'David Smith3', 0),
(11, 'kctest00304', 'David Smith4', 0),
(12, 'kctest00305', 'David Smith5', 0),
(13, 'kctest00306', 'David Smith6', 0),
(14, 'kctest00307', 'David Smith7', 0),
(15, 'kctest00308', 'David Smith8', 0),
(16, 'kctest00309', 'David Smith9', 0),
(17, 'kctest00310', 'David Smith10', 0),
(18, 'kctest00311', 'David Smith11', 0),
(19, 'kctest00312', 'David Smith12', 0),
(20, 'kctest00313', 'David Smith13', 0),
(21, 'kctest00314', 'David Smith14', 0),
(22, 'kctest00315', 'David Smith15', 0),
(23, 'kctest00316', 'David Smith16', 0),
(24, 'kctest00317', 'David Smith17', 0),
(25, 'kctest00318', 'David Smith18', 0),
(26, 'kctest00319', 'David Smith19', 0),
(27, 'kctest00320', 'David Smith20', 0),
(28, 'kctest00331', 'David Smith31', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `api_users`
--
ALTER TABLE `api_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `api_users`
--
ALTER TABLE `api_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
