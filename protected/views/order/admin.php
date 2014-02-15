<?php
$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Создать заказ','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.filter-$action_tag').css('border', '3px solid red');


$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление заказами</h1>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Обзвон',
    'url' => $this->createUrl('/order/admin/action_tag/call'),
    'htmlOptions'=>array('class'=>'filter filter-call', 'data-at' => 'call'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Повторный обзвон',
    'url' => $this->createUrl('/order/admin/action_tag/recall'),
    'htmlOptions'=>array('class'=>'filter filter-recall', 'data-at' => 'recall'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Доставка карты',
    'url' => $this->createUrl('/order/admin/action_tag/delivery'),
    'htmlOptions'=>array('class'=>'filter filter-delivery', 'data-at' => 'delivery'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'warning',
    'label'=>'Проверка',
    'url' => $this->createUrl('/order/admin/action_tag/check'),
    'htmlOptions'=>array('class'=>'filter filter-check', 'data-at' => 'check'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'success',
    'label'=>'Активация',
    'url' => $this->createUrl('/order/admin/action_tag/activate'),
    'htmlOptions'=>array('class'=>'filter filter-activate', 'data-at' => 'activate'),
)); ?>



<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'order-grid',
	'dataProvider'=> $data_provider,
	'filter'=>$model,
    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);}',

	'columns'=>array(
		'id',
        array(
            'value' => 'isset($data->card->number) ? $data->card->number : ""',
            'header' => $model->getAttributeLabel('card_number'),
            'filter' => CHtml::activeTextField($model, 'card_number'),
        ),
        'email',
        'phone',
        'vin',
        'grn',
        array(
            'value'=>'$data->last_name . " " . $data->first_name. " " . $data->middle_name',//This is the concatenated column
            'header'=>'ФИО',
        ),
	),
)); ?>
