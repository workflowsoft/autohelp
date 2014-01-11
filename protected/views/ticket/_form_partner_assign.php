<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
)); ?>

<!--	<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<!--	--><?php //echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>11)); ?>

<?php echo $form->textAreaRow($model, 'comment', array('class' => 'span5', 'maxlength' => 256)); ?>

<!--	--><?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

<!--	--><?php //echo $form->textFieldRow($model,'last_status_change',array('class'=>'span5')); ?>

<?php echo $form->checkboxRow($model, 'payment_without_card'); ?>


<?php


// Data provider needs ids
foreach ($partners['available'] as $k => $partner) {
    $partners['available'][$k]['id'] = $partner['PartnerId'];
}

if (!empty($partners['services_not_available'])) {
    echo '<h4>Услуги, которые не могут быть предоставлены</h4>';
    foreach ($partners['services_not_available'] as $service) {
        $this->widget('bootstrap.widgets.TbLabel', array(
            'type' => 'important',
            'label' => $service->title,
        ));
        echo '<br>';
    }
}

function makeServiceCheckBox($services, $checked)
{
    $result = '';
    foreach ($services as $service) {
        $result .= '<input type="checkbox"' . ($checked ? 'checked="checked"' : '') . '>';
        $result .= '<span class="label">' . $service->title . '</span>';

        $result .= '<br>';
    }

    return $result;

}


echo '<h4>Партнеры</h4>';

$gridDataProvider = new CArrayDataProvider($partners['available']);

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'condensed',
    'dataProvider' => $gridDataProvider,
    'template' => "{items}",
    'rowCssClassExpression' => '',
//    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('partnerAssign').'/id/"+$.fn.yiiGridView.getSelection(id);}',
    'columns' => array(
        array(
            'name' => 'selected',
            'header' => '',
            'type' => 'raw',
            'value' => function ($data) {
                    return '<input type="checkbox">';
                },
        ),

        array('name' => 'PartnerTitle', 'header' => 'Партнер'),
        array('name' => 'PartnerPhone', 'header' => 'Контактный телефон партнера'),
        array(
            'name' => 'ServiceTitles',
            'header' => 'Услуги',
            'type' => 'raw',
            'value' => function ($data) {
                    $result = '';

                    $result .= makeServiceCheckBox($data['services'], true);

                    if (!empty($data['all_services'])) {
                        $result .= CHtml::link('Показать больше', '#', array('onclick' => '$(".more-services-' . $data['id'] . '").toggle(); event.stopPropagation()'));
                        $result .= '<div class="more-services more-services-' . $data['id'] . '" style="display: none;">';
                        $result .= makeServiceCheckBox($data['all_services'], false);
                        $result .= '</div>';
                    }

                    return $result;
                },
        ),
        array('name' => 'Workload', 'header' => 'Загруженность'),
    ),
));

?>



<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Назначить исполнителей',
    )); ?>
</div>



<?php $this->endWidget(); ?>
