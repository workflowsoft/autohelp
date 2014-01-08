<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	'Управление',
);

$this->menu=array(
//	array('label'=>'List Order','url'=>array('index')),
	array('label'=>'Создать заявку','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
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
<?php
Yii::app()->clientScript->registerScript('filter', "

$('.filter-$action_tag').css('border', '3px solid red');
$('.filter').click(function(){
    $('.filter').css('border', '');
	$(this).css('border', '3px solid red');
	$.fn.yiiGridView.update('order-grid', {
		data: 'action_tag=' + $(this).data('at')
	});
	return false;
});
");
?>

<h1>Управление заказами</h1>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Обзвон',
    'htmlOptions'=>array('class'=>'filter filter-call', 'data-at' => 'call'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'info',
    'label'=>'Повторный обзвон',
    'htmlOptions'=>array('class'=>'filter filter-recall', 'data-at' => 'recall'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'warning',
    'label'=>'Проверка',
    'htmlOptions'=>array('class'=>'filter filter-check', 'data-at' => 'check'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'success',
    'label'=>'Активация',
    'htmlOptions'=>array('class'=>'filter filter-activate', 'data-at' => 'activate'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'danger',
    'label'=>'Истечение',
    'htmlOptions'=>array('class'=>'filter filter-expire', 'data-at' => 'expire'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'inverse',
    'label'=>'Все',
    'htmlOptions'=>array('class'=>'filter filter-all', 'data-at' => 'call'),
)); ?>


<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'order-grid',
	'dataProvider'=> $data_provider,
	'filter'=>$model,
	'columns'=>array(
		'id',
        array(
            'value'=>'isset($data->card->number) ? $data->card->number : ""',
            'header'=>'Номер карты',
        ),
        'email',
        'phone',
//		'description',
//		'first_name',
//		'middle_name',
//        'last_name',
        array(
            'value'=>'$data->last_name . " " . $data->first_name. " " . $data->middle_name',//This is the concatenated column
            'header'=>'ФИО',
        ),
        'vin',
        'grn',
//		'ts_make',
//		'ts_model',
//		'ts_color',
//		'card_delivery_address',
//		'activation_start',
//		'activation_end',
//		'delivery_coords',
//		'delivery_street',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
