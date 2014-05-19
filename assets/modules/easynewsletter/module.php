<?php
/*
Easy Newsletter 1.0
Copyright by: Flux - www.simpleshop.dk
Update by: Sazanof - www.sazanof.ru
Date: 30.01 2014
Notes: This newsletter system is heavily inspired by KoopsmailinglistX so a bow in respect and appreciation to the original author Jasper Koops and sottwell@sottwell.com who ported it to MODx.

---------------------------------------------------------------------
This file is part of Easy Newsletter 1.0

Easy Newsletter 1.0 is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Easy Newsletter 1.0 is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>. 

---------------------------------------------------------------------
UPD май 2013
- убрал /manager/ , заменил на MODX_MANAGER_PATH
- убрал $mod_id из конфигурации
- убрал $path из конфигурации
- исправлена проблема с сылками
UPD июнь 2013
- добавлен импорт из csv с настройками
	указывайте номера строк с именем, фамилией, email и строки которые необходимо исключить из импорта
- обновлен импорт:
	теперь повторяющиеся email не заносятся в базу данных.
- добавлено создание подписчика
- добавлено удаление нескольких или всех подписчиков
UPD декабрь 2013 - январь 2014
- добавлена возможность "отложенной отправки" (выбранным пользователям)
- экспорт резервных копий
- восстановление резервных копий
- присваивание категорий подписчикам
- фильтрация по категориям
- просмотр отчетов по отправке писем
- улучшен интерфейс
- в БД добавлены 2 колонки 
- установка / обновление в howto.html
---------------------------------------------------------------------*/

$mod_id = $_REQUEST['id'];
$path = MODX_BASE_PATH.'assets/modules/easynewsletter/';
$href = '/assets/modules/easynewsletter/';
$sql = "SHOW TABLES LIKE 'easynewsletter_config'";
$rs = $modx->db->query($sql);
$count = $modx->db->getRecordCount($rs);
if($count < 1) {
  $sql = "CREATE TABLE IF NOT EXISTS `easynewsletter_config` (
  `id` int(11) NOT NULL default '0',
  `mailmethod` varchar(20) NOT NULL default '',
  `port` int(11) NOT NULL default '0',
  `smtp` varchar(200) NOT NULL default '',
  `auth` varchar(5) NOT NULL default '',
  `authuser` varchar(100) NOT NULL default '',
  `authpassword` varchar(100) NOT NULL default '',
  `sendername` varchar(200) NOT NULL default '',
  `senderemail` varchar(200) NOT NULL default '',
  `lang_frontend` varchar(100) NOT NULL default '',
  `lang_backend` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
)";
$modx->db->query($sql);
$sql = "INSERT INTO `easynewsletter_config` VALUES (1, 'IsSMTP', 0, '', 'false', '', '', '', '', 'english', 'english')";
$modx->db->query($sql);
  $sql = "CREATE TABLE IF NOT EXISTS `easynewsletter_newsletter` (
  `id` int(11) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  `sent` int(11) NOT NULL default '0',
  `header` longtext,
  `subject` text NOT NULL,
  `newsletter` longtext,
  `footer` longtext,
  `dates` TEXT NOT NULL,
  PRIMARY KEY  (`id`)
)";
$modx->db->query($sql);
////// categories
$modx->db->query($sql);
  $sql = "CREATE TABLE IF NOT EXISTS `easynewsletter_categories` (
  `id` int(11) NOT NULL auto_increment,
  `kat_title` varchar (255) NOT NULL,
  `kat_descr` text NOT NULL,
  PRIMARY KEY  (`id`)
)";
$modx->db->query($sql);
//////
$sql = "CREATE TABLE IF NOT EXISTS `easynewsletter_subscribers` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(50) NOT NULL default '',
  `lastname` varchar(50) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `status` int(11) NOT NULL default '1',
  `blocked` int(11) NOT NULL default '0',
  `lastnewsletter` varchar(50) NOT NULL default '',
  `created` date NOT NULL default '0000-00-00',
  `cat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)";
$modx->db->query($sql);
header('Location:'.$_SERVER['REQUEST_URI']);
$out .=  'Easy Newsletter has now been installed. Please click <strong>Easy Newsletter</strong> in the navigation bar.';
} else {
$theme = $modx->config['manager_theme'];

$manager_language = $modx->config['manager_language'];
if ($modx->getLoginUserID()) {
    $sql = "SELECT setting_name, setting_value FROM " . $modx->getFullTableName('user_settings') . " WHERE setting_name='manager_language' AND user=" . $modx->getLoginUserID();
    $rs = $modx->db->query($sql);
    if ($modx->db->getRecordCount($rs) > 0) {
        $row = $modx->db->getRow($rs);
        $manager_language = $row['setting_value'];
    }
}
if (file_exists($path.'languages/' . $manager_language . '.php')) {
    include($path.'languages/' . $manager_language . '.php');
} else {
    include($path.'languages/' . 'lang/english.php');
}
$out .=  '
<html>
<head>
<title>MODx EasyNewsetter</title>
<meta http-equiv="Content-Type" content="text/html; charset='.$modx->config['modx_charset'].'" />
<link rel="stylesheet" type="text/css" href="/manager/media/style/'.$theme.'/style.css" />
<link rel="stylesheet" type="text/css" href="'.$href.'css/style.css" />
<script src="'.$href.'js/jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    $("#check_all").click(function () {
         if (!$("#check_all").is(":checked"))
            $(".ch").removeAttr("checked");
        else 
            $(".ch").attr("checked","checked");
    });
	
	$("#check_all").click(function () {
		if ($(".ch").is(":checked"))
            {
				$(".add-form").css("display","inline-block");
			}
		else
		{
			$(".add-form").css("display","none");
		}
	});
});   
function checkBlock()
	{
			if ($(".ch").is(":checked"))
				{
					$(".add-form").css("display","inline-block");
				}
			else
			{
				$(".add-form").css("display","none");
			}	
	}
	$(document).ready(function() {
		$("#email_filter").keyup(function () {
			$.ajax({
							type: "POST",
							url: "'.$href.'ajax.options.php",
							data: {
								email_filter:$("#email_filter").val(),
								cat:'.(int)$_GET['cat'].'
							},
							success: function(text){
								$(".gridSubscribers").html(text)
							}
						});
		});
	});
	
</script>
</head>
<body>
<br />
<h1>Easy Newsletter - '.$lang['title'].'</h1>

<div class="sectionBody">
<b>'.$lang['links_header'].'</b>';
include($path.'backend.php');
$menu = '<div id="actions">
			<ul class="actionButtons">';
$menu .=    $menu_add.'
				<li id="ToTop"><a style="padding:4px" href="#"><img src="'.$href.'images/arrow_up.png"></a></li>
				<li id="Button1"><a href="index.php?a=112&id='.$mod_id.'&action=1"><img src="'.$href.'images/subscribers.png"> '.$lang['links_subscribers'].'</a></li>
				<li id="Button1"><a href="index.php?a=112&id='.$mod_id.'&p=1&action=1"><img src="'.$href.'images/pisma.png"> '.$lang['links_newsletter'].'</a></li>
				<li id="Button1"><a href="index.php?a=112&id='.$mod_id.'&p=4"><img src="'.$href.'images/36.png"> Категории</a></li>
				<li id="Button1"><a href="index.php?a=112&id='.$mod_id.'&p=3"><img src="'.$href.'images/28.png"> '.$lang['links_import'].'</a></li>
				<li id="Button1"><a href="index.php?a=112&id='.$mod_id.'&p=2&action=1"><img src="'.$href.'images/settings.png"> '.$lang['links_configuration'].'</a></li>
				<li id="Button1"><a style="padding:4px" href="index.php?a=112&id='.$mod_id.'&p=5"><img src="'.$href.'images/event1.png"></a></li>
				';

				$menu .=    '</ul>
		</div>';
$out .= $menu;
$out .=  '
</div>
<script src="'.$href.'js/infinitescroll.js" type="text/javascript"></script>
<!-- Infinite Scroll вызов в контенте -->
	<script type="text/javascript">    
	    $(\'.gridSubscribers\').infinitescroll({
			navSelector  : ".pagination",            
			nextSelector : "a#next",    
			itemSelector : "#row",          
			debug        : false,
			loadingImg   : "assets/templates/site/infinitescroll/ajax-loader.gif",
		});
		
$( document ).ready(function($){
	var 
	speed = 300,
	scrollTop = $(\'#ToTop\');		

	scrollTop.click(function(e){
		e.preventDefault();

		$( \'html:not(:animated),body:not(:animated)\' ).animate({ scrollTop: 0}, speed );
	});

	//появление
	function show_scrollTop(){
		( $(window).scrollTop() > 300 ) ? scrollTop.fadeIn(300) : scrollTop.fadeOut(300);
	}
	$(window).scroll( function(){ show_scrollTop(); } );
	show_scrollTop();
});
	</script>
</body>
</html>
';
echo $out;
}
?>
