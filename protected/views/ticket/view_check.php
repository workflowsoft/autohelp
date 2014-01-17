<?php
$this->menu = array(
    array('label' => 'Управление инцидентами', 'url' => array('admin')),
    array('label' => 'Поиск клиентов', 'url' => array('/order/search')),
);

$url = Yii::app()->request->requestUri;
$url = str_replace('check', 'a_saveChecked', $url);
$redirect_url = $this->createUrl('/ticket/admin/status/checking');

Yii::app()->clientScript->registerScript('actions', "

function save(){
    var postdata = {};
    if($(this).hasClass('save-success')) {
        postdata['success'] = 1;
    } else {
        var comment =$('.reject-comment').val();
        if( comment == '') {
            alert('Поле комментария отказа не может быть пустым');
            return false;
        }
        postdata['success'] = 0;
        postdata['reject_comment'] = comment;
    }

    $.ajax({
        type: 'POST',
        url: '$url',
        data: postdata,
        // TODO fucking govnocode with redirects, use ajax or yii forms
        // Make action as api, it shouldn return the page
        success: function(data) {  if(data['success']) { document.location.href = '$redirect_url'} else {alert('При соранении статуса возникли ошибки')}},
        error: function(data) {alert('Не удалось сохранить статус инцидента')},
        dataType: 'json'
    });


    return false;
}

$( 'body' ).on( 'click', '.save-success', save);
$( 'body' ).on( 'click', '.save-rejected', save);
");
?>



<h1>Проверка инцидента #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
//        'status',
        'comment',
//		'user_id',
//		'last_status_change',
        'payment_without_card',
    ),
)); ?>

<?php

echo '<h4>Назначенные Партнеры</h4>';

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
                    foreach($data['services'] as $service) {
                        $result .= '<span class="label">' . $service['service']->title . '</span>';
                        $result .= '&nbsp;';
                        $result .= $service['time'];
                        $result .= '<br>';
                    }

                    return $result;
                },
        ),
    ),
));

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'ticket-form',
    'enableAjaxValidation'=>false,
));

echo $form->textAreaRow($model,'reject_comment',array('class'=>'span5 reject-comment','maxlength'=>2048));
?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'label'=> 'В успешные',
        'htmlOptions' => array(
            'class' => 'save-success',
        ),

    ));

    echo '&nbsp';

    $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'danger',
        'label'=> 'В отказ',
        'htmlOptions' => array(
            'class' => 'save-rejected',
        ),

    ));


    ?>
</div>
<?php


$this->endWidget();



?>



