DROP SCHEMA IF EXISTS taskforce;
CREATE SCHEMA taskforce
DEFAULT CHARACTER SET UTF8MB4
DEFAULT COLLATE utf8mb4_general_ci;
USE taskforce;
SET default_storage_engine=InnoDB;

CREATE TABLE category
(
    id   int         NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(64) NOT NULL,
    icon varchar(128)
) COMMENT 'Список категорий';

CREATE TABLE city
(
    id     int           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name   varchar(64)   NOT NULL,
    lat    decimal(8, 6) NOT NULL,
    `long` decimal(9, 6) NOT NULL
) COMMENT 'Список городов';

CREATE TABLE notification_type
(
    id   int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(128) NOT NULL
);

CREATE TABLE status
(
    id   int         NOT NULL PRIMARY KEY,
    name varchar(64) NOT NULL
) COMMENT 'Статусы заданий';

CREATE TABLE `user`
(
    id            int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email         varchar(128) NOT NULL,
    name          varchar(128) NOT NULL,
    password      char(64)     NOT NULL,
    date_add      datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время последней активности на сайте',
    date_activity datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_visible    boolean      NOT NULL DEFAULT true COMMENT 'Показывает/скрывает профиль пользователя.\nЕсли пользователь заказчик - скрыть контакты со страницы пользователя.\nЕсли пользователь исполнитель - скрыть показ карточки со страницы исполнителей.',
    city_id       int COMMENT 'Идентификатор города из таблицы городов',
    address        varchar(255) COMMENT 'Адрес пользователя',
    birthday      date,
    phone         varchar(11),
    skype         varchar(64),
    telegram      varchar(64),
    avatar        varchar(128),
    about         text,
    is_deleted    boolean      NOT NULL DEFAULT false,
    CONSTRAINT fk_users_cities FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE SET NULL ON UPDATE NO ACTION
);

CREATE TABLE user_notification
(
    user_id         int NOT NULL COMMENT 'Таблица настроек уведомлений пользователя.\nЕсли запись существует - уведомление активно.',
    notification_id int NOT NULL COMMENT 'Идентификатор типа уведомления',
    CONSTRAINT fk_user_notification_users FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_user_notification FOREIGN KEY (notification_id) REFERENCES notification_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE favorite
(
    customer_id int NOT NULL,
    executor_id int NOT NULL,
    CONSTRAINT fk_favorites_customer FOREIGN KEY (customer_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_favorites_executor FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Избранные исполнители';

CREATE TABLE portfolio
(
    id       int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id  int          NOT NULL,
    filepath varchar(255) NOT NULL,
    CONSTRAINT fk_images_of_work_users FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Портфолио исполнителей';

CREATE TABLE specialisation
(
    executor_id int NOT NULL,
    category_id int NOT NULL,
    CONSTRAINT fk_specialisations_users FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_specialisations_categories FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Специализации исполнителей.\nЕсли специализаций у пользователя нет - он заказчик.';

CREATE TABLE task
(
    id          int           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name        varchar(128)  NOT NULL COMMENT 'Заголовок задания',
    description text          NOT NULL COMMENT 'Текст задания',
    category_id int           NOT NULL COMMENT 'Идентификатор категории из таблицы типов категорий',
    status_id   int           NOT NULL COMMENT 'Идентификатор статуса из таблицы статусов заданий',
    price       numeric(6, 2) NOT NULL COMMENT 'Цена заказчика',
    customer_id int           NOT NULL COMMENT 'Идентификатор заказчика из таблицы пользователей',
    date_add    datetime      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    executor_id int COMMENT 'Идентификатор исполнителя из таблицы пользователей',
    address      varchar(255),
    city_id     int COMMENT 'Идентификатор города из таблицы городов',
    expire      date COMMENT 'Срок исполнения задания',
    CONSTRAINT fk_tasks_categories FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_tasks_statuses FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_tasks_customer FOREIGN KEY (customer_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_tasks_executor FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_tasks_cities FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE SET NULL ON UPDATE NO ACTION
);

CREATE TABLE task_file
(
    id       int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id  int          NOT NULL,
    filepath varchar(128) NOT NULL,
    CONSTRAINT fk_task_files_tasks FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Файлы, прикрепленные к заданиям';

CREATE TABLE feedback
(
    id          int      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id     int      NOT NULL COMMENT 'Идентификатор задания',
    executor_id int      NOT NULL,
    rate        int      NOT NULL,
    created_at  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description text,
    CONSTRAINT fk_feedbacks_tasks FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_feedbacks_users FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Отзывы пользователей о заданиях';

CREATE TABLE message
(
    id          int      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sender_id   int      NOT NULL,
    receiver_id int      NOT NULL,
    task_id     int      NOT NULL,
    message     text     NOT NULL,
    created_at  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_sender FOREIGN KEY (sender_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_messages_receiver FOREIGN KEY (receiver_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_messages_tasks FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE responce
(
    id          int      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id     int      NOT NULL COMMENT 'Идентификатор задания',
    executor_id int      NOT NULL COMMENT 'Идентификатор исполнителя из таблицы пользователей',
    created_at  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    price       numeric(6, 2) COMMENT 'Цена исполнителя',
    comment     text,
    CONSTRAINT fk_responces_tasks FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT fk_responces_users FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'История откликов исполнителей';

CREATE TABLE opinion
(
    id          int      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    executor_id int      NOT NULL,
	customer_id int      NOT NULL,
    rate        int      NOT NULL,
    created_at  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description text,
    CONSTRAINT fk_opinions_executors FOREIGN KEY (executor_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT fk_opinions_customers FOREIGN KEY (customer_id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) COMMENT 'Отзывы пользователей об исполнителях';