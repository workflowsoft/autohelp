<?php

$this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        array(
            'name' => 'email',
            'type' => 'email'
        ),
        'phone',
        'description',
        'first_name',
        'middle_name',
        'last_name',
        'vin',
        'grn',
        'ts_make',
        'ts_model',
        'ts_color',
        'card_delivery_address',
        array(
            'label' => $model->getAttributeLabel('card_number'),
            'type' => 'raw',
            'value' => isset($model->card->number) ? CHtml::encode($model->card->number) : '',
        ),
        array(
            'name' => 'activation_start',
            'type' => 'date'
        ),
        array(
            'name' => 'activation_end',
            'type' => 'date'
        ),
        array(
            'name' => 'delivered',
            'type' => 'boolean'
        ),
    ),
));

?>
