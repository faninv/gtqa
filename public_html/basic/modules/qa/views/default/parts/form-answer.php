<?php

use artkost\qa\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$action = isset($action) ? $action : '';

/** @var ActiveForm $form */
$form = ActiveForm::begin(['id' => 'answer-form', 'action' => $action, 'enableClientValidation' => true]);
?>

<?php echo $form->errorSummary([$model,$userModel]); ?>

<?php echo $form->field($userModel, 'username')
    ->textInput(); ?>

<?php echo $form->field($model, 'content')
    ->textarea(['rows' => 6])
    ->hint(Module::t('main', 'Markdown powered content')); ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('main', 'Answer'), ['class' =>'btn btn-success']); ?>
    </div>

<?php ActiveForm::end() ?>
