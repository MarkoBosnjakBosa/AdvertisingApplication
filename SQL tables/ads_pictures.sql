CREATE TABLE `ads_pictures` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ads_pictures`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `ads_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;