<?php

class m131207_111756_user_stat_table extends CDbMigration
{
	public function up()
	{
    $this->execute("
      CREATE TABLE IF NOT EXISTS `user_stat` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(10) unsigned NOT NULL,
        `completeness` int(11) NOT NULL DEFAULT '0',
        `invites_send` int(11) NOT NULL DEFAULT '0',
        `invites_registered` int(11) NOT NULL DEFAULT '0',
        `reputation` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    $this->execute("ALTER TABLE `user_stat` ADD UNIQUE (`user_id`)");
    
    $this->execute("ALTER TABLE `user_stat` ADD FOREIGN KEY ( `user_id` ) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;");
    
	}

	public function down()
	{
		echo "m131207_111756_user_stat_table does not support migration down.\n";
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