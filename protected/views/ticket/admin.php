<?php

Yii::app()->clientScript->registerScript('status', "
    $('.filter-$status').css('border', '3px solid red');
");
?>


<h1>Управление инцидентами</h1>

<a class="filter filter-draft btn" data-at="draft" href="/ticket/admin/status/draft">
    Мои черновики <span class="badge"><?php echo !empty($counters[TicketStatus::DRAFT])? $counters[TicketStatus::DRAFT] : '' ;?></span>
</a>
<a class="filter filter-assigning btn" data-at="assigning" href="/ticket/admin/status/assigning">
    Мои назначения <span class="badge"><?php echo !empty($counters[TicketStatus::ASSIGNING])? $counters[TicketStatus::ASSIGNING] : '';?></span>
</a>
<a class="filter filter-checking btn" data-at="checking" href="/ticket/admin/status/checking">
    Мои проверки <span class="badge"><?php echo empty($counters[TicketStatus::CHECKING])? $counters[TicketStatus::CHECKING] : '';?></span>
</a>

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


<?php

switch ($status) {
    case 'draft' :
        $selection_changed = 'update';
        break;
    case 'new' :
        $selection_changed = 'partnerAssign';
        break;
    case 'assigning' :
        $selection_changed = 'partnerAssign';
        break;
    case 'assigned' :
        $selection_changed = 'check';
        break;
    case 'checking' :
        $selection_changed = 'check';
        break;
    case 'done' :
        $selection_changed = 'view';
        break;
    case 'rejected' :
        $selection_changed = 'view';
        break;
    default;
}
$selection_changed = $this->createUrl($selection_changed);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ticket-grid',
    'dataProvider' => $model->searchByStatus($status),
    'filter' => $model,
    'selectionChanged' => 'function(id){ location.href = "' . $selection_changed . '/id/"+$.fn.yiiGridView.getSelection(id);}',

    'columns' => array(
        'id',
        'comment',
        array(
            'value'=>'$data->order->last_name . " " . $data->order->first_name. " " . $data->order->middle_name',//This is the concatenated column
            'header'=>'ФИО клиента',
        ),
        array(
            'value'=>'$data->order->phone',
            'header'=>'Номер телефона клиента',
        ),

    ),
)); ?>
