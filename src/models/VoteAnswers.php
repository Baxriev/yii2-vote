<?php

namespace baxriev\vote\models;

use Yii;

/**
 * This is the model class for table "vote_answers".
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $questions_id
 *
 * @property QuestionAnswers[] $questionAnswers
 */
class VoteAnswers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort', 'questions_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'sort' => 'Sort',
            'questions_id' => 'Questions',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionId()
    {
        return $this->hasOne(VoteQuestions::className(), ['questions_id' => 'id']);
    }
}
