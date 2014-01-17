<?php

Yii::app()->clientScript->registerScript('status', "
    $('.filter-$status').css('border', '3px solid red');
");
?>


<h1>Управление инцидентами</h1>

<!--'new', 'assigned', 'done', 'rejected'-->
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => '',
    'label' => 'Мои черновики',
    'url' => $this->createUrl('/ticket/admin/status/draft'),
    'htmlOptions' => array('class' => 'filter filter-draft', 'data-at' => 'draft'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => '',
    'label' => 'Мои назначения',
    'url' => $this->createUrl('/ticket/admin/status/assigning'),
    'htmlOptions' => array('class' => 'filter filter-assigning', 'data-at' => 'assigning'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => '',
    'label' => 'Мои проверки',
    'url' => $this->createUrl('/ticket/admin/status/checking'),
    'htmlOptions' => array('class' => 'filter filter-checking', 'data-at' => 'checking'),
)); ?>
<br>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'info',
    'label' => 'Новые',
    'url' => $this->createUrl('/ticket/admin/status/new'),
    'htmlOptions' => array('class' => 'filter filter-new', 'data-at' => 'new'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'warning',
    'label' => 'Назначенные',
    'url' => $this->createUrl('/ticket/admin/status/assigned'),
    'htmlOptions' => array('class' => 'filter filter-assigned', 'data-at' => 'assigned'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'success',
    'label' => 'Успешно выполненные',
    'url' => $this->createUrl('/ticket/admin/status/done'),
    'htmlOptions' => array('class' => 'filter filter-done', 'data-at' => 'done'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'danger',
    'label' => 'Отклоненные',
    'url' => $this->createUrl('/ticket/admin/status/rejected'),
    'htmlOptions' => array('class' => 'filter filter-rejected', 'data-at' => 'rejected'),
)); ?>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ticket-grid',
    'dataProvider' => $model->searchByStatus($status),
    'filter' => $model,
    'selectionChanged' => 'function(id){ location.href = "' . $this->createUrl('partnerAssign') . '/id/"+$.fn.yiiGridView.getSelection(id);}',

    'columns' => array(
        'id',
//        'status',
        'comment',
        'user_id',
        'last_status_change',
        'payment_without_card',
//		array(
//			'class'=>'bootstrap.widgets.TbButtonColumn',
//		),
    ),
)); ?>
