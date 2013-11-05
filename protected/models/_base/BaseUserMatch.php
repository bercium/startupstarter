<?php

/**
 * This is the model base class for the table "user_match".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UserMatch".
 *
 * Columns in table "user_match" available as properties of the model,
 * followed by relations of table "user_match" available as properties of the model.
 *
 * @property string $id
 * @property string $user_id
 * @property string $available
 * @property integer $country_id
 * @property string $city_id
 *
 * @property IdeaMember[] $ideaMembers
 * @property UserCollabpref[] $userCollabprefs
 * @property City $city
 * @property Country $country
 * @property User $user
 * @property UserSkill[] $userSkills
 */
abstract class BaseUserMatch extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_match';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User match|User matches', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			//array('available', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('available', 'length', 'max'=>2),
			array('city_id', 'length', 'max'=>10),
			array('user_id, available, country_id, city_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, user_id, available, country_id, city_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'ideaMembers' => array(self::HAS_MANY, 'IdeaMember', 'match_id'),
			'userCollabprefs' => array(self::HAS_MANY, 'UserCollabpref', 'match_id'),
			'available' => array(self::BELONGS_TO, 'Available', 'available'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'userSkills' => array(self::HAS_MANY, 'UserSkill', 'match_id'),
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
			'available' => Yii::t('app', 'Available'),
			'country_id' => Yii::t('app', 'Country'),
			'city_id' => Yii::t('app', 'City'),
			'ideaMembers' => null,
			'userCollabprefs' => null,
			'city' => Yii::t('app', 'City'),
			'country' => Yii::t('app', 'Country'),
			'user' => Yii::t('app', 'User'),
			'userSkills' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('available', $this->available);
		$criteria->compare('country_id', $this->country_id);
		$criteria->compare('city_id', $this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}