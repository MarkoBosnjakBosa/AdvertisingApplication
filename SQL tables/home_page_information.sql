CREATE TABLE `home_page_information` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `home_page_information`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `home_page_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;