<h1>Добавить инцидент</h1>


<?php
    $this->menu = array(
        array('label' => 'Управление инцидентами', 'url' => array('admin')),
        array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
        array('label' => 'Редактировать инцормацию о клиенте', 'url' => array('/order/update/' . $order->id)),
    );

    echo $this->renderPartial('_order_view', array('model'=>$order));
?>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$ticket,
        'services' => $services,
        'order' => $order,
    )
);

?>







