-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 28 2017 г., 13:13
-- Версия сервера: 5.7.16
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `polling_system`
--
CREATE DATABASE IF NOT EXISTS `polling_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `polling_system`;

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_variant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_variant_id`, `user_id`) VALUES
(54, 39, 1, 1),
(55, 40, 3, 1),
(56, 41, 6, 1),
(57, 41, 7, 1),
(58, 41, 9, 1),
(59, 39, 1, 2),
(60, 40, 4, 2),
(61, 41, 9, 2),
(62, 39, 1, 3),
(63, 40, 3, 3),
(64, 41, 5, 3),
(65, 41, 6, 3),
(66, 41, 9, 3),
(67, 39, 2, 4),
(68, 40, 4, 4),
(69, 39, 2, 5),
(70, 40, 3, 5),
(71, 41, 5, 5),
(72, 41, 6, 5),
(73, 41, 7, 5),
(74, 89, 154, 6),
(75, 89, 155, 6),
(76, 90, 160, 6),
(77, 91, 163, 6),
(78, 89, 155, 7),
(79, 90, 159, 7),
(80, 91, 162, 7),
(81, 89, 156, 8),
(82, 89, 157, 8),
(83, 90, 161, 8),
(84, 91, 163, 8),
(85, 89, 158, 9),
(86, 90, 159, 9),
(87, 91, 164, 9),
(88, 89, 154, 10),
(89, 89, 155, 10),
(90, 89, 156, 10),
(91, 90, 160, 10),
(92, 91, 163, 10),
(93, 95, 171, 11),
(94, 96, 174, 11),
(95, 97, 177, 11),
(96, 95, 172, 12),
(97, 96, 173, 12),
(98, 97, 177, 12),
(99, 97, 180, 12),
(100, 95, 172, 13),
(101, 96, 174, 13),
(102, 97, 177, 13),
(103, 97, 178, 13),
(104, 95, 172, 14),
(105, 96, 176, 14),
(106, 97, 178, 14),
(107, 95, 171, 15),
(108, 96, 173, 15),
(109, 97, 179, 15),
(110, 97, 180, 15),
(111, 98, 181, 16),
(112, 99, 188, 16),
(113, 98, 181, 17),
(114, 99, 186, 17),
(115, 98, 182, 18),
(116, 99, 186, 18),
(117, 98, 183, 19),
(118, 99, 185, 19),
(119, 98, 181, 20),
(120, 99, 188, 20),
(121, 46, 22, 21),
(122, 47, 25, 21),
(123, 47, 26, 21),
(124, 48, 29, 21),
(125, 49, 32, 21),
(126, 46, 23, 22),
(127, 47, 26, 22),
(128, 47, 28, 22),
(129, 48, 30, 22),
(130, 49, 32, 22),
(131, 46, 24, 23),
(132, 47, 28, 23),
(133, 48, 29, 23),
(134, 49, 34, 23),
(135, 46, 24, 24),
(136, 47, 26, 24),
(137, 47, 27, 24),
(138, 47, 28, 24),
(139, 48, 29, 24),
(140, 49, 33, 24),
(141, 46, 22, 25),
(142, 47, 25, 25),
(143, 47, 26, 25),
(144, 47, 27, 25),
(145, 47, 28, 25),
(146, 48, 30, 25),
(147, 49, 31, 25);

-- --------------------------------------------------------

--
-- Структура таблицы `answer_variants`
--

DROP TABLE IF EXISTS `answer_variants`;
CREATE TABLE `answer_variants` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answer_variants`
--

INSERT INTO `answer_variants` (`id`, `text`, `question_id`) VALUES
(1, 'Да', 39),
(2, 'Нет', 39),
(3, 'Да', 40),
(4, 'Нет', 40),
(5, 'Аррены', 41),
(6, 'Старки', 41),
(7, 'Талли', 41),
(8, 'Грейджои', 41),
(9, 'Таргариены', 41),
(10, 'Ланнистеры', 41),
(11, 'Тиреллы', 41),
(12, 'Баратеоны', 41),
(13, 'Мартеллы', 41),
(22, 'Это мой первый визит', 46),
(23, 'Раз в месяц и реже', 46),
(24, 'Несколько раз в месяц', 46),
(25, 'Новости', 47),
(26, 'О компании', 47),
(27, 'Производство', 47),
(28, 'Контакты', 47),
(29, 'Мужской', 48),
(30, 'Женский', 48),
(31, 'Меньше 20 лет', 49),
(32, '20 - 30 лет', 49),
(33, '31 - 40 лет', 49),
(34, 'Старше 40 лет', 49),
(154, 'PHP', 89),
(155, 'C#', 89),
(156, 'Python', 89),
(157, 'Java', 89),
(158, 'CC++', 89),
(159, 'Крупная международная компания', 90),
(160, 'Небольшая местная фирма', 90),
(161, 'Стартап', 90),
(162, 'До 20 лет', 91),
(163, '20-35 лет', 91),
(164, 'Старше 35 лет', 91),
(171, 'Мужской', 95),
(172, 'Женский', 95),
(173, 'До 20 лет', 96),
(174, 'От 20 до 30 лет', 96),
(175, 'От 30 до 40 лет', 96),
(176, 'Старше 40 лет', 96),
(177, 'ВКонтакте', 97),
(178, 'Одноклассники', 97),
(179, 'Twitter', 97),
(180, 'Facebook', 97),
(181, 'Да', 98),
(182, 'Да, но не во все три', 98),
(183, 'Нет', 98),
(184, '5', 99),
(185, '4', 99),
(186, '3', 99),
(187, '2', 99),
(188, '1', 99);

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `polls`
--

INSERT INTO `polls` (`id`, `name`, `status`) VALUES
(39, 'Опрос по Игре Престолов', 'closed'),
(44, 'Статистика сайта', 'active'),
(46, 'Языки программирования', 'closed'),
(47, 'Социальные сети', 'closed'),
(48, 'Отзывы об игре \"Mass Effect Andromeda\"', 'closed');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `poll_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `is_required` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `text`, `poll_id`, `type`, `is_required`) VALUES
(39, 'Смотрели ли вы сериал \"Игра Престолов\"?', 39, 'single', 1),
(40, 'А читали ли вы книги цикла \"Песнь Льда и Пламени\"?', 39, 'single', 1),
(41, 'Какие из Великих Семей Вестероса вызывают у вас симпатию?', 39, 'multiple', 0),
(46, 'Как часто вы заходите на сайт?', 44, 'single', 0),
(47, 'Какие разделы представляют для Вас наибольший интерес?', 44, 'multiple', 1),
(48, 'Ваш пол?', 44, 'single', 1),
(49, 'Ваш возраст?', 44, 'single', 0),
(89, 'Каким языком программирования вы пользуетесь на работе?', 46, 'multiple', 1),
(90, 'В какой компании вы работаете?', 46, 'single', 1),
(91, 'Ваш возраст?', 46, 'single', 1),
(95, 'Ваш пол?', 47, 'single', 1),
(96, 'Ваш возраст?', 47, 'single', 1),
(97, 'Какими социальными сетями вы предпочитаете пользоваться?', 47, 'multiple', 1),
(98, 'Играли ли вы в предыдушие игры серии Mass Effect?', 48, 'single', 1),
(99, 'На сколько баллов по пятибальной шкале вы оцениваете игру Mass Effect Andromeda?', 48, 'single', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_variant_id` (`answer_variant_id`);

--
-- Индексы таблицы `answer_variants`
--
ALTER TABLE `answer_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Индексы таблицы `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT для таблицы `answer_variants`
--
ALTER TABLE `answer_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`answer_variant_id`) REFERENCES `answer_variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `answer_variants`
--
ALTER TABLE `answer_variants`
  ADD CONSTRAINT `answer_variants_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
