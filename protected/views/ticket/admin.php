<?php
$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ticket','url'=>array('index')),
	array('label'=>'Create Ticket','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ticket-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
Yii::app()->clientScript->registerScript('status', "

$('.filter-$status').css('border', '3px solid red');
$('.filter').click(function(){
    $('.filter').css('border', '');
	$(this).css('border', '3px solid red');
	$.fn.yiiGridView.update('order-grid', {
		data: 'status=' + $(this).data('at')
	});
	return false;
});
");
?>


<h1>Управление инцидентами</h1>

<!--'new', 'assigned', 'done', 'rejected'-->

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Новые',
    'htmlOptions'=>array('class'=>'filter filter-new', 'data-at' => 'new'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'warning',
    'label'=>'Назначенные',
    'htmlOptions'=>array('class'=>'filter filter-assigned', 'data-at' => 'assigned'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'success',
    'label'=>'Успешно выполненные',
    'htmlOptions'=>array('class'=>'filter filter-done', 'data-at' => 'done'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'danger',
    'label'=>'Отклоненные',
    'htmlOptions'=>array('class'=>'filter filter-rejected', 'data-at' => 'rejected'),
)); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ticket-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('partnerAssign').'/id/"+$.fn.yiiGridView.getSelection(id);}',

	'columns'=>array(
		'id',
		'status',
		'comment',
		'user_id',
		'last_status_change',
		'payment_without_card',
//		array(
//			'class'=>'bootstrap.widgets.TbButtonColumn',
//		),
	),
)); ?>
