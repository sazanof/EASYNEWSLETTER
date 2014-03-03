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
$path = MODX_BASE_PATH.'/assets/modules/easynewsletter/';
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
error_reporting(E_ALL ^ E_NOTICE);

$action = $_POST['option'];
$mode = isset($mode) ? $mode : 'subscribe';
$cat_id = isset($cat_id) ? $cat_id : 0;

if ($mode == 'subscribe')
{
	$subscribe_button = $lang['subscribe'];
}
elseif ($mode=='unsubscribe')
{
	$subscribe_button = $lang['unsubscribe'];
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
						$infos[] = $lang['subscribesuccess'];
					}
				}
				else
				{
					$infos[] = $lang['infos_firstname'];
				}
		 } 
		else 
		{
				$infos[] = $lang['alreadysubscribed'];
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
			$infos[] = $lang['unsubscribesuccess'];
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
$modx->setPlaceholder('lang_firstname',$lang['firstname']);
$modx->setPlaceholder('lang_lastname',$lang['lastname']);
$modx->setPlaceholder('lang_email',$lang['email']);
$modx->setPlaceholder('infos',$mes_wr);
$out .= $tpl;
return $out;
?>
