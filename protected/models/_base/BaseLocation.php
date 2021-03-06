<?php

/**
 * This is the model base class for the table "location".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Location".
 *
 * Columns in table "location" available as properties of the model,
 * followed by relations of table "location" available as properties of the model.
 *
 * @property string $id
 * @property integer $country_id
 * @property string $city_id
 * @property double $lat
 * @property double $lng
 * @property string $count
 *
 * @property Country $country
 * @property City $city
 */
abstract class BaseLocation extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'location';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Location|Locations', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('lat, lng, count', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'numerical'),
			array('city_id', 'length', 'max'=>10),
			array('count', 'length', 'max'=>11),
			array('country_id, city_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, country_id, city_id, lat, lng, count', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'country_id' => null,
			'city_id' => null,
			'lat' => Yii::t('app', 'Lat'),
			'lng' => Yii::t('app', 'Lng'),
			'count' => Yii::t('app', 'Count'),
			'country' => null,
			'city' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('country_id', $this->country_id);
		$criteria->compare('city_id', $this->city_id);
		$criteria->compare('lat', $this->lat);
		$criteria->compare('lng', $this->lng);
		$criteria->compare('count', $this->count, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}