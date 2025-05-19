-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 16 2025 г., 10:04
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
(3, 44, 1, 'Sosat Omerika', '[]', '2025-04-27 01:23:46'),
(4, 48, 1, 'Comment', '[]', '2025-05-05 19:29:24'),
(5, 50, 1, 'Comment\r\n', '[]', '2025-05-05 19:33:47');

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
(47, 5, 'Retweet Testing', '[]', '2025-04-28 01:29:19', 0),
(48, 1, 'Mujik', '[\"..\\/..\\/uploads\\/1746466153_chris_evans.png\"]', '2025-05-05 19:29:13', 0),
(49, 1, 'Mujik 2', '[\"..\\/..\\/uploads\\/1746466398_chris_hemsworth.jpg\"]', '2025-05-05 19:33:18', 0),
(50, 1, 'MUNKRY', '[\"..\\/..\\/uploads\\/1746466410_Frustrated Customer Service GIF.gif\"]', '2025-05-05 19:33:30', 0),
(51, 1, '12345', '[]', '2025-05-14 15:54:11', 0);

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
(47, 5, 44, '2025-04-28 01:18:38'),
(48, 1, 48, '2025-05-05 17:29:16'),
(50, 6, 50, '2025-05-05 17:39:40'),
(52, 1, 50, '2025-05-06 22:34:14');

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
(1, 'Iron Man', 'After being held captive in an Afghan cave, billionaire engineer Tony Stark builds a high-tech suit of armor to escape. Back home, he refines the technology and becomes the armored superhero Iron Man, beginning the Marvel Cinematic Universe.', 'Iron Man is an American superhero film based on the Marvel Comics character Tony Stark / Iron Man. \\n Produced by Marvel Studios and distributed by Paramount Pictures, it is the first film in the Marvel Cinematic Universe (MCU). Directed by Jon Favreau, the film follows Tony Stark, a wealthy and genius weapons manufacturer who is captured by terrorists while testing one of his company’s weapons. After escaping, Stark decides to stop manufacturing weapons and instead creates a high-tech suit of armor to fight evil and protect the innocent. \\n\\n The film stars Robert Downey Jr. as Tony Stark / Iron Man, Gwyneth Paltrow as Pepper Potts, Jeff Bridges as Obadiah Stane, and Clark Gregg as Phil Coulson. Filming took place in 2007, and it introduced the world to a new kind of superhero film—one grounded in technology and realism, with a focus on character-driven storytelling. \\n\\n Released on May 2, 2008, Iron Man was a critical and commercial success, grossing over $585 million worldwide. The film was praised for Downey Jr.’s charismatic performance, its special effects, and its fresh take on the superhero genre. Iron Man launched the Marvel Cinematic Universe and laid the foundation for the interconnected films that followed, making it one of the most influential superhero films ever made.', '2008', '../../Movies/iron_man_mini.jpg', '../../Movies/iron_man.jpg', 126, '2025-05-03 16:42:20', '2025-05-05 15:11:28'),
(2, 'The Incredible Hulk', 'Bruce Banner becomes the Hulk after a gamma radiation experiment goes wrong. On the run from the military, he searches for a cure while battling inner rage and a powerful enemy known as the Abomination.', 'The Incredible Hulk is an American superhero film based on the Marvel Comics character Bruce Banner / The Hulk. \\n Produced by Marvel Studios and distributed by Universal Pictures, it is the second film in the Marvel Cinematic Universe (MCU). Directed by Louis Leterrier, the film follows Bruce Banner as he tries to control the monstrous Hulk persona that emerges when he is exposed to extreme stress. After a failed experiment, Banner becomes a fugitive and seeks a cure, while a new threat arises in the form of the Abomination, a creature created from similar gamma radiation. \\n\\n The film stars Edward Norton as Bruce Banner / The Hulk, Liv Tyler as Betty Ross, Tim Roth as Emil Blonsky / Abomination, and William Hurt as Thaddeus Ross. Filming took place in 2007, and it focuses on the character\'s internal struggle with his anger and the destructive power of the Hulk. \\n\\n Released on June 13, 2008, The Incredible Hulk received generally positive reviews, especially for its action sequences and Norton’s performance. However, it was less successful compared to other MCU films, grossing over $263 million worldwide. Despite its moderate reception, the film helped establish the Hulk character within the MCU, leading to his later appearances in The Avengers (2012) and beyond.', '2008', '../../Movies/incredible_hulk_mini.jpg', '../../Movies/incredible_hulk.jpg', 112, '2025-05-03 17:16:52', '2025-05-05 15:11:24'),
(3, 'Iron Man 2', 'Tony Stark faces pressure from the government, the press, and the public to share his Iron Man technology. He must also battle his declining health and a vengeful new enemy: Whiplash.', 'Iron Man 2 is an American superhero film based on the Marvel Comics character Tony Stark / Iron Man. \\n Produced by Marvel Studios and distributed by Paramount Pictures, it is the third film in the Marvel Cinematic Universe (MCU) and a direct sequel to Iron Man (2008). Directed by Jon Favreau, the film follows Tony Stark as he deals with the government demanding the Iron Man technology, his deteriorating health due to the palladium core in his chest, and the emergence of a new enemy, Ivan Vanko, who has created his own version of the Iron Man suit. \\n\\n The film stars Robert Downey Jr. as Tony Stark / Iron Man, Gwyneth Paltrow as Pepper Potts, Don Cheadle as James Rhodes, Mickey Rourke as Ivan Vanko, and Samuel L. Jackson as Nick Fury. Filming took place in 2009, continuing the story of Tony Stark’s struggles both as a businessman and a hero. \\n\\n Released on May 7, 2010, Iron Man 2 received mixed-to-positive reviews, with praise for its performances, visual effects, and action scenes. It grossed over $623 million worldwide and played a key role in setting up the larger interconnected MCU, particularly through the introduction of Black Widow and Nick Fury\'s role in assembling the Avengers.', '2010', '../../Movies/iron_man_2_mini.jpg', '../../Movies/iron_man_2.jpg', 124, '2025-05-03 17:16:52', '2025-05-05 15:11:20'),
(4, 'Thor', 'Thor, the Norse god of thunder, is cast out of Asgard to live among humans on Earth. Stripped of his powers, he must prove himself worthy while facing threats from his brother Loki.', 'Thor is an American superhero film based on the Marvel Comics character Thor, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Kenneth Branagh, it is the fourth film in the Marvel Cinematic Universe (MCU). The film tells the origin story of Thor, the God of Thunder, who is banished from his home in Asgard to Earth as punishment for his reckless behavior. There, he must learn humility and become a true hero to reclaim his powers and prevent his brother Loki from seizing the throne of Asgard. \\n\\n The film stars Chris Hemsworth as Thor, Natalie Portman as Jane Foster, Tom Hiddleston as Loki, Anthony Hopkins as Odin, and Idris Elba as Heimdall. Filming took place in 2010, with a focus on mixing mythological elements with superhero action. Thor introduces the cosmic side of the MCU and establishes key characters that play a role in later films. \\n\\n Released on May 6, 2011, Thor was well-received for its performances, humor, and visual effects. It grossed over $449 million worldwide and launched the character into the broader MCU, setting the stage for future Avengers films and his own sequels.', '2011', '../../Movies/thor_mini.jpg', '../../Movies/thor.jpg', 115, '2025-05-03 17:16:52', '2025-05-05 15:11:15'),
(5, 'Captain America: The First Avenger', 'Steve Rogers, a frail man transformed into the super-soldier Captain America, fights during World War II to stop the Red Skull from using a powerful artifact called the Tesseract to conquer the world.', 'Captain America: The First Avenger is an American superhero film based on the Marvel Comics character Captain America. \\n Produced by Marvel Studios and distributed by Paramount Pictures, it is the fifth film in the Marvel Cinematic Universe (MCU). Directed by Joe Johnston, the film follows the origin story of Steve Rogers, a frail young man who is transformed into the super-soldier Captain America during World War II to fight the Nazi-backed terrorist group Hydra, led by the villain Red Skull. \\n\\n The film stars Chris Evans as Steve Rogers / Captain America, Hugo Weaving as Red Skull, Tommy Lee Jones, Hayley Atwell, Stanley Tucci, and Dominic Cooper. Filming took place in 2010 and 2011, with the film incorporating World War II-era settings and characters. It explores themes of sacrifice, heroism, and the moral complexities of war. \\n\\n Released on July 22, 2011, Captain America: The First Avenger was well-received by critics and audiences, praised for its nostalgic tone, Evans\' performance, and its compelling story. It grossed over $370 million worldwide and laid the foundation for the character\'s future in the MCU, leading to his role in The Avengers (2012).', '2011', '../../Movies/captain_america_first_avenger_mini.jpg', '../../Movies/captain_america_first_avenger.jpg', 124, '2025-05-03 17:17:32', '2025-05-05 15:10:10'),
(6, 'The Avengers', 'Nick Fury assembles a team of superheroes—Iron Man, Captain America, Thor, Hulk, Black Widow, and Hawkeye—to stop Loki from subjugating Earth using the power of the Tesseract.', 'The Avengers is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Joss Whedon, it is the sixth film in the Marvel Cinematic Universe (MCU) and the first crossover event in the franchise. The film follows a team of superheroes, including Iron Man, Captain America, Thor, Hulk, Black Widow, and Hawkeye, who must come together to stop the villain Loki from invading Earth and taking control of the Tesseract, a powerful alien artifact. \\n\\n The film stars Robert Downey Jr., Chris Evans, Chris Hemsworth, Mark Ruffalo, Scarlett Johansson, Jeremy Renner, Tom Hiddleston, and Samuel L. Jackson. Principal photography began in 2011 and was shot across multiple global locations. The film was groundbreaking in its combination of individual superhero stories into one cohesive narrative. \\n\\n Released on May 4, 2012, The Avengers was a critical and commercial success, grossing over $1.5 billion worldwide. It was praised for its humor, action, and the chemistry between the cast members. The film became a cultural phenomenon and is credited with establishing the modern superhero film genre as a box-office powerhouse.', '2012', '../../Movies/avengers_mini.jpg', '../../Movies/avengers.jpg', 143, '2025-05-03 17:17:32', '2025-05-05 15:10:05'),
(7, 'Iron Man 3', 'Tony Stark struggles with PTSD after the events in New York. When a new enemy called the Mandarin emerges, he must rely on his intellect and courage rather than his suits to survive.', 'Iron Man 3 is an American superhero film based on the Marvel Comics character Tony Stark / Iron Man. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the seventh film in the Marvel Cinematic Universe (MCU) and the direct sequel to The Avengers (2012). Directed by Shane Black, the film follows Tony Stark as he faces the aftermath of the alien invasion in New York and confronts a new foe, the Mandarin, while grappling with his own inner demons. \\n\\n The film stars Robert Downey Jr. as Tony Stark / Iron Man, Gwyneth Paltrow, Don Cheadle, Ben Kingsley as the Mandarin, and Guy Pearce as Aldrich Killian. Filming took place in 2012, with the film focusing more on Tony Stark\'s character development and his struggle with anxiety and his identity as a hero. \\n\\n Released on May 3, 2013, Iron Man 3 was a massive box-office success, grossing over $1.2 billion worldwide. It received positive reviews for its character-driven plot and Downey Jr.\'s performance but was criticized for its handling of the Mandarin character. Despite the mixed reception to certain aspects, it remains one of the most commercially successful films in the MCU.', '2013', '../../Movies/iron_man_3_mini.jpg', '../../Movies/iron_man_3.jpg', 130, '2025-05-03 17:17:32', '2025-05-05 15:10:00'),
(8, 'Thor: The Dark World', 'Thor reunites with Jane Foster to face the Dark Elves, led by Malekith, who seek to plunge the universe into darkness using a powerful force known as the Aether.', 'Thor: The Dark World is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Alan Taylor, it is the eighth film in the Marvel Cinematic Universe (MCU) and the direct sequel to Thor (2011). The film follows Thor as he teams up with his brother Loki to stop the Dark Elf Malekith from using a powerful weapon known as the Aether to plunge the universe into darkness. \\n\\n The film stars Chris Hemsworth as Thor, Tom Hiddleston as Loki, Natalie Portman as Jane Foster, Anthony Hopkins, Idris Elba, and Christopher Eccleston as Malekith. Filming took place in 2012 and 2013, with a focus on action, mythology, and a darker tone compared to the first film. \\n\\n Released on November 8, 2013, Thor: The Dark World was met with mixed reviews, with criticism directed at the plot and pacing, though the performances and visuals were generally well received. Despite this, it grossed over $644 million worldwide and played a key role in setting up future MCU storylines, including the introduction of the Aether, which would become one of the Infinity Stones.', '2013', '../../Movies/thor_dark_world_mini.jpg', '../../Movies/thor_dark_world.jpg', 112, '2025-05-03 17:18:13', '2025-05-05 15:09:56'),
(9, 'Captain America: The Winter Soldier', 'Captain America teams up with Black Widow and Falcon to uncover a conspiracy within S.H.I.E.L.D. and faces a mysterious assassin known as the Winter Soldier—his long-lost friend Bucky Barnes.', 'Captain America: The Winter Soldier is an American superhero film based on the Marvel Comics character Captain America. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the ninth film in the Marvel Cinematic Universe (MCU) and a direct sequel to Captain America: The First Avenger (2011). Directed by Anthony and Joe Russo, the film follows Steve Rogers as he adjusts to life in the modern world after being frozen in ice for decades. He teams up with Black Widow to uncover a conspiracy within S.H.I.E.L.D. while facing a mysterious assassin known as the Winter Soldier. \\n\\n The film stars Chris Evans as Captain America, Scarlett Johansson as Black Widow, along with Samuel L. Jackson, Sebastian Stan, Anthony Mackie, and Robert Redford. Filming took place in 2013, with a focus on more grounded action and espionage elements. \\n\\n Released on April 4, 2014, Captain America: The Winter Soldier was a commercial and critical success, grossing over $714 million worldwide. It was praised for its mature themes, political thriller tone, and its exploration of the relationship between Captain America and the Winter Soldier, and it remains one of the best-reviewed films in the MCU.', '2014', '../../Movies/captain_america_winter_soldier_mini.jpg', '../../Movies/captain_america_winter_soldier.jpg', 136, '2025-05-03 17:18:13', '2025-05-05 15:09:52'),
(10, 'Guardians of the Galaxy', 'A group of misfits—Star-Lord, Gamora, Drax, Rocket, and Groot—must band together to stop the villain Ronan from using a powerful Orb to destroy the galaxy.', 'Guardians of the Galaxy is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by James Gunn, it is the 10th film in the Marvel Cinematic Universe (MCU). The story follows Peter Quill, a misfit thief who forms an unlikely group of heroes to stop the villain Ronan the Accuser from using a powerful artifact called the Orb to destroy planets. Along with Rocket, Groot, Gamora, and Drax, Quill must learn to work together to save the galaxy. \\n\\n The film stars Chris Pratt as Peter Quill, Zoe Saldana, Dave Bautista, Vin Diesel, Bradley Cooper, and Lee Pace. Filming took place in 2014, with Gunn’s distinct humor, irreverence, and colorful visual style defining the film. The film introduced the Guardians, a ragtag group of heroes with a lot of heart, and set the tone for their future adventures. \\n\\n Released on August 1, 2014, Guardians of the Galaxy was a critical and commercial success, grossing over $770 million worldwide. It was praised for its humor, visual style, and soundtrack, and became one of the most beloved films in the MCU, further establishing the cosmic side of the franchise.', '2014', '../../Movies/guardians_of_the_galaxy_mini.jpg', '../../Movies/guardians_of_the_galaxy.jpg', 121, '2025-05-03 17:18:13', '2025-05-05 15:09:15'),
(11, 'Avengers: Age of Ultron', 'When Tony Stark creates Ultron, an AI peacekeeping program, it turns against humanity. The Avengers must unite to stop the rogue AI from causing global extinction.', 'Avengers: Age of Ultron is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Joss Whedon, it is the 11th film in the Marvel Cinematic Universe (MCU) and a direct sequel to The Avengers (2012). The film follows the Avengers as they attempt to stop the artificial intelligence, Ultron, who was created by Tony Stark and Bruce Banner but becomes a villain bent on human extinction. \\n\\n The film stars Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth, Scarlett Johansson, Jeremy Renner, and new cast members James Spader as Ultron, Aaron Taylor-Johnson as Quicksilver, and Elizabeth Olsen as Scarlet Witch. Principal photography began in 2014, and the film features large-scale action sequences and introduces new characters to the MCU. \\n\\n Released on May 1, 2015, Avengers: Age of Ultron was a commercial success, grossing over $1.4 billion worldwide. It received mixed reviews from critics, with praise for its performances and action, though it was critiqued for its convoluted plot and pacing. Despite the mixed critical reception, the film played an important role in setting up future MCU storylines.', '2015', '../../Movies/avengers_age_of_ultron_mini.jpg', '../../Movies/avengers_age_of_ultron.jpg', 141, '2025-05-03 17:18:45', '2025-05-05 15:09:10'),
(12, 'Ant-Man', 'Scott Lang, a skilled thief, is recruited by Hank Pym to wear a suit that allows him to shrink in size but increase in strength. He must embrace his inner hero to pull off a heist that will save the world.', 'Ant-Man is an American superhero film based on the Marvel Comics character Scott Lang / Ant-Man. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 12th film in the Marvel Cinematic Universe (MCU). Directed by Peyton Reed, the film follows Scott Lang, a thief who is recruited by Dr. Hank Pym to become Ant-Man, using a suit that allows him to shrink in size while retaining his strength. Together, they must stop a villain from using the suit for evil. \\n\\n The film stars Paul Rudd as Scott Lang / Ant-Man, Michael Douglas as Hank Pym, Evangeline Lilly, Corey Stoll, Michael Peña, and Bobby Cannavale. Filming took place in 2014, with a focus on visual effects to create shrinking action scenes. Ant-Man is notable for its lighter tone compared to other MCU films, mixing humor with superhero action. \\n\\n Released on July 17, 2015, Ant-Man was a critical success, praised for its humor, action sequences, and the performances of Rudd and Douglas. The film grossed over $519 million worldwide, becoming a commercial success and laying the groundwork for the character\'s return in future MCU films.', '2015', '../../Movies/ant_man_mini.jpg', '../../Movies/ant_man.jpg', 117, '2025-05-03 17:18:45', '2025-05-05 15:09:06'),
(13, 'Captain America: Civil War', 'Political pressure divides the Avengers into opposing factions, led by Captain America and Iron Man, after a mission goes wrong. Old friendships are tested in a battle over accountability and freedom.', 'Captain America: Civil War is an American superhero film based on the Marvel Comics character Captain America. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 13th film in the Marvel Cinematic Universe (MCU). Directed by Anthony and Joe Russo, the film explores the rift between two factions of the Avengers after the Sokovia Accords, which mandate governmental oversight of superhero activity, are introduced. Steve Rogers leads one side, while Tony Stark leads the opposing side, leading to a conflict that threatens the team’s unity. \\n\\n The film stars Chris Evans as Captain America, Robert Downey Jr. as Iron Man, along with Scarlett Johansson, Sebastian Stan, Anthony Mackie, Don Cheadle, Jeremy Renner, and Chadwick Boseman as Black Panther. The film also introduces Tom Holland as Spider-Man into the MCU. Principal photography took place in 2015, with the film featuring high-stakes action sequences and the emotional fallout of its central conflict. \\n\\n Released on May 6, 2016, Captain America: Civil War was both a critical and commercial success, grossing over $1.1 billion worldwide. The film is widely regarded as one of the best entries in the MCU for its emotional depth, complex character dynamics, and its epic airport battle.', '2016', '../../Movies/captain_america_civil_war_mini.jpg', '../../Movies/captain_america_civil_war.jpg', 147, '2025-05-03 17:18:45', '2025-05-05 15:09:01'),
(14, 'Doctor Strange', 'Dr. Stephen Strange, a renowned neurosurgeon, loses the use of his hands in a car accident. Desperate for a cure, he discovers the mystic arts and becomes the Sorcerer Supreme, defending the world from dark forces.', 'Doctor Strange is an American superhero film based on the Marvel Comics character Stephen Strange. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 14th film in the Marvel Cinematic Universe (MCU). Directed by Scott Derrickson, the film tells the story of Stephen Strange, a brilliant but arrogant neurosurgeon who, after a car accident, seeks out alternative medicine in order to heal his hands. His journey leads him to the mystical arts, and he becomes the Sorcerer Supreme. \\n\\n The film stars Benedict Cumberbatch as Stephen Strange, along with Chiwetel Ejiofor, Rachel McAdams, Benedict Wong, Mads Mikkelsen, and Tilda Swinton. The film blends superhero action with mind-bending visuals, incorporating elements of magic and alternate dimensions. Filming took place in 2015, with a heavy focus on visual effects to depict the mystical world. \\n\\n Released on November 4, 2016, Doctor Strange was praised for its visuals, direction, and Cumberbatch’s performance. It grossed over $677 million worldwide and introduced the mystical side of the MCU, expanding its universe into magical realms.', '2016', '../../Movies/doctor_strange_mini.jpg', '../../Movies/doctor_strange.jpg', 115, '2025-05-03 17:20:40', '2025-05-05 15:08:57'),
(15, 'Guardians of the Galaxy Vol. 2', 'The Guardians must face their own personal demons and discover the truth about Peter Quill\'s parentage as they battle a powerful new villain, Ego the Living Planet.', 'Guardians of the Galaxy Vol. 2 is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by James Gunn, it is the sequel to Guardians of the Galaxy (2014) and the 15th film in the Marvel Cinematic Universe (MCU). The story follows the Guardians as they continue their cosmic adventures, uncovering Peter Quill\'s true heritage and facing new threats from his estranged father, Ego the Living Planet. \\n\\n The film stars Chris Pratt, Zoe Saldana, Dave Bautista, Vin Diesel, Bradley Cooper, Michael Rooker, Karen Gillan, and new cast members Kurt Russell, Pom Klementieff, and Elizabeth Debicki. Filming took place in 2016, with Gunn\'s trademark humor, colorful visuals, and emotional depth continuing to define the series. The film explores themes of family, identity, and redemption, expanding on the relationships between the Guardians. \\n\\n Released on May 5, 2017, Guardians of the Galaxy Vol. 2 received positive reviews for its humor, visuals, and performances. The film grossed over $860 million worldwide and became one of the top films of 2017. It further solidified the Guardians as one of the most beloved teams in the MCU.', '2017', '../../Movies/guardians_of_the_galaxy_vol2_mini.jpg', '../../Movies/guardians_of_the_galaxy_vol2.jpg', 136, '2025-05-03 17:20:40', '2025-05-05 15:08:07'),
(16, 'Spider-Man: Homecoming', 'Teenager Peter Parker, after his adventure with the Avengers, tries to balance high school life with his duties as Spider-Man while facing the Vulture, a new villain who threatens his city.', 'Spider-Man: Homecoming is an American superhero film based on Marvel Comics, co-produced by Marvel Studios and Sony Pictures. \\n Directed by Jon Watts, it is the 16th film in the Marvel Cinematic Universe (MCU) and the first solo Spider-Man film in the MCU. The story follows Peter Parker, a high school student who struggles with his responsibilities as Spider-Man while trying to live a normal life. When a new villain, the Vulture, threatens New York City, Peter must step up and prove himself as a hero. \\n\\n The film stars Tom Holland as Peter Parker / Spider-Man, along with Michael Keaton, Robert Downey Jr., Marisa Tomei, Zendaya, Jacob Batalon, and Tony Revolori. Filming took place in Atlanta and New York City in 2016, with the film blending high school drama with superhero action. The film\'s tone was lighter and more humorous than previous Spider-Man adaptations, making it feel fresh and accessible. \\n\\n Released on July 7, 2017, Spider-Man: Homecoming received critical acclaim for its performances, humor, and youthful energy. Holland\'s portrayal of Peter Parker was widely praised, and the film became a box-office success, grossing over $880 million worldwide.', '2017', '../../Movies/spider_man_homecoming_mini.jpg', '../../Movies/spider_man_homecoming.jpg', 133, '2025-05-03 17:20:40', '2025-05-05 15:08:02'),
(17, 'Thor: Ragnarok', 'Thor must escape the planet Sakaar and prevent the prophesied apocalypse, Ragnarok, from destroying Asgard, all while facing his estranged sister Hela and teaming up with Hulk and Loki.', 'Thor: Ragnarok is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Taika Waititi, it is the third film in the Thor series and the 17th film in the Marvel Cinematic Universe (MCU). The story follows Thor as he is imprisoned on the planet Sakaar, where he must fight in a gladiatorial arena against the Hulk. Meanwhile, back on Asgard, his sister Hela threatens to destroy his home and his world. \\n\\n The film stars Chris Hemsworth, Tom Hiddleston, Cate Blanchett, Idris Elba, Mark Ruffalo, Jeff Goldblum, Tessa Thompson, and Anthony Hopkins. Thor: Ragnarok injects a comedic tone into the franchise while maintaining the action and epic storytelling associated with the series. Filming took place in Australia in 2016, with Waititi\'s unique directorial style contributing to a more vibrant and irreverent atmosphere. \\n\\n Released on November 3, 2017, Thor: Ragnarok was a commercial and critical success, praised for its humor, visual style, and performances, particularly Hemsworth and Blanchett. It revitalized the Thor character and became one of the most popular films in the MCU.', '2017', '../../Movies/thor_ragnarok_mini.jpg', '../../Movies/thor_ragnarok.jpg', 130, '2025-05-03 17:21:07', '2025-05-05 15:07:57'),
(18, 'Black Panther', 'T\'Challa returns home to Wakanda to take his place as king. When his father’s past comes back to haunt him, T\'Challa must fight to defend his people and his nation from the villainous Killmonger.', 'Black Panther is an American superhero film based on the Marvel Comics character T\'Challa / Black Panther. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 18th film in the Marvel Cinematic Universe (MCU). Directed by Ryan Coogler, the film tells the story of T\'Challa, who becomes the king of Wakanda following the death of his father. T\'Challa must defend his nation from an enemy who threatens its very existence, as well as uncover the secrets of his father\'s past. \\n\\n The film stars Chadwick Boseman as T\'Challa, alongside Michael B. Jordan, Lupita Nyong\'o, Danai Gurira, Martin Freeman, Daniel Kaluuya, Letitia Wright, and Winston Duke. Filming took place in Atlanta and South Korea in 2017. Black Panther is notable for its cultural significance, featuring a predominantly Black cast and addressing themes of identity, heritage, and the African diaspora. \\n\\n Released on February 16, 2018, Black Panther received critical acclaim for its performances, direction, and cultural impact. It became a box-office hit, grossing over $1.3 billion worldwide, and earned several Academy Award nominations, including Best Picture, making it the first superhero film to receive such a nomination.', '2018', '../../Movies/black_panther_mini.jpg', '../../Movies/black_panther.jpg', 134, '2025-05-03 17:21:07', '2025-05-05 15:07:51'),
(19, 'Avengers: Infinity War', 'The Avengers and their allies must assemble to stop Thanos, who is determined to collect all the Infinity Stones and use them to bring about the extinction of half the universe.', 'Avengers: Infinity War is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Anthony and Joe Russo, it is the 19th film in the Marvel Cinematic Universe (MCU) and the first part of a two-part crossover event that concludes in Avengers: Endgame (2019). The film follows the Avengers as they try to stop the powerful villain Thanos, who is on a quest to collect all six Infinity Stones to wipe out half of the universe\'s population. \\n\\n The film stars an ensemble cast, including Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth, Scarlett Johansson, Benedict Cumberbatch, Tom Holland, Chadwick Boseman, and Josh Brolin, who plays Thanos. The film brings together nearly every major MCU character, as they battle Thanos’s forces in an attempt to prevent the ultimate destruction of reality. Principal photography began in early 2017 and concluded in 2017 across various global locations. \\n\\n Released on April 27, 2018, Avengers: Infinity War was a massive commercial success, grossing over $2 billion worldwide, and received critical acclaim for its action sequences, emotional depth, and performances. The film set up the highly anticipated conclusion in Avengers: Endgame and remains one of the highest-grossing films of all time.', '2018', '../../Movies/avengers_infinity_war_mini.jpg', '../../Movies/avengers_infinity_war.jpg', 149, '2025-05-03 17:21:07', '2025-05-05 15:07:46'),
(20, 'Ant-Man and the Wasp', 'Scott Lang teams up with Hope van Dyne as they seek to uncover the mysteries of the past. They must stop a new villain, Ghost, while trying to rescue Janet van Dyne, the original Wasp, from the Quantum Realm.', 'Ant-Man and the Wasp is an American superhero film based on Marvel Comics featuring the characters Ant-Man and the Wasp. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the sequel to Ant-Man (2015) and the 20th film in the Marvel Cinematic Universe (MCU). Directed by Peyton Reed, the film follows Scott Lang (Ant-Man) and Hope van Dyne (the Wasp) as they team up to rescue Janet van Dyne from the Quantum Realm while being pursued by a new antagonist, Ghost. \\n\\n The film stars Paul Rudd, Evangeline Lilly, Michael Douglas, Michael Peña, and Laurence Fishburne, with the addition of Hannah John-Kamen as Ghost. The film explores the Quantum Realm and further develops the mythology behind the quantum mechanics introduced in the first film and Avengers: Endgame (2019). Principal photography began in 2017, with filming taking place in Georgia and San Francisco. \\n\\n Released on July 6, 2018, Ant-Man and the Wasp received positive reviews for its humor, visual effects, and performances. It was praised for its lighthearted tone and fun action sequences, which contrasted with the darker events of Avengers: Infinity War (2018). The film was a commercial success and helped set up future MCU storylines involving the Quantum Realm and time travel.', '2018', '../../Movies/ant_man_and_the_wasp_mini.jpg', '../../Movies/ant_man_and_the_wasp.jpg', 118, '2025-05-03 17:21:47', '2025-05-05 15:05:44'),
(21, 'Captain Marvel', 'Carol Danvers, a former U.S. Air Force pilot, becomes the powerful Captain Marvel after an accident gives her alien powers. She must join forces with Nick Fury to stop a Skrull invasion and uncover the truth about her origins.', 'Captain Marvel is an American superhero film based on the Marvel Comics character Carol Danvers / Captain Marvel. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 21st film in the Marvel Cinematic Universe (MCU). Directed by Anna Boden and Ryan Fleck, the film serves as an origin story for Carol Danvers, a former U.S. Air Force pilot who becomes the powerful superhero Captain Marvel after being caught in the crossfire of a galactic war between the Kree and Skrull alien races. \\n\\n The film stars Brie Larson as Carol Danvers, alongside Samuel L. Jackson, Ben Mendelsohn, Lashana Lynch, Clark Gregg, and Jude Law. Set in the 1990s, the film explores Carol’s journey to uncover the truth about her past while trying to stop the Skrull invasion. Principal photography began in early 2018, with extensive visual effects to create the film\'s intergalactic setting. \\n\\n Released on March 8, 2019, Captain Marvel was a commercial success, grossing over $1 billion worldwide. The film received positive reviews for its performances, particularly Brie Larson’s portrayal of Carol, as well as for its empowering themes and retro 90s aesthetic. It was instrumental in setting up the character’s pivotal role in Avengers: Endgame (2019).', '2019', '../../Movies/captain_marvel_mini.jpg', '../../Movies/captain_marvel.jpg', 123, '2025-05-03 17:21:47', '2025-05-05 15:05:38'),
(22, 'Avengers: Endgame', 'After the devastating events of Infinity War, the remaining Avengers and their allies must come together to undo the destruction caused by Thanos and bring back their fallen friends in a final battle to save the universe.', 'Avengers: Endgame is an American superhero film based on Marvel Comics, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. \\n Directed by Anthony and Joe Russo, it is the direct sequel to Avengers: Infinity War (2018) and the 22nd film in the Marvel Cinematic Universe (MCU). The film follows the surviving Avengers as they attempt to undo the catastrophic events caused by Thanos, who wiped out half of all life in the universe using the Infinity Stones. \\n\\n The film stars Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth, Scarlett Johansson, Jeremy Renner, Don Cheadle, Paul Rudd, Brie Larson, Karen Gillan, Danai Gurira, Benedict Wong, Jon Favreau, and Josh Brolin. Avengers: Endgame brings together nearly all of the MCU\'s major characters for an epic conclusion to the Infinity Saga. Principal photography took place from 2017 to 2018, with extensive visual effects and action sequences. \\n\\n Released on April 26, 2019, Avengers: Endgame became a global phenomenon, receiving widespread critical acclaim for its performances, direction, and emotional weight. It became the highest-grossing film of all time, surpassing Avatar (2009), and was a fitting and emotional conclusion to over a decade of interconnected storytelling in the MCU.', '2019', '../../Movies/avengers_endgame_mini.jpg', '../../Movies/avengers_endgame.jpg', 181, '2025-05-03 17:21:47', '2025-05-05 15:05:32'),
(23, 'Spider-Man: Far From Home', 'Peter Parker goes on a school trip to Europe, but his plans are interrupted when Nick Fury recruits him to fight a new threat: Mysterio, a villain capable of creating illusions that blur the line between reality and fiction.', 'Spider-Man: Far From Home is an American superhero film based on Marvel Comics, co-produced by Marvel Studios and Sony Pictures. \\n Directed by Jon Watts, it is the sequel to Spider-Man: Homecoming (2017) and the 23rd film in the Marvel Cinematic Universe (MCU). Following the events of Avengers: Endgame (2019), Peter Parker struggles to fill the void left by Tony Stark’s death while embarking on a school trip to Europe, where he is recruited by Nick Fury to stop a new threat in the form of Mysterio. \\n\\n The film stars Tom Holland as Peter Parker, Zendaya, Jacob Batalon, Jon Favreau, and Marisa Tomei, with Jake Gyllenhaal joining the cast as Mysterio. The film explores Peter’s grief over the loss of his mentor Tony Stark, while dealing with his responsibilities as a young superhero. Principal photography took place in 2019, primarily in various European locations. \\n\\n Released on July 2, 2019, Spider-Man: Far From Home received widespread praise for its performances, visual effects, and balance of humor and emotional depth. It became the highest-grossing film of 2019 and was a critical and commercial success, setting up future MCU projects with its post-credits scene.', '2019', '../../Movies/spider_man_far_from_home_mini.jpg', '../../Movies/spider_man_far_from_home.jpg', 129, '2025-05-03 17:22:16', '2025-05-05 15:05:26'),
(24, 'Black Widow', 'Natasha Romanoff confronts her past as she goes on a mission to take down a dangerous conspiracy linked to her history as a spy, all while dealing with old family ties and a new deadly foe.', 'Black Widow is an American superhero film based on the Marvel Comics character Natasha Romanoff / Black Widow. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the 24th film in the Marvel Cinematic Universe (MCU). Directed by Cate Shortland, the film serves as a prequel to the events of Avengers: Endgame (2019), exploring Natasha Romanoff’s past as she confronts her history and the dark secrets of her family. \\n\\n The film stars Scarlett Johansson, who reprises her role as Natasha Romanoff, alongside Florence Pugh, David Harbour, Rachel Weisz, and O-T Fagbenle. The film delves into Natasha\'s journey after the events of Captain America: Civil War (2016), when she reunites with her \"family\" from her time as a spy. Principal photography took place in 2019, but was delayed due to the COVID-19 pandemic. \\n\\n Released on July 9, 2021, Black Widow was praised for its action sequences, performances, and the introduction of new characters, particularly Yelena Belova, played by Florence Pugh. The film also provided an emotional send-off for the beloved character of Natasha Romanoff, though its release on Disney+ alongside theaters led to mixed reactions regarding its box office performance.', '2021', '../../Movies/black_widow_mini.jpg', '../../Movies/black_widow.jpg', 134, '2025-05-03 17:22:16', '2025-05-05 15:05:24'),
(25, 'Shang-Chi and the Legend of the Ten Rings', 'Shang-Chi, a martial artist who has been living a normal life, is drawn into the world of the mysterious Ten Rings organization. He must confront his past and the legacy of his father, who leads the deadly criminal group.', 'Shang-Chi and the Legend of the Ten Rings is an American superhero film based on the Marvel Comics character Shang-Chi. \\n Produced by Marvel Studios and directed by Destin Daniel Cretton, it is the 25th film in the Marvel Cinematic Universe (MCU). The story centers on Shang-Chi, a martial arts master who must confront his past and the legacy of his father, the leader of the Ten Rings organization, which was first teased in earlier MCU films. \\n\\n The film stars Simu Liu as Shang-Chi, alongside Awkwafina, Meng’er Zhang, Fala Chen, Benedict Wong, Michelle Yeoh, and Tony Leung. Principal photography began in Australia in early 2020 and faced delays due to the COVID-19 pandemic, resuming later that year. The film mixes action, fantasy, and Eastern mythology, while also exploring themes of identity, family, and heritage. \\n\\n Released on September 3, 2021, Shang-Chi and the Legend of the Ten Rings was both a critical and commercial success. It was praised for its choreography, emotional resonance, and cultural representation, marking a major step for Asian representation in the MCU.', '2021', '../../Movies/shang_chi_mini.jpg', '../../Movies/shang_chi.jpg', 132, '2025-05-03 17:22:16', '2025-05-05 15:04:20'),
(26, 'Eternals', 'The Eternals, a group of immortal beings with superhuman powers, have secretly lived on Earth for thousands of years. When an ancient enemy, the Deviants, return, they must emerge from hiding to protect humanity.', 'Eternals is an American superhero film based on the Marvel Comics race of the same name. \\n Produced by Marvel Studios and directed by Academy Award-winning filmmaker Chloé Zhao, it is the 26th film in the Marvel Cinematic Universe (MCU). The story follows a group of immortal beings who have secretly lived on Earth for thousands of years, reuniting to protect humanity from their ancient enemies, the Deviants, following the events of Avengers: Endgame (2019). \\n\\n The ensemble cast includes Gemma Chan, Richard Madden, Angelina Jolie, Salma Hayek, Kumail Nanjiani, Brian Tyree Henry, Lauren Ridloff, Lia McHugh, Don Lee, Barry Keoghan, and Kit Harington. The film blends science fiction, mythology, and cosmic themes while introducing a new layer of lore to the MCU. Filming began in July 2019 in various locations including London and the Canary Islands, and concluded in early 2020. \\n\\n Released on November 5, 2021, Eternals received mixed reviews, with praise for its ambition, visuals, and representation, but criticism for pacing and tonal shifts. Despite polarized reception, it expanded the MCU’s scope by exploring concepts of cosmic creation and morality.', '2021', '../../Movies/eternals_mini.jpg', '../../Movies/eternals.jpg', 156, '2025-05-03 17:22:41', '2025-05-05 15:04:13'),
(27, 'Spider-Man: No Way Home', 'Peter Parker seeks help from Doctor Strange to erase the memory of his identity as Spider-Man from the world. However, things go wrong, opening portals to the Multiverse and bringing villains from other realities.', 'Spider-Man: No Way Home is an American superhero film based on Marvel Comics, co-produced by Marvel Studios and Columbia Pictures, and distributed by Sony Pictures. \\n It is the third installment in the Spider-Man trilogy starring Tom Holland, following Spider-Man: Homecoming (2017) and Spider-Man: Far From Home (2019). Directed by Jon Watts, the film explores the multiverse after a botched spell by Doctor Strange causes alternate realities to collide, bringing in villains and heroes from other Spider-Man franchises. \\n\\n The film stars Tom Holland, Zendaya, Benedict Cumberbatch, Jacob Batalon, and Marisa Tomei, with the return of Willem Dafoe, Alfred Molina, Jamie Foxx, and former Spider-Man actors Tobey Maguire and Andrew Garfield. Production took place in Atlanta and New York, with tight secrecy maintained around plot and cast reveals. The film became a massive cultural event due to the crossover of characters from previous Spider-Man universes. \\n\\n Released on December 17, 2021, Spider-Man: No Way Home received critical acclaim for its fan service, performances, and emotional storytelling. It became one of the highest-grossing films of all time and was a milestone in multiverse storytelling within the MCU.', '2021', '../../Movies/spider_man_no_way_home_mini.jpg', '../../Movies/spider_man_no_way_home.jpg', 148, '2025-05-03 17:22:41', '2025-05-05 15:04:05'),
(28, 'Doctor Strange in the Multiverse of Madness', 'Doctor Strange teams up with America Chavez to explore the Multiverse and protect reality from the dangers caused by their reckless use of magic, all while facing a powerful new enemy in Scarlet Witch.', 'Doctor Strange in the Multiverse of Madness is an American superhero film based on Marvel Comics featuring the character Stephen Strange / Doctor Strange. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the sequel to Doctor Strange (2016) and the 28th film in the Marvel Cinematic Universe (MCU). The film is directed by Sam Raimi and written by Michael Waldron, and it follows the events of Spider-Man: No Way Home (2021) and WandaVision (2021). It follows Doctor Strange as he protects America Chavez, a teenager with the ability to travel across the multiverse, from a powerful and corrupted Wanda Maximoff who seeks to reunite with her lost children. \\n\\n The film stars Benedict Cumberbatch, Elizabeth Olsen, Chiwetel Ejiofor, Benedict Wong, Xochitl Gomez, Michael Stuhlbarg, and Rachel McAdams. Development began in 2016, with original director Scott Derrickson later replaced by Sam Raimi in 2020 due to creative differences. Filming started in London in November 2020 and continued in various UK locations, concluding in spring 2021 under COVID-19 safety protocols. \\n\\n The film blends horror, fantasy, and superhero action, expanding on the multiverse themes introduced in earlier MCU projects. It received praise for its visual style and Raimi\'s distinctive direction, though reactions to its tone were mixed. Doctor Strange in the Multiverse of Madness was released on May 2, 2022, and became a box office success, further shaping the future of the MCU.', '2022', '../../Movies/doctor_strange_multiverse_of_madness_mini.jpg', '../../Movies/doctor_strange_multiverse_of_madness.jpg', 126, '2025-05-03 17:22:41', '2025-05-05 14:57:20'),
(29, 'Thor: Love and Thunder', 'Thor embarks on a journey of self-discovery but must face a new villain, Gorr the God Butcher, who is determined to eliminate all gods. Along the way, he is reunited with Jane Foster, who now wields the power of Thor.', 'Thor: Love and Thunder is an American superhero film based on Marvel Comics featuring the character Thor. \\n Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the sequel to Thor: Ragnarok (2017) and the 29th film in the Marvel Cinematic Universe (MCU). Directed by Taika Waititi, who also co-wrote the screenplay with Jennifer Kaytin Robinson, the film follows Thor as he attempts to find inner peace while facing a new threat in the form of Gorr the God Butcher. \\n\\n The film stars Chris Hemsworth as Thor, alongside Natalie Portman, Christian Bale, Tessa Thompson, Taika Waititi, Russell Crowe, and the Guardians of the Galaxy cast. Portman returns as Jane Foster, who takes on the mantle of the Mighty Thor while battling a life-threatening illness. Principal photography began in Australia in January 2021 and concluded in June of the same year. The film incorporates elements of cosmic adventure, comedy, and mythology. \\n\\n Thor: Love and Thunder was released on July 8, 2022, and received mixed reviews from critics. While performances and visuals were praised, the film\'s tone and humor divided audiences. Despite that, it became a box office success and continued the storyline of Thor within the broader scope of the MCU\'s Phase Four.', '2022', '../../Movies/thor_love_and_thunder_mini.jpg', '../../Movies/thor_love_and_thunder.jpg', 119, '2025-05-03 17:23:11', '2025-05-05 15:03:09'),
(30, 'Black Panther: Wakanda Forever', 'Wakanda mourns the loss of their king, T\'Challa, while facing new challenges as a powerful new enemy, Namor the Sub-Mariner, threatens their world. The nation must unite and discover new allies to protect Wakanda’s legacy.', 'Black Panther: Wakanda Forever is an American superhero film based on Marvel Comics featuring the character Black Panther. \\n Produced by Marvel Studios and directed by Ryan Coogler, it serves as a sequel to Black Panther (2018) and the 30th film in the Marvel Cinematic Universe (MCU). Following the death of actor Chadwick Boseman, the film reimagines the story by focusing on Wakanda’s leaders as they mourn their fallen king T’Challa and face a new threat from the underwater nation of Talokan. \\n\\n The film stars Letitia Wright, Lupita Nyong\'o, Danai Gurira, Winston Duke, Angela Bassett, Tenoch Huerta, and Dominique Thorne. Production began in 2021, with extensive rewrites and delays due to both the pandemic and Boseman\'s unexpected passing. Coogler returned as director and co-writer, honoring Boseman\'s legacy while introducing new characters such as Namor and Riri Williams (Ironheart). \\n\\n Released on November 11, 2022, Black Panther: Wakanda Forever was praised for its emotional depth, performances, and cultural resonance. Angela Bassett received critical acclaim and multiple award nominations. The film became one of the highest-grossing of the year and served as a poignant conclusion to Phase Four of the MCU.', '2022', '../../Movies/black_panther_wakanda_forever_mini.jpg', '../../Movies/black_panther_wakanda_forever.jpg', 161, '2025-05-03 17:23:11', '2025-05-05 15:03:26');

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
-- Структура таблицы `pin_like`
--

CREATE TABLE `pin_like` (
  `pin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pin_like`
--

INSERT INTO `pin_like` (`pin_id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-05-13 16:38:49'),
(5, 1, '2025-05-13 17:41:08');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `pin_likes_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `pin_likes_count` (
`pin_id` int(10) unsigned
,`pin_name` varchar(255)
,`owner_id` int(10) unsigned
,`like_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Структура таблицы `pin_movie`
--

CREATE TABLE `pin_movie` (
  `id` int(10) UNSIGNED NOT NULL,
  `pin_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pin_movie`
--

INSERT INTO `pin_movie` (`id`, `pin_id`, `movie_id`, `created_at`) VALUES
(1, 1, 28, '2025-05-12 21:48:10'),
(2, 3, 28, '2025-05-12 21:48:12'),
(3, 1, 24, '2025-05-13 17:24:54'),
(4, 1, 20, '2025-05-13 17:24:56'),
(5, 1, 22, '2025-05-13 17:24:57'),
(6, 1, 25, '2025-05-13 17:24:59'),
(9, 1, 30, '2025-05-13 17:30:35'),
(10, 1, 21, '2025-05-13 17:52:17'),
(11, 1, 17, '2025-05-13 17:52:18'),
(12, 1, 19, '2025-05-14 13:22:36');

-- --------------------------------------------------------

--
-- Структура таблицы `pin_series`
--

CREATE TABLE `pin_series` (
  `id` int(10) UNSIGNED NOT NULL,
  `pin_id` int(10) UNSIGNED NOT NULL,
  `series_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pin_series`
--

INSERT INTO `pin_series` (`id`, `pin_id`, `series_id`, `created_at`) VALUES
(4, 1, 18, '2025-05-12 21:47:23'),
(6, 1, 19, '2025-05-12 21:47:59'),
(7, 2, 19, '2025-05-12 21:48:00'),
(8, 1, 20, '2025-05-13 17:24:48'),
(9, 1, 22, '2025-05-13 17:24:50'),
(10, 1, 21, '2025-05-13 17:24:51'),
(13, 3, 19, '2025-05-13 18:11:40'),
(14, 1, 2, '2025-05-13 18:13:27');

-- --------------------------------------------------------

--
-- Структура таблицы `pin_view`
--

CREATE TABLE `pin_view` (
  `pin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pin_view`
--

INSERT INTO `pin_view` (`pin_id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-05-14 13:55:11'),
(2, 1, '2025-05-13 22:45:52'),
(3, 1, '2025-05-14 13:55:09'),
(4, 1, '2025-05-13 22:45:43'),
(5, 1, '2025-05-13 17:43:20');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `pin_views_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `pin_views_count` (
`pin_id` int(10) unsigned
,`pin_name` varchar(255)
,`owner_id` int(10) unsigned
,`view_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Структура таблицы `premium_subscriptions`
--

CREATE TABLE `premium_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `activated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `cost` decimal(10,2) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'Secret Invasion', 'Nick Fury teams up with a group of spies to uncover an alien invasion on Earth, as shape-shifting Skrulls infiltrate the planet, sparking a thrilling adventure of mystery and danger in the Marvel Universe.', 'Secret Invasion is an American television series created by Kyle Bradstreet for Disney+, based on the Marvel Comics storyline of the same name. \\n The series is set in the Marvel Cinematic Universe (MCU) and follows Nick Fury and Maria Hill as they uncover a secret invasion of Earth by the shape-shifting Skrulls, who have infiltrated society for years. The show focuses on the paranoia and betrayal that arise from this invasion, as Fury and his allies attempt to expose the Skrulls and prevent a full-scale takeover. \\n\\n Samuel L. Jackson reprises his role as Nick Fury, with Ben Mendelsohn returning as Talos, and the cast also includes Kingsley Ben-Adir, Olivia Colman, and Emilia Clarke. The series delves into themes of trust, deception, and the complex nature of identity, while expanding the MCU’s portrayal of the Skrulls after their introduction in Captain Marvel (2019). \\n\\n Premiering in 2023, Secret Invasion is anticipated for its intense, spy-thriller atmosphere and its contribution to the larger MCU storyline involving the multiverse. The series is expected to explore the political ramifications of the Skrulls\' actions and their long-term impact on Earth.\n', '2023', '../../Series/secret_invasion_mini.jpg', '../../Series/secret_invasion.jpg', 45, '2025-05-03 14:54:16', '2025-05-05 15:14:00'),
(3, 'Hawkeye', 'Clint Barton teams up with young archer Kate Bishop in New York City to face a criminal conspiracy involving the Tracksuit Mafia, all while navigating their personal struggles and heroism during the holidays.', 'Hawkeye is an American television series created by Jonathan Igla for Disney+, based on the Marvel Comics character Clint Barton / Hawkeye. \\n Set in the Marvel Cinematic Universe (MCU), the series follows Clint Barton as he spends time with his family during the Christmas holiday, only to be pulled back into action when a young archer named Kate Bishop stumbles upon a conspiracy involving dangerous criminals. As the two form an unlikely partnership, they must confront Barton’s past and stop a criminal syndicate threatening to ruin Christmas. \\n\\n Jeremy Renner reprises his role as Clint Barton / Hawkeye, with Hailee Steinfeld as Kate Bishop, Florence Pugh as Yelena Belova, and Vera Farmiga as Eleanor Bishop. The series explores themes of mentorship, legacy, and healing, as Clint helps Kate take on the mantle of a new archer hero while dealing with his own personal trauma. \\n\\n Premiering on November 24, 2021, Hawkeye was praised for its holiday setting, dynamic between the leads, and its incorporation of the larger MCU storylines, particularly regarding Yelena’s role post-Black Widow. The series also introduced new characters like Kate Bishop, who is expected to play a significant role in the MCU\'s future.\n', '2021', '../../Series/hawkeye_mini.jpg', '../../Series/hawkeye.jpg', 45, '2025-05-03 14:54:16', '2025-05-05 15:14:05'),
(4, 'The Falcon and the Winter Soldier', 'Sam Wilson and Bucky Barnes, both dealing with the legacy of Captain America, are forced to team up and confront new threats in a world recovering from the Avengers’ Endgame, facing personal and global challenges.', 'The Falcon and the Winter Soldier is an American television series created by Malcolm Spellman for Disney+, based on the Marvel Comics characters Sam Wilson / Falcon and Bucky Barnes / Winter Soldier. \\n The series is set in the Marvel Cinematic Universe (MCU) and explores the aftermath of Avengers: Endgame, focusing on Sam and Bucky as they navigate a post-Thanos world. Sam Wilson grapples with the legacy of Captain America and the responsibility of taking up the shield, while Bucky Barnes faces his own struggles with his past as the Winter Soldier. Together, they face new threats and confront a group known as the Flag Smashers. \\n\\n Anthony Mackie stars as Sam Wilson / Falcon, Sebastian Stan as Bucky Barnes / Winter Soldier, with Wyatt Russell as John Walker / U.S. Agent, and Daniel Brühl reprising his role as Helmut Zemo. The series tackles themes of identity, legacy, race, and healing, making it one of the most socially relevant shows in the MCU. \\n\\n Premiering on March 19, 2021, The Falcon and the Winter Soldier received praise for its action sequences, emotional depth, and the chemistry between Mackie and Stan. The series was instrumental in Sam Wilson’s journey to becoming the new Captain America and set the stage for future MCU events.\n', '2021', '../../Series/falcon_winter_soldier_mini.jpg', '../../Series/falcon_winter_soldier.jpg', 50, '2025-05-03 14:54:16', '2025-05-05 15:14:10'),
(5, 'Daredevil: Born Again', 'Matt Murdock, the blind lawyer turned vigilante Daredevil, returns to Hell\'s Kitchen as he faces new adversaries and legal battles, trying to balance his life as a hero and a lawyer in this highly anticipated reboot.', 'Daredevil: Born Again is an upcoming American television series created by Matt Corman and Chris Ord for Disney+, based on the Marvel Comics character Daredevil. \\n Set in the Marvel Cinematic Universe (MCU), the series will follow Matt Murdock / Daredevil as he faces new challenges in his role as both a lawyer and a vigilante in New York City. The title, \"Born Again,\" is a reference to a famous Daredevil comic storyline where Murdock’s life is turned upside down after his secret identity is exposed, leading to a major transformation in his life and career. \\n\\n Charlie Cox reprises his role as Matt Murdock / Daredevil, and the series will continue to explore his dual identity and struggles as a superhero in a gritty urban setting. \\n\\n Premiering in 2024, Daredevil: Born Again is highly anticipated by fans due to the character’s beloved portrayal in the Netflix series. The show is expected to delve deeper into Daredevil\'s personal battles and expand his role within the larger MCU narrative.\n', '2025', '../../Series/daredevil_born_again_mini.jpg', '../../Series/daredevil_born_again.jpg', 50, '2025-05-03 14:54:16', '2025-05-05 15:14:16'),
(7, 'Moon Knight', 'Steven Grant, a gift-shop employee, discovers he shares a body with mercenary Marc Spector. Together, they battle crime and uncover hidden secrets related to an ancient Egyptian god in this dark superhero series.', 'Moon Knight is an American television series created by Jeremy Slater for Disney+, based on the Marvel Comics character Marc Spector / Moon Knight. \\n The series is set in the Marvel Cinematic Universe (MCU) and follows Marc Spector, a former mercenary who becomes the avatar of the Egyptian moon god Khonshu after a near-death experience. Struggling with dissociative identity disorder, Marc juggles multiple personalities while fighting crime as Moon Knight, all while uncovering a mystery involving ancient Egyptian mythology and confronting the villainous Arthur Harrow. \\n\\n Oscar Isaac stars as Marc Spector / Moon Knight, with Ethan Hawke as Arthur Harrow and May Calamawy in a supporting role. The series explores themes of mental illness, identity, and redemption, offering a darker and more psychological side to the MCU. \\n\\n Premiering on March 30, 2022, Moon Knight was praised for its complex character portrayal, especially Isaac’s performance, and its unique approach to superhero storytelling. The show was noted for its blend of horror, mystery, and action, and it provided a fresh perspective within the MCU, introducing new mythologies and character dynamics.\n', '2022', '../../Series/moon_knight_mini.jpg', '../../Series/moon_knight.jpg', 50, '2025-05-03 14:54:58', '2025-05-05 15:14:22'),
(11, 'Agatha All Along', 'Agatha Harkness, a powerful witch from WandaVision, returns in her own series, delving into her dark past and magical origins as she faces new challenges in the supernatural world.', 'Agatha All Along is an upcoming American television miniseries created by Jac Schaeffer for Disney+, based on the Marvel Comics character Agatha Harkness. \\n The series is set in the Marvel Cinematic Universe (MCU) and will explore the backstory of Agatha Harkness, the witch who played a key role in WandaVision. The show will delve into Agatha\'s past, her powers, and the secrets of her mysterious life before her involvement with Wanda Maximoff in Westview. The series is expected to blend comedy, magic, and dark secrets. \\n\\n Kathryn Hahn reprises her role as Agatha Harkness, and the series will explore her character’s complexity, revealing more about her history and motivations. \\n\\n Set to premiere in 2023, Agatha All Along has generated significant excitement after Hahn’s portrayal of Agatha in WandaVision became a fan favorite. The show is expected to add depth to the character and expand the MCU\'s magical and mystical lore.\n', '2024', '../../Series/agatha_all_along_mini.jpg', '../../Series/agatha_all_along.jpg', 45, '2025-05-03 14:54:58', '2025-05-05 15:14:27'),
(12, 'Ms. Marvel', 'Kamala Khan, a teenager from Jersey City, discovers her powers as a fan of superheroes. She becomes Ms. Marvel, embracing her newfound abilities and identity as a superhero while navigating her cultural heritage.', 'Ms. Marvel is an American television series created by Bisha K. Ali for Disney+, based on the Marvel Comics character Kamala Khan / Ms. Marvel. \\n The series is set in the Marvel Cinematic Universe (MCU) and follows Kamala Khan, a Muslim-American teenager from Jersey City who discovers she has the ability to stretch and shape-shift her body after gaining mystical powers from a mysterious bangle. As Kamala embraces her powers, she is inspired by her idol, Captain Marvel, and must balance her superhero duties with the challenges of adolescence. \\n\\n Iman Vellani stars as Kamala Khan / Ms. Marvel, with Matt Lintz, Yasmeen Fletcher, and Mohan Kapur in supporting roles. The show explores Kamala’s cultural identity, family dynamics, and her journey to becoming a superhero. \\n\\n Premiering on June 8, 2022, Ms. Marvel was praised for its representation of Muslim-American culture, its lighthearted tone, and its exploration of Kamala’s coming-of-age story. The series introduces Kamala to the MCU, setting up her appearance in The Marvels (2023) and her involvement in future MCU storylines.\n', '2022', '../../Series/ms_marvel_mini.jpg', '../../Series/ms_marvel.jpg', 45, '2025-05-03 14:54:58', '2025-05-05 15:14:33'),
(13, 'Agents of S.H.I.E.L.D.', 'Agents of S.H.I.E.L.D. follows a group of specialized agents led by Phil Coulson, as they investigate strange occurrences and protect humanity from threats both alien and terrestrial, in a thrilling blend of espionage and science fiction.', 'Agents of S.H.I.E.L.D. is an American television series created by Joss Whedon, Jed Whedon, and Maurissa Tancharoen, based on the Marvel Comics organization S.H.I.E.L.D. \\n Produced by Marvel Television and aired on ABC, the show is set in the Marvel Cinematic Universe (MCU) and follows a team of elite S.H.I.E.L.D. agents, led by Phil Coulson, as they deal with extraordinary threats and investigate supernatural events. Throughout the series, the agents face off against both human and alien threats, uncover government conspiracies, and explore the ramifications of the Avengers\' actions on the world. \\n\\n Clark Gregg reprises his role as Phil Coulson, with Ming-Na Wen, Brett Dalton, Chloe Bennet, Iain De Caestecker, Elizabeth Henstridge, and Henry Simmons in key roles. The series features numerous connections to the larger MCU, including crossovers with characters and storylines from the films. \\n\\n Premiering on September 24, 2013, Agents of S.H.I.E.L.D. ran for seven seasons and received generally positive reviews for its character development, action, and creative storytelling. While initially criticized for its pacing and tone, the show gained a loyal fanbase and became one of the longest-running MCU television series. The series was praised for expanding the MCU\'s narrative in ways that were complementary to the films.\n', '2013', '../../Series/agents_of_shield_mini.jpg', '../../Series/agents_of_shield.jpg', 45, '2025-05-03 14:54:58', '2025-05-05 15:13:06'),
(14, 'WandaVision', 'WandaVision follows Wanda Maximoff and Vision as they navigate life in a strange, idyllic suburban world, only to unravel dark secrets behind their perfect reality. This series blends classic sitcom styles with Marvel\'s larger universe.', 'WandaVision is an American television miniseries created by Jac Schaeffer for Disney+, based on Marvel Comics and starring Elizabeth Olsen and Paul Bettany. \\n The series is set in the Marvel Cinematic Universe (MCU) and follows Wanda Maximoff (Scarlet Witch) and Vision as they attempt to live an idyllic suburban life in the town of Westview, New Jersey, while dealing with the complexities of their own realities. The show blends classic sitcom tropes with elements of psychological horror, as Wanda’s grief and trauma begin to unravel, altering the reality around her. \\n\\n Elizabeth Olsen and Paul Bettany reprise their roles from the MCU films, with Kathryn Hahn, Teyonah Parris, Randall Park, and Kat Dennings also starring. WandaVision explores the aftermath of Avengers: Endgame and expands on Wanda’s powers and her role in the MCU. \\n\\n Premiering on January 15, 2021, WandaVision was praised for its unique storytelling, acting, and creativity, particularly its homage to different eras of television. It received critical acclaim for pushing boundaries within the superhero genre, tackling themes of grief, loss, and self-identity. The show became a cultural phenomenon, sparking fan theories and discussions, and was instrumental in launching Disney+\'s MCU content.\n', '2021', '../../Series/wandavision_mini.jpg', '../../Series/wandavision.jpg', 50, '2025-05-03 14:54:58', '2025-05-05 15:13:11'),
(15, 'She-Hulk: Attorney at Law', 'Jennifer Walters, a lawyer and cousin of Bruce Banner, transforms into She-Hulk after a blood transfusion. She balances her career as a lawyer with her new life as a powerful superhero, in a fun and legal action-comedy.', 'She-Hulk: Attorney at Law is an American television series created by Jessica Gao for Disney+, based on the Marvel Comics character Jennifer Walters / She-Hulk. \\n The show is set in the Marvel Cinematic Universe (MCU) and follows Jennifer Walters, a lawyer who gains the powers of the Hulk after a blood transfusion from her cousin Bruce Banner. As She-Hulk, Jennifer must navigate both her legal career and her newfound abilities, while handling cases involving superhumans and facing off against various comic book villains. \\n\\n Tatiana Maslany stars as Jennifer Walters / She-Hulk, with Mark Ruffalo reprising his role as Bruce Banner / Hulk, and the cast includes Ginger Gonzaga, Renée Elise Goldsberry, and Tim Roth. The show blends legal drama with comedic and superhero elements, offering a lighter, more humorous take on the MCU. \\n\\n Premiering on August 18, 2022, She-Hulk: Attorney at Law was praised for its humor, Maslany’s performance, and its exploration of breaking the fourth wall, reminiscent of the comic books. The series is notable for its self-aware tone, addressing themes of feminism, body image, and identity, while providing a fresh and fun addition to the MCU.\n', '2022', '../../Series/she_hulk_mini.jpg', '../../Series/she_hulk.jpg', 50, '2025-05-03 14:54:58', '2025-05-05 15:13:15'),
(16, 'Daredevil', 'Daredevil follows Matt Murdock, a blind lawyer by day and vigilante by night, who uses his heightened senses to fight crime in Hell\'s Kitchen while facing personal challenges and moral dilemmas.', 'Daredevil is an American television series created by Drew Goddard, based on the Marvel Comics character Matt Murdock / Daredevil. \\n Produced by Marvel Television and aired on Netflix, the series is set in the Marvel Cinematic Universe (MCU) and follows Matt Murdock, a blind lawyer who fights crime as Daredevil in the Hell\'s Kitchen neighborhood of New York City. After a chemical accident leaves him with heightened senses, Matt becomes a vigilante, using his abilities to take down the criminal underworld, led by the ruthless Wilson Fisk (Kingpin). \\n\\n Charlie Cox stars as Matt Murdock / Daredevil, with Vincent D\'Onofrio as Wilson Fisk / Kingpin, Deborah Ann Woll as Karen Page, and Elden Henson as Foggy Nelson. The series is known for its gritty, mature tone, intense action sequences, and its exploration of moral dilemmas and the impact of vigilantism. \\n\\n Premiering on April 10, 2015, Daredevil was critically acclaimed, with praise for its writing, performances, and the darker, grounded approach to superhero storytelling. The series ran for three seasons before being canceled in 2018, but it remains a fan-favorite for its strong character development, complex villains, and its place in the larger Marvel Netflix universe.\n', '2015', '../../Series/daredevil_mini.jpg', '../../Series/daredevil.jpg', 55, '2025-05-03 14:56:31', '2025-05-05 15:13:20'),
(17, 'Loki', 'Loki, the God of Mischief, finds himself in a new timeline and must confront his past, present, and future in a thrilling series that explores the multiverse and sets the stage for future Marvel adventures.', 'Loki is an American television series created by Michael Waldron for Disney+, based on the Marvel Comics character Loki. \\n The series is set in the Marvel Cinematic Universe (MCU) and follows the God of Mischief, Loki, after he escapes with the Tesseract during the events of Avengers: Endgame (2019). In the show, Loki is apprehended by the Time Variance Authority (TVA), an organization that manages the timelines of the multiverse. As he is forced to work with TVA agent Mobius, Loki begins to explore the chaos he’s caused by tampering with the timeline and confronts alternate versions of himself. \\n\\n Tom Hiddleston reprises his iconic role as Loki, with Owen Wilson as Mobius, Gugu Mbatha-Raw, Sophia Di Martino, and Wunmi Mosaku in supporting roles. The series introduces the concept of the multiverse and expands the MCU into new dimensions. \\n\\n Premiering on June 9, 2021, Loki was well-received for its unique narrative structure, humor, and the exploration of Loki’s character. It was praised for Hiddleston’s performance and its contribution to the MCU’s multiverse arc, setting the stage for future films and series in the franchise. The show became a cultural phenomenon and was renewed for a second season.\n', '2021', '../../Series/loki_mini.jpg', '../../Series/loki.jpg', 50, '2025-05-03 14:56:31', '2025-05-05 15:13:25'),
(18, 'Agent Carter', 'Agent Peggy Carter, a founding member of S.H.I.E.L.D., embarks on espionage missions in the post-WWII era, all while fighting for recognition in a male-dominated world.', 'Agent Carter is an American television series created by Christopher Markus and Stephen McFeely, based on the Marvel Comics character Peggy Carter. \\n Produced by Marvel Television and aired on ABC, the show is set in the Marvel Cinematic Universe (MCU) and takes place in the aftermath of World War II. The series follows Peggy Carter, a British intelligence officer who, while working for the Strategic Scientific Reserve (SSR), must navigate the challenges of being a woman in a male-dominated workplace while also dealing with espionage, secret organizations, and global threats. \\n\\n Hayley Atwell reprises her role as Peggy Carter, with James D\'Arcy as Edwin Jarvis and Shea Whigham as Chief Thompson. The show delves into Peggy\'s life after Captain America\'s disappearance and her efforts to protect the world while honoring her late partner, Steve Rogers. \\n\\n Premiering on January 6, 2015, Agent Carter received positive reviews for its strong female lead, period setting, and unique perspective in the MCU. Although the series was well-received by critics and fans, it was ultimately canceled after two seasons, but it remains a fan favorite due to its character development and exploration of post-war America.\n', '2015', '../../Series/agent_carter_mini.jpg', '../../Series/agent_carter.jpg', 45, '2025-05-03 14:56:31', '2025-05-05 15:12:17'),
(19, 'Jessica Jones', 'Jessica Jones, a private investigator with superhuman abilities, struggles with her trauma and the aftermath of being manipulated by a mind-controlling villain, all while solving crimes in New York City.', 'Jessica Jones is an American television series created by Melissa Rosenberg, based on the Marvel Comics character Jessica Jones. \\n Produced by Marvel Television and aired on Netflix, the series is set in the Marvel Cinematic Universe (MCU) and follows the story of Jessica Jones, a private investigator with superhuman strength who is trying to put her traumatic past behind her. Jessica is drawn into a dangerous investigation when a mysterious villain named Kilgrave resurfaces, and she must confront her dark past in order to stop him. \\n\\n Krysten Ritter stars as Jessica Jones, with David Tennant as Kilgrave, Mike Colter as Luke Cage, and Rachael Taylor as Trish Walker. The show tackles themes of trauma, PTSD, and empowerment, with a darker and more mature tone than many other MCU properties. \\n\\n Premiering on November 20, 2015, Jessica Jones was praised for its complex characters, particularly Jessica, and its handling of difficult subject matter like abuse and consent. The series ran for three seasons before being canceled in 2019, but it remains one of the most highly regarded of the Netflix Marvel series for its performances and unique approach to superhero storytelling.\n', '2015', '../../Series/jessica_jones_mini.jpg', '../../Series/jessica_jones.jpg', 50, '2025-05-03 14:56:31', '2025-05-05 15:12:24'),
(20, 'Iron Fist', 'Iron Fist follows Danny Rand, a billionaire with the mystical power of the Iron Fist, as he returns to New York City to fight crime, face his past, and protect his family legacy.', 'Iron Fist is an American television series created by Scott Buck, based on the Marvel Comics character Danny Rand / Iron Fist. \\n Produced by Marvel Television and aired on Netflix, the series is part of the Marvel Cinematic Universe (MCU) and follows Danny Rand, a billionaire who returns to New York City after being presumed dead for years. Danny is the heir to a powerful corporation and is trained in the mystical arts of K\'un-Lun, where he becomes the Iron Fist, a hero capable of channeling his chi into an incredibly powerful punch. \\n\\n Finn Jones stars as Danny Rand / Iron Fist, with Jessica Henwick as Colleen Wing, Tom Pelphrey as Ward Meachum, and David Wenham as Harold Meachum. The show combines martial arts action with the exploration of corporate intrigue and Danny\'s internal struggle to balance his responsibilities as both a business heir and a superhero. \\n\\n Premiering on March 17, 2017, Iron Fist received mixed reviews, with praise for its fight choreography but criticism directed at the pacing and Jones\' portrayal of the lead character. Despite the criticism, the series ran for two seasons before being canceled in 2018. Iron Fist played a role in the larger Defenders universe, tying into shows like Daredevil, Jessica Jones, and Luke Cage.\n', '2017', '../../Series/iron_fist_mini.jpg', '../../Series/iron_fist.jpg', 55, '2025-05-03 14:56:31', '2025-05-05 15:12:30'),
(21, 'What If…?', 'What If…? explores alternate realities in the Marvel Universe, asking \"What if?\" pivotal moments in history had gone differently, presenting different outcomes for familiar heroes and villains.', 'What If…? is an American animated television series created by A.C. Bradley for Disney+, based on the Marvel Comics series of the same name. \\n The show is set in an alternate universe within the Marvel Cinematic Universe (MCU), exploring what might happen if key moments from the MCU films had unfolded differently. Each episode features a different \"what if\" scenario, such as what would have happened if Peggy Carter had taken the Super Soldier Serum instead of Steve Rogers, or if T\'Challa had become Star-Lord. \\n\\n The series features many of the original actors from the MCU, including Jeffrey Wright as The Watcher, who serves as the narrator and observer of these alternate realities. The animation style is distinct, with a focus on creating visually stunning and imaginative reimaginings of familiar MCU characters and stories. \\n\\n Premiering on August 11, 2021, What If…? was well-received for its creativity and ability to explore alternate versions of beloved characters and events. The show was praised for its unique storytelling, animation style, and voice performances, particularly from the MCU veterans. It also played a significant role in expanding the MCU multiverse, with potential for future crossovers in other MCU properties.\n', '2021', '../../Series/what_if_mini.jpg', '../../Series/what_if.jpg', 30, '2025-05-03 14:56:31', '2025-05-05 15:12:34'),
(22, 'Cloak & Dagger', 'Cloak & Dagger follows two teenagers, Tyrone and Tandy, who gain supernatural powers after a tragic event. They must navigate their new abilities and face a shared destiny in New Orleans.', 'Cloak & Dagger is an American television series created by Joe Pokaski, based on the Marvel Comics characters Tyrone Johnson / Cloak and Tandy Bowen / Dagger. \\n Produced by Marvel Television and aired on Freeform, the series is set in the Marvel Cinematic Universe (MCU) and follows the story of two teenagers, Tyrone and Tandy, who gain supernatural powers after a life-changing accident. Tyrone gains the ability to cloak himself and others in darkness, while Tandy can project light daggers. Together, they must learn to harness their powers while dealing with their traumatic pasts and uncovering a larger conspiracy. \\n\\n Olivia Holt stars as Tandy Bowen / Dagger, Aubrey Joseph as Tyrone Johnson / Cloak, with Gloria Reuben and James Saito in supporting roles. The show combines supernatural elements with social commentary on race, privilege, and class, making it a unique entry in the MCU television lineup. \\n\\n Premiering on June 7, 2018, Cloak & Dagger was praised for its character-driven storytelling and the chemistry between the leads. However, it was canceled after two seasons in 2019, despite its loyal fanbase and potential for future storytelling in the MCU.\n', '2018', '../../Series/cloak_dagger_mini.jpg', '../../Series/cloak_dagger.jpg', 50, '2025-05-03 14:56:31', '2025-05-05 15:12:39');

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
  `description` text DEFAULT NULL,
  `background_image` varchar(255) DEFAULT '../../Backgrounds/default_background.png',
  `posts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `followers` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `following` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pin` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `achivments` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `name`, `email`, `password`, `avatar`, `description`, `background_image`, `posts`, `followers`, `following`, `pin`, `achivments`, `balance`) VALUES
(1, 'Davit', 'SoloGamer', '101sologaming101@gmail.com', '$2y$10$ZHbcI3lri8KWBIe9gtpRuOiVomXzqV2XMZfcqI2mD8DevetzoAFMG', '../../Avatars/Davit_avatar.jpg\r\n', NULL, '../../Backgrounds/davit.png', 12, 777, 777, 27, 777, 0.00),
(5, 'GigaNiga', '', 'GigaNigaNiga@gmail.com', '$2y$10$nAsGrTsuILomjXVE.3p38uorwmpmnbEZAaD9N1Y8yRANl/HiCy82i', '../../Avatars/GigaNiga_avatar.png\r\n', NULL, '../../Backgrounds/default_background.png', 0, 0, 0, 0, 0, 0.00),
(6, 'Narek', '', 'narek@gmail.com', '$2y$10$/e.BmoOLkAh9UVOnXtpCD.qDdebuB7Ma8LC5GYVcQCjvD9rfciMpm', '../../Avatars/Defoult_avatar.png', NULL, '../../Backgrounds/default_background.png', 0, 0, 0, 0, 0, 0.00);

-- --------------------------------------------------------

--
-- Структура таблицы `user_pins`
--

CREATE TABLE `user_pins` (
  `id` int(10) UNSIGNED NOT NULL,
  `pin_name` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cover` varchar(255) DEFAULT '../../Covers/default_cover.svg',
  `description` text DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_pins`
--

INSERT INTO `user_pins` (`id`, `pin_name`, `user_id`, `created_at`, `cover`, `description`, `private`) VALUES
(1, 'Test 1', 1, '2025-05-12 13:08:00', '../../Covers/6821f2b0b9c1b.png', 'I have collected the best films and series where the power of feminists is stronger than ever. forward marvel feminism', 0),
(2, 'Test 2', 1, '2025-05-12 13:34:57', '../../Covers/default_cover.svg', 'Defoult description', 0),
(3, 'Test 3', 1, '2025-05-12 13:35:52', '../../Covers/default_cover.svg', 'Defoult description', 0),
(4, 'Test 4', 1, '2025-05-12 13:43:55', '../../Covers/6821fb1ba1c2a.png', 'Defoult description', 0),
(5, 'Test 5', 1, '2025-05-12 13:51:05', '../../Covers/default_cover.svg', 'Defoult description', 0);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `user_pins_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `user_pins_count` (
`user_id` int(10) unsigned
,`pinned_movie` bigint(21)
,`pinned_series` bigint(21)
,`total_pin` bigint(22)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `user_posts_count`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `user_posts_count` (
`user_id` int(10) unsigned
,`total_posts` bigint(21)
);

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

--
-- Дамп данных таблицы `user_ratings`
--

INSERT INTO `user_ratings` (`user_id`, `movie_id`, `rating`, `created_at`) VALUES
(1, 24, 5, '2025-05-08 19:23:29'),
(1, 28, 5, '2025-05-10 23:40:34'),
(5, 24, 5, '2025-05-05 16:04:59');

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
(1, 1, 44, '2025-05-06 22:47:22'),
(3, 1, 24, '2025-04-25 22:40:00'),
(16, 5, 44, '2025-05-13 18:28:50'),
(153, 1, 22, '2025-05-13 20:01:06'),
(238, 5, 47, '2025-04-28 01:22:23'),
(301, 1, 48, '2025-05-13 20:00:49'),
(303, 1, 50, '2025-05-13 20:07:12'),
(305, 6, 50, '2025-05-05 17:39:41'),
(316, 1, 49, '2025-05-06 22:43:47'),
(324, 1, 7, '2025-05-06 22:15:57'),
(331, 1, 10, '2025-05-06 22:21:01'),
(357, 1, 21, '2025-05-13 20:01:09'),
(358, 1, 16, '2025-05-13 20:01:27'),
(361, 1, 17, '2025-05-13 20:02:00');

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
-- Структура для представления `pin_likes_count`
--
DROP TABLE IF EXISTS `pin_likes_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pin_likes_count`  AS SELECT `up`.`id` AS `pin_id`, `up`.`pin_name` AS `pin_name`, `up`.`user_id` AS `owner_id`, count(`pl`.`user_id`) AS `like_count` FROM (`user_pins` `up` left join `pin_like` `pl` on(`up`.`id` = `pl`.`pin_id`)) GROUP BY `up`.`id`, `up`.`pin_name`, `up`.`user_id` ;

-- --------------------------------------------------------

--
-- Структура для представления `pin_views_count`
--
DROP TABLE IF EXISTS `pin_views_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pin_views_count`  AS SELECT `up`.`id` AS `pin_id`, `up`.`pin_name` AS `pin_name`, `up`.`user_id` AS `owner_id`, count(`pv`.`user_id`) AS `view_count` FROM (`user_pins` `up` left join `pin_view` `pv` on(`up`.`id` = `pv`.`pin_id`)) GROUP BY `up`.`id`, `up`.`pin_name`, `up`.`user_id` ;

-- --------------------------------------------------------

--
-- Структура для представления `series_ratings_view`
--
DROP TABLE IF EXISTS `series_ratings_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `series_ratings_view`  AS SELECT `s`.`id` AS `series_id`, `s`.`title` AS `title`, round(avg(`usr`.`rating`),1) AS `average_rating`, count(`usr`.`rating`) AS `ratings_count` FROM (`series` `s` left join `user_series_ratings` `usr` on(`usr`.`series_id` = `s`.`id`)) GROUP BY `s`.`id` ;

-- --------------------------------------------------------

--
-- Структура для представления `user_pins_count`
--
DROP TABLE IF EXISTS `user_pins_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_pins_count`  AS SELECT `up`.`user_id` AS `user_id`, count(distinct `pm`.`movie_id`) AS `pinned_movie`, count(distinct `ps`.`series_id`) AS `pinned_series`, count(distinct `pm`.`movie_id`) + count(distinct `ps`.`series_id`) AS `total_pin` FROM ((`user_pins` `up` left join `pin_movie` `pm` on(`up`.`id` = `pm`.`pin_id`)) left join `pin_series` `ps` on(`up`.`id` = `ps`.`pin_id`)) GROUP BY `up`.`user_id` ;

-- --------------------------------------------------------

--
-- Структура для представления `user_posts_count`
--
DROP TABLE IF EXISTS `user_posts_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_posts_count`  AS SELECT `u`.`ID` AS `user_id`, count(`p`.`ID`) AS `total_posts` FROM (`users` `u` left join `forum` `p` on(`u`.`ID` = `p`.`user_id`)) GROUP BY `u`.`ID`, `u`.`name` ;

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
-- Индексы таблицы `pin_like`
--
ALTER TABLE `pin_like`
  ADD PRIMARY KEY (`pin_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `pin_movie`
--
ALTER TABLE `pin_movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pin_id` (`pin_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Индексы таблицы `pin_series`
--
ALTER TABLE `pin_series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pin_id` (`pin_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Индексы таблицы `pin_view`
--
ALTER TABLE `pin_view`
  ADD PRIMARY KEY (`pin_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `premium_subscriptions`
--
ALTER TABLE `premium_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Индексы таблицы `user_pins`
--
ALTER TABLE `user_pins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `comments_likes`
--
ALTER TABLE `comments_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `forum`
--
ALTER TABLE `forum`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `pin_movie`
--
ALTER TABLE `pin_movie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `pin_series`
--
ALTER TABLE `pin_series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `premium_subscriptions`
--
ALTER TABLE `premium_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `user_pins`
--
ALTER TABLE `user_pins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

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
-- Ограничения внешнего ключа таблицы `pin_like`
--
ALTER TABLE `pin_like`
  ADD CONSTRAINT `pin_like_ibfk_1` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pin_like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pin_movie`
--
ALTER TABLE `pin_movie`
  ADD CONSTRAINT `pin_movie_ibfk_1` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pin_movie_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pin_series`
--
ALTER TABLE `pin_series`
  ADD CONSTRAINT `pin_series_ibfk_1` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pin_series_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pin_view`
--
ALTER TABLE `pin_view`
  ADD CONSTRAINT `pin_view_ibfk_1` FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pin_view_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `premium_subscriptions`
--
ALTER TABLE `premium_subscriptions`
  ADD CONSTRAINT `premium_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

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
-- Ограничения внешнего ключа таблицы `user_pins`
--
ALTER TABLE `user_pins`
  ADD CONSTRAINT `user_pins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

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
