<?php

/**
 * This is the model base class for the table "skillsets".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Skillsets".
 *
 * Columns in table "skillsets" available as properties of the model,
 * followed by relations of table "skillsets" available as properties of the model.
 *
 * @property integer $ID
 * @property string $name
 *
 * @property SkillsetsSkills[] $skillsetsSkills
 * @property UsersSkills[] $usersSkills
 */
abstract class BaseSkillsets extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'skillsets';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Skillsets|Skillsets', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>128),
			array('ID, name', 'safe', 'on'=>'search'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'ID' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('ID', $this->ID);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}