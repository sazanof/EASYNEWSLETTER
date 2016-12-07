<?php
if(IN_MANAGER_MODE!='true' && !$modx->hasPermission('exec_module')) die('<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.');
require_once(MODX_BASE_PATH.'assets/modules/easynewsletter/inc/cfg.php');
if (file_exists($lng_file)){
    require_once($lng_file);
}
else {
    die("Не найден языковой файл! Проверьте конфинурацию модуля и файлы.");
}
$out = '';
$title = $lang['title'];
$content= '';
$out .= '<!DOCTYPE html><html><head>
<title>[+title+]</title>
<link rel="stylesheet" type="text/css" href="/manager/media/style/MODxRE2/style.css" />
<link rel="stylesheet" type="text/css" href="[+path+]libs/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="[+path+]libs/DataTables/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" href="media/style/common/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="[+path+]libs/DataTables/datatables.min.css"/>
<link rel="stylesheet" href="[+path+]css/style.css" />

<script src="[+path+]libs/jquery-3.1.1.min.js"></script>
<script src="[+path+]libs/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="[+path+]libs/DataTables/datatables.min.js"></script>
<script src="[+path+]libs/bootstrap/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $("#example").DataTable( {
        "ajax": "'.ENL_MODULE_URL.'&act=1&list=subs",
        "stateSave": true,
        "lengthMenu": [[50,100,250,500, -1], [50,100,250,500, "Все"]],
        "columns": [
            { "data":"id"},
            { "data": "firstname" },
            { "data": "lastname" },
            { "data": "email" },
            { "data":"buttons" }
        ],
        "language": {
            "url": "[+path+]languages/datatables/'.$lng.'.json"
        }
    } );
});
</script>
<meta charset="utf-8"></head>
 <body>
 <div class="sectionBody">
 <h1>[+title+]</h1>
    <div id="actions">
		<ul class="actionButtons">
			<li><a href="[+url+]&act=1"><i class="fa fa-users" aria-hidden="true"></i> '.$lang['links_subscribers'].'</a></li>
			<li><a href="[+url+]&act=2"><i class="fa fa-envelope" aria-hidden="true"></i> '.$lang['links_newsletter'].'</a></li>
			<li><a href="[+url+]&act=3"><i class="fa fa-tasks" aria-hidden="true"></i> '.$lang['links_categories'].'</a></li>
			<li><a href="[+url+]&act=4"><i class="fa fa-gears" aria-hidden="true"></i> '.$lang['links_configuration'].'</a></li>
			<li><a href="[+url+]&act=5"><i class="fa fa-question" aria-hidden="true"></i> '.$lang['links_help'].'</a></li>
        </ul>
	</div>
  [+content+]
 </div>
 </body>
</html>';
$act = (int)$_GET['act'];
if (!$act) header('Location:'.ENL_MODULE_URL.'&act=1');
switch($act){
    case 1:
        $title = $lang['links_subscribers'];
        require_once(ENL_PATH.'inc/subscriber.inc.php');
        break;
    case 2:
        $title = $lang['links_subscribers'];
        break;
    case 3:
        $title = $lang['links_categories'];
        break;
    case 4:
        $title = $lang['links_configuration'];
        break;
    case 5:
        $title = $lang['links_help'];
        break;
}
$f = [
    '[+title+]',
    '[+content+]',
    '[+path+]',
    '[+url+]'
];
$r = [
    $title,
    $content,
    ENL_FRONTEND_PATH,
    ENL_MODULE_URL
];
echo str_replace($f,$r,$out);