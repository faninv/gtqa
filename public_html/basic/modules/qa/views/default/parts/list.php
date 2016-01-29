<?php
/**
 * @var \app\modules\qa\models\Question[] $models
 */
use artkost\qa\Module;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="qa-list list-group">
    <?php if (!empty($models)): foreach ($models as $model): ?>
        <div class="list-group-item clearfix qa-item" id="question-<?= $model->id ?>">
            <div class="qa-panels">
                 <div class="qa-panel <?= ($model->answers > 0) ? 'status-answered' : 'status-unanswered' ?>">
                    <div class="qa-panel-count"><?= $model->answers ?></div>
                    <div><?= Module::t('main', 'answers')?></div>
                </div>
                <div class="qa-panel views">
                    <div class="qa-panel-count"><?= $model->views ?></div>
                    <div><?= Module::t('main', 'views') ?></div>
                </div>
            </div>
            <div class="qa-summary">
                <div class="question-meta">
                    <?= $this->render(Url::to('created'), ['model' => $model]) ?>
                </div>
                <h4 class="question-heading list-group-item-heading">
                    <a href="<?= Module::url(['view', 'id' => $model->id, 'alias' => $model->alias]) ?>"
                       class="question-link" title="<?= Html::encode($model->title) ?>"><?= Html::encode($model->title) ?></a>
                    <?php if ($model->isDraft()): ?>
                        <small><span class="label label-default"><?= Module::t('main', 'Draft') ?></span></small>
                    <?php endif; ?>
                </h4>
            </div>
        </div>
    <?php endforeach; else: ?>
        <div class="list-group-item qa-item-not-found">
            <h4 class="list-group-item-heading question-heading"><?= Module::t('main', 'No questions yet') ?></h4>
        </div>
    <?php endif; ?>
</div>
