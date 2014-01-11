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


<?php

// Data provider needs ids
foreach ($partners['available'] as $k =>$partner ){
    $partners['available'][$k]['id'] = $partner['PartnerId'];
}

echo '<h4>Услуги, которые не могут быть предоставлены</h4>';
foreach ($partners['services_not_available'] as $service) {
    $this->widget('bootstrap.widgets.TbLabel', array(
        'type'=>'important',
        'label'=>$service->title,
    ));
    echo '<br>';
}

echo '<h4>Партнеры</h4>';

$gridDataProvider = new CArrayDataProvider($partners['available']);

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'condensed',
    'dataProvider'=>$gridDataProvider,
    'template'=>"{items}",
    'columns'=>array(

        array('name'=>'PartnerTitle' , 'header'=>'Партнер'),
        array('name'=>'PartnerPhone' , 'header'=>'Контактный телефон партнера'),
        array(
            'name'=>'ServiceTitles' ,
            'header'=>'Услуги',
            'type'=>'raw',
            'value' => function($data)
                {
                    $result = '';
                    foreach($data['services'] as $service) {
                        $result .= $this->widget('bootstrap.widgets.TbLabel', array(
                            'type'=>'default',
                            'label'=>$service->title,
                        ), true);
                        $result .= '<br>';
                    }

                    return $result;
                },
        ),
        array('name'=>'Workload' , 'header'=>'Загруженность'),
    ),
));

?>



<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
    )); ?>
</div>



<?php $this->endWidget(); ?>
