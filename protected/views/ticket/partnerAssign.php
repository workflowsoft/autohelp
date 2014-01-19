
<h1>Назначение партнеров на инцидент #<?php echo $model->id; ?></h1>

<?php
    echo $this->renderPartial(
        '_form_partner_assign',
        array(
            'model'=>$model,
            'partners' => $partners,
            'order' => $order,
        )
    );
?>