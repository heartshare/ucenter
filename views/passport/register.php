<?php
/* @var $this RegisterFormController */
/* @var $model RegisterForm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form-register-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repassword'); ?>
		<?php echo $form->textField($model,'repassword'); ?>
		<?php echo $form->error($model,'repassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ready'); ?>
		<?php echo $form->checkBox($model,'ready'); ?>
		<?php echo $form->error($model,'ready'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
        <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer','class'=>'verifyCode'))); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobileCode'); ?>
		<?php echo $form->textField($model,'mobileCode'); ?>
		<?php echo $form->error($model,'mobileCode'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->