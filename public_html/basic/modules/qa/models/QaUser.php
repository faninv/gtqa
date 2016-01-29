<?php
namespace app\modules\qa\models;

use Yii;

/**
 * This is the model class for table "qa_user".
 *
 * @property integer $id
 * @property string $username
 */
class QaUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qa_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя',
        ];
    }

    /**
     * @param $name
     * @return QaUser|bool
     */
    public function createUser($name){
        $newUser = new QaUser();
        $newUser->username = $name;
        if($newUser->save())
            return $newUser;
        return false;
    }
}