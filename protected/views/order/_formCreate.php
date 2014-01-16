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
        //TODO:Сделать вывод цветов из таблицы БД
        widget(
            'ext.colorpicker.ColorPicker', array(
                'model' => $model,
                'attribute' => 'ts_color',
                'form' => $form,
                'options' => array(
                    'colors'=> array(
                        "Черный"=>"000000",
                        "Серебристый" => "C0C0C0",
                        "Белый" => "FFFFFF",
                        "Синий" => "0000FF",
                        "Красный" => "FF0000",
                        "Зеленый" => "00FF00",
                        "Желтый" => "FFFF00",
                        "Голубой" => "00FFFF"
                    ),
                    'defaultColor' => "Черный",
                ),
                'htmlOptions' => array(
                    'class'=>'span5',
                    'maxlength' => 128,
                ),
            )
        );
    ?>

	<?php echo $form->textFieldRow($model,'card_delivery_address',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'card_number',array('class'=>'span5','maxlength'=>10)); ?>

    <?php echo $form->dateRangeRow(
        $model,
        'activation_range',
        array(
            'options' => array(
                    'prepend' => '<i class="icon-calendar"></i>',
                    'locale' => array(
                        'fromLabel'=>'Начало',
                        'toLabel' => 'Окончание',
                        'applyLabel' => 'Активация',
                        'cancelLabel' => 'Отмена',
                        'weekLabel' => 'Нед.',
                        'customRangeLabel' => 'Время активности карты',
                    ),
                    'format' => 'DD.MM.YYYY',
                    'startDate' => date('d.m.Y', strtotime('+1 days')),
                    'endDate' => date('d.m.Y', strtotime('+1 years +1 days')),
                )
            )
        );
    ?>


    <?php // echo $form->textFieldRow($model,'activation_start',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'activation_end',array('class'=>'span5')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
