<?php
$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ticket','url'=>array('index')),
	array('label'=>'Create Ticket','url'=>array('create')),
	array('label'=>'Update Ticket','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Ticket','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ticket','url'=>array('admin')),
);
?>

<h1>View Ticket #<?php echo $model->id; ?></h1>

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
