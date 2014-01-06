<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Order','url'=>array('index')),
	array('label'=>'Create Order','url'=>array('create')),
	array('label'=>'Update Order','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Order','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order','url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
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
		'card_id',
		'activation_start',
		'activation_end',
		'delivery_coords',
		'delivery_street',
	),
)); ?>
