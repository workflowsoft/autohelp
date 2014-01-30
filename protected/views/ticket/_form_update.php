<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
)); ?>


<?php echo $form->errorSummary($model); ?>
<?php
    if($model->comment == 'default') {
        $model->comment = '';
    }
    echo $form->textAreaRow($model, 'comment', array('class' => 'span5', 'maxlength' => 256));
?>
<?php
echo $form->checkboxRow($model, 'payment_without_card', array('disabled' => true));
?>


<h4>Необходимые услуги </h4>

<?php


if (!empty($services)) {
    foreach ($services as $key => $service) {
        $checked = in_array($service->id, $active_services) ? 'checked="checked"' : '';
        echo '<input name="Service[' . $service->id . ']" id="Service_id_' . $service->id . '" value="1" type="checkbox" ' . $checked . '>';

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
    <?php
    echo '<input type="hidden" name="save_new" class="save-new-input" value="0">';

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Сохранить',
    ));
    echo '&nbsp;';

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Сохранить как новый',
        'htmlOptions'=>array(
            'class'=> 'save-new-button',
        )
    ));

    echo $this->renderPartial('_reject_widget', array('ticket_id' => $model->id));
    ?>
</div>



<?php $this->endWidget(); ?>


<script type="text/javascript">

    $(document).ready(function () {
        $('body').on('click', '.save-new-button', function(){
            $('.save-new-input').val(1);
        });
    });


</script>
