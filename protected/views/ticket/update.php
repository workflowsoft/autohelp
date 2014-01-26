<h1>Редактирование инцидента # <?php echo $ticket->id; ?></h1>
<?php
//    echo '<h4>Информация о клиенте</h4>';
//    echo $this->renderPartial('_order_view', array('model'=>$order));
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
