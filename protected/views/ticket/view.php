<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);
?>

<h1>Просмотр инцидента #<?php echo $model->id; ?></h1>

<?php




echo '<h4>Информация о клиенте</h4>';
echo $this->renderPartial('_order_view', array('model' => $order));

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


if(!empty($ticket2service)) {
    echo '<h4>Список требуемых услуг</h4>';
    foreach($ticket2service as $service) {
        echo '<span class="label">'. $service->title.'</span><br>';
    }
}

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
                    foreach ($data['services'] as $service) {
                        $result .= '<span class="label">' . $service['service']->title . '</span>';
                        $result .= '&nbsp;';
                        $result .= $service['time'];
                        $result .= '&nbsp;';
                        if ($service['reject_comment']) {
                            $result .= '<b>Отклонено с комментарием: ' . $service['reject_comment'] . '</b>';
                        }
                        $result .= '<br>';
                    }

                    return $result;
                },
        ),
    ),
));

if ($model->status == TicketStatus::DRAFT) {
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => '',
        'url' => $this->createUrl('/ticket/update/' . $model->id),
        'type' => 'primary',
        'label' => 'Перейти к редактированию',
    ));

} elseif ($model->status == TicketStatus::NEW_TICKET || $model->status == TicketStatus::ASSIGNING) {
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => '',
        'url' => $this->createUrl('/ticket/partnerAssign/' . $model->id),
        'type' => 'primary',
        'label' => 'Перейти к назначению партнеров',
    ));

} elseif ($model->status == TicketStatus::ASSIGNED || $model->status == TicketStatus::CHECKING) {
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => '',
        'url' => $this->createUrl('/ticket/check/' . $model->id),
        'type' => 'primary',
        'label' => 'Перейти к проверке',
    ));

}

if (!in_array($model->status, array(TicketStatus::DONE, TicketStatus::REJECTED))) {
    echo $this->renderPartial('_reject_widget', array('ticket_id' => $model->id));
}

?>

