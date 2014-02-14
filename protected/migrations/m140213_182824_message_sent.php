<?php

class m140213_182824_message_sent extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `message` ADD `time_viewed` TIMESTAMP NULL ;");
    $this->execute("ALTER TABLE `message` CHANGE `time_sent` `time_sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;");
    
    $this->execute("CREATE TABLE IF NOT EXISTS `mail_log` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `type` varchar(100) DEFAULT NULL,
      `user_to_id` int(10) unsigned NOT NULL,
      `time_send` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `time_open` timestamp NULL DEFAULT NULL,
      `extra_id` int(10) unsigned DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `user_to_id` (`user_to_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    $this->execute("ALTER TABLE `mail_log` ADD CONSTRAINT `mail_log_ibfk_1` FOREIGN KEY (`user_to_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
    
     $this->execute("CREATE TABLE IF NOT EXISTS `mail_click_log` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `mail_id` int(10) unsigned NOT NULL,
        `link` varchar(255) NOT NULL,
        `time_clicked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `button_name` varchar(200) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `mail_id` (`mail_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
     
      $this->execute("ALTER TABLE `mail_click_log` ADD CONSTRAINT `mail_click_log_ibfk_1` FOREIGN KEY (`mail_id`) REFERENCES `mail_log` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

	}

	public function down()
	{
		echo "m140213_182824_message_sent does not support migration down.\n";
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