<?php

/**
 * This is the model class for table "event_signup".
 *
 * The followings are the available columns in table 'event_signup':
 * @property string $id
 * @property string $event_id
 * @property string $user_id
 * @property string $time
 * @property string $idea_id
 * @property integer $payment
 * @property string $survey
 * @property string $referrer_id
 *
 * The followings are the available model relations:
 * @property User $referrer
 * @property Event $event
 * @property User $user
 * @property Idea $idea
 */
class EventSignup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'event_signup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, user_id', 'required'),
			array('payment', 'numerical', 'integerOnly'=>true),
			array('event_id', 'length', 'max'=>10),
			array('user_id, idea_id, referrer_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, user_id, time, idea_id, payment, survey, referrer_id, canceled', 'safe', 'on'=>'search'),
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
			'referrer' => array(self::BELONGS_TO, 'User', 'referrer_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'event_id' => 'Event',
			'user_id' => 'User',
			'time' => 'Time',
			'idea_id' => 'Idea',
			'payment' => 'Payment',
			'survey' => 'Survey',
			'referrer_id' => 'Referrer',
			'canceled' => 'Canceled',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('idea_id',$this->idea_id,true);
		$criteria->compare('payment',$this->payment);
		$criteria->compare('survey',$this->survey,true);
		$criteria->compare('referrer_id',$this->referrer_id,true);
		$criteria->compare('canceled',$this->canceled,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventSignup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
