<?php
$this->breadcrumbs=array(
	'Заказы'=>array('admin', 'action_tag'=>$model->activeActionTag),
	$model->id,
);

$this->menu=array(
	array('label'=>'Создать заказ','url'=>array('create')),
	array('label'=>'Редактировать заказ','url'=>array('update','id'=>$model->id)),
	array('label'=>'Удалить заказ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить заказ?')),
);
?>

<h1>Просмотр заказа #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
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
)); ?>
