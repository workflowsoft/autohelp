<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ticket-form',
	'enableAjaxValidation'=>false,
)); ?>

<!--	<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

<!--	--><?php //echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>11)); ?>

	<?php echo $form->textAreaRow($model,'comment',array('class'=>'span5','maxlength'=>256)); ?>

<!--	--><?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

<!--	--><?php //echo $form->textFieldRow($model,'last_status_change',array('class'=>'span5')); ?>

	<?php echo $form->checkboxRow($model,'payment_without_card'); ?>


<h4>Необходимые услуги </h4>

<?php


//$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
//    'id'=>'service-form',
//    'enableAjaxValidation'=>false,
//));


foreach($services as $key => $service) {
//    var_dump($key);
//    echo $form->checkBox($service, 'id' /* , array('disabled'=>true)*/);
    echo '<input name="Service['.$service->id.']" id="Service_id_'.$service->id.'" value="1" type="checkbox">';

    echo '&nbsp';
    $this->widget('bootstrap.widgets.TbLabel', array(
        'type'=>'default',
        'label'=>$service->title,
    ));
    echo '<br>';
}


//echo $form->checkBoxListRow($model, 'id', array(
//        1 => 'Option one is this and that—be sure to include why it\'s great',
//        2 => 'Option two can also be checked and included in form results',
//        3 => 'Option three can—yes, you guessed it—also be checked and included in form results',
//    ), array('hint'=>'<strong>Note:</strong> Labels surround all the options for much larger click areas.')
//);


?>



<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Создать' : 'Save',
    )); ?>
</div>



<?php $this->endWidget(); ?>
