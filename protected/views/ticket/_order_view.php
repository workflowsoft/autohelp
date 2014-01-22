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
            'label' => 'Номер карты',
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
        'delivery_street',
        array(
            'name' => 'delivered',
            'type' => 'boolean'
        ),
    ),
));

?>
