<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property UserNotification[] $userNotifications
 */
class NotificationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery|UserNotificationQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::className(), ['notification_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return NotificationTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationTypeQuery(get_called_class());
    }
}
