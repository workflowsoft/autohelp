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
 * @property int $delivered
 * @property string $activation_comment
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

    public $cardResult;
    public $card_number;
    public $activation_range;

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
            //Сначала общие правила валидации по форматам данных
            array('email', 'email'),
            array('phone', 'match', 'pattern'=>'/^\+\d+\-\d+\-\d+$/'),
            array('vin', 'match', 'pattern'=>'/^(([a-h,A-H,j-n,J-N,p-z,P-Z,0-9]{9})([a-h,A-H,j-n,J-N,p,P,r-t,R-T,v-z,V-Z,0-9])([a-h,A-H,j-n,J-N,p-z,P-Z,0-9])(\d{6}))$/'),
            array('grn','match', 'pattern'=> '/^[0-9ABCEHKMOPTXYabcehkmoptxyАВСЕНКМОРТХУавсенкмортху]\d{3}[ABCEHKMOPTXYabcehkmoptxyАВСЕНКМОРТХУавсенкмортху]{2}\d{2,3}$/u'),
            //У нас всегда обязателен номер телефона, без вариантов. Нет телефона = некуда звонить
            array('phone', 'required'),
            //Обязательность у нас выстраивается сложно в зависимости от запрашиваемого сценария

            //Сложная валидация карт с походом в базу данных
            array('card_number', 'checkCardNumber'),

            //Проверка формата диавазона карт
            array('activation_range', 'checkActivationDate'),

            //Проверка коментария платежа
            array('activation_comment', 'checkActivationComment'),

            //Проверка факта доставки карты
            array('delivered', 'checkDelivered'),

            //Фиьтрация диапазона действия карт
            array('activation_range', 'filter', 'filter'=>array( $this, 'filterActivationDate' )),

            array('delivered', 'numerical', 'integerOnly'=>true),

            array('ts_color', 'length', 'max'=>64),
            array('card_id', 'length', 'max'=>10),

            array('first_name, middle_name, last_name, ts_make, ts_model', 'length', 'max'=>64),

            array('vin, grn ,card_id, activation_start, activation_end', 'default', 'setOnEmpty' => true, 'value' => null),

            //Мы можем всегда массово назначить эти атрибуты
            array('delivery_coords, activation_range', 'safe'),


			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, phone, description, first_name, middle_name, last_name, vin, grn, ts_make, ts_model, ts_color, card_delivery_address, card_id, activation_start, activation_end, delivery_coords, delivery_street, card_number', 'safe', 'on'=>'search'),

        );
	}

    public  function checkActivationComment($attribute,$params)
    {
        if ($this[$attribute])
        {
            if (!$this->activation_range)
            {
                $this->addError($attribute, "Нельзя выставлять коментарий активации карты без указания даты активации");
            }
        }
    }

    public function  checkDelivered($attribute,$params)
    {
        if ($this[$attribute])
        {
            if ($this[$attribute] == 1 && !$this->card_number)
            {
                  $this->addError('delivered', "Доставка невозможна без указания номера карты");
            }
        }
    }

    public  function  checkCardNumber($attribute,$params)
    {
        if ($this[$attribute])
        {
            $this->cardResult = CardChecker::CheckCard($this[$attribute], $this->id);
            if ($this->cardResult['result'] != "CanCreateNew" && $this->cardResult['result']!= "CanUseThis")
            {
                $error = "Карточка не может быть использована по причине: ".(($this->cardResult['result']=='AlreadyUsed')?"Уже используется":"Серия данной карты не найдена");
                $this->addError('card_number',$error);
            }
        }
    }

    public  function filterActivationDate($value)
    {
        $dates = explode(" - ", $value);
        if (count($dates)>1)
        {
            $this->activation_start = date('Y-m-d H:i:s', strtotime($dates[0]));
            $this->activation_end = date('Y-m-d H:i:s', strtotime($dates[1]));
        }
        return $value;
    }

    protected function afterFind()
    {
        parent::afterFind();
        if ($this->card)
            $this->card_number = $this->card->number;
    }

    public  function checkActivationDate($attribute,$params)
    {
        if($this[$attribute])
        {
            preg_match("/^(\d{2}\.\d{2}.\d{4}) \- (\d{2}\.\d{2}.\d{4})$/", $this[$attribute], $datePatrs);
            if (!count($datePatrs))
                $this->addError('activation_range',"Некорректный формат диапазона действия карты");
            else
            {
                if (!$this->card_number)
                {
                   //Не указан номер карты, так тоже не пойдет активировать
                   $this->addError('card_number',"Попытка активации карты без номера карты, которую предполагается активировать");
                }
                //Если с датой активации все ОК, то обязательно должен быть коментарий и номер валидный номер карты
                if (!$this->activation_comment)
                {
                    //TODO: Учесть, что если карта была оплачена через интернет, коментарий при активации необязателен
                    //Нет коментария к активации карты
                    $this->addError('activation_comment',"Попытка активации карты без указания коментария активации");
                }
                /*А еще активация невозможна без обязательны идентификационных признаков.
                  Должен быть хотя бы VIN или GRN
                */
                if (!$this->grn && !$this->vin)
                {
                    $identifyError = "Попытка активации карты без указания идентификационных параметров ТС, Нужен VIN или ГРН";
                    $this->addError('grn',$identifyError);
                    $this->addError('vin',$identifyError);
                }
            }
        }
    }


    protected function beforeSave()
    {
        $result = true;
        if (isset($this->card_number) && isset($this->cardResult))
        {
            //Создаем карточку или используем существующую
            if ($this->cardResult['result'] == "CanUseThis")
            {
                $this->card_id = $this->cardResult['id'];
            }
            else if ($this->cardResult['result'] == "CanCreateNew")
            {
                $card = new Card;
                $card->number = $this->card_number;
                $card->series_id = $this->cardResult['series_id'];
                $result = $card->save();
                $this->card_id = $card->id;
                //TODO: Не забыть про транзакцию. Карту сохраняем только с самим заказов
            }
            else $result = false;
        }
        return $result;
    }

    /*
    protected function afterFind(){

        foreach($this->metadata->tableSchema->columns as $columnName => $column){

            if (!strlen($this->$columnName)) continue;

            if ($column->dbType == 'date'){
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
            }elseif ($column->dbType == 'datetime'){
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
            }
        }
        return true;
    }
    */

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
			'action_tag' => array(self::HAS_MANY, 'ActionTag', array('action_tag_id' => 'id'), 'through'=>'order2actionTags'),
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
			'card_delivery_address' => 'Адрес доставки',
			'card_number' => 'Номер карты',
			'activation_start' => 'Начало действия карты',
			'activation_end' => 'Окончание действия карты',
			'delivery_coords' => 'Координаты доставки',
			'delivery_street' => 'Уточнение координат доставки',
			'delivered' => 'Карта доставлена',
            'activation_range' => 'Время действия карты',
            'activation_comment' => 'Коментарий активации (платежный документ)'
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
        if ($this->card_number)
        {
            $criteria->with = array('card');
            $criteria->addCondition('card.number LIKE "'.$this->card_number.'%"');
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchNotActivated($action_tag)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.phone',$this->phone,true);
		$criteria->compare('t.first_name',$this->first_name,true);
		$criteria->compare('t.middle_name',$this->middle_name,true);
		$criteria->compare('t.last_name',$this->last_name,true);
		$criteria->compare('t.activation_start',NULL,true);

        $criteria->addCondition('t.activation_start is null');

        if(!empty($action_tag)) {
            $criteria->join = 'LEFT JOIN `order2action_tag` O2AT ON O2AT.order_id = t.id
   LEFT JOIN `action_tag` AT ON AT.id = O2AT.action_tag_id';
            $criteria->addCondition('AT.name = "' . $action_tag .'"');
        }

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
		return parent::model($className)->with('card');
	}

    public function isActivated() {
        //replace with php comparation
        $id = $this->id;
        $table = $this->tableName();
        $sql = "
          SELECT
	        CURRENT_TIMESTAMP() between activation_start and activation_end as `activated`
          FROM
	        `$table`
          WHERE
	        id = $id;
        ";
        $result = Yii::app()->db->createCommand($sql)->query()->read();

        return $result['activated'];


    }
}
