<?php

namespace baxriev\vote\models;

use Yii;

/**
 * This is the model class for table "vote_result".
 *
 * @property int $id
 * @property int $questions_id
 * @property int $answer_id
 */
class VoteResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questions_id', 'answer_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questions_id' => 'Questions ID',
            'answer_id' => 'Answer ID',
        ];
    }
}
