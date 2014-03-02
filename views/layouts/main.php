<?php
//$cs = Yii::app()->clientScript;
//$cs->registerCssFile(Yii::app()->request->baseUrl. '/assets/bootstrap/css/bootstrap.css');
//$cs->registerCssFile(Yii::app()->request->baseUrl. '/assets/css/style.css');
//$cs->registerScriptFile(Yii::app()->request->baseUrl. '/assets/js/jquery-1.11.0.min.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile(Yii::app()->request->baseUrl. '/assets/js/jquery-migrate-1.2.1.min.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile(Yii::app()->request->baseUrl. '/assets/bootstrap/js/bootstrap.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile(Yii::app()->request->baseUrl. '/assets/js/html5shiv.js', CClientScript::POS_HEAD, array('media' => 'lt IE 9'));
//?>


<?php $this->beginContent('//layouts/main'); ?>
    <?php echo $this->renderPartial('/public/header');?>
    <?php echo $content; ?>
    <?php echo $this->renderPartial('/public/footer');?>
<?php $this->endContent(); ?>