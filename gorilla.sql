-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 29 2016 г., 11:32
-- Версия сервера: 5.6.28-0ubuntu0.15.10.1
-- Версия PHP: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gorilla`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1453796427),
('m140314_120159_create_qa_question_table', 1453796434),
('m140314_120441_create_qa_answer_table', 1453796434),
('m140314_120505_create_qa_tag_table', 1453796434),
('m140316_070048_create_qa_vote_table', 1453796435),
('m140512_191636_create_qa_favorite_table', 1453796435),
('m150429_211628_alter_qa_answer_table_column_is_correct', 1453796436),
('m160126_163216_qa_user', 1453826465);

-- --------------------------------------------------------

--
-- Структура таблицы `qa_answer`
--

CREATE TABLE IF NOT EXISTS `qa_answer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `is_correct` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `qa_answer`
--

INSERT INTO `qa_answer` (`id`, `user_id`, `question_id`, `content`, `votes`, `status`, `created_at`, `updated_at`, `is_correct`) VALUES
(3, 5, 4, 'bla bla bla', 0, 1, 1453914795, 1453914795, 0),
(4, 4, 4, 'asdfgh', 0, 1, 1453914850, 1453914850, 0),
(5, 3, 4, 'asfdgfghj', 0, 1, 1453914864, 1453914864, 0),
(6, 6, 4, '2222', 0, 1, 1453922519, 1453922519, 0),
(7, 7, 4, 'jsedfgh', 0, 1, 1454016409, 1454016409, 0),
(8, 11, 10, '<script>alert(4);</script>', 0, 1, 1454020584, 1454020584, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `qa_favorite`
--

CREATE TABLE IF NOT EXISTS `qa_favorite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `created_ip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `qa_question`
--

CREATE TABLE IF NOT EXISTS `qa_question` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `tags` text,
  `answers` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `qa_question`
--

INSERT INTO `qa_question` (`id`, `user_id`, `title`, `alias`, `content`, `tags`, `answers`, `views`, `votes`, `status`, `created_at`, `updated_at`) VALUES
(4, 2, 'title', 'title', 'content', 'tag', 7, 186, 0, 1, 1453885336, 1453885336),
(9, 9, 'vopros', 'vopros', '<div class="asd">soderjanie</div>', NULL, 0, 2, 0, 1, 1454020488, 1454020488),
(10, 10, '<script>alert(1);</script>', 'scriptalert1script', '<script>alert(3);</script>', NULL, 1, 7, 0, 1, 1454020524, 1454020524);

-- --------------------------------------------------------

--
-- Структура таблицы `qa_tag`
--

CREATE TABLE IF NOT EXISTS `qa_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `frequency` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `qa_tag`
--

INSERT INTO `qa_tag` (`id`, `name`, `frequency`) VALUES
(1, 'tag', 4),
(2, 'question', 1),
(3, 'test', 1),
(4, 'lorem', 1),
(5, 'asd', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `qa_user`
--

CREATE TABLE IF NOT EXISTS `qa_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `qa_user`
--

INSERT INTO `qa_user` (`id`, `username`) VALUES
(10, ' <script>alert(2);</script>'),
(11, '<script>alert(3);</script>'),
(4, 'answerer2'),
(7, 'dfgh'),
(9, 'imya'),
(2, 'name'),
(3, 'name answer'),
(8, 'sdfv'),
(6, 'vasta'),
(5, 'vasya');

-- --------------------------------------------------------

--
-- Структура таблицы `qa_vote`
--

CREATE TABLE IF NOT EXISTS `qa_vote` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity` smallint(6) NOT NULL,
  `vote` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL,
  `created_ip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `qa_answer`
--
ALTER TABLE `qa_answer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `qa_favorite`
--
ALTER TABLE `qa_favorite`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `qa_question`
--
ALTER TABLE `qa_question`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `qa_tag`
--
ALTER TABLE `qa_tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `qa_user`
--
ALTER TABLE `qa_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `qa_vote`
--
ALTER TABLE `qa_vote`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `qa_answer`
--
ALTER TABLE `qa_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `qa_favorite`
--
ALTER TABLE `qa_favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `qa_question`
--
ALTER TABLE `qa_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `qa_tag`
--
ALTER TABLE `qa_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `qa_user`
--
ALTER TABLE `qa_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `qa_vote`
--
ALTER TABLE `qa_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
