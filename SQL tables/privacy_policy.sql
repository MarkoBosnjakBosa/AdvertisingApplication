CREATE TABLE `privacy_policy` (
  `id` int(11) NOT NULL,
  `privacy_policy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `privacy_policy`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `privacy_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;