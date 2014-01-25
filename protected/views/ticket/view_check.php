<?php
$url = Yii::app()->request->requestUri;
$url = '/api/ticket/saveChecked/' . $model->id;
$redirect_url = $this->createUrl('/ticket/admin/status/checking');

?>

<script type="text/javascript">

    function save() {
        var postdata = {};
        var services = [];
        $.each($('.grid-view').find('.service-checker'), function (key, tr) {
            if ($(this).attr('checked')) {
                var reject_input = $(this).next().next().next();
                services.push({
                    'partner_id': reject_input.data('partner-id'),
                    'service_id': reject_input.data('service-id'),
                    'comment': reject_input.val()
                });
            }
        });
        postdata['rejected_services'] = services;

        $.ajax({
            type: 'POST',
            url: '<?php echo $url ?>',
            data: postdata,
            success: function (data) {
                if (data['success']) {
                    document.location.href = '<?php echo $redirect_url?>'
                } else {
                    alert('При сохранении инцидента возникли ошибки')
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

    function onKeyUpServiceReject() {
        var input = $(this);
        var sc = '.service-checker-' + input.data('partner-id') + '-' + input.data('service-id');
        if (input.val() != '') {
            $(sc).attr('checked', true);
        } else {
            $(sc).attr('checked', false);
        }

    }


    $(document).ready(function () {
        $('body').on('keyup', '.service-reject', onKeyUpServiceReject);
        $('body').on('click', '.save-done', save);
//        $('body').on('click', '.save-rejected', save);
        $('body').on('click', '.show-service-reject', showServiceReject);

    });


</script>


<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);

?>

<h1> Проверка инцидента #<?php echo $model->id; ?></h1>

<?php

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

        $result .= '<input type="checkbox" disabled style="display:none;"'
            . ' class="service-checker service-checker-' . $partner_id . '-' . $service['service']->id . '" data-id="'
            . $service['service']->id . '">';

        $result .= '<span class="label">' . $service['service']->title . '</span>';
        $result .= '&nbsp;';
        $result .= $service['time'];
        $result .= '&nbsp;';
        $result .= '<br>';
        $result .= '<input
            type="text"
            placeholder="Причина отказа"
            style="display:none;"
            class="service-reject "
            data-partner-id="' . $partner_id . '" data-service-id="' . $service['service']->id . '">';

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
                    $result .= '<br>';

                    return $result;
                },
        ),
    ),
));

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ticket-form',
    'enableAjaxValidation' => false,
));

//echo $form->textAreaRow($model, 'reject_comment', array('class' => 'span5 reject-comment', 'maxlength' => 2048));
?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
        'label' => 'Закрыть инцидент',
        'htmlOptions' => array(
            'class' => 'save-done',
        ),

    ));

    //    echo '&nbsp';
    //
    //    $this->widget('bootstrap.widgets.TbButton', array(
    //        'type' => 'danger',
    //        'label' => 'В отказ',
    //        'htmlOptions' => array(
    //            'class' => 'save-rejected',
    //        ),
    //
    //    ));


    ?>
</div>
<?php


$this->endWidget();



?>



