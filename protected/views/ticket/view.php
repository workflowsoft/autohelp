<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);
?>

<h1>Просмотр инцидента #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'status',
        'comment',
//		'user_id',
//		'last_status_change',
        'payment_without_card',
    ),
)); ?>

<?php

echo '<h4>Назначенные Партнеры</h4>';

$gridDataProvider = new CArrayDataProvider($partners);

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'condensed',
    'dataProvider' => $gridDataProvider,
    'template' => "{items}",
    'rowCssClassExpression' => '',
    'columns' => array(
        array('name' => 'title', 'header' => 'Партнер'),
        array('name' => 'phone', 'header' => 'Контактный телефон партнера'),
        array(
            'name' => 'ServiceTitles',
            'header' => 'Услуги',
            'type' => 'raw',
            'value' => function ($data) {
                    $result = '';
                    foreach($data['services'] as $service) {
                        $result .= '<span class="label">' . $service['service']->title . '</span>';
                        $result .= '&nbsp;';
                        $result .= $service['time'];
                        $result .= '<br>';
                    }

                    return $result;
                },
        ),
    ),
));

?>

