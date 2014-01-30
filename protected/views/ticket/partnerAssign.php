<h1>Назначение партнеров на инцидент #<?php echo $model->id; ?></h1>

<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
    array('label' => 'Редактировать инцормацию о клиенте', 'url' => array('/order/update/' . $order->id)),
);


echo $this->renderPartial(
    '_form_partner_assign',
    array(
        'model' => $model,
        'partners' => $partners,
        'order' => $order,
    )
);
?>