<?php
$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	'Создание',
);

//$this->menu=array(
//	array('label'=>'Перечень заявок','url'=>array('admin')),
//	array('label'=>'Manage Order','url'=>array('admin')),
//);

?>

<h1>Создание заказа</h1>

<?php echo $this->renderPartial('_formCreate', array('model'=>$model)); ?>