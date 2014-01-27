<?php
$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Создать заказ','url'=>array('create')),
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
    'type'=>'info',
    'label'=>'Доставка карты',
    'htmlOptions'=>array('class'=>'filter filter-delivery', 'data-at' => 'delivery'),
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


<?php //$this->widget('bootstrap.widgets.TbButton', array(
//    'type'=>'danger',
//    'label'=>'Истечение',
//    'htmlOptions'=>array('class'=>'filter filter-expire', 'data-at' => 'expire'),
//)); ?>
<!---->
<?php //$this->widget('bootstrap.widgets.TbButton', array(
//    'type'=>'inverse',
//    'label'=>'Все',
//    'htmlOptions'=>array('class'=>'filter filter-all', 'data-at' => 'call'),
//)); ?>



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
            'value'=>'isset($data->card->number) ? $data->card->number : ""',
            'header'=>$model->getAttributeLabel('card_number'),
        ),
        'email',
        'phone',
        array(
            'value'=>'$data->last_name . " " . $data->first_name. " " . $data->middle_name',//This is the concatenated column
            'header'=>'ФИО',
        ),
        'vin',
        'grn',
	),
)); ?>
