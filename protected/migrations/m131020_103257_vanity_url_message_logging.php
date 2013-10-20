<?php

class m131020_103257_vanity_url_message_logging extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `user` ADD `vanityURL` VARCHAR( 128 ) NULL ");
		$this->execute("ALTER TABLE `idea` ADD `vanityURL` VARCHAR( 128 ) NULL ");
    
    $this->execute("CREATE TABLE IF NOT EXISTS `message` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_from_id` int(11) NOT NULL,
      `user_to_id` int(11) DEFAULT NULL,
      `idea_to_id` int(11) DEFAULT NULL,
      `time_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `message` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
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