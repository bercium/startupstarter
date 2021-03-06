<?php

/**
 * This is the model base class for the table "user_link".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UserLink".
 *
 * Columns in table "user_link" available as properties of the model,
 * followed by relations of table "user_link" available as properties of the model.
 *
 * @property string $id
 * @property string $user_id
 * @property string $link_id
 *
 * @property Link $link
 * @property User $user
 */
abstract class BaseUserLink extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_link';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Link|Links', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('user_id, title, url', 'required'),
			array('url', 'url', 'defaultScheme' => 'http'),
			array('user_id', 'length', 'max'=>8),
			array('id, user_id, link_id', 'safe', 'on'=>'search'),
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
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}