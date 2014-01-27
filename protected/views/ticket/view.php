<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);
?>

<h1>Просмотр инцидента #<?php echo $model->id; ?></h1>

<?php




echo '<h4>Информация о клиенте</h4>';
echo $this->renderPartial('_order_view', array('model'=>$order));

echo '<h4>Информация об инциденте</h4>';
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'status',
        'comment',
        'reject_comment',
        array(
            'name' => 'payment_without_card',
            'type' => 'raw',
            'value' => function ($data) {
                    $checkbox = '<input disabled="disabled" type="checkbox"' .
                        ($data['payment_without_card'] ? 'checked="checked"' : '') .
                        '>';

                    return $checkbox;
                },
        ),

    ),
));



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
                        $result .= '&nbsp;';
                        if($service['reject_comment']) {
                            $result .= '<b>Отклонено с комментарием: ' . $service['reject_comment'] . '</b>';
                        }
                        $result .= '<br>';
                    }

                    return $result;
                },
        ),
    ),
));

if(!in_array($model->status, array(TicketStatus::DONE, TicketStatus::REJECTED))) {
    echo $this->renderPartial('_reject_widget', array('ticket_id'=>$model->id));
}

?>

