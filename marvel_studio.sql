-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 28 2025 г., 03:46
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marvel_studio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `ID` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `comment_text` varchar(1500) NOT NULL,
  `comment_image` varchar(255) NOT NULL,
  `comment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`ID`, `post_id`, `user_id`, `comment_text`, `comment_image`, `comment_date`) VALUES
(1, 44, 1, 'Test N 1', '[\"..\\/..\\/uploads\\/1745695223_Frustrated Customer Service GIF.gif\"]', '2025-04-26 21:20:23'),
(2, 44, 1, 'Test N 2', '[]', '2025-04-27 00:10:22'),
(3, 44, 1, 'Sosat Omerika', '[]', '2025-04-27 01:23:46');

-- --------------------------------------------------------

--
-- Структура таблицы `comments_likes`
--

CREATE TABLE `comments_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments_likes`
--

INSERT INTO `comments_likes` (`id`, `user_id`, `comment_id`, `created_at`) VALUES
(4, 1, 2, '2025-04-26 23:23:29'),
(5, 1, 3, '2025-04-26 23:23:56'),
(6, 5, 3, '2025-04-28 01:22:35');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `comments_likes_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `comments_likes_view` (
`comment_id` int(10) unsigned
,`like_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Структура таблицы `forum`
--

CREATE TABLE `forum` (
  `ID` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `post_text` varchar(2000) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_save` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `forum`
--

INSERT INTO `forum` (`ID`, `user_id`, `post_text`, `post_image`, `post_date`, `post_save`) VALUES
(4, 1, 'Now i am genius', '[]', '2025-04-21 23:01:45', 0),
(5, 1, 'I am fucking genius', '[]', '2025-04-21 23:10:27', 0),
(6, 1, 'Test 3', '[]', '2025-04-21 23:10:47', 0),
(7, 1, 'Can i get image?', '[\"../../uploads\\/1745269905_slide_1.png\"]', '2025-04-21 23:11:45', 0),
(8, 1, 'How about more image?', '[\"../../uploads\\/1745269950_slide_1.png\",\"../../uploads\\/1745269950_slide_1_mini.png\",\"../../uploads\\/1745269950_slide_2.png\",\"../../uploads\\/1745269950_slide_2_mini.png\"]', '2025-04-21 23:12:30', 0),
(10, 5, 'Mega Giga NIIIIIIGGGGGGGAAAAAAA!!!!', '[]', '2025-04-21 23:18:08', 0),
(11, 1, 'Mega test', '[]', '2025-04-21 23:24:01', 0),
(12, 1, 'SUCHKA', '[]', '2025-04-21 23:32:37', 0),
(13, 1, 'SUCHKA', '[]', '2025-04-21 23:32:44', 0),
(14, 1, 'SUCHKA?', '[]', '2025-04-21 23:33:00', 0),
(15, 1, 'GAY?', '[]', '2025-04-21 23:33:37', 0),
(16, 1, 'please', '[]', '2025-04-21 23:35:17', 0),
(17, 1, 'a', '[]', '2025-04-21 23:36:35', 0),
(18, 1, 'Post Post', '[]', '2025-04-22 15:40:45', 0),
(21, 1, 'I AM STEEVEE!!', '[\"..\\/..\\/uploads\\/1745348529_slide_2_mini.png\"]', '2025-04-22 21:02:09', 0),
(22, 1, 'LALALALA', '[\"..\\/..\\/uploads\\/1745348552_slide_5.png\"]', '2025-04-22 21:02:32', 0),
(23, 1, 'DAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '[]', '2025-04-23 19:34:07', 0),
(24, 1, 'Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2_Test2', '[]', '2025-04-23 19:36:57', 10),
(44, 1, 'SOSAT AMERIKA!!!!', '[\"..\\/..\\/uploads\\/1745447619_Frustrated Customer Service GIF.gif\"]', '2025-04-24 00:33:39', 0),
(47, 5, 'Retweet Testing', '[]', '2025-04-28 01:29:19', 0);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `forum_comments_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `forum_comments_view` (
`post_id` int(10) unsigned
,`comment_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `forum_likes_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `forum_likes_view` (
`post_id` int(10) unsigned
,`like_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `forum_reposts_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `forum_reposts_view` (
`post_id` int(10) unsigned
,`repost_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `forum_views_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `forum_views_view` (
`post_id` int(10) unsigned
,`view_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(25, 1, 23, '2025-04-24 21:23:17'),
(37, 1, 24, '2025-04-25 23:31:06'),
(44, 1, 47, '2025-04-27 23:49:51'),
(45, 1, 44, '2025-04-27 23:53:53'),
(47, 5, 44, '2025-04-28 01:18:38');

-- --------------------------------------------------------

--
-- Структура таблицы `reposts`
--

CREATE TABLE `reposts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reposts`
--

INSERT INTO `reposts` (`id`, `user_id`, `post_id`, `post_user_id`, `created_at`) VALUES
(7, 1, 47, 5, '2025-04-27 23:49:55'),
(36, 5, 44, 1, '2025-04-28 01:44:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '../../Avatars/Defoult_avatar.png',
  `posts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `followers` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `following` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pin` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `achivments` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `name`, `email`, `password`, `avatar`, `posts`, `followers`, `following`, `pin`, `achivments`) VALUES
(1, 'Davit', 'SoloGamer', '101sologaming101@gmail.com', '$2y$10$ZHbcI3lri8KWBIe9gtpRuOiVomXzqV2XMZfcqI2mD8DevetzoAFMG', '../../Avatars/Davit_avatar.jpg\r\n', 12, 187, 87, 27, 69),
(5, 'GigaNiga', '', 'GigaNigaNiga@gmail.com', '$2y$10$nAsGrTsuILomjXVE.3p38uorwmpmnbEZAaD9N1Y8yRANl/HiCy82i', '../../Avatars/GigaNiga_avatar.png\r\n', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `views`
--

CREATE TABLE `views` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `views`
--

INSERT INTO `views` (`id`, `user_id`, `post_id`, `viewed_at`) VALUES
(1, 1, 44, '2025-04-28 01:39:19'),
(3, 1, 24, '2025-04-25 22:40:00'),
(16, 5, 44, '2025-04-28 01:43:15'),
(153, 1, 22, '2025-04-26 22:31:42'),
(238, 5, 47, '2025-04-28 01:22:23');

-- --------------------------------------------------------

--
-- Структура для представления `comments_likes_view`
--
DROP TABLE IF EXISTS `comments_likes_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comments_likes_view`  AS SELECT `comments`.`ID` AS `comment_id`, count(`comments_likes`.`id`) AS `like_count` FROM (`comments` left join `comments_likes` on(`comments`.`ID` = `comments_likes`.`comment_id`)) GROUP BY `comments`.`ID` ;

-- --------------------------------------------------------

--
-- Структура для представления `forum_comments_view`
--
DROP TABLE IF EXISTS `forum_comments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum_comments_view`  AS SELECT `forum`.`ID` AS `post_id`, count(`comments`.`ID`) AS `comment_count` FROM (`forum` left join `comments` on(`comments`.`post_id` = `forum`.`ID`)) GROUP BY `forum`.`ID` ;

-- --------------------------------------------------------

--
-- Структура для представления `forum_likes_view`
--
DROP TABLE IF EXISTS `forum_likes_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum_likes_view`  AS SELECT `forum`.`ID` AS `post_id`, count(`likes`.`id`) AS `like_count` FROM (`forum` left join `likes` on(`forum`.`ID` = `likes`.`post_id`)) GROUP BY `forum`.`ID` ;

-- --------------------------------------------------------

--
-- Структура для представления `forum_reposts_view`
--
DROP TABLE IF EXISTS `forum_reposts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum_reposts_view`  AS SELECT `forum`.`ID` AS `post_id`, count(`reposts`.`id`) AS `repost_count` FROM (`forum` left join `reposts` on(`forum`.`ID` = `reposts`.`post_id`)) GROUP BY `forum`.`ID` ;

-- --------------------------------------------------------

--
-- Структура для представления `forum_views_view`
--
DROP TABLE IF EXISTS `forum_views_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum_views_view`  AS SELECT `forum`.`ID` AS `post_id`, count(`views`.`id`) AS `view_count` FROM (`forum` left join `views` on(`forum`.`ID` = `views`.`post_id`)) GROUP BY `forum`.`ID` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_comment` (`user_id`,`comment_id`),
  ADD KEY `idx_comment_id` (`comment_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Индексы таблицы `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_post` (`user_id`,`post_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Индексы таблицы `reposts`
--
ALTER TABLE `reposts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_post` (`user_id`,`post_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `reposts_ibfk_3` (`post_user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_post` (`user_id`,`post_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `comments_likes`
--
ALTER TABLE `comments_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `forum`
--
ALTER TABLE `forum`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `reposts`
--
ALTER TABLE `reposts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD CONSTRAINT `comments_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_likes_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `forum` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reposts`
--
ALTER TABLE `reposts`
  ADD CONSTRAINT `reposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reposts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `forum` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reposts_ibfk_3` FOREIGN KEY (`post_user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `forum` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
