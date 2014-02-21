<?php
/*
Easy Newsletter 1.0
Update by: Sazanof - www.sazanof.ru
Date: 11.02 2014
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

---------------------------------------------------------------------*/
$tbl_kat = "easynewsletter_categories";
$tbl_sbscr = "easynewsletter_subscribers";
$tbl_config = "easynewsletter_config";
if(!isset($_GET['p'])) { $_GET['p'] = ''; }
if(!isset($_GET['action'])) { $_GET['action'] = 1; }

function rus2translit($string)
{
    global $modx;
	$converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',' '=>'_'
    );
    return strtr($string, $converter);
}

switch($_GET['p']) {

	// List newsletters
	case "1":
		if ($_GET['action'] == 1) 
		{
			if (!isset($_GET['sortorder'])) {
				$sortorder = 'date';
			} else {
				$sortorder = $_GET['sortorder'];
			}
			$sql = "SELECT * FROM `easynewsletter_newsletter` ORDER BY `".$sortorder."`";
			$sql = $modx->db->query($sql);
			$result = $modx->db->makeArray($sql);
			$num = $modx->db->getRecordCount($sql);
			if ($num > 0) {
				$list = '<script type="text/javascript">
				<!--
				function delete_newsletter(a,b)
				{
				answer = confirm("'.$lang['newsletter_delete_alert'].'\n"+b)
				if (answer !=0)
				{
				location = "index.php?a=112&id='.$mod_id.'&p=1&action=6&nid="+a
				}
				}
				function send_newsletter(a,b)
				{
				answer = confirm("'.$lang['newsletter_send_alert1'].'\n"+b+"\n\n'.$lang['newsletter_send_alert2'].'")
				if (answer !=0)
				{
				location = "index.php?a=112&id='.$mod_id.'&p=1&action=2&nid="+a
				}
				}
				//-->
				</script>';
				if(is_array($_SESSION['check-some']))
				{
					$out.='
					<div class="actButs">
						<a href="" class="but nounder">Адреса на отправку '.count($_SESSION['check-some']).'</a>
					</div>
					';
				}
				// отчет по логам
				$list .='
				<div class="actionMainSend">
							<a class="but" href="index.php?a=112&id='.$mod_id.'&p=1&action=9"><img src="/assets/modules/easynewsletter/images/folder_page_add.png"> Файлы отчетов</a>
				</div>';
				$list .= '
				<table style="font-size: 12px;" cellspacing="0" width="100%" class="gridSubscribers">';
				// кнопка создать письмо
				$menu_add .= '<li><a href="index.php?a=112&id='.$mod_id.'&p=1&action=3"><img src="'.$href.'images/add.png"> '.$lang['newsletter_create'].'</a></li>';
				$list .= '<tr class="headTR">';
				$list .= '<th class="gridHeader" width="100"><a href="index.php?a=112&id='.$mod_id.'&p=1&action=1&sortorder=date"><strong>'.$lang['newsletter_date'].'</strong></a></td>';
				$list .= '<th class="gridHeader"><a href="index.php?a=112&id='.$mod_id.'&p=1&action=1&sortorder=subject"><strong>'.$lang['newsletter_subject'].'</strong></a></td>';
				$list .= '<th class="gridHeader"><strong>'.$lang['newsletter_action'].'</strong></td>';
				$list .= '</tr>';
				$i=0;	
				foreach ($result as $row)	
				{				
					$list .='<tr>';
					$list .= '<td>'.$row["date"].'</td>';
					$list .= '<td class="nounder"><a href="index.php?a=112&id='.$mod_id.'&p=1&action=3&nid='.$row["id"].'">'.$row["subject"].'</a>';
					
					if (is_array($_SESSION['check-some']))
							{
									$list.=' <br> <a class="but" href="index.php?a=112&id='.$mod_id.'&p=1&action=2&nid='.$row["id"].'&check=1">Отправить письмо выбранным</a>';
							}
					
					$list.='</td>';
					// ссылки-действия в списке писем
					$list .= '<td width="130" align="center">
					<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&p=1&action=3&nid='.$row["id"].'" title="'.$lang['newsletter_edit'].'"><img src="'.$href.'images/edit.png"></a> 
					<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&p=1&action=7&nid='.$row["id"].'" title="Отчеты об отправке"><img src="'.$href.'images/cal.gif"></a>
					<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&p=1&action=2&nid='.$row["id"].'" onclick=" send_newsletter(\''.$row["id"].'\',\''.$row["subject"].'\'); return false;" title="'.$lang['newsletter_send'].'"><img src="'.$href.'images/04-1.png"></a>
					<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&p=1&action=6&nid='.$row["id"].'" onclick=" delete_newsletter(\''.$row["id"].'\',\''.$row["subject"].'\'); return false;" title="'.$lang['newsletter_delete'].'"><img src="'.$href.'images/delete.png"></a>
					</td>';
					$list .= '</tr>';
					$i++;
				}
				$list .= '</table><div style="height:100px"></div>';
				$out .=  '<div class="sectionHeader">Список писем для рассылок</div>
				<div class="sectionBody">'.$list.'</div>';
			} else {
				$out .=  $lang['newsletter_noposts'];
				$menu_add ='<li><a href="index.php?a=112&id='.$mod_id.'&p=1&action=3"><img src="'.$href.'images/add.png"> '.$lang['newsletter_create'].'</a></li>';
			}
		} elseif ($_GET['action'] == 2) {
			// Send newsletter // Отправка письма
			$nid = (int)$_GET['nid'];
			$sql = "SELECT * FROM `easynewsletter_newsletter` WHERE `id` = $nid";
			$result = $modx->db->query($sql);
			$row = $modx->db->getRow($result);
			$newsletter_header = $row["header"];
			$newsletter_subject = $row["subject"];
			$newsletter_newsletter = $row["newsletter"];
			$newsletter_footer = $row["footer"];
			//изменить на выбор почтовика в MODX
			$sql = "SELECT * FROM $tbl_config WHERE `id` = 1";
			$result = $modx->db->query($sql);
			$row = $modx->db->getRow($result);
			$mailmethod = $row["mailmethod"];
			$smtp = $row["smtp"];
			$fromname = stripslashes($row["sendername"]);
			$from = $row["senderemail"];
			$auth = $row["auth"];
			$authuser = $row["authuser"];
			$authpassword = $row["authpassword"];
			
			include_once "../manager/includes/controls/class.phpmailer.php";
			$sql = "SELECT email,firstname FROM $tbl_sbscr ORDER BY email ASC";
			// получаем массив из сессии выбранных
			if (is_array($_SESSION['check-some']) and $_GET['check']==1)
			{
				$ar=array();
				$array = $_SESSION['check-some'];
				foreach ($array as $id)
				{
					$sql = "SELECT email,firstname FROM $tbl_sbscr WHERE id='".$id."'";
					$eml = $modx->db->getRow($modx->db->query($sql));
					$ar[]= array('email'=>$eml['email'],'firstname'=>$eml['firstname'],);
				}
			}
			// или получаем массив из email адресов из БД
			else
			{
				$ar = $modx->db->makeArray($modx->db->query($sql));
			}
			$i=0;
			$sentsuccess=0;
			$out .=  '<div class="infoMess">'.$lang['newsletter_sending'].'</div>';
			
			// начинаем запись log файлов
			$hand = fopen($path."logs/".date('d-m-Y H_i_s').".csv","w");
			if(fwrite($hand,iconv("utf-8","windows-1251",
			$newsletter_subject." 
			(проведенная рассылка)\n
			Дата проведения: ".date('d-m-Y в H:i:s')."
			\n")))
			{
				foreach ($ar as $eml)
				{
					$mail = new PHPMailer();
					if ($mailmethod == IsMail) {$mail->IsMail();}
					if ($mailmethod == IsSMTP) {
						$mail->IsSMTP();
						$mail->Host = $smtp;
						if ($auth == 'true') {
							$mail->SMTPAuth = true;
							$mail->Username = $authuser;
							$mail->Password = $authpassword;
						} else {
							$mail->SMTPAuth = false;
						}
					}
					if ($mailmethod == IsSendmail) {$mail->IsSendmail();}
					if ($mailmethod == IsQmail) {$mail->IsQmail();}
					$mail->CharSet = $modx->config['modx_charset'];
					$mail->From		= $from;
					$mail->FromName	= $fromname;
					$mail->Subject	= $newsletter_subject;
					$mail->Body		= $newsletter_newsletter;
					$mail->AltBody	= $newsletter_newsletter;
					$mail->AddAddress($eml['email']);
					if(!$mail->send()) {
						$out .=  $lang['newsletter_sending_done4'];
						return 'Main mail: ' . $_lang['ef_mail_error'] . $mail->ErrorInfo;
					} else {
						$string = ($i+1).";".$eml['email'].";".$eml['firstname']."\n";
						fwrite($hand,iconv("utf-8","windows-1251",$string));
						$out .='Отправлено => '.$eml['email']."____".$eml['firstname'].'<br>';
						// обновляем информацию о последнем отправленном письме в БД
						$sql="UPDATE $tbl_sbscr SET lastnewsletter='".time()."' WHERE email='".$eml['email']."'";
						$modx->db->query($sql);
						$sentsuccess++;
					}
					$i++;
				}
			
			// Обновляем счетчик отправки
			$s = "SELECT dates FROM `easynewsletter_newsletter` WHERE id='".(int)$_GET['nid']."'";
			$r = $modx->db->getRow($modx->db->query($s));
			$sql = "UPDATE `easynewsletter_newsletter` SET sent=sent+1,dates='".time().';'.$r['dates']."' WHERE id='".(int)$_GET['nid']."'";
			$modx->db->query($sql);
			// отчеты об отправки писем
			$out .=  '<div class="infoMess">'.$lang['newsletter_sending_done1'] . $sentsuccess . $lang['newsletter_sending_done2'] . $num . $lang['newsletter_sending_done3'].'</div>';
			}
			else
			{
				echo "Запись в файл не удалась. И отправка тоже =(. Проверьте папку easynewsletter/logs на существование и запись";
			}
			// закрываем лог файл после записи
			fclose($hand);
			
		} elseif ($_GET['action'] == 3) {
			// Newsletter Rich Text Editor
			$action = 4;
			$nid = '';
			if (isset($_GET['nid'])) {
				$nid = $_GET['nid'];
				$sql = "SELECT * FROM `easynewsletter_newsletter` WHERE `id` = $nid";
				$result = $modx->db->query($sql);
				$row = $modx->db->getRow($result);
				$subject = $row["subject"];
				$newsletter = $row["newsletter"];
				$action = 5;
			}
			
			$out .=  '<div class="content_">
					<p>'.$lang['newsletter_edit_header'].'</p>
					<form action="index.php?a=112&id='.$mod_id.'&p=1&action='.$action.'" method="post">
					<b>'.$lang['newsletter_edit_subject'].'</b>
					<br /><input type="hidden" name="xid" value="'.$nid.'">
					<input type="text" size="50" maxlength="250" name="subject" value="'.$subject.'">
					<br /><br />';
			
			// Get access to template variable function (to output the RTE)
			include_once($modx->config['base_path'].'manager/includes/tmplvars.inc.php');
		  
			$event_output = $modx->invokeEvent("OnRichTextEditorInit", array('editor'=>$modx->config['which_editor'], 'elements'=>array('tvmailMessage')));
		
			if(is_array($event_output)) {
				$editor_html = implode("",$event_output);
			}
			// Get HTML for the textarea, last parameters are default_value, elements, value
			$rte_html = renderFormElement('richtext', 'mailMessage', '', '', $newsletter);
			$out .=  $rte_html;
			$out .=  $editor_html;
			$out .=   '<button class="but" type="submit" name="edit"  value="'.$lang['newsletter_edit_save'].'"><img src="'.$href.'images/add.png"> '.$lang['newsletter_edit_save'].'</button>
			</div>';
	} 
	elseif ($_GET['action'] == 4) { 
		// Insert newsletter into database
		$sql = "INSERT INTO easynewsletter_newsletter VALUES('', now(), '','', '', '".$modx->db->escape($_POST['subject'])."', '".$modx->db->escape($_POST['tvmailMessage'])."', '','') ";
		$result = $modx->db->query($sql);
		header ('Location:index.php?a=112&id='.$mod_id.'&p=1&action=1');
	} 
	elseif ($_GET['action'] == 5) {
		// Обновление письма
		// замена адресов на абсолютные
		$sql = "UPDATE easynewsletter_newsletter SET subject='".$_POST['subject']."', newsletter='".$modx->db->escape($_POST['tvmailMessage'])."' WHERE id='".$_POST['xid']."'";
		$result = $modx->db->query($sql);
		header ('Location:index.php?a=112&id='.$mod_id.'&p=1&action=1');
		print_r ($_POST);
	} 
	elseif ($_GET['action'] == 6) {
		// удаление
		$sql = "DELETE FROM easynewsletter_newsletter WHERE id='".$_GET['nid']."'";
		$result = $modx->db->query($sql);
		header ('Location:index.php?a=112&id='.$mod_id.'&p=1&action=1');
	} 
	elseif ($_GET['action'] == 7) 
	{
			if ($_POST['clear_statistic']==1)
			{
				$sql = "UPDATE `easynewsletter_newsletter` SET sent='0',dates='' WHERE id='".(int)$_GET['nid']."'";
				$modx->db->query($sql);
				header ('Location:'.$_SERVER['REQUEST_URI']);
			}
			// отчеты по письму
			// выводим сам отчет
			$out .= '<div class="sectionHeader">Отчеты по отправке рассылок</div>';
			$out .='<div class="sectionBody">';
			$sql = "SELECT id,date,subject,sent,dates FROM easynewsletter_newsletter WHERE id = '".(int)$_GET['nid']."'";
			$res = $modx->db->getRow($modx->db->query($sql));
			$out .='<div style="padding:5px; border:1px solid #ddd; background:#fff">';
			$out .= '<b>Тема письма:</b><br>'.$res['subject'];
			$out .='<br><b>Отослано</b><br>'.$res['sent'].' раз(а)';
			$out .='<br><b>Даты отправления письма</b><br>';
			$ar_dates = explode(';',$res['dates']);
			// удаляем пустые элементы массива
			$ar_dates=array_diff($ar_dates, array(''));
			foreach ($ar_dates as $date)
			{
				$out .='<span class="but">'.date('d-m-Y в H:i:s', $date).'</span>';
			}
			$out .= '<div align="right">
			<form method="post" action="">
			<button class="but" type="submit" name="clear_statistic" value="1">
			<img src="'.$href.'images/event1.png"> Очистить статистику</button>
			<form>
			</div>';
			$out .='</div>';
			$out .='</div>';

	}
	elseif ($_GET['action']==8)
	{
		// если нажата кнопка сделать бэкап
		if ($_POST['add-backup'])
		{
			$sql = "SELECT id,firstname,lastname,email,status,blocked,lastnewsletter,created,cat_id FROM $tbl_sbscr ORDER BY email ASC";
			$r = $modx->db->makeArray($modx->db->query($sql));
			if(count($r)>0)
			{
				$csv = array();
				if($_POST['bckp_name'])
				{	
					$title_bckp = rus2translit($_POST['bckp_name']);
				}
				else
				{
					$title_bckp = date('d-m-Y__H-i-s');
				}
				$line='';
				foreach ($r as $str)
				{
					$line .= 
					trim($str['id']).';'.
					trim($str['firstname']).';'.
					trim($str['lastname']).';'.
					trim($str['email']).';'.
					trim($str['status']).';'.
					trim($str['blocked']).';'.
					trim($str['lastnewsletter']).';'.
					trim($str['created']).';'.
					trim($str['cat_id']).
					"\n";
				}
				file_put_contents(MODX_BASE_PATH.'assets/modules/easynewsletter/s_backups/'.$title_bckp.'.csv',$line);
				header('Location:'.$_SERVER['REQUEST_URI']);
			}
			else
			{
				$out .='У вас нет подписчиков для создания резервной копии';
			}
		}
		// получаем список файлов в папке
		$dirList= scandir(MODX_BASE_PATH.'assets/modules/easynewsletter/s_backups/');
		unset($dirList[0],$dirList[1]);
		$out .= '<div class="sectionHeader">Экспорт подписчиков и восстановление резервных копий</div>';
		$out .='<div class="sectionBody">';
		$out .='<div class="actionMainSend">
					<form action="" method="post">
					<input type="text" value="" name="bckp_name" placeholder="Имя резервной копии (необязательно)" style="width:250px">
					<button class="but" type="submit" name="add-backup" value="add"><img src="'.$href.'images/save.png">Зарезервировать</button>
					|
					<button class="but" name="to-send" value="1"><img src="'.$href.'images/delete.png">Удалить все</button>
					</form>
				</div>';
		//выводим список файлов в папке
		if (!empty($dirList))
		{
			$folder = MODX_BASE_PATH.'assets/modules/easynewsletter/s_backups/';
			if ($_GET['restorefile'])
			{
				if (file_exists($folder.$_GET['restorefile']))
				{
					// очищаем базу
					$sql = "TRUNCATE TABLE  $tbl_sbscr";
					$modx->db->query($sql);
					// получаем данные из файла
					$data = file($folder.$_GET['restorefile']);
					// пишем эти данные в БД таблицу подписчиков
					foreach ($data as $str)
					{
						$s = explode(';',$str);
						$sql = "INSERT INTO $tbl_sbscr 
						(id,firstname,lastname,email,status,blocked,lastnewsletter,created,cat_id)
						VALUES ( 
						NULL, 
						'".$s[1]."', 
						'".$s[2]."', 
						'".trim($s[3])."', 
						'".$s[3]."', 
						'".$s[4]."', 
						'', 
						NOW(),
						'".$s[8]."')";
						if($modx->db->query($sql))
						{
							header ('Location:index.php?a=112&id='.$mod_id.'&action=1');
						}
						
					}
				}
			}
			elseif($_GET['delfile'])
			{
				unlink ($folder.$_GET['delfile']);
				header ('Location:index.php?a=112&id='.$mod_id.'&p=1&action=8');
			}
			$out .='<div class="actionMainSend"><ul class="bckp_list">';
			foreach ($dirList as $file)
			{
				$file = iconv("cp1251","utf-8", $file);
				$out .='<li>
				<a href="index.php?a=112&id='.$mod_id.'&p=1&action=8&restorefile='.$file.'" class="but roundbut" style="float:left; margin-left:4px"><img src="'.$href.'images/clock_play.png"></a>
				<div>'.$file.'</div> 
				<a href="index.php?a=112&id='.$mod_id.'&p=1&action=8&delfile='.$file.'" class="but roundbut"><img src="'.$href.'images/delete.png"></a>
				</li>';
			}
			$out .='</ul></div>';
		}
		$out .='';
		$out .='</div>';
	}
	// файлы отчетов выводим
	elseif ($_GET['action'] == 9) 
	{
		$dirList= scandir(MODX_BASE_PATH.'assets/modules/easynewsletter/logs/');
		unset($dirList[0],$dirList[1]);
		if (in_array('index.html',$dirList))
		{
			unset($dirList[array_search('index.html',$dirList)]);
		}
		$out .='<div class="sectionHeader">Файлы отчетов об отправке (логи)</div>';
		$out .='<div class="sectionBody"><ul>';
		foreach ($dirList as $log)
		{
			$out.='<li><a href="/assets/modules/easynewsletter/logs/'.$log.'">'.$log.'</a></li>';
		}
		$out.='</ul></div>';
	}
	break;
	case 2:
		if ($_GET['action'] == 1) {
			// Show Configuration
			$sql = "SELECT *  FROM $tbl_config WHERE `id` = 1";
			$result = $modx->db->query($sql);
			$row = $modx->db->getRow($result);
			$mailmethod = $row["mailmethod"];
			$auth = $row["auth"];
			$list = '<div class="sectionHeader">'.$lang['config_header'].'</div><div class="sectionBody">
					<form action="index.php?a=112&id='.$mod_id.'&p=2&action=2" method="post" class="comon_settings"><b>';
			$list .= '<table style="margin-top:10px; font-size: 12px;" class="grid" width="100%">';
			
			$list .= '
			<tr>
				<td><strong>'.$lang['config_sendername'].'</strong></td>
				<td><input type="text" size="100" maxlength="100" name="sendername" value="'.stripslashes($row["sendername"]).'"></input>
				<span class="descr">'.$lang['config_sendername_description'].'</span>
				</td>
			</tr>';
			$list .= '
			<tr>
				<td><strong>'.$lang['config_senderemail'].'</strong></td>
				<td><input type="text" size="100" maxlength="100" name="senderemail" value="'.$row["senderemail"].'"></input>
				<span class="descr">'.$lang['config_senderemail_description'].'</span>
				</td>
			</tr>';
			
			$list .= '
			<tr>
				<td><strong>'.$lang['config_mail'].'</strong></td>
				<td><select name="mailmethod">';

			if($mailmethod == 'IsMail'){$dropdown = ' selected="selected"';} else {$dropdown = '';}
			$list .= '<option value="IsMail"'.$dropdown.'>PHP mail</option>';

			if($mailmethod == 'IsSMTP'){$dropdown = ' selected="selected"';} else {$dropdown = '';}
			$list .= '<option value="IsSMTP"'.$dropdown.'>SMTP</option>';

			if($mailmethod == 'IsSendmail'){$dropdown = ' selected="selected"';} else {$dropdown = '';}
			$list .= '<option value="IsSendmail"'.$dropdown.'>Sendmail</option>';

			if($mailmethod == 'IsQmail'){$dropdown = ' selected="selected"';} else {$dropdown = '';}
			$list .= '<option value="IsQmail"'.$dropdown.'>Qmail MTA</option>';
	
			$list .= '</select>
				<span class="descr">'.$lang['config_mail_description'].'</span>
				</td>
			</tr>';

			$list .= '
			<tr>
				<td><strong>'.$lang['config_auth'].'</strong></td>
				<td><select name="auth">';

			if($auth == 'true'){$dropdown3 = ' selected="selected"';} else {$dropdown3 = '';}
			$list .= '<option value="true"'.$dropdown3.'>'.$lang['config_true'].'</option>';

			if($auth == 'false'){$dropdown3 = ' selected="selected"';} else {$dropdown3 = '';}
			$list .= '<option value="false"'.$dropdown3.'>'.$lang['config_false'].'</option>';
			
			$list .= '</select>
			<span class="descr">'.$lang['config_auth_description'].'</span></td></tr>';

			$list .= '<tr><td><strong>'.$lang['config_smtp'].'</strong></td><td>: <input type="text" size="100" maxlength="100" name="smtp" value="'.$row["smtp"].'"></input></td></tr>';
			$list .= '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;'.$lang['config_smtp_description'].'</td></tr>';
			$list .= '<tr><td><strong>'.$lang['config_authuser'].'</strong></td><td>: <input type="text" size="100" maxlength="100" name="authuser" value="'.$row["authuser"].'"></input></td></tr>';
			$list .= '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;'.$lang['config_authuser_description'].'</td></tr>';
			$list .= '<tr><td><strong>'.$lang['config_authpassword'].'</strong></td><td>: <input type="password" size="100" maxlength="100" name="authpassword" value="'.$row["authpassword"].'"></input></td></tr>';
			$list .= '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;'.$lang['config_authpassword_description'].'</td></tr>';
			
			$list .= '</table>';
			$list .= '<button type="submit" class="but" value="'.$lang['config_save'].'"><img src="'.$href.'images/save.png"> '.$lang['config_save'].'</button>';
			$out .=  $list;
		} elseif ($_GET['action'] == 2) {
			// Update configuration
			$sql = "UPDATE easynewsletter_config SET mailmethod='".$_POST['mailmethod']."', smtp='".$_POST['smtp']."', auth='".$_POST['auth']."', authuser='".$_POST['authuser']."', authpassword='".$_POST['authpassword']."', sendername='".addslashes($_POST['sendername'])."', senderemail='".$_POST['senderemail']."', lang_frontend='".$_POST['lang_frontend']."', lang_backend='".$_POST['lang_backend']."' WHERE id='1'";	
			$result = $modx->db->query($sql);
			header ('Location:index.php?a=112&id='.$mod_id.'&p=2&action=1');
		}
	break;
	// sazanof added import section
	case 3 : 
		// upload ceck and progress section
		// верхушку формы переместил сюда
		$out .='<div class="err">'.$err.'</div>
		<form method="post" enctype="multipart/form-data">';
		if ($_POST['sub_import'])
		{
			if ( $_FILES['file-import']['name'] !=='')
			{
				$handle = $_SESSION['file'] = $_FILES['file-import']['tmp_name'];
				$data = file($handle);
				
				$data = str_replace(chr(9),"|",$data); 
				$data = str_replace('"',"",$data); 
				//если заданы строки для исключения то
				$i = 0;
				if (!empty ($_POST['exclude']))
				{
					$arr = explode (',',$_POST['exclude']);
					$array = array();
					foreach ($arr as $ar)
					{
						$array = $ar-1;
						unset ($data[$array]);
					}
				}
				// иначе .....
				else
				{
					$out .= 'Нет исключений<br>';
				}
				foreach ($data as $d)
				{
					$d = explode (';',$d);
					//$out .=$i;
					if ($d[($_POST['email_import'] - 1)] !== '')
					{
						$out .='<div class="predpr">';
						$out .= '<b>№ '.($i+1).'</b><br>';
						$out .= '<b>Email</b>: '.$d[($_POST['email_import'] - 1)].'<br>';
						$out .= '<b>'.$lang['subscriber_firstname'].'</b>: '.$d[($_POST['name_import'] - 1)].'<br>';
						$out .= '<b>'.$lang['subscriber_lastname'].'</b>: '.$d[($_POST['lastname_import'] - 1)];	
						
						// проверка на повторение записей
						$chk = "SELECT * FROM $tbl_sbscr WHERE email='".$d[($_POST['email_import'] - 1)]."'";
						// если email уже существует в таблице, то выводим сообщение об ошибке 
						if ($modx->db->getRecordCount($modx->db->query($chk)) > 0)
						{
							$out .='<br><small style="color:red">Подписчик уже существует!</small>';
						}
						else
						{
							$out .='<br><small style="color:green">Подписчик добавлен!</small>';
							$sql = "INSERT INTO $tbl_sbscr (firstname, lastname, email,lastnewsletter,cat_id) VALUES ('".$d[($_POST['name_import'] - 1)]."','".$d[($_POST['lastname_import'] - 1)]."','".$d[($_POST['email_import'] - 1)]."','','".$modx->db->escape($_POST['categories'])."' )";
							$result = $modx->db->query($sql);
							
						}
						$out .='</div>';
					
					}
					$i++;
				}
			}
			else
			{
				$err=$lang['import_not_choose'];
			}
			
		}
		// categories
		$categories = '<select name="categories"><option value="0">Без категории</option>';
		
				$sql = "SELECT id,kat_title FROM $tbl_kat";
				$res = $modx->db->query($sql);
				$n = $modx->db->getRecordCount($res);
				if($n>0){
				foreach ($modx->db->makeArray($res) as $i)
				{
					$categories.='<option value="'.$i['id'].'"';
					$categories.='>'.$i['kat_title'].'</option>';
				}
				}
		$categories .='</select>';
		
		// загрузка файла
		$importForm = 		
		'	<input type="hidden" value="" name="get_out">
			<fieldset><legend>'.$lang['import_upltxt'].'</legend>
			<div class="upload_info">Откройте файл csv в Microsoft Excel и впишите в поля номера колонок Email, Имя и Фамилия </div>
			<input type="text" name="email_import" value="'.$_POST['email_import'].'" placeholder="№ Email"> - 
			<input type="text" name="name_import" value="'.$_POST['name_import'].'" placeholder="№ '.$lang['subscriber_firstname'].'"> - 
			<input type="text" name="lastname_import" value="'.$_POST['lastname_import'].'" placeholder="№ '.$lang['subscriber_lastname'].'"><br>
			<b>'.$lang['import_exclude'].'</b><br>
			<input type="text" name="exclude" value="'.$_POST['exclude'].'" placeholder="1,2,3">
			'.$categories.'
			<div class="upload_info">Инфа о том, как загружать</div>
			<input type="file" name="file-import"></fieldset>
			<button class="but" type="submit" value="'.$lang['import_sub'].'" name="sub_import"><img src="'.$href.'images/39.png"> '.$lang['import_sub'].'</button>
		</form>';
		
		$out .= '<div class="sectionHeader">'.$lang['import_title'].'</div>';
		$out .= '<div class="sectionBody">';
		$out .= $importForm;
		$out .='</div>';
	break;	
	// NEW
	// добавлены категории
	case 4:
	$out .= '<div class="sectionHeader">Управление категориями</div>';
	$out .= '<div class="sectionBody">';
	$sql = "SELECT id, kat_title,kat_descr FROM $tbl_kat";
	$do = $modx->db->makeArray($modx->db->query($sql));
	$out .="<table class='grid' style='margin:10px 0; font-size:12px'>";
	if ($modx->db->getRecordCount($modx->db->query($sql))<1)
	{
		$out .='<tr><td colspan="4" align="center">Не создано ни одной категории</td></tr>';
	}
	$i=1;
	foreach ($do as $kat)
	{
		$out .="
		<tr>
			<td>".$i."/<small>".$kat['id']."</small></td>
			<td>".$kat['kat_title']."</td>
			<td>".$kat['kat_descr']."</td>
			<td>
			<a href='index.php?a=112&id=".$mod_id."&p=4&edit=".$kat['id']."'>Ред.</a> 
			| 
			<a href='index.php?a=112&id=".$mod_id."&p=4&del=".$kat['id']."'>Уд.</a>
			</td>
		</tr>";
		$i++;
	}
	$out .='</table>';
	// редактирование категории
	if ((int)$_GET['edit'])
	{
		$sql = "SELECT id,kat_title,kat_descr FROM $tbl_kat WHERE id='".$_GET['edit']."'";
		$r = $modx->db->getRow($modx->db->query($sql));
		$title = $r['kat_title'];
		$descr = $r['kat_descr'];
		$t = "Редактирование категории";
		if ($_POST['kat_submit'])
		{
			$sql = "UPDATE $tbl_kat SET kat_title = '".$modx->db->escape($_POST['kat_name'])."',kat_descr='".$modx->db->escape($_POST['kat_descr'])."' WHERE id='".(int)$_GET['edit']."'";
			$modx->db->query($sql);
			header('Location:'.$_SERVER['REQUEST_URI']);
		}
		
	}
	// удаление категории
	elseif ($_GET['del'])
	{
		$sql="DELETE FROM $tbl_kat WHERE id='".(int)$_GET['del']."'";
		$modx->db->query($sql);
		header('Location:index.php?a=112&id='.$mod_id.'&p=4');
	}
	// добавление новой категории
	else
	{
		$title = $_POST['kat_name'];
		$descr = $_POST['kat_descr'];
		$t = "Добавление новой категории";
		// если добавляем новую категорию
		if ($_POST['kat_submit'])
		{
			$sql = "SELECT kat_title FROM $tbl_kat WHERE kat_title='".$_POST['kat_name']."'";
			if ($modx->db->getRecordCount($modx->db->query($sql))==1)
			{
				$out .='Такая категория уже существует!';
			}
			else
			{
				if($_POST['kat_descr']=='')
				{
					$out .='Введите описание категории';
				}
				else
				{
					$sql = "INSERT INTO $tbl_kat VALUES(NULL,'".$modx->db->escape($_POST['kat_name'])."','".$modx->db->escape($_POST['kat_descr'])."')";
					$modx->db->query($sql);
					header('Location:'.$_SERVER['REQUEST_URI']);
				}
			}
		}
	}
	$out .='
	<fieldset>
	<legend>'.$t.'</legend>
	<form method="post" action="">
		<label>Название категории</label><br>
		<input type="text" name="kat_name" value="'.$title.'" placeholder="Название категории"><br>
		<label>Краткое описание категории</label><br>
		<textarea name="kat_descr" placeholder="Краткое описание категории">'.$descr.'</textarea><br><br>
		<button type="submit" name="kat_submit" value="Отправить">Отправить</button>
	</form>
	</fieldset>';
	$out .='</div>';
	break;
	// help / раздел помощи
	case 5 :
	$out.=file_get_contents($path.'/help/help.html');
	break;
	default:
		if ($_GET['action'] == 1) {
			// если добавляем
			if ($_POST['add-sub'])
			{
				if ($num==0)
				{
				$out .= '<div class="content_">
					<fieldset>
					<legend>'.$lang['subscriber_add_header'].'</legend>
					<form action="index.php?a=112&id='.$mod_id.'&action=5" method="post">
					<b>'.$lang['subscriber_firstname'].'</b><br /><input type="text" size="50" maxlength="50" name="firstname" value=""></input><br />
					<b>'.$lang['subscriber_lastname'].'</b><br /><input type="text" size="50" maxlength="50" name="lastname" value=""></input><br />
					<b>'.$lang['subscriber_email'].'</b><br /><input type="text" size="50" maxlength="50" name="email" value=""></input><br />';
					$out .='<b>Категория:</b><br>
					<select name="kategory_id" style="width:357px">
					<option>Без категории</option>
					';
					$sql = "SELECT id,kat_title FROM $tbl_kat";
								foreach ($modx->db->makeArray($modx->db->query($sql)) as $kat)
								{
										$out.='<option value="'.$kat['id'].'"';
										$out.='>'.$kat['kat_title'].'</option>';
								}
					$out.='</select><br>';
					$out.='<button class="but" type="submit" value="'.$lang['subscriber_edit_save'].'" name="add"><img src="'.$href.'images/add.png"> '.$lang['subscriber_edit_save'].'</button>
					</fieldset>
					</div>';
				}
				else
				{
					$out .= '<div class="content_">
					<p>'.$lang['subscriber_add_header'].'</p>
					<form action="index.php?a=112&id='.$mod_id.'&action=5" method="post">
					<b>'.$lang['subscriber_firstname'].'</b><br /><input type="text" size="50" maxlength="50" name="firstname" value="'.$row["firstname"].'"></input><br />
					<b>'.$lang['subscriber_lastname'].'</b><br /><input type="text" size="50" maxlength="50" name="lastname" value="'.$row["lastname"].'"></input><br />
					<b>'.$lang['subscriber_email'].'</b><br /><input type="text" size="50" maxlength="50" name="email" value="'.$row["email"].'"></input><br /><br />
					<button class="but" type="submit" value="'.$lang['subscriber_edit_save'].'" name="add"><img src="'.$href.'images/add.png"> '.$lang['subscriber_edit_save'].'</button></div>';
				}
			}
			// удаление выбранных подписчиков
			elseif ($_POST['del-some'])
			{
				if ($_POST['check-some']=='')
				{
					$out .='Вы не выбрали ни одного подписчика для удаления.';
				}
				else
				{
					$arr = $_POST['check-some'];
					foreach ($arr as $del_sbscr)
					{
						$sql = "DELETE FROM $tbl_sbscr WHERE id = '".$del_sbscr."'";
						$modx->db->query($sql);
					}
					header ('Location:'.$_SERVER['REQUEST_URI']);
				}
			}
			// удаление всех подписчиков с редиректом
			elseif ($_POST['del-all'])
			{
				$sql = "TRUNCATE TABLE  $tbl_sbscr";
				$modx->db->query($sql);
				header ('Location:'.$_SERVER['REQUEST_URI']);
			}
			elseif ($_POST['to-send'])
			{
				$_SESSION['check-some'] = $_POST['check-some'];
				header('Location:'.$_SERVER['REQUEST_URI']);
			}
			elseif ($_POST['to-send-clear'])
			{
				$_SESSION['check-some'] = '';
				header('Location:'.$_SERVER['REQUEST_URI']);
			}
			else
			{
				// List subscribers
				if (!isset($_GET['sortorder'])) {
					$sortorder = 'email';
				} else {
					$sortorder = $_GET['sortorder'];
				}
				// фильтрация по категориям
				if ((int)$_POST['start-filter'])
				{
					if ((int)$_POST['filter'])
					{
						header('Location:index.php?a=112&id='.$mod_id.'&action=1&cat='.$_POST['filter']);
					}
					elseif ($_POST['filter']=='all')
					{
						header('Location:index.php?a=112&id='.$mod_id.'&action=1');
					}
					elseif ($_POST['filter']=='0')
					{
						header('Location:index.php?a=112&id='.$mod_id.'&action=1&cat=0');
					}
				}
				$limit = 20;
				if($_GET['page'])
				{
					$start = ((int)$_GET['page'] - 1) * $limit;
				}
				else
				{
					$_GET['page']=1;
					$start =0;
					//header('Location:index.php?a=112&id='.$mod_id.'&action=1&page=1');
				}
				if ((int)$_GET['cat'])
				{
					$filter = 'WHERE cat_id="'.(int)$_GET['cat'].'"';
				}
				else
				{
					$filter ='';
				}
				$sql = "SELECT * FROM $tbl_sbscr $filter ORDER BY `".$sortorder."` ASC LIMIT $start,$limit";
				$result = $modx->db->query($sql);
				$num = $modx->db->getRecordCount($result);
				if ($num > 0) {				
				$list .= '<script type="text/javascript">
					<!--
					function delete_subscriber(a,b,c,d)
					{
					answer = confirm("'.$lang['subscriber_delete_alert'].'\n"+b+" "+c+" - "+d)
					if (answer !=0)
					{
					location = "index.php?a=112&id='.$mod_id.'&action=4&nid="+a
					}
					}
					//-->
					</script>';
					$list .= '
					<div class="sectionHeader">
						Список подписчиков, зарегистрированных в системе
					</div>
					<div class="sectionBody">
					<form method="post" name="s_list" id="s_list" action="index.php?a=112&id='.$mod_id.'&action=1">
					
					<div class="actionMainSend">
							<button class="but" name="add-sub" value="add"><img src="'.$href.'images/add.png"> Добавить подписчика</button>
							<button class="but" name="to-send" value="1"><img src="'.$href.'images/39.png"> Отложить выбранные</button>';
							if (is_array($_SESSION['check-some']))
							{
								$list.='<button class="but" style="position:relative" name="to-send-clear" value="1"><img src="'.$href.'images/pisma.png"> Отложено '.count($_SESSION['check-some']).' email
									<div>Для удаления отложенных адресов нажмите на эту кнопку</div>
								</button>';
							}
							$list.='<a class="but nounder" href="index.php?a=112&id='.$mod_id.'&p=1&action=8" name="to-export" value="1"><img src="'.$href.'images/save.png"> Экспорт/Бэкап</a>';
							$sql = "SELECT id,kat_title FROM $tbl_kat";
							$list.='<div class="actButs add-form"  style="display:none">
							<select name="filter_all">
							<option value="0">Без категории</option>';
							if ($_POST['sub_kat_all'])
							{
								foreach ($_POST['check-some'] as $cs)
								{
									$sql = "UPDATE $tbl_sbscr SET cat_id='".$modx->db->escape((int)$_POST['filter_all'])."'
									WHERE id = ('".$cs."')";
									$modx->db->query($sql);
								}
								header('location:'.$_SERVER['REQUEST_URI']);
							}
							foreach ($modx->db->makeArray($modx->db->query($sql)) as $kat)
								{
									if($modx->db->getRecordCount($modx->db->query($sql))>0){
										$list.='<option value="'.$kat['id'].'"';
										$list.='>'.$kat['kat_title'].'</option>';
									}
								}
							$list.='</select>
							<button type="submit" class="but" name="sub_kat_all" value="1">Изменить категорию</button>
							</div>';
							
					$list .='
					
					<div class="actionMainSendRight">
							<input type="text" id="email_filter" value="" placeholder="Фильтр по email">
							<select name="filter">
								<option value="all">Все</option>
								<option value="0"';
								if ($_GET['cat']=='0')
										{
											$list.=' selected ';
										}
								$list.='>Без категории</option>';
								// вывод фильтра по категориям
								$sql = "SELECT id,kat_title FROM $tbl_kat";
								foreach ($modx->db->makeArray($modx->db->query($sql)) as $kat)
								{
									$s = "SELECT id FROM $tbl_sbscr WHERE cat_id='".$kat['id']."'";
									$res = $modx->db->query($s);
									$n = $modx->db->getRecordCount($res);
									if($n>0){
										$list.='<option value="'.$kat['id'].'"';
										if ($kat['id']==$_GET['cat'])
										{
											$list.=' selected ';
										}
										$list.='>'.$kat['kat_title'].'</option>';
									}
								}
								
							$list.='</select>
							<button name="start-filter" class="but" value="1" type="submit">Применить</button>
					</div>
					</div><!--/actionMainSend-->
					<div class="actButs">
						<span>Действия с подписчиками:</span>
						<button class="but" name="del-some" value="some"><img src="'.$href.'images/error.png" style="top:2px; position:relative; margin-right:5px" height="13"> Удалить выбранные</button>
						<button class="but" name="del-all" value="all"><img src="'.$href.'images/cancel.png" style="top:2px; position:relative; margin-right:5px" height="13"> Удалить все</button>
					</div>
					<div id="result"></div>
					<table style="font-size: 12px;" cellspacing="0" width="100%" class="gridSubscribers">';
					$list .= '<tr class="headTR">';
					$list .= '
					<th class="gridHeader" align="center">
					<label><input type="checkbox" id="check_all"></label>  
					<b>№ / id</b>
					</th>
					<th class="gridHeader" align="left"><a href="index.php?a=112&id='.$mod_id.'&action=1&sortorder=email"><strong>'.$lang['subscriber_email'].'</strong></a></th>
					<th class="gridHeader" align="left"><a href="index.php?a=112&id='.$mod_id.'&action=1&sortorder=firstname"><strong>'.$lang['subscriber_firstname'].'</strong></a></th>
					<th class="gridHeader" align="left"><a href="index.php?a=112&id='.$mod_id.'&action=1&sortorder=lastname"><strong>'.$lang['subscriber_lastname'].'</strong></a></th>					
					<th class="gridHeader">'.$lang['subscriber_action'].'</th>
					<th class="gridHeader" align="center" width="130">Отправлено</th>
					';
					$list .= '</tr>';
					$i=0;	
					// выводим таблицу на главной
					while($i < $num){		
						$row = $modx->db->getRow($result);	
						$list .=	'
					
						<tr valign="middle" id="row" class="
						';
						if (is_array($_SESSION['check-some']))
							{
								if(in_array($row["id"],$_SESSION['check-some']))
								{
									$list.=' CHECKEDTR ';
								}
							}
						$list.='
						">';
						$list .= '
						<td class="row" width="110" align="center">
							<input onclick="checkBlock();" id="check'.$row["id"].'" class="ch" type="checkbox" value="'.$row["id"].'" name="check-some[]"';
							if (is_array($_SESSION['check-some']))
							{
								if(in_array($row["id"],$_SESSION['check-some']))
								{
									$list.=' CHECKED ';
								}
							}
							
							$list.='>
							<b>'.($i + $start + 1).'</b> <small>/ '.$row["id"].'</small>
						</td>
						<td class="row"><label for="check'.$row["id"].'"><img src="'.$href.'images/03.png" style="top:2px; position:relative; margin-right:5px" height="13"> <b>'.$row["email"].'</b></label></td>
						<td class="row">'.$row["firstname"].'&nbsp;</td>
						<td class="row">'.$row["lastname"].'&nbsp;</td>						
						<td class="row" align="center" width="100" align="center">
								<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&action=2&nid='.$row["id"].'"><img src="'.$href.'images/edit.png" height="13"></a>
								<a class="but roundbut" href="index.php?a=112&id='.$mod_id.'&action=4&nid='.$row["id"].'" onclick=" delete_subscriber(\''.$row["id"].'\',\''.$row["firstname"].'\',\''.$row["lastname"].'\',\''.$row["email"].'\'); return false;"><img src="'.$href.'images/cancel.png"></a>		
						</td>
						<td class="row"><small>';
						if($row["lastnewsletter"]!=='')
						{
							$list.=date('d.m.Y в H:i:s',$row["lastnewsletter"]);
						}
						$list.='</small></td>
						';
						$list .= '</tr>';
						$i++;
					}
					$list .= '
					</table></form>';
					//pagination
					$page = (int)$_GET['page']+1;
					$tot = "SELECT id FROM $tbl_sbscr $filter";
					$total = $modx->db->getRecordCount($modx->db->query($tot));
					$lastpage = ceil($total/$limit);
					if ((int)$_GET['page']>$lastpage)
					{
						header('Location:index.php?a=112&id='.$mod_id.'&action=1');
					}
					$list .= '<div class="pagination">';
					$list .= '<a id="next" href="index.php?a=112&id='.$mod_id.'&action=1';
					if ((int)$_GET['cat'])
					{
						$list.='&cat='.(int)$_GET['cat'];
					}
					$list.='&page='.$page.'">'.$page.'</a>';
					$list.='</div>';
					$list.='
					
					</div>';
					$out .=  $list;
				} 
				else {
				/// если нет подписчиков
					$out .=
					'<div class="sectionBody">
					<form method="post" action="index.php?a=112&id='.$mod_id.'&action=1">
					
					<div align="center">
					<div style="text-align:center; margin:10px"><img src="'.$href.'images/about.jpg"></div>
					<button class="but" name="add-sub" value="add"><img src="'.$href.'images/add.png" style="top:2px; position:relative; margin-right:5px" height="13"> Добавите сюда вашего первого подписчика</button>
					<a class="but nounder" href="index.php?a=112&id='.$mod_id.'&p=1&action=8" name="to-export" value="1"><img src="'.$href.'images/save.png"> Восстановление существующей базы</a>
					</div>
					<div class="actButs">
						<button class="but" name="del-some" value="some"><img src="'.$href.'images/error.png" style="top:2px; position:relative; margin-right:5px" height="13"> Удалить выбранные</button>
						<button class="but" name="del-all" value="all"><img src="'.$href.'images/cancel.png" style="top:2px; position:relative; margin-right:5px" height="13"> Удалить все</button>
					</div>
					</form>'
					;
				}
			
			}
			
			
		} elseif ($_GET['action'] == 2) {
			if ($_POST['upd_s'])
			{
				// Update existing subscriber
				$sql = "UPDATE $tbl_sbscr SET firstname='".$_POST['firstname']."', lastname='".$_POST['lastname']."', email='".$_POST['email']."', cat_id='".(int)$_POST['kategory_id']."' WHERE id='".$_GET['nid']."'";
				if ($modx->db->query($sql))
				{
					header('Location:'.$_SERVER['REQUEST_URI']);
				}
			}
			// Update existing subscriber form
			$sql = "SELECT * FROM $tbl_sbscr WHERE id = '".$_GET['nid']."'";
			$result = $modx->db->query($sql);
			$row = $modx->db->getRow($result);
			$out .= '<div class="content_">
					<fieldset>
					<legend>'.$lang['subscriber_edit_header'].'</legend>
					<form action="" method="post">
					<b>'.$lang['subscriber_firstname'].'</b><br /><input type="text" size="50" maxlength="50" name="firstname" value="'.$row["firstname"].'"></input><br />
					<b>'.$lang['subscriber_lastname'].'</b><br /><input type="text" size="50" maxlength="50" name="lastname" value="'.$row["lastname"].'"></input><br />
					<b>'.$lang['subscriber_email'].'</b><br /><input type="text" size="50" maxlength="50" name="email" value="'.$row["email"].'"></input><br />';
					$out .='<b>Категория</b><br>
					<select name="kategory_id" style="width:357px">
					<option>Без категории</option>';
					$sql = "SELECT id,kat_title FROM $tbl_kat";
								foreach ($modx->db->makeArray($modx->db->query($sql)) as $kat)
								{
										$out.='<option value="'.$kat['id'].'"';
										if ($kat['id']==$row["cat_id"])
										{
											$out.=' selected ';
										}
										$out.='>'.$kat['kat_title'].'</option>';
								}
					$out.='</select><br>';
					$out.='<button class="but" type="submit" name="upd_s" value="'.$lang['subscriber_edit_save'].'"><img src="'.$href.'images/add.png"> '.$lang['subscriber_edit_save'].'</button></form></fieldset></div>';
		}
		elseif ($_GET['action'] == 4) {
			// Delete subscriber
			$sql = "DELETE FROM $tbl_sbscr WHERE id='".$_GET['nid']."'";
			$result = $modx->db->query($sql);
			$out .=  $lang['subscriber_edit_delete'];
		}
		elseif ($_GET['action']==5)
		{
			if ($_POST['firstname']!=='' and $_POST['lastname']!=='' and $_POST['email']!=='' )
			{
				if (preg_match('/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i', $_POST['email'], $m))
					{
						$chk = "SELECT * FROM $tbl_sbscr WHERE email='".$_POST['email']."'";
						// если email уже сцществует в таблице, то выводим сообщение об ошибке 
						if ($modx->db->getRecordCount($modx->db->query($chk)) > 0)
						{
							$out .='Такой подписчик уже существует';
						}
						// иначе добавляем 
						else
						{
							$sql = "INSERT INTO $tbl_sbscr VALUES (NULL, '".$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['email']."', '', '', '', now(),'".$_POST['kategory_id']."') ";
							$modx->db->query($sql);
							header ('Location:index.php?a=112&id='.$mod_id.'&action=1');
						}
					}
					else
					{
						$out .='Неправильный формат email';
					}
			}
			else
			{
				$out .= 'Вы оставили пустыми поля.';
			}
		}
}
?>
