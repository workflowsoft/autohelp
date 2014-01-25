<script type="text/javascript">

    function save() {
        var postdata = {};
        if ($(this).hasClass('save-success')) {
            postdata['success'] = 1;
        } else {
            var comment = $('.reject-comment').val();
            if (comment == '') {
                alert('Поле комментария отказа не может быть пустым');
                return false;
            }
            postdata['success'] = 0;
            postdata['reject_comment'] = comment;

            var services = [];
            var error = false;
            $.each($('.grid-view').find('.service-checker'), function (key, tr) {
                if ($(this).attr('checked')) {
                    var reject_input = $(this).next().next();
                    if (reject_input.val() == '') {
                        error = true;
                        return false;
                    }
                    services.push({
                        'partner_id': reject_input.data('partner_id'),
                        'service_id': reject_input.data('id'),
                        'comment': reject_input.val()
                    });
                }
            });
            if (error) {
                alert('Причина отказа не может быть пустой');
                return false;
            }
            postdata['rejected_services'] = services;

        }

        $.ajax({
            type: 'POST',
            url: '$url',
            data: postdata,
            // TODO fucking govnocode with redirects, use ajax or yii forms
            // Make action as api, it shouldn return the page
            success: function (data) {
                if (data['success']) {
                    document.location.href = '$redirect_url'
                } else {
                    alert('При соранении статуса возникли ошибки')
                }
            },
            error: function (data) {
                alert('Не удалось сохранить статус инцидента')
            },
            dataType: 'json'
        });


        return false;
    }

    function showServiceReject() {
        $('.service-checker').toggle();
        $('.service-reject').toggle();
    }


    $('body').on('click', '.save-success', save);
    $('body').on('click', '.save-rejected', save);
    $('body').on('click', '.show-service-reject', showServiceReject);

</script>


<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);

$url = Yii::app()->request->requestUri;
$url = str_replace('check', 'a_saveChecked', $url);
$redirect_url = $this->createUrl('/ticket/admin/status/checking');
?>

<h1> Проверка инцидента #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
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
)); ?>

<?php

echo '<h4>Информация о клиенте</h4>';
echo $this->renderPartial('_order_view', array('model' => $order));


echo '<h4>Назначенные Партнеры</h4>';

$this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'danger',
    'label' => 'Отметить услуги, которые не могут быть оказаны',
    'htmlOptions' => array(
        'class' => 'show-service-reject',
    ),

));

function makeServiceCheckBox($services, $partner_id)
{
    $result = '';
    foreach ($services as $service) {

        $result .= '<input type="checkbox" style="display:none;"'
            . ' class="service-checker" data-id="'
            . $service['service']->id . '">';

        $result .= '<span class="label">' . $service['service']->title . '</span>';
        $result .= '&nbsp;';
        $result .= $service['time'];
        $result .= '&nbsp;';
        $result .= '<input type="text" placeholder="Причина отказа" style="display:none;" class="service-reject" data-partner_id="' . $partner_id . '" data-id="' . $service['service']->id . '">';

        $result .= '<br>';
    }

    return $result;

}


$gridDataProvider = new CArrayDataProvider($partners);
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'condensed',
    'dataProvider' => $gridDataProvider,
    'template' => "{items}",
    'rowCssClassExpression' => '',
    'columns' => array(
        array('name' => 'title', 'header' => 'Партнер'),
        array('name' => 'phone', 'header' => 'Контактный телефон партнера'),
        array(
            'name' => 'ServiceTitles',
            'header' => 'Услуги',
            'type' => 'raw',
            'value' => function ($data) {
                    $result = '';
                    $result .= makeServiceCheckBox($data['services'], $data['id']);
//                    foreach($data['services'] as $service) {

//                        $result .= '<span class="label">' . $service['service']->title . '</span>';
//                        $result .= '&nbsp;';
//                        $result .= $service['time'];
                    $result .= '<br>';
//                    }

                    return $result;
                },
        ),
    ),
));

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
));

echo $form->textAreaRow($model, 'reject_comment', array('class' => 'span5 reject-comment', 'maxlength' => 2048));
?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
        'label' => 'В успешные',
        'htmlOptions' => array(
            'class' => 'save-success',
        ),

    ));

    echo '&nbsp';

    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'danger',
        'label' => 'В отказ',
        'htmlOptions' => array(
            'class' => 'save-rejected',
        ),

    ));


    ?>
</div>
<?php


$this->endWidget();



?>



