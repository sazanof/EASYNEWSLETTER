<?php
require($_SERVER['DOCUMENT_ROOT'].'/manager/includes/protect.inc.php');
include ($_SERVER['DOCUMENT_ROOT'].'/manager/includes/config.inc.php');
include(MODX_BASE_PATH."manager/includes/document.parser.class.inc.php");
$modx = new DocumentParser;
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	if ($_POST['email_filter'])
		{
			if($_POST['cat'])
			{
				$where = "WHERE cat_id='".(int)$_POST['cat']."'";
			}
			else
			{
				$where = "WHERE cat_id='0'";
			}
			//фильтр по категориям и привязанным мэйлам
			$sql="SELECT * FROM `easynewsletter_subscribers` $where";
			$res = $modx->db->query($sql);
			$res = $modx->db->makeArray($res);
			// begin filter
			$term = mb_strtolower(trim($_POST['email_filter']));
			$ar = array();
			foreach ($res as $r)
			{
				if (strstr($r['email'],$term))
				{
					$ar[]= array($r['id'],$r['firstname'],$r['lastname'],$r['email'],$r['status'],$r['lastnewsletter'],$r['created'],$r['cat_id']);
				}
			}
			if (!empty($ar))
			{
				// нашли массив совпадений
				foreach ($ar as $str)
				{
					$out .='<tr id="row">
						<td >'.$str[0].'</td>
						<td>'.$str[3].'</td>
						<td>'.$str[1].'</td>
						<td>'.$str[2].'</td>
						<td>ред уд</td>
					</tr>';
				}
			}
			else
			{
				$rus = array('ё','й','ц','у','к','е','н','г','ш','щ','з','х','ъ','ф','ы','в','а','п','р','о','л','д','ж','э','я','ч','с','м','и','т','ь','б','ю');
				$out .='<a href="">Сброс фильтра</a>';
			}
			
		}
echo $out;
}
?>