<?php

namespace baxriev\vote\models;

use oks\langs\components\ModelBehavior;
use oks\langs\models\Langs;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vote_questions".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property string $top
 * @property string $status
 * @property int $lang
 * @property string $lang_hash
 *
 * @property QuestionAnswers[] $questionAnswers
 * @property Langs $lang0
 */
class VoteQuestions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vote_questions';
    }

    public function behaviors()
    {
        return [
            'ts' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at'
                ]
            ],
            'lang' => [
                'class' => ModelBehavior::className(),
                'fill' => [
                    'status' => '',
                    'top' => '',
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'lang'], 'integer'],
            [['title', 'top', 'status'], 'string', 'max' => 255],
            [['lang_hash'], 'string', 'max' => 60],
            [['lang'], 'exist', 'skipOnError' => true, 'targetClass' => Langs::className(), 'targetAttribute' => ['lang' => 'lang_id']],
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
            'created_at' => 'Created At',
            'top' => 'Top',
            'status' => 'Status',
            'lang' => 'Lang',
            'lang_hash' => 'Lang Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteAnswers()
    {
        return $this->hasMany(VoteAnswers::className(), ['questions_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Langs::className(), ['lang_id' => 'lang']);
    }
}
