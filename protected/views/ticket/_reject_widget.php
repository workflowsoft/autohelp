<script type="text/javascript">
    function showRejectPromt() {
        window.event.cancelBubble = true;
        var reject_comment = prompt("Введите комментарий отказа");

        if (reject_comment) {
            $.ajax({
                type: 'POST',
                url: '/api/ticket/reject/' + '<?php echo $ticket_id ?>',
                data: {'reject_comment': reject_comment},
                success: function (data) {
                    if (data['success']) {
                        document.location.href = '/ticket/admin/status/rejected'
                    } else {
                        alert('При сохранении инцидента возникли ошибки');
                    }
                },
                error: function (data) {
                    alert('Не удалось сохранить статус инцидента');
                },
                dataType: 'json'
            });

        } else {
            alert('Не введен комментарий отказа');
        }


    }
</script>
<button class="btn btn-danger" onclick="showRejectPromt();return false;">
    В отказ
</button>

