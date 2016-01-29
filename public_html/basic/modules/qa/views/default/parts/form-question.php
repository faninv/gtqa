<?php
use artkost\qa\Module;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\qa\models\Question */
/* @var $form ActiveForm */

$form = ActiveForm::begin(['id' => 'question-form', 'enableClientValidation' => true]);
?>

<?php echo $form->errorSummary([$model,$userModel]); ?>

<?php echo $form->field($model, 'title')
    ->textInput()
    ->hint(Module::t('main', "What's your question? Be specific.")
    );
?>

<?php echo $form->field($userModel, 'username')
    ->textInput(); ?>

<?php echo $form->field($model, 'content')
    ->textarea(['rows' => 5])
    ->hint(Module::t('main', 'Markdown powered content')); ?>

    <div class="form-group">
        <div class="btn-group ">
            <?= Html::submitButton(Module::t('main', 'Publish'), ['class' =>'btn btn-primary']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
