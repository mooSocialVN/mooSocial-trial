CREATE TABLE IF NOT EXISTS `{PREFIX}storage_aws_object_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(2048) NOT NULL,
  `url` varchar(2048) NOT NULL,
  `size` int(11) NOT NULL,
  `bucket` varchar(200) NOT NULL,
  `key` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `{PREFIX}storage_aws_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(10) NOT NULL,
  `oid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(2048) NOT NULL DEFAULT '',
  `path` varchar(2048) NOT NULL DEFAULT '',
  `bucket` varchar(200) NOT NULL DEFAULT '',
  `key` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `{PREFIX}storage_aws_object_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
);