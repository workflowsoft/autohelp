<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
)); ?>


<?php echo $form->errorSummary($model); ?>
<?php echo $form->textAreaRow($model, 'comment', array('class' => 'span5', 'maxlength' => 256)); ?>
<?php
echo $form->checkboxRow($model, 'payment_without_card', array('disabled' => true));
?>


<h4>Необходимые услуги </h4>

<?php


if (!empty($services)) {
    foreach ($services as $key => $service) {
        echo '<input name="Service[' . $service->id . ']" id="Service_id_' . $service->id . '" value="1" type="checkbox">';

        echo '&nbsp';
        $this->widget('bootstrap.widgets.TbLabel', array(
            'type' => 'default',
            'label' => $service->title,
        ));
        echo '<br>';
    }
}

?>



<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Создать' : 'Сохранить',
    ));

    echo $this->renderPartial('_reject_widget', array('ticket_id' => $model->id));
    ?>
</div>



<?php $this->endWidget(); ?>
