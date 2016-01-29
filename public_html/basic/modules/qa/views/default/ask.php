<?php
use artkost\qa\Module;
use yii\helpers\Url;

$this->title = Module::t('main', 'Ask a Question');
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <h1><?= $this->title ?></h1>
        <?php echo $this->render(Url::to('/default/parts/form-question'), ['model' => $model, 'userModel' => $userModel]); ?>
    </div>
</div>