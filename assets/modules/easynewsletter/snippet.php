<?php
/*
Easy Newsletter 0.3
Copyright by: Flux - www.simpleshop.dk
update - SAZANOF - www.sazanof.ru
---------------------------------------------------------------------*/
function msqlResultRow ($sql,$field)
{
	global $modx;
	$res = $modx->db->getRow($modx->db->query($sql));
	return $res[$field];
}
$sql = "SELECT * FROM `easynewsletter_config` WHERE `id` = 1";
$result = $modx->db->query($sql);
include('assets/modules/easynewsletter/languages/'.msqlResultRow($sql,"lang_frontend").'.php');
error_reporting(E_ALL ^ E_NOTICE);

$action = $_POST['option'];
$mode = isset($mode) ? $mode : 'subscribe';
$cat_id = isset($cat_id) ? $cat_id : 0;

if ($mode == 'subscribe')
{
	$subscribe_button = $lang_subscribe;
}
elseif ($mode=='unsubscribe')
{
	$subscribe_button = $lang_unsubscribe;
}
$tpl = isset($tpl) ? $modx->getChunk($tpl) : '
<div class="infos_subscr">
	[+infos+]
</div>
<div id="subscr">
<form id="subscrForm" onsubmit="return validate_form(this);" method="post">
	<input type="hidden" value="" name="hid">
	<input type="text" name="firstname"  value="" placeholder="[+lang_firstname+]" >
  	<input type="text" name="lastname"  value="" placeholder="[+lang_lastname+]"  >
	<input type="text" name="email"  value="" placeholder="[+lang_email+]">
	<input type="hidden" name="op" value="set">
	[+options_choice_suscribe+]
	[+options_choice_unsuscribe+]
<button type="submit" value="GO!" id="change" name="subscr_sbmt" class="button full-width">[+subscribe_button+]</button>
</form>
</div>';

$infos = array();
switch($mode) {
case "subscribe":
if ($_POST['hid']=='' and trim($_POST['email'])!=='')
  {
		$sql = "SELECT * FROM `easynewsletter_subscribers` WHERE email = '".trim($_POST['email'])."'";
		$result = $modx->db->query($sql);
		$num = $modx->db->getRecordCount($result);	
		//если нет такого фдреса почты в БД, то записываем
		if ($num < 1) 
 		 {
				$sql = "INSERT INTO `easynewsletter_subscribers` VALUES ('', '".$modx->db->escape($_POST['firstname'])."', '".$modx->db->escape($_POST['lastname'])."', '".$modx->db->escape($_POST['email'])."', '', '', '', now(),'".$cat_id."') ";
				if (trim($_POST['firstname'])!=='')
				{				
					if ($modx->db->query($sql))
					{
						$infos[] = $lang_subscribesuccess;
					}
				}
				else
				{
					$infos[] = $lang_infos_firstname;
				}
		 } 
		else 
		{
				$infos[] = $lang_alreadysubscribed;
		}
  }
	break;
case "unsubscribe":
	if ($_POST['email'])
	{
		$sql = "SELECT * FROM `easynewsletter_subscribers` WHERE email = '".$_POST['email']."'";
		$result = $modx->db->query($sql);
		$num = $modx->db->getRecordCount($result);	
		if ($num < 1) {
			$infos[] = $lang_notsubscribed;
		} else {
			$email = $_POST['email'];
			$sql = "DELETE FROM easynewsletter_subscribers WHERE email = '".$email."'";
			$result = $modx->db->query($sql);
			$infos[] = $lang_unsubscribesuccess;
		}
	}
	break;  	
}
// если массив с сообщениями не пустой, то выводим его
if (!empty($infos))
{
	$mes_wr = '<ul class="subscr_ul_mess">[+messages_wrapper+]</ul>';
	foreach ($infos as $mes)
	{
		$mes = '<li>'.$mes.'</li>';
	}
	$out .= str_replace('[+messages_wrapper+]',$mes,$mes_wr);
}
$modx->setPlaceholder('mode',$mode);
$modx->setPlaceholder('subscribe_button',$subscribe_button);
$modx->setPlaceholder('lang_firstname',$lang_firstname);
$modx->setPlaceholder('lang_lastname',$lang_lastname);
$modx->setPlaceholder('lang_email',$lang_email);
$modx->setPlaceholder('infos',$mes_wr);
$out .= $tpl;
?>