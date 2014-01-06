<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $email
 * @property string $phone
 * @property string $description
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $vin
 * @property string $grn
 * @property string $ts_make
 * @property string $ts_model
 * @property string $ts_color
 * @property string $card_delivery_address
 * @property string $card_id
 * @property string $activation_start
 * @property string $activation_end
 * @property string $delivery_coords
 * @property string $delivery_street
 *
 * The followings are the available model relations:
 * @property Card $card
 * @property Order2actionTag[] $order2actionTags
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, description, card_delivery_address, delivery_street', 'length', 'max'=>256),
			array('phone, grn', 'length', 'max'=>16),
            array('vin,grn', 'default', 'setOnEmpty' => true, 'value' => null),
			array('first_name, middle_name, last_name, ts_make, ts_model', 'length', 'max'=>64),
			array('vin', 'length', 'max'=>17),
			array('ts_color', 'length', 'max'=>6),
			array('card_id', 'length', 'max'=>10),
			array('activation_start, activation_end, delivery_coords', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, phone, description, first_name, middle_name, last_name, vin, grn, ts_make, ts_model, ts_color, card_delivery_address, card_id, activation_start, activation_end, delivery_coords, delivery_street', 'safe', 'on'=>'search'),
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
			'card' => array(self::BELONGS_TO, 'Card', 'card_id'),
			'order2actionTags' => array(self::HAS_MANY, 'Order2actionTag', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Идентиикатор заявки',
			'email' => 'Email',
			'phone' => 'Телефон',
			'description' => 'Описание',
			'first_name' => 'Имя',
			'middle_name' => 'Отчество',
			'last_name' => 'Фамилия',
			'vin' => 'VIN',
			'grn' => 'Гос регистрационный номер',
			'ts_make' => 'Марка ТС',
			'ts_model' => 'Модель ТС',
			'ts_color' => 'Цвет ТС',
			'card_delivery_address' => 'Адрес доставки карты',
			'card_id' => 'Номер карты',
			'activation_start' => 'Начало действия карты',
			'activation_end' => 'Окончание действия карты',
			'delivery_coords' => 'Координаты доставки',
			'delivery_street' => 'Уточнение координат доставки',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('vin',$this->vin,true);
		$criteria->compare('grn',$this->grn,true);
		$criteria->compare('ts_make',$this->ts_make,true);
		$criteria->compare('ts_model',$this->ts_model,true);
		$criteria->compare('ts_color',$this->ts_color,true);
		$criteria->compare('card_delivery_address',$this->card_delivery_address,true);
		$criteria->compare('card_id',$this->card_id,true);
		$criteria->compare('activation_start',$this->activation_start,true);
		$criteria->compare('activation_end',$this->activation_end,true);
		$criteria->compare('delivery_coords',$this->delivery_coords,true);
		$criteria->compare('delivery_street',$this->delivery_street,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchNotActivated()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
//		$criteria->compare('description',$this->description,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
//		$criteria->compare('vin',$this->vin,true);
//		$criteria->compare('grn',$this->grn,true);
//		$criteria->compare('ts_make',$this->ts_make,true);
//		$criteria->compare('ts_model',$this->ts_model,true);
//		$criteria->compare('ts_color',$this->ts_color,true);
//		$criteria->compare('card_delivery_address',$this->card_delivery_address,true);
//		$criteria->compare('card_id',$this->card_id,true);
		$criteria->compare('activation_start',NULL,true);
        $criteria->addSearchCondition('activation_start', '<=', true );
//		$criteria->compare('activation_end',NULL,true);
//		$criteria->compare('delivery_coords',$this->delivery_coords,true);
//		$criteria->compare('delivery_street',$this->delivery_street,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
