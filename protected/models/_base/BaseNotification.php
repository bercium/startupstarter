<?php

/**
 * This is the model base class for the table "notification".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Notification".
 *
 * Columns in table "notification" available as properties of the model,
 * followed by relations of table "notification" available as properties of the model.
 *
 * @property string $id
 * @property string $user_id
 * @property integer $type
 * @property string $notify_at
 * @property integer $viewed
 *
 * @property User $user
 */
abstract class BaseNotification extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'notification';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Notification|Notifications', $n);
	}

	public static function representingColumn() {
		return 'notify_at';
	}

	public function rules() {
		return array(
			array('user_id, type', 'required'),
			array('type, viewed', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('viewed', 'default', 'setOnEmpty' => true, 'value' => null),
      array('notify_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			array('id, user_id, type, notify_at, viewed', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'user_id' => null,
			'type' => Yii::t('app', 'Type'),
			'notify_at' => Yii::t('app', 'Notify At'),
			'viewed' => Yii::t('app', 'Viewed'),
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('type', $this->type);
		$criteria->compare('notify_at', $this->notify_at, true);
		$criteria->compare('viewed', $this->viewed);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
    
    public function scopes() {
        return array(
            'bynotifyat' => array('order' => 'notify_at'),
        );
    }
}