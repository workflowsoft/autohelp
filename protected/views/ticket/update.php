<h1>Редактирование инцидента # <?php echo $ticket->id; ?></h1>
<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
    array('label' => 'Редактировать инцормацию о клиенте', 'url' => array('/order/update/' . $order->id)),
);
?>


<?php echo $this->renderPartial('_order_view', array('model'=>$order)); ?>

<?php echo $this->renderPartial(
    '_form_update',
    array(
        'model'=>$ticket,
        'services' => $services,
        'active_services' => $active_services,
        'order' => $order,
    )
);

?>
