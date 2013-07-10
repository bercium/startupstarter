<?php

/**
 * This is the model base class for the table "idea_translation".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "IdeaTranslation".
 *
 * Columns in table "idea_translation" available as properties of the model,
 * followed by relations of table "idea_translation" available as properties of the model.
 *
 * @property string $id
 * @property integer $language_id
 * @property string $idea_id
 * @property string $pitch
 * @property string $description
 * @property integer $description_public
 * @property string $tweetpitch
 * @property integer $deleted
 * @property string $title
 *
 * @property Language $language
 * @property Idea $idea
 */
abstract class BaseIdeaTranslation extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);	
	}

	public function tableName() {
		return 'idea_translation';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'IdeaTranslation|IdeaTranslations', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('language_id, title, pitch, description_public', 'required'),
			array('language_id, description_public, deleted', 'numerical', 'integerOnly'=>true),
			array('idea_id', 'length', 'max'=>8),
			array('tweetpitch', 'length', 'max'=>140),
			array('title', 'length', 'max'=>128),
			array('keywords', 'length', 'max'=>256),
			array('title', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, language_id, idea_id, pitch, description, description_public, tweetpitch, deleted, title, keywords', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
			'idea' => array(self::BELONGS_TO, 'Idea', 'idea_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'language_id' => null,
			'idea_id' => null,
			'pitch' => Yii::t('app', 'Pitch'),
			'description' => Yii::t('app', 'Description'),
			'description_public' => Yii::t('app', 'Description Public'),
			'keywords' => Yii::t('app', 'Keywords'),
			'tweetpitch' => Yii::t('app', 'Tweetpitch'),
			'deleted' => Yii::t('app', 'Deleted'),
			'title' => Yii::t('app', 'Title'),
			'language' => null,
			'idea' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('idea_id', $this->idea_id);
		$criteria->compare('pitch', $this->pitch, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('description_public', $this->description_public);
		$criteria->compare('keywords', $this->keywords);
		$criteria->compare('tweetpitch', $this->tweetpitch, true);
		$criteria->compare('deleted', $this->deleted);
		$criteria->compare('title', $this->title, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}