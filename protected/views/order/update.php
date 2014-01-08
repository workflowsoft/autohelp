<?php
$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
//	'',
);

//$this->menu=array(
//	array('label'=>'List Order','url'=>array('index')),
//	array('label'=>'Create Order','url'=>array('create')),
//	array('label'=>'View Order','url'=>array('view','id'=>$model->id)),
//	array('label'=>'Manage Order','url'=>array('admin')),
//);

?>

<h1>Заказ # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>