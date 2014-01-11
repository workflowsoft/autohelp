<?php
$this->breadcrumbs=array(
	'Partners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Partner','url'=>array('index')),
	array('label'=>'Manage Partner','url'=>array('admin')),
);
?>

<h1>Create Partner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>