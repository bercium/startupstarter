<?php

class m131005_151517_idea_link_fix extends CDbMigration
{
	public function up()
	{
    $this->execute('ALTER TABLE `invite` DROP INDEX `id_sender` ,
                    ADD INDEX `sender_id` ( `sender_id` )');

    $this->execute('ALTER TABLE `invite` DROP INDEX `id_idea` ,
                    ADD INDEX `idea_id` ( `idea_id` )');

    $this->execute('ALTER TABLE `invite` DROP INDEX `id_receiver` ,
                    ADD INDEX `receiver_id` ( `receiver_id` ) ');
	}

	public function down()
	{
		echo "m131005_151517_idea_link_fix does not support migration down.\n";
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