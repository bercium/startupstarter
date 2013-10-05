ALTER TABLE `invite` CHANGE `id_sender` `sender_id` INT( 11 ) UNSIGNED NULL 

ALTER TABLE `slocoworking`.`invite` DROP INDEX `id_sender` ,
ADD INDEX `sender_id` ( `sender_id` ) 

ALTER TABLE `slocoworking`.`invite` DROP INDEX `id_idea` ,
ADD INDEX `idea_id` ( `idea_id` ) 

ALTER TABLE `slocoworking`.`invite` DROP INDEX `id_receiver` ,
ADD INDEX `receiver_id` ( `receiver_id` ) 