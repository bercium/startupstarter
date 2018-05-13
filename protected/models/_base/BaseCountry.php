<?php

/**
 * This is the model base class for the table "country".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Country".
 *
 * Columns in table "country" available as properties of the model,
 * followed by relations of table "country" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 *
 */
abstract class BaseCountry extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'country';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Country|Countries', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>32),
			array('country_code', 'required'),
			array('country_code', 'length', 'max'=>2),
			array('id, name, country_code', 'safe', 'on'=>'search'),
		);
	}

	/*public function relations() {
		return array(
			'userShares' => array(self::HAS_MANY, 'UserShare', 'country_id'),
			'userTmps' => array(self::HAS_MANY, 'UserTmp', 'country_id'),
		);
	}*/

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Country'),
      'country_code' => Yii::t('app', 'Country code'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('country_code', $this->country_code, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}