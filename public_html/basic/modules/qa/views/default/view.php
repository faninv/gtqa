<?php
/**
 * @var \app\modules\qa\models\Question $model
 * @var \app\modules\qa\models\QaUser $userModel
 * @var \yii\data\ActiveDataProvider $answerDataProvider
 * @var string $answerOrder
 * @var \app\modules\qa\models\Answer $answer
 * @var \yii\web\View $this
 */

use artkost\qa\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$answerOrders = [
    'Active' => 'active',
    'Oldest' => 'oldest',
    'Votes' => 'votes'
];

app\modules\qa\assets\Qa::register($this);
?>
<section class="qa-view">
    <article class="qa-view-question row">
        <header class="page-header col-md-12">
            <h1 class="qa-view-title">
                <?= Html::encode($this->title) ?>

                <?php if ($model->isDraft()): ?>
                    <small><span class="label label-default"><?= Module::t('main', 'Draft') ?></span></small>
                <?php endif; ?>
            </h1>
        </header>
        <section class="qa-view-aside col-md-2" role="aside">
            <?= $this->render('parts/created', ['model' => $model]) ?>
        </section>
        <section class="qa-view-body col-md-10" role="main">
            <div class="panel panel-default">
                <section class="panel-body qa-view-text">
                    <?= $model->body ?>
                </section>
                <?= $this->render(Url::to('/default/parts/edit-links'), ['model' => $model]) ?>
            </div>
        </section>
    </article>

    <div class="qa-view-answers row">
        <div class="qa-view-answers-heading col-md-12  clearfix">
            <h3 class="qa-view-title"><?= Module::t('main', '{n, plural, =0{No answers yet} =1{One answer} other{# answers}}', ['n' => $answerDataProvider->totalCount]); ?></h3>
        </div>

        <div class="qa-view-answers-list col-md-12">
        <?php foreach ($answerDataProvider->models as $row): ?>
            <article class="qa-view-answer row">
                <section class="qa-view-answer-aside col-md-2">
                    <?= $this->render(Url::to('/default/parts/created'), ['model' => $row]) ?>
                </section>
                <section class="panel <?= ($row->isCorrect()) ? 'panel-warning': 'panel-default' ?> col-md-10">
                    <section class="panel-body">
                        <div class="qa-view-text">
                            <?= $row->body ?>
                        </div>
                    </section>
                </section>
            </article>

        <?php endforeach; ?>
        </div>

        <div class="qa-view-answer-pager">
            <?= $this->render(Url::to('/default/parts/pager'), ['dataProvider' => $answerDataProvider]) ?>
        </div>

        <div class="qa-view-answer-form">
            <?= $this->render(Url::to('/default/parts/form-answer'), ['model' => $answer, 'userModel' => $userModel, 'action' => Module::url(['answer', 'id' => $model->id])]); ?>
        </div>
    </div>
</section>