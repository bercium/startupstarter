<?php

/**
 * This is the model class for table "idea_gallery".
 *
 * The followings are the available columns in table 'idea_gallery':
 * @property string $id
 * @property string $idea_id
 * @property string $url
 * @property integer $cover
 *
 * The followings are the available model relations:
 * @property Idea $idea
 */
class IdeaGallery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IdeaGallery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'idea_gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idea_id, url, cover', 'required'),
			array('cover', 'numerical', 'integerOnly'=>true),
			array('idea_id', 'length', 'max'=>11),
			array('url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, idea_id, url, cover', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idea' => array(self::BELONGS_TO, 'Idea', 'idea_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idea_id' => 'Idea',
			'url' => 'Url',
			'cover' => 'cover',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('idea_id',$this->idea_id,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('cover',$this->cover);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}