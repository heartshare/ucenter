<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form-login-form',
	'enableAjaxValidation'=>false,
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
		<?php echo $form->labelEx($model,'rememberMe'); ?>
		<?php echo $form->checkbox($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

    <?php echo CHtml::link('注册',array('register')); ?>

</div><!-- form -->