-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 22 2025 г., 21:02
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

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
  `ID` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `comment_text` varchar(1500) NOT NULL,
  `comment_like` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `forum`
--

CREATE TABLE `forum` (
  `ID` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `post_text` varchar(2000) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_like` int(10) NOT NULL DEFAULT 0,
  `post_comment` int(10) NOT NULL DEFAULT 0,
  `post_retweet` int(10) NOT NULL DEFAULT 0,
  `post_view` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `forum`
--

INSERT INTO `forum` (`ID`, `user_id`, `user_name`, `user_login`, `user_avatar`, `post_text`, `post_image`, `post_date`, `post_like`, `post_comment`, `post_retweet`, `post_view`) VALUES
(4, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'Now i am genius', '[]', '2025-04-21 23:01:45', 0, 0, 0, 0),
(5, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg', 'I am fucking genius', '[]', '2025-04-21 23:10:27', 0, 0, 0, 0),
(6, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg', 'Test 3', '[]', '2025-04-21 23:10:47', 0, 0, 0, 0),
(7, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg', 'Can i get image?', '[\"../../uploads\\/1745269905_slide_1.png\"]', '2025-04-21 23:11:45', 0, 0, 0, 0),
(8, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg', 'How about more image?', '[\"../../uploads\\/1745269950_slide_1.png\",\"../../uploads\\/1745269950_slide_1_mini.png\",\"../../uploads\\/1745269950_slide_2.png\",\"../../uploads\\/1745269950_slide_2_mini.png\"]', '2025-04-21 23:12:30', 0, 0, 0, 0),
(10, 5, 'GigaNiga', '', '../../Avatars/GigaNiga_avatar.png\r\n', 'Mega Giga NIIIIIIGGGGGGGAAAAAAA!!!!', '[]', '2025-04-21 23:18:08', 0, 0, 0, 0),
(11, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'Mega test', '[]', '2025-04-21 23:24:01', 0, 0, 0, 0),
(12, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'SUCHKA', '[]', '2025-04-21 23:32:37', 0, 0, 0, 0),
(13, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'SUCHKA', '[]', '2025-04-21 23:32:44', 0, 0, 0, 0),
(14, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'SUCHKA?', '[]', '2025-04-21 23:33:00', 0, 0, 0, 0),
(15, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'GAY?', '[]', '2025-04-21 23:33:37', 0, 0, 0, 0),
(16, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'please', '[]', '2025-04-21 23:35:17', 0, 0, 0, 0),
(17, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'a', '[]', '2025-04-21 23:36:35', 0, 0, 0, 0),
(18, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'Post Post', '[]', '2025-04-22 15:40:45', 0, 0, 0, 0),
(19, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'LALALALA\r\n', '[\"uploads\\/1745346748_slide_4_mini.png\"]', '2025-04-22 20:32:28', 0, 0, 0, 0),
(20, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'I AM A STEEVEEE!!!!', '[\"uploads\\/1745347428_slide_2_mini.png\"]', '2025-04-22 20:43:48', 0, 0, 0, 0),
(21, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'I AM STEEVEE!!', '[\"..\\/..\\/uploads\\/1745348529_slide_2_mini.png\"]', '2025-04-22 21:02:09', 0, 0, 0, 0),
(22, 1, 'Davit', 'SoloGamer', '../../Avatars/Davit_avatar.jpg\r\n', 'LALALALA', '[\"..\\/..\\/uploads\\/1745348552_slide_5.png\"]', '2025-04-22 21:02:32', 0, 0, 0, 0);

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
  `avatar` varchar(255) DEFAULT NULL,
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

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `forum`
--
ALTER TABLE `forum`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
