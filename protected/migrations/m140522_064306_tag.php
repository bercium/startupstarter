<?php

class m140522_064306_tag extends CDbMigration
{
	public function up()
	{

		$this->execute("CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");


$this->execute("CREATE TABLE IF NOT EXISTS `tag_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`,`user_id`,`added_by`,`revoked_by`),
  KEY `user_id` (`user_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");


$this->execute("CREATE TABLE IF NOT EXISTS `tag_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `event_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `event_id` (`event_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");


$this->execute("CREATE TABLE IF NOT EXISTS `tag_idea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `idea_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `added_by` (`added_by`),
  KEY `tag_id` (`tag_id`,`idea_id`,`revoked_by`),
  KEY `idea_id` (`idea_id`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;");


$this->execute("CREATE TABLE IF NOT EXISTS `tag_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `added_by` int(11) unsigned NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked_by` int(11) unsigned DEFAULT NULL,
  `revoked_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`,`user_id`,`added_by`,`revoked_by`),
  KEY `user_id` (`user_id`),
  KEY `added_by` (`added_by`),
  KEY `revoked_by` (`revoked_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");


$this->execute("ALTER TABLE `tag_admin`
  ADD CONSTRAINT `tag_admin_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_admin_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

$this->execute("ALTER TABLE `tag_event`
  ADD CONSTRAINT `tag_event_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_event_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

$this->execute("ALTER TABLE `tag_idea`
  ADD CONSTRAINT `tag_idea_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_idea_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

$this->execute("ALTER TABLE `tag_user`
  ADD CONSTRAINT `tag_user_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_user_ibfk_4` FOREIGN KEY (`revoked_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m140522_064306_tag does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}