<?php

/**
 * This is the model class for table "card".
 *
 * The followings are the available columns in table 'card':
 * @property string $id
 * @property string $number
 * @property string $series_id
 * @property integer $prepaid
 *
 * The followings are the available model relations:
 * @property CardSeries $series
 * @property Order[] $orders
 */
class Card extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, series_id', 'required'),
			array('prepaid', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>128),
			array('series_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, series_id, prepaid', 'safe', 'on'=>'search'),
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
			'series' => array(self::BELONGS_TO, 'CardSeries', 'series_id'),
			'orders' => array(self::HAS_MANY, 'Order', 'card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'series_id' => 'Series',
			'prepaid' => 'Prepaid',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('series_id',$this->series_id,true);
		$criteria->compare('prepaid',$this->prepaid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Card the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
