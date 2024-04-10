CREATE TABLE `clips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namespace` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `value` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `clipindex` (`namespace`,`name`),
  FULLTEXT KEY `clipcontent` (`value`)
);

CREATE TABLE `pointers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namespace` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `clipid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `namespace` (`namespace`,`name`),
  KEY `clipids` (`namespace`,`name`)
);
