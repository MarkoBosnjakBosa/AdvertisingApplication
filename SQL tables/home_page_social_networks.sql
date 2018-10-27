CREATE TABLE `home_page_social_networks` (
  `id` int(11) NOT NULL,
  `facebook_url` varchar(255) NOT NULL,
  `twitter_url` varchar(255) NOT NULL,
  `instagram_url` varchar(255) NOT NULL,
  `linkedin_url` varchar(255) NOT NULL,
  `youtube_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `home_page_social_networks`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `home_page_social_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;