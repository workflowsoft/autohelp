<?php
$this->breadcrumbs=array(
	'Partners'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Partner','url'=>array('index')),
	array('label'=>'Create Partner','url'=>array('create')),
	array('label'=>'Update Partner','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Partner','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Partner','url'=>array('admin')),
);
?>

<h1>View Partner #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'address',
		'phone',
		'email',
		'skype',
		'icq',
		'mra',
	),
)); ?>
