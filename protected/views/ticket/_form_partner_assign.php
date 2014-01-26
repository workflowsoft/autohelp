<?php

$url = Yii::app()->request->requestUri;
$view_url = str_replace('partnerAssign', 'view', $url);
$url = '/api/ticket/partnerAssign/' . $model->id;
$ticket_id = $model->id;

?>


<script type="text/javascript">
    function intersect(array1, array2) {
        var result = [];
        // Don't destroy the original arrays
        var a = array1.slice(0);
        var b = array2.slice(0);
        var aLast = a.length - 1;
        var bLast = b.length - 1;
        while (aLast >= 0 && bLast >= 0) {
            if (a[aLast] > b[bLast]) {
                a.pop();
                aLast--;
            } else if (a[aLast] < b[bLast]) {
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
        var errors = false;

        var services = [];
        $.each($('.service-checker'), function (key, service) {
            var service_input = $(this);
            if (service_input.attr('checked')) {
                var time_input = service_input.next().next();
                var partner_id = time_input.data('partner-id');
                var service_id = time_input.data('service-id');
                var time = time_input.val();

                services.push({
                    'partner_id': partner_id,
                    'service_id': service_id,
                    'time': time
                });
            }
        });
        var_dump(services);


        $.ajax({
            type: 'POST',
            url: '<?php echo $url?>',
            data: {'data': services},
            // TODO fucking govnocode with redirects, use ajax or yii forms
            // Make action as api, it shouldn return the page
            success: function (data) {
                document.location.href = '<?php echo $view_url; ?>';
            },
            error: function (data) {
                alert('Не удалось назначить партнеров');
            },
            dataType: 'json'
        });

    }

    function timerOnChange() {
        var input = $(this);
        var sc = '.service-checker-' + input.data('partner-id') + '-' + input.data('service-id');
        if (input.val() != '') {
            $(sc).attr('checked', true);
        } else {
            $(sc).attr('checked', false);
        }
    }

    $(document).ready(function () {
        $('body').on('click', '.show-services', showActiveServices);
        $('body').on('keyup', '.timer', timerOnChange);
    });

    function var_dump(object) {
        console.log(object);
    }

</script>



<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
));


// Data provider needs ids
if (!empty($partners['available'])) {
    foreach ($partners['available'] as $k => $partner) {
        $partners['available'][$k]['id'] = $partner['PartnerId'];
    }
}


function makeServiceCheckBox($services, $checked, $partner_id)
{
    $result = '';
    foreach ($services as $service) {
        $result .= '<input type="checkbox" disabled'
//            . ($checked ? 'checked="checked"' : '')
            . ' class="service-checker service-checker-' . $partner_id . '-' . $service->id . '" data-id="'
            . $service->id . '">';
        $result .= '<span class="label">' . $service->title . '</span>';
        $result .= '&nbsp<input type="text" class="timer timer-' . $partner_id . '" data-service-id="' . $service->id . '" data-partner-id="' . $partner_id . '" style="width:40px;"> минут';

        $result .= '<br>';
    }

    return $result;

}


echo '<h4>Информация о клиенте</h4>';
echo $this->renderPartial('_order_view', array('model' => $order));

echo '<h4>Информация об инциденте</h4>';
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
//        'status',
        'comment',
        array(
            'name' => 'payment_without_card',
            'type' => 'raw',
            'value' => function ($data) {
                    $checkbox = '<input disabled="disabled" type="checkbox"' .
                        ($data['payment_without_card'] ? 'checked="checked"' : '') .
                        '>';

                    return $checkbox;
                },
        ),

    ),
));


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


if (!empty($partners['available'])) {
    echo '<h4>Партнеры</h4>';


    $gridDataProvider = new CArrayDataProvider($partners['available']);

    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'condensed',
        'dataProvider' => $gridDataProvider,
        'template' => "{items}",
        'rowCssClassExpression' => '',
//    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('partnerAssign').'/id/"+$.fn.yiiGridView.getSelection(id);}',
        'columns' => array(
//            array(
//                'name' => 'selected',
//                'header' => '',
//                'type' => 'raw',
//                'value' => function ($data) {
//                        return '<input type="checkbox" disabled class="partner" data-id="' . $data['id'] . '">';
//                    },
//            ),

            array('name' => 'PartnerTitle', 'header' => 'Партнер'),
            array('name' => 'PartnerPhone', 'header' => 'Контактный телефон партнера'),
            array(
                'name' => 'ServiceTitles',
                'header' => 'Услуги',
                'type' => 'raw',
                'value' => function ($data) {
                        $result = '';

                        $result .= makeServiceCheckBox($data['services'], true, $data['id']);

                        if (!empty($data['all_services'])) {
                            $result .= CHtml::link('Показать больше', '#', array('onclick' => '$(".more-services-' . $data['id'] . '").toggle(); event.stopPropagation()'));
                            $result .= '<div class="more-services more-services-' . $data['id'] . '" style="display: none;">';
                            $result .= makeServiceCheckBox($data['all_services'], false, $data['id']);
                            $result .= '</div>';
                        }

                        return $result;
                    },
            ),
            array('name' => 'Workload', 'header' => 'Загруженность'),
        ),
    ));


}
?>



<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
//        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Назначить исполнителей!',
        'htmlOptions' => array(
            'class' => 'show-services',
        ),
    ));

    echo $this->renderPartial('_widget_unlock', array('ticket_id'=>$model->id));
    echo $this->renderPartial('_reject_widget', array('ticket_id'=>$model->id));
    ?>
</div>



<?php $this->endWidget(); ?>
