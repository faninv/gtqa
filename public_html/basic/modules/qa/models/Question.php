<?php

namespace app\modules\qa\models;

use artkost\qa\models\Question as BaseQuestion;
use artkost\qa\ActiveRecord;
use artkost\qa\Module;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;
use yii\helpers\Markdown;

class Question extends BaseQuestion
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
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias'
                ],
                'value' => function ($event) {
                    return Inflector::slug($event->sender->title);
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'body'
                ],
                'value' => function ($event) {
                    return HtmlPurifier::process(Markdown::process($event->sender->content, 'gfm'));
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required']
        ];
    }

    /**
     * This is invoked after the record is saved.
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return int|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserName()
    {
        return $this->user ? Module::getInstance()->getUserName($this->user, 'id') : $this->user_id;
    }

    public function getUnanswered()
    {
        $this->find()->all();
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * User Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(\app\modules\qa\models\QaUser::className(), ['id' => 'user_id']);
    }
}
