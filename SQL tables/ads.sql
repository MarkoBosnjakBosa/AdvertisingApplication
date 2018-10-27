CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `ad_picture` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `publication_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;