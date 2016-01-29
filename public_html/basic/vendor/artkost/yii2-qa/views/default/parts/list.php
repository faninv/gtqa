<?php
/**
 * @var \artkost\qa\models\Question[] $models
 */
use artkost\qa\Module;
use yii\helpers\Html;

?>
<div class="qa-list list-group">
    <?php if (!empty($models)): foreach ($models as $model): ?>
        <div class="list-group-item clearfix qa-item" id="question-<?= $model->id ?>">
            <div class="qa-panels">
                <div class="qa-panel votes">
                    <div class="qa-panel-count"><?= $model->votes ?></div>
                    <div><?= Module::t('main', 'votes')?></div>
                </div>
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
                    <?= $this->render('created', ['model' => $model]) ?>
                    <?= $this->render('edit-links', ['model' => $model]) ?>
                </div>
                <h4 class="question-heading list-group-item-heading">
                    <a href="<?= Module::url(['view', 'id' => $model->id, 'alias' => $model->alias]) ?>"
                       class="question-link" title="<?= Html::encode($model->title) ?>"><?= Html::encode($model->title) ?></a>
                    <?php if ($model->isDraft()): ?>
                        <small><span class="label label-default"><?= Module::t('main', 'Draft') ?></span></small>
                    <?php endif; ?>
                </h4>
                <div class="question-tags">
                    <?= $this->render('tags-list', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    <?php endforeach; else: ?>
        <div class="list-group-item qa-item-not-found">
            <h4 class="list-group-item-heading question-heading"><?= Module::t('main', 'No questions yet') ?></h4>
        </div>
    <?php endif; ?>
</div>
