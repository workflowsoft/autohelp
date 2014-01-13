<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
)); ?>



<?php

$url = Yii::app()->request->requestUri;
$view_url = str_replace('partnerAssign', 'view', $url);
$url = str_replace('partnerAssign', 'a_partnerAssign', $url);;
$ticket_id = $model->id;

Yii::app()->clientScript->registerScript('services', "

function intersect(array1, array2) {
   var result = [];
   // Don't destroy the original arrays
   var a = array1.slice(0);
   var b = array2.slice(0);
   var aLast = a.length - 1;
   var bLast = b.length - 1;
   while (aLast >= 0 && bLast >= 0) {
      if (a[aLast] > b[bLast] ) {
         a.pop();
         aLast--;
      } else if (a[aLast] < b[bLast] ){
         b.pop();
         bLast--;
      } else /* they're equal */ {
         result.push(a.pop());
         b.pop();
         aLast--;
         bLast--;
      }
   }
   return result;
}



function showActiveServices() {
    var partners = [];
    $.each( $('.grid-view').find('.partner'), function( key, tr ) {
        var input = $(this);
        var partner_id = null;
        //партнер выбран
        if(input.attr('checked')){
          partner_id = $(this).data('id');
          var service_ids = [];
            $.each( input.closest('tr').find('.service-checker'), function( key2, service ) {
                var service_input =$(this);
                if(service_input.attr('checked')){
                    var service_id = $(this).data('id');
                    service_ids.push(service_id)
                }
            });
          if (partner_id) {
            partners.push({
                'ticket_id' : '$ticket_id',
                'partner_id' : partner_id,
                'service_ids' : service_ids
            });
          }
        }

    });
    var_dump(partners);

    $.ajax({
        type: 'POST',
        url: '$url',
        data: {'data' : partners},
        // TODO fucking govnocode with redirects, use ajax or yii forms
        // Make action as api, it shouldn return the page
        success: function(data) {  alert(11); var_dump(data);    /*document.location.href = '$view_url'*/},
        error: function(data) {alert('Не удалось назначить партнеров')},
        dataType: 'json'
    });

}


$( 'body' ).on( 'click', '.show-services', showActiveServices);

function var_dump (object) {
    console.log(object);
}

");

?>




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
        $result .= '<input type="checkbox"'
            . ($checked ? 'checked="checked"' : '')
            . ' class="service-checker" data-id="'
            . $service->id . '">';
        $result .= '<span class="label">' . $service->title . '</span>';
        $result .= '&nbsp<input type="text" class="timer timer-' . $service->id . '" style="width:40px;">';

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
                    return '<input type="checkbox" class="partner" data-id="' . $data['id'] . '">';
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
//        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Назначить исполнителей!',
        'htmlOptions' => array(
            'class' => 'show-services',
        ),
    )); ?>

<!--    --><?php //$this->widget('bootstrap.widgets.TbButton', array(
//        'buttonType' => 'submit',
//        'type' => 'primary',
//        'label' => 'Сохранить',
//    )); ?>

</div>



<?php $this->endWidget(); ?>
