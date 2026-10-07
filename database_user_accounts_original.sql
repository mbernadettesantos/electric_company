CREATE TABLE `user_accounts` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
);

INSERT INTO `user_accounts`
(`username`, `password`, `name`)
VALUES
('admin', 'admin123', 'Administrator');