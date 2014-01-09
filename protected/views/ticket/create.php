<?php
$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ticket','url'=>array('index')),
	array('label'=>'Manage Ticket','url'=>array('admin')),
);
?>

<h1>Добавить инцидент</h1>


<?php echo $this->renderPartial('_order_view', array('model'=>$order)); ?>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$ticket,
        'services' => $services,
        'order' => $order,
    )
);

?>







