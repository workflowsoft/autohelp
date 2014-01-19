<?php

/**
 * This is the model class for table "card_series".
 *
 * The followings are the available columns in table 'card_series':
 * @property string $id
 * @property integer $starting_number
 * @property integer $ending_number
 * @property string $series_type
 * @property string $distributing_point
 * @property string $comment
 * @property integer $count
 *
 * The followings are the available model relations:
 * @property Card[] $cards
 */
class CardSeries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'card_series';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('starting_number, ending_number, series_type, count', 'required'),
			array('starting_number, ending_number, count', 'numerical', 'integerOnly'=>true),
			array('series_type', 'length', 'max'=>1),
			array('distributing_point', 'length', 'max'=>128),
			array('comment', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, starting_number, ending_number, series_type, distributing_point, comment, count', 'safe', 'on'=>'search'),
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
			'cards' => array(self::HAS_MANY, 'Card', 'series_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'starting_number' => 'Starting Number',
			'ending_number' => 'Ending Number',
			'series_type' => 'Series Type',
			'distributing_point' => 'Distributing Point',
			'comment' => 'Comment',
			'count' => 'Count',
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
		$criteria->compare('starting_number',$this->starting_number);
		$criteria->compare('ending_number',$this->ending_number);
		$criteria->compare('series_type',$this->series_type,true);
		$criteria->compare('distributing_point',$this->distributing_point,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CardSeries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
