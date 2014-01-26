<script type="text/javascript">
    function showRejectPromt(reject_comment) {
//        window.event.cancelBubble = true;
//        var reject_comment = prompt("Введите комментарий отказа");

        if (reject_comment) {
            $.ajax({
                type: 'POST',
                url: '/api/ticket/reject/' + '<?php echo $ticket_id ?>',
                data: {'reject_comment': reject_comment},
                success: function (data) {
                    if (data['success']) {
                        document.location.href = '/ticket/admin/status/rejected'
                    } else {
                        bootbox.alert('При сохранении инцидента возникли ошибки');
                    }
                },
                error: function (data) {
                    bootbox.alert('Не удалось сохранить статус инцидента');
                },
                dataType: 'json'
            });

        } else {
            bootbox.alert("Не введен комментарий отказа")
        }


    }
</script>
<?
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Отказ',
        'type' => 'danger',
        'htmlOptions' => array(
            'style' => 'margin-left:3px',
            'onclick' => 'js:bootbox.prompt("Введите комментарий отказа", showRejectPromt)'
        ),
    )
);
?>
