<?php
//$this->breadcrumbs=array(
//	'Заказы'=>array('admin'),
//	$model->id,
//);

//$this->menu=array(
//	array('label'=>'List Order','url'=>array('index')),
//	array('label'=>'Создать заказ','url'=>array('create')),
//	array('label'=>'Редактировать заказ','url'=>array('update','id'=>$model->id)),
//	array('label'=>'Удалить заказ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Order','url'=>array('admin')),
//);
//?>


<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
        'phone',
        'email',
//		'description',
		'first_name',
		'middle_name',
		'last_name',
		'vin',
		'grn',
		'ts_make',
		'ts_model',
		'ts_color',
//		'card_delivery_address',
		'card_id',
		'activation_start',
		'activation_end',
//		'delivery_coords',
//		'delivery_street',
	),
)); ?>