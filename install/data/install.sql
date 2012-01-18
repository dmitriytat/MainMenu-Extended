DROP TABLE IF EXISTS `cms_menu_count`;
CREATE TABLE IF NOT EXISTS `cms_menu_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `code` text NOT NULL,
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `cms_menu_count` (`name`, `code`) VALUES
('от галлереи', 'counters::gallery'),
('от библиотеки', 'counters::library'),
('от загрузок', 'counters::downloads'),
('от форума', 'counters::forum'),
('от гостевой', 'counters::guestbook'),
('от пользователей', 'counters::users'),
('от альбомов', 'counters::album');

DROP TABLE IF EXISTS `cms_menu_group`;
CREATE TABLE IF NOT EXISTS `cms_menu_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos` int(11) NOT NULL,
  `pic` text NOT NULL,
  `name` text NOT NULL,
  `show` int(2) NOT NULL,
  `sumbo` text NOT NULL,
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `cms_menu_group` (`pos`, `pic`, `name`, `show`, `sumbo`) VALUES
(1, 'page_white_edit.png', 'Общение', 1, ''),
(2, 'disk.png', 'Полезное', 1, ''),
(3, 'award_star_gold.png', 'Актив сайта', 1, ''),
(4, 'anchor.png', 'Ссылки', 1, '');

DROP TABLE IF EXISTS `cms_menu_link`;
CREATE TABLE IF NOT EXISTS `cms_menu_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos` int(11) NOT NULL,
  `pic` text NOT NULL,
  `type` int(11) NOT NULL,
  `show` int(2) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `group` text NOT NULL,
  `sumbo` text NOT NULL,
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `cms_menu_link` (`pos`, `pic`, `type`, `show`, `name`, `link`, `group`, `sumbo`) VALUES
(3, '', 2, 1, 'Библиотека', 'library/', '2', ''),
(2, '', 6, 1, 'Пользователи', 'users/index.php', '3', ''),
(3, '', 1, 1, 'Галерея', 'gallery/', '2', ''),
(1, '', 7, 1, 'Фотоальбомы', 'users/album.php', '3', ''),
(1, '', 3, 1, 'Загрузки', 'download/', '2', ''),
(2, '', 4, 1, 'Форум', 'forum/', '1', ''),
(1, '', 5, 1, 'Гостевая', 'guestbook/index.php', '1', ''),
(1, '', 0, 1, 'Gazenwagen', 'http://gazenwagen.com/', '4', ''),
(2, '', 0, 1, 'Dimko`s blog', 'http://dimkos.ru', '4', '');

DROP TABLE IF EXISTS `cms_menu_settings`;
CREATE TABLE IF NOT EXISTS `cms_menu_settings` (
  `key` tinytext NOT NULL,
  `val` text NOT NULL,
  PRIMARY KEY (`key`(30))
)
CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `cms_menu_settings` (`key`, `val`) VALUES
('enabled', '1'),
('pic_path', 'pic'),
('pic_cat', '0');
