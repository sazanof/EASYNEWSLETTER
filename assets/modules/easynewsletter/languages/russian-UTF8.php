<?php
# Easy Newsletter 0.3
# Created by: Flux
# Language: Russian
# ------------------------------------------------------------------------
$lang['title'] = "Модуль управления рассылкой для MODx Evolution";
$lang['links_subscribers'] = "Подписчики";
$lang['links_newsletter'] = "Письма";
$lang['links_configuration'] = "Настройки";
$lang['links_import'] = "Импорт из csv";
$lang['import_exclude'] = "Вы можете исключить строки из импорта.<br> Указываются в формате 1,2,3";
$lang['import_notify'] = "Контакты, которые будут импортированы в модуль";

$lang['import_title'] = "Импорт данных из csv файла";
$lang['import_sub'] = "Загрузить файл";
$lang['import_upltxt'] = "Загрузка файла";
$lang['import_not_choose'] = "Вы не выбрали файл!";
$lang['import_submit'] = "Импортировать";

$lang['mailinglist'] = "Пожалуйста введите ваше имя и e-mail адрес чтобы подписаться или отписаться от новостной рассылки.";
$lang['firstname'] = "Имя";
$lang['lastname'] = "Фамилия";
$lang['email'] = "E-mail адрес";
$lang['submit'] = "Отправить";
$lang['subscribe'] = "Подписаться";
$lang['unsubscribe'] = "Отписаться";
$lang['alreadysubscribed'] = "Такой почтовый адрес уже зарегистрирован.";
$lang['notsubscribed'] = "Этот почтовый адрес отсутсвует в нашей системе.";
$lang['subscribesuccess'] = "Спасибо Вам за то, что подписались на наши новости";
$lang['unsubscribesuccess'] = "Вы только что отписались от нашей новостной ленты.";
$lang['notvalidemail'] = "Почтовый адрес неправильного формата. Пожалуйста, попробуйте еще раз.";

$lang['newsletter_noposts'] = "Вы не создали еще ни одного письма.";
$lang['newsletter_test'] = "Тестовая отправка (e-mail адрес используется в <strong>настройках</strong>).";
$lang['newsletter_testmail'] = "Тест";
$lang['newsletter_delete_alert'] = "Вы действительно хотите удалить:";
$lang['newsletter_send_alert1'] = "Вы хотите отправить сообщение:";
$lang['newsletter_send_alert2'] = "ВНИМАНИЕ: Письмо отправится всем подписчикам.";
$lang['newsletter_create'] = "Создать письмо";
$lang['newsletter_date'] = "Дата";
$lang['newsletter_subject'] = "Тема письма";
$lang['newsletter_status'] = "Действия";
$lang['newsletter_sent'] = "Отосланные";
$lang['newsletter_action'] = "Действие";
$lang['newsletter_edit'] = "Редактировать";
$lang['newsletter_delete'] = "Удалить";
$lang['newsletter_send'] = "Отослать";
$lang['newsletter_sending'] = "Отсылка письма всем подписчикам....Пожалуйста подождите.<br>";
$lang['newsletter_sending_done1'] = "<b>Расылка закончена!</b>Отослано ";
$lang['newsletter_sending_done2'] = " письмо ";
$lang['newsletter_sending_done3'] = " подписчикам.<br>";
$lang['newsletter_sending_done4'] = "<span style='color:red'>Ошибка!!!<br>Возможно у вас указаны неверные настройки.</span>";
$lang['newsletter_edit_header'] = "Здесь вы можете создать письмо для рассылки.";
$lang['newsletter_edit_subject'] = "Тема:";
$lang['newsletter_edit_save'] = "Сохранить письмо";
$lang['newsletter_edit_update'] = "Письмо успешно обновлено!";
$lang['newsletter_edit_delete'] = "Письмо удалено!";
$lang['newsletter_edit_create'] = "Письмо создано!";

$lang['subscriber_noposts'] = "Нет зарегистрированных подписчиков.";
$lang['subscriber_delete_alert'] = "Вы правда хотите удалить:";
$lang['subscriber_edit_header'] = "Редактируйте информацию о подписчиках здесь.";
$lang['subscriber_add_header'] = "Добавление нового подписчика";
$lang['subscriber_created'] = "Создано";
$lang['subscriber_firstname'] = "Имя";
$lang['subscriber_lastname'] = "Фамилия";
$lang['subscriber_email'] = "E-mail адрес";
$lang['subscriber_action'] = "Действие";
$lang['subscriber_edit_action'] = "Действие";
$lang['subscriber_edit_save'] = "Обновить информацию";
$lang['subscriber_edit_update'] = "Информация обновлена!";
$lang['subscriber_edit_delete'] = "Подписчик удален!";

$lang['config_header'] = "Редактирование настроек.";
$lang['config_mail'] = "Метод отправки";
$lang['config_mail_description'] = "Различные методы отправки. При выборе SMTP заполните поля ниже.";
$lang['config_smtp'] = "SMTP сервер";
$lang['config_smtp_description'] = "Можно узнать у провайдера, какой у вас SMTP сервер.";
$lang['config_auth'] = "SMTP аутентификация обязательна?";
$lang['config_auth_description'] = "Используется только с методом почты SMTP. Требуется SMTP имя пользователя и пароль.";
$lang['config_true'] = "Да";
$lang['config_false'] = "Нет";
$lang['config_authuser'] = "SMTP имя пользователя";
$lang['config_authuser_description'] = "Имя пользователя для SMTP аутентификации. Обычно как и для вашего адреса электронной почты.";
$lang['config_authpassword'] = "SMTP пароль";
$lang['config_authpassword_description'] = "Пароль для SMTP аутентификации. Обычно как и для вашего адреса электронной почты.";
$lang['config_sendername'] = "Имя отправителя";
$lang['config_sendername_description'] = "Имя, которое появляется в электронной почте, как имя отправителя.";
$lang['config_senderemail'] = "E-mail отправителя";
$lang['config_senderemail_description'] = "Адрес электронной почты, который появляется в письме.";
$lang['config_lang_website'] = "Язык - фроненд";
$lang['config_lang_website_description'] = "Язык для формы подписки на сайте.";
$lang['config_lang_manager'] = "Язык - бэкенд";
$lang['config_lang_manager_description'] = "Язык, использующийся в системе управления.";
$lang['config_save'] = "Сохранить настройки";
$lang['config_update'] = "Настройки обновлены!";
?>