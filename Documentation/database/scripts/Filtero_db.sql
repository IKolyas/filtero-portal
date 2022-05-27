CREATE TABLE `activity_types` (
  `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL
);

CREATE TABLE `institutes` (
  `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL
);

CREATE TABLE `users` (
  `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `login` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `is_admin` TINYINT DEFAULT 0
);

CREATE TABLE `activities` (
  `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) UNIQUE NOT NULL,
  `institute_id` BIGINT,
  `activity_id` BIGINT,
  `age_from` INT,
  `age_to` INT,
  `amount_of_week` INT,
  `duration_time` INT,
  `price` FLOAT,
  `price_month` FLOAT,
  `contacts` TEXT,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  `user_id` BIGINT
);

ALTER TABLE `activities` ADD FOREIGN KEY (`activity_id`) REFERENCES `activity_types` (`id`);

ALTER TABLE `activities` ADD FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`);

ALTER TABLE `activities` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
