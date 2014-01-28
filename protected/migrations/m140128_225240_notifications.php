<?php

class m140128_225240_notifications extends CDbMigration
{
	public function up()
	{
    $this->execute("CREATE TABLE IF NOT EXISTS `notification` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(10) unsigned NOT NULL,
                    `type` int(11) NOT NULL,
                    `notify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `viewed` tinyint(1) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`),
                    KEY `user_id` (`user_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

    $this->execute("ALTER TABLE `notification` ADD FOREIGN KEY ( `user_id` ) REFERENCES `slocoworking`.`user` (`id` ) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m140128_225240_notifications does not support migration down.\n";
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