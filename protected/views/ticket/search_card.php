<?php
$this->breadcrumbs=array(
	'Инциденты. Поиск клиента'=>array('index'),
	'Поиск клиента',
);

$this->menu=array(
	array('label'=>'Список открытых инцидентов','url'=>array('admin')),
);
?>

<h1>Поиск клиента</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>