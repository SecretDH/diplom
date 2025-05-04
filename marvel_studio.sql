-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 05 2025 г., 00:48
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
-- Структура таблицы `actors`
--

CREATE TABLE `actors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `actors`
--

INSERT INTO `actors` (`id`, `name`, `photo`, `bio`, `birth_date`, `country`) VALUES
(1, 'Robert Downey Jr.', '../../Actors/robert_downey_jr.png', 'Robert Downey Jr. is best known for portraying Tony Stark / Iron Man in the Marvel Cinematic Universe, becoming a central figure from 2008 to 2019.', '1965-04-04', 'USA'),
(2, 'Chris Evans', '../../Actors/chris_evans.png', 'Chris Evans rose to fame for his role as Steve Rogers / Captain America, leading the Avengers and appearing in numerous MCU films.', '1981-06-13', 'USA'),
(3, 'Scarlett Johansson', '../../Actors/scarlett_johansson.png', 'Scarlett Johansson portrayed Natasha Romanoff / Black Widow, a skilled spy and member of the original Avengers team.', '1984-11-22', 'USA'),
(4, 'Chris Hemsworth', '../../Actors/chris_hemsworth.jpg', 'Chris Hemsworth is known for his role as Thor, the Norse God of Thunder, appearing in multiple solo and team-up films.', '1983-08-11', 'Australia'),
(5, 'Mark Ruffalo', '../../Actors/mark_ruffalo.jpg', 'Mark Ruffalo took over the role of Bruce Banner / Hulk, portraying the scientist with a monstrous alter ego since 2012.', '1967-11-22', 'USA'),
(6, 'Tom Holland', '../../Actors/tom_holland.jpg', 'Tom Holland plays Peter Parker / Spider-Man, a teenage superhero mentored by Iron Man in the MCU reboot of the character.', '1996-06-01', 'UK'),
(7, 'Benedict Cumberbatch', '../../Actors/benedict_cumberbatch.jpg', 'Benedict Cumberbatch portrays Doctor Stephen Strange, a brilliant neurosurgeon turned master of the mystic arts.', '1976-07-19', 'UK'),
(8, 'Elizabeth Olsen', '../../Actors/elizabeth_olsen.jpg', 'Elizabeth Olsen plays Wanda Maximoff / Scarlet Witch, one of the most powerful characters in the MCU with magic and reality-altering abilities.', '1989-02-16', 'USA'),
(9, 'Paul Rudd', '../../Actors/paul_rudd.jpg', 'Paul Rudd stars as Scott Lang / Ant-Man, a former thief turned superhero who can shrink and grow in size.', '1969-04-06', 'USA'),
(10, 'Brie Larson', '../../Actors/brie_larson.jpg', 'Brie Larson portrays Carol Danvers / Captain Marvel, a former Air Force pilot who gains cosmic powers and becomes one of the MCU’s strongest heroes.', '1989-10-01', 'USA');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `actor_movie_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `actor_movie_count` (
`actor_id` int(10) unsigned
,`actor_name` varchar(255)
,`movie_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `actor_series_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `actor_series_count` (
`actor_id` int(10) unsigned
,`actor_name` varchar(255)
,`series_count` bigint(21)
);

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
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Структура таблицы `movies`
--

CREATE TABLE `movies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `big_description` text DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `poster` varchar(255) DEFAULT '../../Posters/default_poster.jpg',
  `big_poster` varchar(255) DEFAULT '../../Posters/default_big_poster.jpg',
  `duration` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `big_description`, `year`, `poster`, `big_poster`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Iron Man', 'After being held captive in an Afghan cave, billionaire engineer Tony Stark builds a high-tech suit of armor to escape. Back home, he refines the technology and becomes the armored superhero Iron Man, beginning the Marvel Cinematic Universe.', '', '2008', '../../Movies/iron_man_mini.jpg', '../../Movies/iron_man.jpg', 126, '2025-05-03 16:42:20', '2025-05-03 16:42:20'),
(2, 'The Incredible Hulk', 'Bruce Banner becomes the Hulk after a gamma radiation experiment goes wrong. On the run from the military, he searches for a cure while battling inner rage and a powerful enemy known as the Abomination.', '', '2008', '../../Movies/incredible_hulk_mini.jpg', '../../Movies/incredible_hulk.jpg', 112, '2025-05-03 17:16:52', '2025-05-03 17:16:52'),
(3, 'Iron Man 2', 'Tony Stark faces pressure from the government, the press, and the public to share his Iron Man technology. He must also battle his declining health and a vengeful new enemy: Whiplash.', '', '2010', '../../Movies/iron_man_2_mini.jpg', '../../Movies/iron_man_2.jpg', 124, '2025-05-03 17:16:52', '2025-05-03 17:16:52'),
(4, 'Thor', 'Thor, the Norse god of thunder, is cast out of Asgard to live among humans on Earth. Stripped of his powers, he must prove himself worthy while facing threats from his brother Loki.', '', '2011', '../../Movies/thor_mini.jpg', '../../Movies/thor.jpg', 115, '2025-05-03 17:16:52', '2025-05-03 17:16:52'),
(5, 'Captain America: The First Avenger', 'Steve Rogers, a frail man transformed into the super-soldier Captain America, fights during World War II to stop the Red Skull from using a powerful artifact called the Tesseract to conquer the world.', '', '2011', '../../Movies/captain_america_first_avenger_mini.jpg', '../../Movies/captain_america_first_avenger.jpg', 124, '2025-05-03 17:17:32', '2025-05-03 17:17:32'),
(6, 'The Avengers', 'Nick Fury assembles a team of superheroes—Iron Man, Captain America, Thor, Hulk, Black Widow, and Hawkeye—to stop Loki from subjugating Earth using the power of the Tesseract.', '', '2012', '../../Movies/avengers_mini.jpg', '../../Movies/avengers.jpg', 143, '2025-05-03 17:17:32', '2025-05-03 17:17:32'),
(7, 'Iron Man 3', 'Tony Stark struggles with PTSD after the events in New York. When a new enemy called the Mandarin emerges, he must rely on his intellect and courage rather than his suits to survive.', '', '2013', '../../Movies/iron_man_3_mini.jpg', '../../Movies/iron_man_3.jpg', 130, '2025-05-03 17:17:32', '2025-05-03 17:17:32'),
(8, 'Thor: The Dark World', 'Thor reunites with Jane Foster to face the Dark Elves, led by Malekith, who seek to plunge the universe into darkness using a powerful force known as the Aether.', '', '2013', '../../Movies/thor_dark_world_mini.jpg', '../../Movies/thor_dark_world.jpg', 112, '2025-05-03 17:18:13', '2025-05-03 17:18:13'),
(9, 'Captain America: The Winter Soldier', 'Captain America teams up with Black Widow and Falcon to uncover a conspiracy within S.H.I.E.L.D. and faces a mysterious assassin known as the Winter Soldier—his long-lost friend Bucky Barnes.', '', '2014', '../../Movies/captain_america_winter_soldier_mini.jpg', '../../Movies/captain_america_winter_soldier.jpg', 136, '2025-05-03 17:18:13', '2025-05-03 17:18:13'),
(10, 'Guardians of the Galaxy', 'A group of misfits—Star-Lord, Gamora, Drax, Rocket, and Groot—must band together to stop the villain Ronan from using a powerful Orb to destroy the galaxy.', '', '2014', '../../Movies/guardians_of_the_galaxy_mini.jpg', '../../Movies/guardians_of_the_galaxy.jpg', 121, '2025-05-03 17:18:13', '2025-05-03 17:18:13'),
(11, 'Avengers: Age of Ultron', 'When Tony Stark creates Ultron, an AI peacekeeping program, it turns against humanity. The Avengers must unite to stop the rogue AI from causing global extinction.', '', '2015', '../../Movies/avengers_age_of_ultron_mini.jpg', '../../Movies/avengers_age_of_ultron.jpg', 141, '2025-05-03 17:18:45', '2025-05-03 17:18:45'),
(12, 'Ant-Man', 'Scott Lang, a skilled thief, is recruited by Hank Pym to wear a suit that allows him to shrink in size but increase in strength. He must embrace his inner hero to pull off a heist that will save the world.', '', '2015', '../../Movies/ant_man_mini.jpg', '../../Movies/ant_man.jpg', 117, '2025-05-03 17:18:45', '2025-05-03 17:18:45'),
(13, 'Captain America: Civil War', 'Political pressure divides the Avengers into opposing factions, led by Captain America and Iron Man, after a mission goes wrong. Old friendships are tested in a battle over accountability and freedom.', '', '2016', '../../Movies/captain_america_civil_war_mini.jpg', '../../Movies/captain_america_civil_war.jpg', 147, '2025-05-03 17:18:45', '2025-05-03 17:18:45'),
(14, 'Doctor Strange', 'Dr. Stephen Strange, a renowned neurosurgeon, loses the use of his hands in a car accident. Desperate for a cure, he discovers the mystic arts and becomes the Sorcerer Supreme, defending the world from dark forces.', '', '2016', '../../Movies/doctor_strange_mini.jpg', '../../Movies/doctor_strange.jpg', 115, '2025-05-03 17:20:40', '2025-05-03 17:20:40'),
(15, 'Guardians of the Galaxy Vol. 2', 'The Guardians must face their own personal demons and discover the truth about Peter Quill\'s parentage as they battle a powerful new villain, Ego the Living Planet.', '', '2017', '../../Movies/guardians_of_the_galaxy_vol2_mini.jpg', '../../Movies/guardians_of_the_galaxy_vol2.jpg', 136, '2025-05-03 17:20:40', '2025-05-03 17:20:40'),
(16, 'Spider-Man: Homecoming', 'Teenager Peter Parker, after his adventure with the Avengers, tries to balance high school life with his duties as Spider-Man while facing the Vulture, a new villain who threatens his city.', '', '2017', '../../Movies/spider_man_homecoming_mini.jpg', '../../Movies/spider_man_homecoming.jpg', 133, '2025-05-03 17:20:40', '2025-05-03 17:20:40'),
(17, 'Thor: Ragnarok', 'Thor must escape the planet Sakaar and prevent the prophesied apocalypse, Ragnarok, from destroying Asgard, all while facing his estranged sister Hela and teaming up with Hulk and Loki.', '', '2017', '../../Movies/thor_ragnarok_mini.jpg', '../../Movies/thor_ragnarok.jpg', 130, '2025-05-03 17:21:07', '2025-05-03 17:21:07'),
(18, 'Black Panther', 'T\'Challa returns home to Wakanda to take his place as king. When his father’s past comes back to haunt him, T\'Challa must fight to defend his people and his nation from the villainous Killmonger.', '', '2018', '../../Movies/black_panther_mini.jpg', '../../Movies/black_panther.jpg', 134, '2025-05-03 17:21:07', '2025-05-03 17:21:07'),
(19, 'Avengers: Infinity War', 'The Avengers and their allies must assemble to stop Thanos, who is determined to collect all the Infinity Stones and use them to bring about the extinction of half the universe.', '', '2018', '../../Movies/avengers_infinity_war_mini.jpg', '../../Movies/avengers_infinity_war.jpg', 149, '2025-05-03 17:21:07', '2025-05-03 17:21:07'),
(20, 'Ant-Man and the Wasp', 'Scott Lang teams up with Hope van Dyne as they seek to uncover the mysteries of the past. They must stop a new villain, Ghost, while trying to rescue Janet van Dyne, the original Wasp, from the Quantum Realm.', '', '2018', '../../Movies/ant_man_and_the_wasp_mini.jpg', '../../Movies/ant_man_and_the_wasp.jpg', 118, '2025-05-03 17:21:47', '2025-05-03 17:21:47'),
(21, 'Captain Marvel', 'Carol Danvers, a former U.S. Air Force pilot, becomes the powerful Captain Marvel after an accident gives her alien powers. She must join forces with Nick Fury to stop a Skrull invasion and uncover the truth about her origins.', '', '2019', '../../Movies/captain_marvel_mini.jpg', '../../Movies/captain_marvel.jpg', 123, '2025-05-03 17:21:47', '2025-05-03 17:21:47'),
(22, 'Avengers: Endgame', 'After the devastating events of Infinity War, the remaining Avengers and their allies must come together to undo the destruction caused by Thanos and bring back their fallen friends in a final battle to save the universe.', '', '2019', '../../Movies/avengers_endgame_mini.jpg', '../../Movies/avengers_endgame.jpg', 181, '2025-05-03 17:21:47', '2025-05-03 17:21:47'),
(23, 'Spider-Man: Far From Home', 'Peter Parker goes on a school trip to Europe, but his plans are interrupted when Nick Fury recruits him to fight a new threat: Mysterio, a villain capable of creating illusions that blur the line between reality and fiction.', '', '2019', '../../Movies/spider_man_far_from_home_mini.jpg', '../../Movies/spider_man_far_from_home.jpg', 129, '2025-05-03 17:22:16', '2025-05-03 17:22:16'),
(24, 'Black Widow', 'Natasha Romanoff confronts her past as she goes on a mission to take down a dangerous conspiracy linked to her history as a spy, all while dealing with old family ties and a new deadly foe.', '', '2021', '../../Movies/black_widow_mini.jpg', '../../Movies/black_widow.jpg', 134, '2025-05-03 17:22:16', '2025-05-03 17:22:16'),
(25, 'Shang-Chi and the Legend of the Ten Rings', 'Shang-Chi, a martial artist who has been living a normal life, is drawn into the world of the mysterious Ten Rings organization. He must confront his past and the legacy of his father, who leads the deadly criminal group.', '', '2021', '../../Movies/shang_chi_mini.jpg', '../../Movies/shang_chi.jpg', 132, '2025-05-03 17:22:16', '2025-05-03 17:22:16'),
(26, 'Eternals', 'The Eternals, a group of immortal beings with superhuman powers, have secretly lived on Earth for thousands of years. When an ancient enemy, the Deviants, return, they must emerge from hiding to protect humanity.', '', '2021', '../../Movies/eternals_mini.jpg', '../../Movies/eternals.jpg', 156, '2025-05-03 17:22:41', '2025-05-03 17:22:41'),
(27, 'Spider-Man: No Way Home', 'Peter Parker seeks help from Doctor Strange to erase the memory of his identity as Spider-Man from the world. However, things go wrong, opening portals to the Multiverse and bringing villains from other realities.', '', '2021', '../../Movies/spider_man_no_way_home_mini.jpg', '../../Movies/spider_man_no_way_home.jpg', 148, '2025-05-03 17:22:41', '2025-05-03 17:22:41'),
(28, 'Doctor Strange in the Multiverse of Madness', 'Doctor Strange teams up with America Chavez to explore the Multiverse and protect reality from the dangers caused by their reckless use of magic, all while facing a powerful new enemy in Scarlet Witch.', '', '2022', '../../Movies/doctor_strange_multiverse_of_madness_mini.jpg', '../../Movies/doctor_strange_multiverse_of_madness.jpg', 126, '2025-05-03 17:22:41', '2025-05-03 17:22:41'),
(29, 'Thor: Love and Thunder', 'Thor embarks on a journey of self-discovery but must face a new villain, Gorr the God Butcher, who is determined to eliminate all gods. Along the way, he is reunited with Jane Foster, who now wields the power of Thor.', '', '2022', '../../Movies/thor_love_and_thunder_mini.jpg', '../../Movies/thor_love_and_thunder.jpg', 119, '2025-05-03 17:23:11', '2025-05-03 17:23:11'),
(30, 'Black Panther: Wakanda Forever', 'Wakanda mourns the loss of their king, T\'Challa, while facing new challenges as a powerful new enemy, Namor the Sub-Mariner, threatens their world. The nation must unite and discover new allies to protect Wakanda’s legacy.', '', '2022', '../../Movies/black_panther_wakanda_forever_mini.jpg', '../../Movies/black_panther_wakanda_forever.jpg', 161, '2025-05-03 17:23:11', '2025-05-03 17:23:11');

-- --------------------------------------------------------

--
-- Структура таблицы `movie_actors`
--

CREATE TABLE `movie_actors` (
  `movie_id` int(10) UNSIGNED NOT NULL,
  `actor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `movie_actors`
--

INSERT INTO `movie_actors` (`movie_id`, `actor_id`) VALUES
(1, 1),
(2, 5),
(3, 1),
(3, 3),
(4, 4),
(5, 2),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(8, 4),
(9, 2),
(9, 3),
(10, 3),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(12, 9),
(13, 1),
(13, 2),
(13, 3),
(13, 9),
(14, 7),
(15, 3),
(16, 1),
(16, 6),
(17, 4),
(17, 5),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 7),
(19, 8),
(19, 9),
(20, 9),
(21, 10),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(22, 8),
(22, 9),
(22, 10),
(23, 6),
(24, 3),
(27, 1),
(27, 6),
(27, 7),
(28, 7),
(29, 4),
(30, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `movie_genres`
--

CREATE TABLE `movie_genres` (
  `movie_id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `movie_ratings_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `movie_ratings_view` (
`movie_id` int(10) unsigned
,`title` varchar(255)
,`average_rating` decimal(5,1)
,`ratings_count` bigint(21)
);

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
-- Структура таблицы `series`
--

CREATE TABLE `series` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `big_description` text DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `poster` varchar(255) DEFAULT '../../Posters/default_series.jpg',
  `big_poster` varchar(255) DEFAULT '../../Posters/default_big_series.jpg',
  `duration` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `series`
--

INSERT INTO `series` (`id`, `title`, `description`, `big_description`, `year`, `poster`, `big_poster`, `duration`, `created_at`, `updated_at`) VALUES
(2, 'Secret Invasion', 'Nick Fury teams up with a group of spies to uncover an alien invasion on Earth, as shape-shifting Skrulls infiltrate the planet, sparking a thrilling adventure of mystery and danger in the Marvel Universe.', NULL, '2023', '../../Series/secret_invasion_mini.jpg', '../../Series/secret_invasion.jpg', 45, '2025-05-03 14:54:16', '2025-05-03 15:17:03'),
(3, 'Hawkeye', 'Clint Barton teams up with young archer Kate Bishop in New York City to face a criminal conspiracy involving the Tracksuit Mafia, all while navigating their personal struggles and heroism during the holidays.', NULL, '2021', '../../Series/hawkeye_mini.jpg', '../../Series/hawkeye.jpg', 45, '2025-05-03 14:54:16', '2025-05-03 15:17:03'),
(4, 'The Falcon and the Winter Soldier', 'Sam Wilson and Bucky Barnes, both dealing with the legacy of Captain America, are forced to team up and confront new threats in a world recovering from the Avengers’ Endgame, facing personal and global challenges.', NULL, '2021', '../../Series/falcon_winter_soldier_mini.jpg', '../../Series/falcon_winter_soldier.jpg', 50, '2025-05-03 14:54:16', '2025-05-03 15:17:03'),
(5, 'Daredevil: Born Again', 'Matt Murdock, the blind lawyer turned vigilante Daredevil, returns to Hell\'s Kitchen as he faces new adversaries and legal battles, trying to balance his life as a hero and a lawyer in this highly anticipated reboot.', NULL, '2025', '../../Series/daredevil_born_again_mini.jpg', '../../Series/daredevil_born_again.jpg', 50, '2025-05-03 14:54:16', '2025-05-03 15:17:03'),
(7, 'Moon Knight', 'Steven Grant, a gift-shop employee, discovers he shares a body with mercenary Marc Spector. Together, they battle crime and uncover hidden secrets related to an ancient Egyptian god in this dark superhero series.', NULL, '2022', '../../Series/moon_knight_mini.jpg', '../../Series/moon_knight.jpg', 50, '2025-05-03 14:54:58', '2025-05-03 15:17:03'),
(11, 'Agatha All Along', 'Agatha Harkness, a powerful witch from WandaVision, returns in her own series, delving into her dark past and magical origins as she faces new challenges in the supernatural world.', NULL, '2024', '../../Series/agatha_all_along_mini.jpg', '../../Series/agatha_all_along.jpg', 45, '2025-05-03 14:54:58', '2025-05-03 15:26:56'),
(12, 'Ms. Marvel', 'Kamala Khan, a teenager from Jersey City, discovers her powers as a fan of superheroes. She becomes Ms. Marvel, embracing her newfound abilities and identity as a superhero while navigating her cultural heritage.', NULL, '2022', '../../Series/ms_marvel_mini.jpg', '../../Series/ms_marvel.jpg', 45, '2025-05-03 14:54:58', '2025-05-03 15:17:03'),
(13, 'Agents of S.H.I.E.L.D.', 'Agents of S.H.I.E.L.D. follows a group of specialized agents led by Phil Coulson, as they investigate strange occurrences and protect humanity from threats both alien and terrestrial, in a thrilling blend of espionage and science fiction.', NULL, '2013', '../../Series/agents_of_shield_mini.jpg', '../../Series/agents_of_shield.jpg', 45, '2025-05-03 14:54:58', '2025-05-03 15:17:03'),
(14, 'WandaVision', 'WandaVision follows Wanda Maximoff and Vision as they navigate life in a strange, idyllic suburban world, only to unravel dark secrets behind their perfect reality. This series blends classic sitcom styles with Marvel\'s larger universe.', NULL, '2021', '../../Series/wandavision_mini.jpg', '../../Series/wandavision.jpg', 50, '2025-05-03 14:54:58', '2025-05-03 15:17:03'),
(15, 'She-Hulk: Attorney at Law', 'Jennifer Walters, a lawyer and cousin of Bruce Banner, transforms into She-Hulk after a blood transfusion. She balances her career as a lawyer with her new life as a powerful superhero, in a fun and legal action-comedy.', NULL, '2022', '../../Series/she_hulk_mini.jpg', '../../Series/she_hulk.jpg', 50, '2025-05-03 14:54:58', '2025-05-03 15:17:03'),
(16, 'Daredevil', 'Daredevil follows Matt Murdock, a blind lawyer by day and vigilante by night, who uses his heightened senses to fight crime in Hell\'s Kitchen while facing personal challenges and moral dilemmas.', NULL, '2015', '../../Series/daredevil_mini.jpg', '../../Series/daredevil.jpg', 55, '2025-05-03 14:56:31', '2025-05-03 15:17:03'),
(17, 'Loki', 'Loki, the God of Mischief, finds himself in a new timeline and must confront his past, present, and future in a thrilling series that explores the multiverse and sets the stage for future Marvel adventures.', NULL, '2021', '../../Series/loki_mini.jpg', '../../Series/loki.jpg', 50, '2025-05-03 14:56:31', '2025-05-03 15:17:03'),
(18, 'Agent Carter', 'Agent Peggy Carter, a founding member of S.H.I.E.L.D., embarks on espionage missions in the post-WWII era, all while fighting for recognition in a male-dominated world.', NULL, '2015', '../../Series/agent_carter_mini.jpg', '../../Series/agent_carter.jpg', 45, '2025-05-03 14:56:31', '2025-05-03 15:40:05'),
(19, 'Jessica Jones', 'Jessica Jones, a private investigator with superhuman abilities, struggles with her trauma and the aftermath of being manipulated by a mind-controlling villain, all while solving crimes in New York City.', NULL, '2015', '../../Series/jessica_jones_mini.jpg', '../../Series/jessica_jones.jpg', 50, '2025-05-03 14:56:31', '2025-05-03 15:45:21'),
(20, 'Iron Fist', 'Iron Fist follows Danny Rand, a billionaire with the mystical power of the Iron Fist, as he returns to New York City to fight crime, face his past, and protect his family legacy.', NULL, '2017', '../../Series/iron_fist_mini.jpg', '../../Series/iron_fist.jpg', 55, '2025-05-03 14:56:31', '2025-05-03 15:45:21'),
(21, 'What If…?', 'What If…? explores alternate realities in the Marvel Universe, asking \"What if?\" pivotal moments in history had gone differently, presenting different outcomes for familiar heroes and villains.', NULL, '2021', '../../Series/what_if_mini.jpg', '../../Series/what_if.jpg', 30, '2025-05-03 14:56:31', '2025-05-03 15:45:21'),
(22, 'Cloak & Dagger', 'Cloak & Dagger follows two teenagers, Tyrone and Tandy, who gain supernatural powers after a tragic event. They must navigate their new abilities and face a shared destiny in New Orleans.', NULL, '2018', '../../Series/cloak_dagger_mini.jpg', '../../Series/cloak_dagger.jpg', 50, '2025-05-03 14:56:31', '2025-05-03 15:45:21');

-- --------------------------------------------------------

--
-- Структура таблицы `series_actors`
--

CREATE TABLE `series_actors` (
  `series_id` int(10) UNSIGNED NOT NULL,
  `actor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `series_actors`
--

INSERT INTO `series_actors` (`series_id`, `actor_id`) VALUES
(2, 3),
(3, 3),
(4, 2),
(5, 2),
(7, 7),
(11, 8),
(12, 10),
(13, 3),
(14, 7),
(14, 8),
(15, 3),
(16, 2),
(17, 4),
(18, 3),
(19, 3),
(20, 4),
(21, 3),
(21, 7),
(22, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `series_genres`
--

CREATE TABLE `series_genres` (
  `series_id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `series_ratings_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `series_ratings_view` (
`series_id` int(10) unsigned
,`title` varchar(255)
,`average_rating` decimal(5,1)
,`ratings_count` bigint(21)
);

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
-- Структура таблицы `user_ratings`
--

CREATE TABLE `user_ratings` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 10),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_series_ratings`
--

CREATE TABLE `user_series_ratings` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `series_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 10),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 44, '2025-05-04 13:55:54'),
(3, 1, 24, '2025-04-25 22:40:00'),
(16, 5, 44, '2025-04-28 01:43:15'),
(153, 1, 22, '2025-04-26 22:31:42'),
(238, 5, 47, '2025-04-28 01:22:23');

-- --------------------------------------------------------

--
-- Структура для представления `actor_movie_count`
--
DROP TABLE IF EXISTS `actor_movie_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `actor_movie_count`  AS SELECT `a`.`id` AS `actor_id`, `a`.`name` AS `actor_name`, count(`am`.`movie_id`) AS `movie_count` FROM (`actors` `a` left join `movie_actors` `am` on(`a`.`id` = `am`.`actor_id`)) GROUP BY `a`.`id` ;

-- --------------------------------------------------------

--
-- Структура для представления `actor_series_count`
--
DROP TABLE IF EXISTS `actor_series_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `actor_series_count`  AS SELECT `a`.`id` AS `actor_id`, `a`.`name` AS `actor_name`, count(`asr`.`series_id`) AS `series_count` FROM (`actors` `a` left join `series_actors` `asr` on(`a`.`id` = `asr`.`actor_id`)) GROUP BY `a`.`id` ;

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

-- --------------------------------------------------------

--
-- Структура для представления `movie_ratings_view`
--
DROP TABLE IF EXISTS `movie_ratings_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movie_ratings_view`  AS SELECT `m`.`id` AS `movie_id`, `m`.`title` AS `title`, round(avg(`ur`.`rating`),1) AS `average_rating`, count(`ur`.`rating`) AS `ratings_count` FROM (`movies` `m` left join `user_ratings` `ur` on(`ur`.`movie_id` = `m`.`id`)) GROUP BY `m`.`id` ;

-- --------------------------------------------------------

--
-- Структура для представления `series_ratings_view`
--
DROP TABLE IF EXISTS `series_ratings_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `series_ratings_view`  AS SELECT `s`.`id` AS `series_id`, `s`.`title` AS `title`, round(avg(`usr`.`rating`),1) AS `average_rating`, count(`usr`.`rating`) AS `ratings_count` FROM (`series` `s` left join `user_series_ratings` `usr` on(`usr`.`series_id` = `s`.`id`)) GROUP BY `s`.`id` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Индексы таблицы `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_post` (`user_id`,`post_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD PRIMARY KEY (`movie_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Индексы таблицы `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`movie_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

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
-- Индексы таблицы `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `series_actors`
--
ALTER TABLE `series_actors`
  ADD PRIMARY KEY (`series_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Индексы таблицы `series_genres`
--
ALTER TABLE `series_genres`
  ADD PRIMARY KEY (`series_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Индексы таблицы `user_series_ratings`
--
ALTER TABLE `user_series_ratings`
  ADD PRIMARY KEY (`user_id`,`series_id`),
  ADD KEY `series_id` (`series_id`);

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
-- AUTO_INCREMENT для таблицы `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `reposts`
--
ALTER TABLE `reposts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `series`
--
ALTER TABLE `series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

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
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `forum` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD CONSTRAINT `movie_actors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reposts`
--
ALTER TABLE `reposts`
  ADD CONSTRAINT `reposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reposts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `forum` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reposts_ibfk_3` FOREIGN KEY (`post_user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `series_actors`
--
ALTER TABLE `series_actors`
  ADD CONSTRAINT `series_actors_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `series_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `series_genres`
--
ALTER TABLE `series_genres`
  ADD CONSTRAINT `series_genres_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `series_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_series_ratings`
--
ALTER TABLE `user_series_ratings`
  ADD CONSTRAINT `user_series_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_series_ratings_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

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
