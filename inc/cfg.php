<?php
/*{
    @propetities
    "lng": [
    {
      "label": "Language",
      "type": "list",
      "value": "russian-UTF8",
      "options": "russian-UTF8,danish,english,german,italian",
      "default": "russian-UTF8",
      "desc": ""
    }
  ]
}*/
$per = $modx->config("table_perfix");
define ('ENL_PATH',MODX_BASE_PATH.'assets/modules/easynewsletter/');
define('ENL_FRONTEND_PATH','/assets/modules/easynewsletter/');
define('ENL_MODULE_URL',MODX_MANAGER_URL.'index.php?a=112&id='.(int)$_REQUEST['id']);
define('TBL_SUBSCRIBERS',$per.'easynewsletter_subscribers');
$lng = isset($lng) ? $lng : 'russian-UTF8';
$lng_file = ENL_PATH.'languages/'.$lng.'.php';