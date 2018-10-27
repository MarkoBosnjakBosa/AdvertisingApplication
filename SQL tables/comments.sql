CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `mother_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `username` varchar(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `publication_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `comments`
  ADD FOREIGN KEY (ad_id) REFERENCES ads(id);
  