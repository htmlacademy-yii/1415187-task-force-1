<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_notification".
 *
 * @property int $user_id Таблица настроек уведомлений пользователя. Если запись существует - уведомление активно.
 * @property int $notification_id Идентификатор типа уведомления
 *
 * @property NotificationType $notification
 * @property User $user
 */
class UserNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'notification_id'], 'required'],
            [['user_id', 'notification_id'], 'integer'],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::className(), 'targetAttribute' => ['notification_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'Таблица настроек уведомлений пользователя.
Если запись существует - уведомление активно.'),
            'notification_id' => Yii::t('app', 'Идентификатор типа уведомления'),
        ];
    }

    /**
     * Gets query for [[Notification]].
     *
     * @return \yii\db\ActiveQuery|NotificationTypeQuery
     */
    public function getNotification()
    {
        return $this->hasOne(NotificationType::className(), ['id' => 'notification_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserNotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserNotificationQuery(get_called_class());
    }
}
