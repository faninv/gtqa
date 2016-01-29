<?php
/**
 * @var string $route
 */
use artkost\qa\Module;
use yii\helpers\url;

?>
<div class="qa-index-header">
    <a class="qa-index-add-button btn btn-primary"
       href="<?= Module::url(['ask']) ?>"><?= Module::t('main', 'Ask a Question') ?></a>
    <ul class="qa-index-tabs nav nav-tabs">
        <li <?= ($route == 'index') ? 'class="active"' : '' ?>><a
                href="<?= Module::url(['index']) ?>"><?= 'Все' ?></a></li>

        <li <?= ($route == 'unanswered') ? 'class="active"' : '' ?>><a
                href="<?= url::to(['unanswered']) ?>"><?= 'Неосвещенные' ?></a></li>

        <li <?= ($route == 'answered') ? 'class="active"' : '' ?>><a
                href="<?= Module::url(['answered']) ?>"><?= 'Отвеченные' ?></a></li>
    </ul>
</div>