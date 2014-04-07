<?php

class m140312_231320_calendar_events extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `event_cofinder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) unsigned NOT NULL,
  `price_person` smallint(3) unsigned NOT NULL,
  `price_idea` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->execute("ALTER TABLE `event_cofinder`
  ADD CONSTRAINT `event_cofinder_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
 

    $this->execute("CREATE TABLE IF NOT EXISTS `event_signup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idea_id` int(11) unsigned NOT NULL,
  `payment` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

    $this->execute("ALTER TABLE  `event_signup` ADD  `survey` TEXT NOT NULL ;");

$this->execute("ALTER TABLE `event_signup`
  ADD CONSTRAINT `event_signup_ibfk_3` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_signup_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_signup_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

$this->execute("ALTER TABLE  `event_signup` CHANGE  `idea_id`  `idea_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;");

$this->execute("ALTER TABLE  `event_signup` ADD  `referrer_id` INT( 11 ) UNSIGNED NOT NULL ,
ADD INDEX (  `referrer_id` ) ;");

$this->execute("ALTER TABLE  `event_signup` ADD FOREIGN KEY (  `referrer_id` ) REFERENCES  `cofinder`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");

$this->execute("ALTER TABLE  `event_signup` CHANGE  `referrer_id`  `referrer_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;");

$this->execute("ALTER TABLE  `event_signup` ADD FOREIGN KEY (  `referrer_id` ) REFERENCES  `cofinder`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");

	}

	public function down()
	{
		echo "m140512_102424_event does not support migration down.\n";
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