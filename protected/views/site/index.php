<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Добро пожаловать на портал "'.CHtml::encode(Yii::app()->name) . '"',
)); ?>


<?php $this->endWidget(); ?>

<?php //echo $l; ?>
