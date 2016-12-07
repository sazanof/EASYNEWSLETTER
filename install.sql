CREATE TABLE `easynewsletter_categories` (
  `id` int(11) NOT NULL,
  `kat_title` varchar(255) NOT NULL,
  `kat_descr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `easynewsletter_config` (
  `id` int(11) NOT NULL DEFAULT '0',
  `mailmethod` varchar(20) NOT NULL DEFAULT '',
  `port` int(11) NOT NULL DEFAULT '0',
  `smtp` varchar(200) NOT NULL DEFAULT '',
  `auth` varchar(5) NOT NULL DEFAULT '',
  `authuser` varchar(100) NOT NULL DEFAULT '',
  `authpassword` varchar(100) NOT NULL DEFAULT '',
  `sendername` varchar(200) NOT NULL DEFAULT '',
  `senderemail` varchar(200) NOT NULL DEFAULT '',
  `lang_frontend` varchar(100) NOT NULL DEFAULT '',
  `lang_backend` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `easynewsletter_newsletter` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `status` int(11) NOT NULL DEFAULT '0',
  `sent` int(11) NOT NULL DEFAULT '0',
  `header` longtext,
  `subject` text NOT NULL,
  `newsletter` longtext,
  `footer` longtext,
  `dates` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `easynewsletter_subscribers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  `blocked` int(11) NOT NULL DEFAULT '0',
  `lastnewsletter` varchar(50) NOT NULL DEFAULT '',
  `created` date NOT NULL DEFAULT '0000-00-00',
  `cat_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
