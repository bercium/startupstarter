<?php

/**
 * This is the model base class for the table "tag_event".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TagEvent".
 *
 * Columns in table "tag_event" available as properties of the model,
 * followed by relations of table "tag_event" available as properties of the model.
 *
 * @property string $id
 * @property string $tag_id
 * @property string $event_id
 * @property string $added_by
 * @property string $added_time
 * @property string $revoked_by
 * @property string $revoked_time
 *
 * @property Tag $tag
 * @property Event $event
 * @property User $addedBy
 * @property User $revokedBy
 */
abstract class BaseTagEvent extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tag_event';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'TagEvent|TagEvents', $n);
	}

	public static function representingColumn() {
		return 'added_time';
	}

	public function rules() {
		return array(
			array('tag_id, event_id, added_by, added_time', 'required'),
			array('tag_id, event_id, added_by, revoked_by', 'length', 'max'=>11),
			array('revoked_time', 'safe'),
			array('revoked_by, revoked_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, tag_id, event_id, added_by, added_time, revoked_by, revoked_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'addedBy' => array(self::BELONGS_TO, 'User', 'added_by'),
			'revokedBy' => array(self::BELONGS_TO, 'User', 'revoked_by'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'tag_id' => null,
			'event_id' => null,
			'added_by' => null,
			'added_time' => Yii::t('app', 'Added Time'),
			'revoked_by' => null,
			'revoked_time' => Yii::t('app', 'Revoked Time'),
			'tag' => null,
			'event' => null,
			'addedBy' => null,
			'revokedBy' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('tag_id', $this->tag_id);
		$criteria->compare('event_id', $this->event_id);
		$criteria->compare('added_by', $this->added_by);
		$criteria->compare('added_time', $this->added_time, true);
		$criteria->compare('revoked_by', $this->revoked_by);
		$criteria->compare('revoked_time', $this->revoked_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}