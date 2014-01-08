<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ticket-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>11)); ?>

	<?php echo $form->textFieldRow($model,'comment',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'last_status_change',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'payment_without_card',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
