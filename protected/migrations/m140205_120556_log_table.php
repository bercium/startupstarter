<?php

class m140205_120556_log_table extends CDbMigration
{
	public function up(){
    $this->execute("CREATE TABLE `action_log` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(10) unsigned DEFAULT NULL,
                    `ipaddress` varchar(50) NOT NULL,
                    `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `controller` varchar(255) NOT NULL DEFAULT '',
                    `action` varchar(255) NOT NULL DEFAULT '',
                    `details` text,
                    PRIMARY KEY (`id`)
                   ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    
	}

	public function down()
	{
		echo "m140205_120556_log_table does not support migration down.\n";
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