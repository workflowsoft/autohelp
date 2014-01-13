<?php
$this->menu=array(
	array('label'=>'Управление инцидентами','url'=>array('admin')),
	array('label'=>'Поиск клиентов','url'=>array('/order/search')),
);
?>

<h1>Просмотр инцидента #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'status',
		'comment',
		'user_id',
		'last_status_change',
		'payment_without_card',
	),
)); ?>
