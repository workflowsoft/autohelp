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

	<?php echo $form->textFieldRow($model,'ts_color',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'card_delivery_address',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'card_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'activation_start',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'activation_end',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'delivery_coords',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'delivery_street',array('class'=>'span5','maxlength'=>256)); ?>

	<div class="form-actions">
		<?php

        foreach ($model->action_tag as $action_tag) {
            if ($action_tag->name === 'call') {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'label' => 'Повторный обзвон',
                    'htmlOptions'   => array('name'=> 'recall'),
                ));
                echo '&nbsp;';
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type'=>'success',
                    'label' => 'Активация',
                    'htmlOptions'   => array('name'=> 'activate'),
                ));
            }

            if ($action_tag->name === 'recall') {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type'=>'success',
                    'label' => 'Активация',
                    'htmlOptions'   => array('name'=> 'activate'),
                ));
            }

            if ($action_tag->name === 'check') {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'label' => 'Повторный обзвон',
                    'htmlOptions'   => array('name'=> 'recall'),
                ));
                echo '&nbsp;';
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type'=>'success',
                    'label' => 'Активация',
                    'htmlOptions'   => array('name'=> 'activate'),
                ));
            }


            // Просто выставить даты начала и конца срока действия карты
//            if ($action_tag->name === 'activate') {
//                $this->widget('bootstrap.widgets.TbButton', array(
//                    'buttonType' => 'submit',
//                    'type'=>'success',
//                    'label' => 'Активировать',
//                ));
//            }


        }
        ?>
	</div>

<?php $this->endWidget(); ?>
