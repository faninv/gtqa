<?php

namespace app\modules\qa\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Question Model Search
 * @package app\modules\qa\models
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()->with('user');

        $query->andWhere(['status' => self::STATUS_PUBLISHED]);

        if (isset($params['tags']) && $params['tags']) {
            $query->andWhere(['like', 'tags', $params['tags']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchUnanswered($params)
    {
        $query = self::find()->leftJoin('qa_answer', 'qa_question.id = qa_answer.question_id')->where(['qa_answer.question_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchAnswered($params)
    {
        $query = self::find()->joinWith('answers');
        $query
            ->andWhere([
                'qa_question.status' => self::STATUS_PUBLISHED,
            ])
            ->andWhere(['!=', 'qa_answer.question_id', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @param int $userID
     * @return ActiveDataProvider
     */
    public function searchFavorite($params, $userID)
    {
        $dataProvider = $this->search($params);
        $dataProvider->query
            ->joinWith('favorites', true, 'RIGHT JOIN')
            ->andWhere([self::tableName() . '.user_id' => $userID]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @param $userID
     * @return ActiveDataProvider
     */
    public function searchMy($params, $userID)
    {
        $dataProvider = $this->search($params);
        $dataProvider->query
            ->andWhere(['status' => self::STATUS_DRAFT])
            ->where(['user_id' => $userID]);

        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
