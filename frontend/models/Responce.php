<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responce".
 *
 * @property int $id
 * @property int $task_id Идентификатор задания
 * @property int $executor_id Идентификатор исполнителя из таблицы пользователей
 * @property string $created_at
 * @property float|null $price Цена исполнителя
 * @property string|null $comment
 *
 * @property User $executor
 * @property Task $task
 */
class Responce extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responce';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'executor_id'], 'required'],
            [['task_id', 'executor_id'], 'integer'],
            [['created_at'], 'safe'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'Идентификатор задания'),
            'executor_id' => Yii::t('app', 'Идентификатор исполнителя из таблицы пользователей'),
            'created_at' => Yii::t('app', 'Created At'),
            'price' => Yii::t('app', 'Цена исполнителя'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ResponceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponceQuery(get_called_class());
    }
}
