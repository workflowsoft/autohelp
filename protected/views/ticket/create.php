<h1>Добавить инцидент</h1>


<?php echo $this->renderPartial('_order_view', array('model'=>$order)); ?>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$ticket,
        'services' => $services,
        'order' => $order,
    )
);

?>







