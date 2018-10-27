CREATE TABLE `home_page_description` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `home_page_description`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `home_page_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;