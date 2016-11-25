<?php
# Easy Newsletter 0.3
# Created by: Flux
# Language: German, thanks to myeviltwin for the translation.
# ------------------------------------------------------------------------
$lang['title'] = "Modul für MODx Evolution";
$lang['links_subscribers'] = "Abonnenten";
$lang['links_newsletter'] = "Newsletter";
$lang['links_configuration'] = "Konfiguration";
$lang['links_import'] = "Aus CSV Datei importieren";
$lang['import_exclude'] = "Kommaseparierte Liste der ignorierten Zeilen im Import.";
$lang['import_notify'] = "Kontakte, die in das Modul importiert werden";

$lang['import_title'] = "Daten aus CSV Datei importieren";
$lang['import_sub'] = "Datei hochladen";
$lang['import_upltxt'] = "Datei auswählen";
$lang['import_not_choose'] = "Sie haben keine Datei ausgewählt.";
$lang['import_submit'] = "Import starten";

$lang['mailinglist'] = "Bitte geben Sie Ihren Namen und Ihrer E-Mail-Adresse ein um den Newsletter zu abonnieren oder abzubestellen:";
$lang['firstname'] = "Vorname";
$lang['lastname'] = "Nachname";
$lang['email'] = "E-Mail";
$lang['submit'] = "senden";
$lang['subscribe'] = "Abonnieren";
$lang['unsubscribe'] = "Kündigen";
$lang['alreadysubscribed'] = "Diese E-Mail-Adresse ist bereits eingetragen.";
$lang['notsubscribed'] = "Diese E-Mail-Adresse ist nicht hinterlegt.";
$lang['subscribesuccess'] = "Vielen Dank, Sie wurden in die Verteilerliste aufgenommen!";
$lang['unsubscribesuccess'] = "Sie haben sich aus dem Verteiler ausgetragen.";
$lang['notvalidemail'] = "Diese E-Mail-Adresse ist nicht gueltig. Bitte versuchen Sie es noch einmal.";

$lang['newsletter_noposts'] = "Es wurden noch keine Newsletter erstellt.";
$lang['newsletter_test'] = "Test-E-Mail wird gesendet (E-Mail-Addresse aus der <strong>Konfiguration</strong> wurde verwendet).";
$lang['newsletter_testmail'] = "Test";
$lang['newsletter_delete_alert'] = "Wirklich löschen?";
$lang['newsletter_send_alert1'] = "Möchten Sie den Newsletter absenden?";
$lang['newsletter_send_alert2'] = "ACHTUNG: Der Newsletter wird an alle Empfänger gesendet!";
$lang['newsletter_create'] = "Newsletter erstellen";
$lang['newsletter_date'] = "Datum";
$lang['newsletter_subject'] = "Betreff";
$lang['newsletter_status'] = "Status";
$lang['newsletter_sent'] = "Gesendet";
$lang['newsletter_action'] = "Aktion";
$lang['newsletter_edit'] = "Editieren";
$lang['newsletter_delete'] = "Löschen";
$lang['newsletter_send'] = "Senden";
$lang['newsletter_sending'] = "<h1>Sende Newsletter an alle Empfänger ... bitte warten.</h1>";
$lang['newsletter_sending_done1'] = "<h2>E-Mails gesendet!</h2>Gesendet: ";
$lang['newsletter_sending_done2'] = " E-Mails an ";
$lang['newsletter_sending_done3'] = " Newsletter Empfänger.";
$lang['newsletter_sending_done4'] = "<h2>Ein Fehler ist aufgetreten!</h2>Die Einstellungen in der <strong>Konfiguration</strong> sind möglicherweise falsch.";
$lang['newsletter_edit_header'] = "Newsletter erstellen.";
$lang['newsletter_edit_subject'] = "Betreff:";
$lang['newsletter_edit_save'] = "Newsletter speichern";
$lang['newsletter_edit_update'] = "Newsletter wurde aktualisiert!";
$lang['newsletter_edit_delete'] = "Newsletter wurde gelöscht!";
$lang['newsletter_edit_create'] = "Newsletter wurde erstellt!";

$lang['subscriber_noposts'] = "Es sind noch keine Empfänger registriert.";
$lang['subscriber_delete_alert'] = "Wirklich löschen?";
$lang['subscriber_edit_header'] = "Empfängerdetails editieren.";
$lang['subscriber_add_header'] = "Neuen Abonnenten hinzufügen.";
$lang['subscriber_created'] = "Eingetragen";
$lang['subscriber_firstname'] = "Vorname";
$lang['subscriber_lastname'] = "Nachname";
$lang['subscriber_email'] = "E-Mail";
$lang['subscriber_action'] = "Aktion";
$lang['subscriber_edit_action'] = "Aktion";
$lang['subscriber_edit_save'] = "Empfänger aktualisieren";
$lang['subscriber_edit_update'] = "Empfänger wurde aktualisiert!";
$lang['subscriber_edit_delete'] = "Empfänger wurde gelöscht!";

$lang['config_header'] = "Konfiguration ändern.";
$lang['config_mail'] = "Mail Methode";
$lang['config_mail_description'] = "Verschiedene Mail-Methoden. SMTP wird empfohlen.";
$lang['config_smtp'] = "SMTP Server";
$lang['config_smtp_description'] = "Ihr Hoster kann Ihnen normalerweise sagen, wie Ihr SMTP-Server heißt.";
$lang['config_auth'] = "SMTP Authentifizierung notwendig?";
$lang['config_auth_description'] = "Wird nur mit SMTP verwendet. Benötigt SMTP Benutzername and Passwort.";
$lang['config_true'] = "Ja";
$lang['config_false'] = "Nein";
$lang['config_authuser'] = "SMTP Benutzername";
$lang['config_authuser_description'] = "Benutzername für die SMTP Authentifizierung. Normalerweise der selbe wie für Ihr E-Mail Konto.";
$lang['config_authpassword'] = "SMTP Passwort";
$lang['config_authpassword_description'] = "Passwort für die SMTP Authentifizierung. Normalerweise das selbe wie für Ihr E-Mail Konto.";
$lang['config_sendername'] = "Absendername";
$lang['config_sendername_description'] = "Dieser Name erscheint als Absender.";
$lang['config_senderemail'] = "Absender E-Mail";
$lang['config_senderemail_description'] = "Diese E-Mail-Adresse erscheint als Absender E-Mail.";
$lang['config_lang_website'] = "Sprache - Website";
$lang['config_lang_website_description'] = "Sprachdatei, die für das Web-Formular verwendet wird.";
$lang['config_lang_manager'] = "Sprache - Manager";
$lang['config_lang_manager_description'] = "Die Sprachdatei des Managers (yepp, dieses Dings hier).";
$lang['config_save'] = "Konfiguration speichern";
$lang['config_update'] = "Die Konfiguration wurde aktualisiert!";
?>