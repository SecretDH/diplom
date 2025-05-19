-- Таблица для именованных списков пинов пользователя
CREATE TABLE `user_pins` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pin_name` VARCHAR(255) NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `description` TEXT NULL,
  `cover` VARCHAR(255) NOT NULL DEFAULT '../../Covers/default_cover.jpg',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `private` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Таблица для пинов фильмов
CREATE TABLE `pin_movie` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pin_id` INT(10) UNSIGNED NOT NULL,
  `movie_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Таблица для пинов сериалов
CREATE TABLE `pin_series` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pin_id` INT(10) UNSIGNED NOT NULL,
  `series_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pin_view` (
  `pin_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`pin_id`, `user_id`),
  FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pin_like` (
  `pin_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`pin_id`, `user_id`),
  FOREIGN KEY (`pin_id`) REFERENCES `user_pins` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE VIEW `user_pins_count` AS
SELECT 
    up.user_id,
    up.id AS pin_id,
    up.pin_name,
    COALESCE(SUM(CASE WHEN pm.id IS NOT NULL THEN 1 ELSE 0 END), 0) AS movie_pins,
    COALESCE(SUM(CASE WHEN ps.id IS NOT NULL THEN 1 ELSE 0 END), 0) AS series_pins,
    COALESCE(SUM(CASE WHEN pm.id IS NOT NULL THEN 1 ELSE 0 END), 0) + 
    COALESCE(SUM(CASE WHEN ps.id IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_pins
FROM `user_pins` up
LEFT JOIN `pin_movie` pm ON up.id = pm.pin_id
LEFT JOIN `pin_series` ps ON up.id = ps.pin_id
GROUP BY up.user_id, up.id, up.pin_name;

CREATE VIEW `pin_views_count` AS
SELECT 
    up.`id` AS pin_id,
    up.`pin_name`,
    up.`user_id` AS owner_id,
    COUNT(pv.`user_id`) AS view_count
FROM `user_pins` up
LEFT JOIN `pin_view` pv ON up.`id` = pv.`pin_id`
GROUP BY up.`id`, up.`pin_name`, up.`user_id`;

CREATE VIEW `pin_likes_count` AS
SELECT 
    up.`id` AS pin_id,
    up.`pin_name`,
    up.`user_id` AS owner_id,
    COUNT(pl.`user_id`) AS like_count
FROM `user_pins` up
LEFT JOIN `pin_like` pl ON up.`id` = pl.`pin_id`
GROUP BY up.`id`, up.`pin_name`, up.`user_id`;


1. Активация премиум-подписки
START TRANSACTION;
UPDATE `users`
SET `balance` = `balance` - 10.00
WHERE `ID` = 1 AND `balance` >= 10.00;
INSERT INTO `premium_subscriptions` (`user_id`, `expires_at`, `cost`)
SELECT 
    1 AS user_id,
    DATE_ADD(NOW(), INTERVAL 30 DAY) AS expires_at,
    10.00 AS cost
FROM `users`
WHERE `ID` = 1 AND `balance` >= 10.00
LIMIT 1;
COMMIT;

2. Проверка статуса премиума
SELECT 
    u.`ID`,
    u.`name`,
    u.`balance`,
    CASE 
        WHEN ps.`id` IS NOT NULL AND ps.`expires_at` > NOW() THEN 'Active'
        ELSE 'Inactive'
    END AS premium_status,
    ps.`expires_at`
FROM `users` u
LEFT JOIN `premium_subscriptions` ps 
    ON u.`ID` = ps.`user_id` 
    AND ps.`expires_at` > NOW()
WHERE u.`ID` = 1;

3. Ограничение количества списков пинов
SELECT 
    u.`ID`,
    COUNT(up.`id`) AS pin_list_count,
    CASE 
        WHEN ps.`id` IS NOT NULL AND ps.`expires_at` > NOW() THEN 10
        ELSE 2
    END AS max_pin_lists
FROM `users` u
LEFT JOIN `user_pins` up ON u.`ID` = up.`user_id`
LEFT JOIN `premium_subscriptions` ps 
    ON u.`ID` = ps.`user_id` 
    AND ps.`expires_at` > NOW()
WHERE u.`ID` = 1
GROUP BY u.`ID`;

4. Ограничение количества пинов
SELECT 
    u.`ID`,
    (SELECT COUNT(*) FROM `pin_movie` pm 
     JOIN `user_pins` up ON pm.`pin_id` = up.`id` 
     WHERE up.`user_id` = u.`ID`) +
    (SELECT COUNT(*) FROM `pin_series` ps 
     JOIN `user_pins` up ON ps.`pin_id` = up.`id` 
     WHERE up.`user_id` = u.`ID`) AS total_pins,
    CASE 
        WHEN ps.`id` IS NOT NULL AND ps.`expires_at` > NOW() THEN 50
        ELSE 20
    END AS max_pins
FROM `users` u
LEFT JOIN `premium_subscriptions` ps 
    ON u.`ID` = ps.`user_id` 
    AND ps.`expires_at` > NOW()
WHERE u.`ID` = 1;

5. Проверка истекших подписок
SELECT 
    `user_id`,
    `expires_at`
FROM `premium_subscriptions`
WHERE `expires_at` <= NOW();

6. Пополнение баланса (для тестов)
UPDATE `users`
SET `balance` = `balance` + 20.00
WHERE `ID` = 1;


