<?php

class m140128_075830_user_tag extends CDbMigration
{
	public function up()
	{
    $this->execute("CREATE TABLE IF NOT EXISTS `user_tag` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(10) unsigned NOT NULL,
      `tag` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;");
    $this->execute("ALTER TABLE `user_tag` ADD `applied_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;");
	}

	public function down()
	{
		echo "m140128_075830_user_tag does not support migration down.\n";
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