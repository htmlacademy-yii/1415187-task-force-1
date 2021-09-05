<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opinion".
 *
 * @property int $id
 * @property int $executor_id
 * @property int $customer_id
 * @property int $rate
 * @property string $created_at
 * @property string|null $description
 *
 * @property User $customer
 * @property User $executor
 */
class Opinion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'customer_id', 'rate'], 'required'],
            [['executor_id', 'customer_id', 'rate'], 'integer'],
            [['created_at'], 'safe'],
            [['description'], 'string'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'executor_id' => Yii::t('app', 'Executor ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'rate' => Yii::t('app', 'Rate'),
            'created_at' => Yii::t('app', 'Created At'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
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
     * {@inheritdoc}
     * @return OpinionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpinionQuery(get_called_class());
    }
}
