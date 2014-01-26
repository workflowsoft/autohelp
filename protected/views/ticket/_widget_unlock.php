<script type="text/javascript">
    function unlock(){
        $.ajax({
            type: 'POST',
            url: '<?php echo "/api/ticket/unlock/" . $ticket_id?>',
            data: '',
            success: function (data) {
                if(data.success) {
                    document.location.href = '/ticket/admin';
                } else {
                    bootbox.alert('<b>Ошибка</b>' + data.message);
                }

            },
            error: function (data) {
                bootbox.alert('Не разблокировать тикет');
            },
            dataType: 'json'
        });


    }
</script>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'primary',
    'label' => 'Снять блокировку тикета',
    'htmlOptions' => array(
        'style' => 'margin-left:3px',
        'onclick' => 'js:unlock()'
    ),
));
?>
