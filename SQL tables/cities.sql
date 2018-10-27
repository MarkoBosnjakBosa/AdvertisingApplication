CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publication_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;