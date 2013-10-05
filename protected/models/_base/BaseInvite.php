<?php

/**
 * This is the model base class for the table "invite".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Invite".
 *
 * Columns in table "invite" available as properties of the model,
 * followed by relations of table "invite" available as properties of the model.
 *
 * @property integer $id
 * @property string $id_sender
 * @property string $key
 * @property string $email
 * @property string $id_idea
 * @property string $id_receiver
 *
 * @property User $idSender
 * @property Idea $idIdea
 * @property User $idReceiver
 */
abstract class BaseInvite extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'invite';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Invite|Invites', $n);
	}

	public static function representingColumn() {
		return 'email';
	}

	public function rules() {
		return array(
			array('email', 'required'),
			array('email', 'email'),
      		array('email', 'unique', 'criteria'=>array(
            'condition'=>'`idea_id`=:ideaId OR ISNULL(idea_id)',
            'params'=>array(
                ':ideaId'=>$this->idea_id,
            )
        )),        
			array('sender_id, idea_id, receiver_id', 'length', 'max'=>11),
			array('key, email', 'length', 'max'=>50),
			array('key, idea_id, receiver_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('time_invited', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			array('id, sender_id, key, email, idea_id, receiver_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'senderId' => array(self::BELONGS_TO, 'User', 'sender_id'),
			'ideaId' => array(self::BELONGS_TO, 'Idea', 'idea_id'),
			'receiverId' => array(self::BELONGS_TO, 'User', 'receiver_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'sender_id' => null,
			'key' => Yii::t('app', 'Key'),
			'email' => Yii::t('app', 'Email'),
			'idea_id' => null,
			'receiver_id' => null,
			'senderId' => null,
			'ideaId' => null,
			'receiverId' => null,
			'time_invited' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('sender_id', $this->sender_id);
		$criteria->compare('key', $this->key, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('idea_id', $this->idea_id);
		$criteria->compare('receiver_id', $this->receiver_id);
		$criteria->compare('time_invited', $this->time_invited);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
