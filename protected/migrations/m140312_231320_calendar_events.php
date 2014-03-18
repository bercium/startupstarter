<?php

class m140312_231320_calendar_events extends CDbMigration
{
	public function up()
	{
    $this->execute("
      CREATE TABLE IF NOT EXISTS `event` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        `all_day` tinyint(1) NOT NULL,
        `content` varchar(1500) DEFAULT NULL,
        `link` varchar(255) DEFAULT NULL,
        `location` varchar(255) DEFAULT NULL,
        `source` varchar(128) DEFAULT NULL,
        `color` varchar(50) DEFAULT NULL,
        `city` varchar(128) DEFAULT NULL,
        `country` varchar(128) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");    
	}

	public function down()
	{
		echo "m140312_231320_calendar_events does not support migration down.\n";
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