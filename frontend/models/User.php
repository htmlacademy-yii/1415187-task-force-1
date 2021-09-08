<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $date_add Время последней активности на сайте
 * @property string $date_activity
 * @property int $is_visible Показывает/скрывает профиль пользователя. Если пользователь заказчик - скрыть контакты со страницы пользователя. Если пользователь исполнитель - скрыть показ карточки со страницы исполнителей.
 * @property int|null $city_id Идентификатор города из таблицы городов
 * @property string|null $address Адрес пользователя
 * @property string|null $birthday
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string|null $avatar
 * @property string|null $about
 * @property int $is_deleted
 *
 * @property City $city
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Opinion[] $opinions
 * @property Opinion[] $opinions0
 * @property Portfolio[] $portfolios
 * @property Responce[] $responces
 * @property Specialisation[] $specialisations
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserNotification[] $userNotifications
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password'], 'required'],
            [['date_add', 'date_activity', 'birthday'], 'safe'],
            [['is_visible', 'city_id', 'is_deleted'], 'integer'],
            [['about'], 'string'],
            [['email', 'name', 'avatar'], 'string', 'max' => 128],
            [['password', 'skype', 'telegram'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'name' => Yii::t('app', 'Name'),
            'password' => Yii::t('app', 'Password'),
            'date_add' => Yii::t('app', 'Время последней активности на сайте'),
            'date_activity' => Yii::t('app', 'Date Activity'),
            'is_visible' => Yii::t('app', 'Показывает/скрывает профиль пользователя.
Если пользователь заказчик - скрыть контакты со страницы пользователя.
Если пользователь исполнитель - скрыть показ карточки со страницы исполнителей.'),
            'city_id' => Yii::t('app', 'Идентификатор города из таблицы городов'),
            'address' => Yii::t('app', 'Адрес пользователя'),
            'birthday' => Yii::t('app', 'Birthday'),
            'phone' => Yii::t('app', 'Phone'),
            'skype' => Yii::t('app', 'Skype'),
            'telegram' => Yii::t('app', 'Telegram'),
            'avatar' => Yii::t('app', 'Avatar'),
            'about' => Yii::t('app', 'About'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorite::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery|FeedbackQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessageQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery|MessageQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery|OpinionQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions0]].
     *
     * @return \yii\db\ActiveQuery|OpinionQuery
     */
    public function getOpinions0()
    {
        return $this->hasMany(Opinion::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery|PortfolioQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Responces]].
     *
     * @return \yii\db\ActiveQuery|ResponceQuery
     */
    public function getResponces()
    {
        return $this->hasMany(Responce::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Specialisations]].
     *
     * @return \yii\db\ActiveQuery|SpecialisationQuery
     */
    public function getSpecialisations()
    {
        return $this->hasMany(Specialisation::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery|UserNotificationQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
