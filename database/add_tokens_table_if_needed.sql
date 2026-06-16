-- Add this table if your database does not already have bearer tokens.
CREATE TABLE IF NOT EXISTS `tokens` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`token_id`),
  UNIQUE KEY `token_unique` (`token`),
  KEY `fk_tokens_users` (`user_id`),
  CONSTRAINT `fk_tokens_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
