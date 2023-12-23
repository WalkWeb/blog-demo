<?php

declare(strict_types=1);

namespace Migrations;

use NW\Connection;

class Version_2023_12_23_21_32_25_28
{
    public function run(Connection $connection): void
    {
        $connection->query('
            CREATE TABLE `era` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(20) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `seasons` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(20) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `races` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `icon` VARCHAR(50) NOT NULL,
              `plural` VARCHAR(50) NOT NULL,
              `single` VARCHAR(50) NOT NULL,
            
              `STR`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `INT`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `DEX`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `WILL` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `END`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `PERC` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `CHAR` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
              `LUCK` SMALLINT UNSIGNED NOT NULL DEFAULT 0
            
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');
        $connection->query('
            CREATE TABLE `floors` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `plural` VARCHAR(50) NOT NULL,
              `single` VARCHAR(50) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `account_status` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `status` VARCHAR(20) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `account_group` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `plural` VARCHAR(30) NOT NULL,
              `single` VARCHAR(30) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `avatars` (
              `id` MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `url` VARCHAR(90) NOT NULL,
              `race_id` TINYINT UNSIGNED NOT NULL,
              `floor_id` TINYINT UNSIGNED NOT NULL,
              FOREIGN KEY (`race_id`) REFERENCES `races`(`id`),
              FOREIGN KEY (`floor_id`) REFERENCES `floors`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `account_energy` (
              `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `energy` SMALLINT UNSIGNED NOT NULL DEFAULT 100,
              `time` DECIMAL(20,4) NOT NULL,
              `residue` TINYINT UNSIGNED NOT NULL DEFAULT 0
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `chat_channel` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(50) NOT NULL,     # Название канала
              `lvl` TINYINT UNSIGNED NOT NULL, # Минимальный уровень для доступа к нему
              `race_id` TINYINT UNSIGNED,      # Ограничение по расе (NULL - нет ограничения)
              FOREIGN KEY (`race_id`) REFERENCES `races`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `chat_status_message` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `status` VARCHAR(50) NOT NULL # Название статуса 1 - Обычное, 2 - Удаленное, 3 - Объявление, 4 - Глобальное объявление
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `chat_status_account` (
              `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `status` VARCHAR(50) NOT NULL, # Название статуса 1 - Доступен, 2 - Только чтение, 3 - Доступ к чату закрыт, 4 - Модератор
              `channel_id` TINYINT UNSIGNED,   # Если статус модератора (4) - то здесь указывается номер канала, к которому даны модераторские права
              FOREIGN KEY (`channel_id`) REFERENCES `chat_channel`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        $connection->query('
            CREATE TABLE `accounts` (
              `id`             VARCHAR(36) NOT NULL PRIMARY KEY,            # ID
              `login`          VARCHAR(20) UNIQUE NOT NULL,                 # Login
              `name`           VARCHAR(20) UNIQUE NOT NULL,                 # Отображаемое имя
              `pass`           VARCHAR(60) NOT NULL,                        # хеш пароля
              `hash`           VARCHAR(65) NOT NULL,                        # хеш для авторизации
              `reg_date`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,         # дата регистрации
              `ip`             VARCHAR(16) NOT NULL,                        # IP при регистрации
              `ref`            VARCHAR(30) NOT NULL,                        # реферальный ключ
              `mail`           VARCHAR(30) UNIQUE NOT NULL,                 # почта
              `floor_id`       TINYINT UNSIGNED NOT NULL,                   # id пола
              `status_id`      TINYINT UNSIGNED NOT NULL DEFAULT 1,         # id статуса
              `group_id`       TINYINT UNSIGNED NOT NULL DEFAULT 1,         # id группы
              `char_visible`   TINYINT UNSIGNED NOT NULL DEFAULT 1,         # Видимость персонажей аккаунта. 1 - видны, 0 - скрыты
              `energy_id`      INT UNSIGNED NOT NULL,                       # id записи в таблице `energy`
              `char_active_id` INT UNSIGNED,                                # id активного (выбранного) персонажа
              `chat_status_id` TINYINT UNSIGNED NOT NULL DEFAULT 1,         # id статуса аккаунта в чате
              `upload`         INT UNSIGNED NOT NULL DEFAULT 0,             # суммарный вес файлов, загруженных пользователем
              `help`           TINYINT UNSIGNED NOT NULL DEFAULT 0,         # нужно ли показывать помощь по интерфейсу при входе в локацию
              `notice`         TINYINT UNSIGNED NOT NULL DEFAULT 0,         # есть ли у пользователя активные уведомления
              `user_agent`     VARCHAR(100) NOT NULL DEFAULT \'undefined\', # информация userAgent полученная от браузера
              `can_like`       TINYINT NOT NULL DEFAULT 1,
            
              FOREIGN KEY (`floor_id`) REFERENCES `floors`(`id`),
              FOREIGN KEY (`status_id`) REFERENCES `account_status`(`id`),
              FOREIGN KEY (`group_id`) REFERENCES `account_group`(`id`),
              FOREIGN KEY (`energy_id`) REFERENCES `account_energy`(`id`),
              FOREIGN KEY (`chat_status_id`) REFERENCES `chat_status_account`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        echo "run Version_2023_12_23_21_32_25_28\n";
    }
}
