<?php

namespace app\modules\qa\models;

use artkost\qa\models\Answer as BaseAnswer;
use artkost\qa\ActiveRecord;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

class Answer extends BaseAnswer
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'body'
                ],
                'value' => function ($event) {
                    return HtmlPurifier::process(Markdown::process($event->sender->content, 'gfm-comment'));
                }
            ],
        ];
    }

    /**
     * User Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(\app\modules\qa\models\QaUser::className(), ['id' => 'user_id']);
    }

    /**
     * Formatted user
     * @return int
     */
    public function getUserName()
    {
        return $this->user->username;
    }
}