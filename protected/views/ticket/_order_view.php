<?php
    $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
        'phone',
        'email',
		'first_name',
		'middle_name',
		'last_name',
		'vin',
		'grn',
		'ts_make',
		'ts_model',
		'ts_color',
//		'card_delivery_address',
		'card_id',
//		'activation_start',
//		'activation_end',
//		'delivery_coords',
//		'delivery_street',
	),
)); ?>
