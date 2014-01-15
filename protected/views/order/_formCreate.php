<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Поля отмеченные <span class="required">*</span> обязательны</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'middle_name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'vin',array('class'=>'span5','maxlength'=>17)); ?>

	<?php echo $form->textFieldRow($model,'grn',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'ts_make',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'ts_model',array('class'=>'span5','maxlength'=>64)); ?>

    <?php
    /*Используется
    https://github.com/tonybolzan/yii-colorpicker (Yii)
    http://www.laktek.com/2008/10/27/really-simple-color-picker-in-jquery/ (Demo)
    http://github.com/laktek/really-simple-color-picker (Js)
    */
    $this->
        widget(
            'ext.colorpicker.ColorPicker', array(
                'model' => $model->ts_color,
                'name' => 'ts_color',
                'options' => array( // Optional
                    'pickerDefault' => "fff",
                    'colors'=> array("000", 'fff', 'ccc')
                ),
            )
        );
    ?>

	<?php echo $form->textFieldRow($model,'ts_color',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'card_delivery_address',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'card_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'activation_start',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'activation_end',array('class'=>'span5')); ?>

<!--	--><?php //echo $form->textFieldRow($model,'activation_end',array('class'=>'span5')); ?>


<!--	--><?php //echo $form->textFieldRow($model,'delivery_coords',array('class'=>'span5')); ?>

<!--	--><?php //echo $form->textFieldRow($model,'delivery_street',array('class'=>'span5','maxlength'=>256)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
