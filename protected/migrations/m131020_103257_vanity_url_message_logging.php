<?php

class m131020_103257_vanity_url_message_logging extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `user` ADD `vanityURL` VARCHAR( 128 ) NULL ");
		$this->execute("ALTER TABLE `idea` ADD `vanityURL` VARCHAR( 128 ) NULL ");
    
    $this->execute("CREATE TABLE IF NOT EXISTS `message` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_from_id` int(11) unsigned NOT NULL,
          `user_to_id` int(11) unsigned DEFAULT NULL,
          `idea_to_id` int(11) unsigned DEFAULT NULL,
          `time_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `message` text NOT NULL,
          PRIMARY KEY (`id`),
          KEY `user_from_id` (`user_from_id`),
          KEY `user_to_id` (`user_to_id`),
          KEY `idea_to_id` (`idea_to_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    $this->execute("ALTER TABLE `message`
      ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`idea_to_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_from_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`user_to_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");    
    
	}

	public function down()
	{
		echo "m131020_103257_vanity_url_message_logging does not support migration down.\n";
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