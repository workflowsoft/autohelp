<?php
//$this->breadcrumbs=array(
//	'Tickets'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Ticket','url'=>array('index')),
//	array('label'=>'Create Ticket','url'=>array('create')),
//	array('label'=>'View Ticket','url'=>array('view','id'=>$model->id)),
//	array('label'=>'Manage Ticket','url'=>array('admin')),
//);
//?>

<h1>Редактирование инцидента # <?php echo $model->id; ?></h1>
<?php
    echo '<h4>Информация о клиенте</h4>';
    echo $this->renderPartial('_order_view', array('model'=>$order));
?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>