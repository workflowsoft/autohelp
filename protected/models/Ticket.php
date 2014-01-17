<?php

/**
 * This is the model class for table "ticket".
 *
 * The followings are the available columns in table 'ticket':
 * @property string $id
 * @property string $status
 * @property string $comment
 * @property string $user_id
 * @property string $last_status_change
 * @property integer $payment_without_card
 *
 * The followings are the available model relations:
 * @property Partner2ticket[] $partner2tickets
 * @property User $user
 */
class Ticket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_without_card', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>11),
			array('comment', 'length', 'max'=>256),
			array('user_id', 'length', 'max'=>10),
			array('last_status_change', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, comment, user_id, last_status_change, payment_without_card', 'safe', 'on'=>'search'),
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
			'partner2tickets' => array(self::HAS_MANY, 'Partner2ticket', 'ticket_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Идентификатор ',
			'status' => 'Статус',
			'comment' => 'Комментарий',
			'user_id' => 'Пользователь',
			'last_status_change' => 'Последнее обновление статуса',
			'payment_without_card' => 'Оплата не месте',
            'reject_comment' => 'Причина отказа',
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
		$criteria->compare('status',$this->status,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('last_status_change',$this->last_status_change,true);
		$criteria->compare('payment_without_card',$this->payment_without_card);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function searchByStatus($status = TicketStatus::NEW_TICKET)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('status',$status);
        if($status == TicketStatus::DRAFT || $status == TicketStatus::ASSIGNING) {
            $criteria->compare('user_id',UserIdentity::getCurrentUserId());
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ticket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
