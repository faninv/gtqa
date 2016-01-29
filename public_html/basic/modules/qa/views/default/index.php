<?php
/**
 * @var \app\modules\qa\models\Question[] $models
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use artkost\qa\Module;
use yii\helpers\Url;

$this->title = Module::t('main', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qa-index">
    <div class="row">
        <div class="col-md-12">
            <?= $this->render(Url::to('_tabs'), ['route' => $this->context->action->id]) ?>
            <?= $this->render(Url::to('/default/parts/list'), ['models' => $models]) ?>
        </div>
    </div>
    <?= ($dataProvider) ? $this->render(Url::to('/default/parts/pager'), ['dataProvider' => $dataProvider]) : false ?>
</div>


