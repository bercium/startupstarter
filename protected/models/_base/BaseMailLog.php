<?php

/**
 * This is the model base class for the table "mail_log".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "MailLog".
 *
 * Columns in table "mail_log" available as properties of the model,
 * followed by relations of table "mail_log" available as properties of the model.
 *
 * @property string $id
 * @property string $type
 * @property string $user_to_id
 * @property string $time_send
 * @property string $time_open
 * @property string $extra_id
 *
 * @property MailClickLog[] $mailClickLogs
 * @property User $userTo
 */
abstract class BaseMailLog extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mail_log';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'MailLog|MailLogs', $n);
	}

	public static function representingColumn() {
		return 'time_send';
	}

	public function rules() {
		return array(
			array('user_to_id, time_send', 'required'),
			array('type', 'length', 'max'=>100),
			array('user_to_id, extra_id', 'length', 'max'=>10),
			array('time_open', 'safe'),
			array('type, time_open, extra_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, type, user_to_id, time_send, time_open, extra_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'mailClickLogs' => array(self::HAS_MANY, 'MailClickLog', 'mail_id'),
			'userTo' => array(self::BELONGS_TO, 'User', 'user_to_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'type' => Yii::t('app', 'Type'),
			'user_to_id' => null,
			'time_send' => Yii::t('app', 'Time Send'),
			'time_open' => Yii::t('app', 'Time Open'),
			'extra_id' => Yii::t('app', 'Extra'),
			'mailClickLogs' => null,
			'userTo' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('type', $this->type, true);
		$criteria->compare('user_to_id', $this->user_to_id);
		$criteria->compare('time_send', $this->time_send, true);
		$criteria->compare('time_open', $this->time_open, true);
		$criteria->compare('extra_id', $this->extra_id, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}