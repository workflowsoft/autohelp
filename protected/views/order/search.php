<?php
//$this->breadcrumbs=array(
//	'Заказы'=>array('admin'),
//	'Управление',
//);

$this->menu = array(
//	array('label'=>'List Order','url'=>array('index')),
//	array('label'=>'Создать инцидент','url'=>array('create')),
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

<h1>Поиск клиентов</h1>


<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php

class Order2ticket
{
    static $data = array();

    public static function getTicketLink($order_id)
    {
        if (empty(self::$data[$order_id])) {
            return '';
        } else {
            $url = '/ticket/view/id/' . self::$data[$order_id];
            $link = CHtml::link('Инцидент # ' . self::$data[$order_id], array($url));
            return $link;
        }

    }


}

Order2ticket::$data = $order2ticket;


$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'order-grid',
    'dataProvider' => $data_provider,
    'filter' => $model,
    //goto update on row click
    'selectionChanged' => 'function(id){ location.href = "' . $this->createUrl('/ticket/create') . '/order_id/"+$.fn.yiiGridView.getSelection(id);}',

    'columns' => array(
        'id',
        'phone',
        array(
            'value' => 'isset($data->card->number) ? $data->card->number : ""',
            'header' => 'Номер карты',
        ),
        'grn',
        'vin',
        'last_name',
        'first_name',
        'middle_name',

        array(
            'header' => 'Активные инциденты',
            'type' => 'raw',
            'value' => function ($data) {
                    return Order2ticket::getTicketLink($data->id);
                },
        ),

    ),
)); ?>
