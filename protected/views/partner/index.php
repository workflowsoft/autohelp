<?php
$this->breadcrumbs=array(
	'Partners',
);

$this->menu=array(
	array('label'=>'Create Partner','url'=>array('create')),
	array('label'=>'Manage Partner','url'=>array('admin')),
);
?>

<h1>Partners</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
