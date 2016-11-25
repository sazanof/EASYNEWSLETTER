ALTER TABLE  `easynewsletter_newsletter` ADD  `dates` TEXT NOT NULL AFTER  `footer`;
ALTER TABLE  `easynewsletter_subscribers` ADD  `cat_id` INT NOT NULL AFTER  `created`;
//создайте папку s_backups (777) в корне модуля
