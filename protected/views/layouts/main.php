<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Поиск клиентов', 'url'=>array('/order/search')),

                array('label'=>'Заказы', 'url'=>array('/order/admin/?action_tag=call'),
                'items' => array(
                    array('label'=>'Добавить заказ', 'url'=>array('/order/create')),
                    array('label'=>'Управление заказами', 'url'=>array('/order/admin/?action_tag=call')),
                )),
                array('label'=>'Инциденты', 'url'=>array('/ticket/admin'),
                    'items' => array(
                        array('label'=>'Добавить инцидент', 'url'=>array('/order/search')),
                        array('label'=>'Управление инцидентами', 'url'=>array('/ticket/admin/status/new')),
                )),
                array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'homeLink'=> CHtml::link('Главная', $this->createUrl('/')),
        )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
