CREATE TABLE `home_page_pictures` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `home_page_pictures`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `home_page_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;