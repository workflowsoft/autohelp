<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('middle_name')); ?>:</b>
	<?php echo CHtml::encode($data->middle_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('vin')); ?>:</b>
	<?php echo CHtml::encode($data->vin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grn')); ?>:</b>
	<?php echo CHtml::encode($data->grn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ts_make')); ?>:</b>
	<?php echo CHtml::encode($data->ts_make); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ts_model')); ?>:</b>
	<?php echo CHtml::encode($data->ts_model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ts_color')); ?>:</b>
	<?php echo CHtml::encode($data->ts_color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_delivery_address')); ?>:</b>
	<?php echo CHtml::encode($data->card_delivery_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_id')); ?>:</b>
	<?php echo CHtml::encode($data->card_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_start')); ?>:</b>
	<?php echo CHtml::encode($data->activation_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_end')); ?>:</b>
	<?php echo CHtml::encode($data->activation_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_coords')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_coords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_street')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_street); ?>
	<br />

	*/ ?>

</div>