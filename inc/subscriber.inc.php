<?php
if(IN_MANAGER_MODE!='true' && !$modx->hasPermission('exec_module')) die('<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.');
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $data = '';
    $buttons = '<a href="" class="btn btn-info round-corners"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    <a href="" class="btn btn-danger round-corners"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
    ';
    $subs = $modx->db->select('id,firstname,lastname,email',TBL_SUBSCRIBERS);
    $res = $modx->db->makeArray($subs);
    $i = 0;
    foreach ($res as $row){
        $res[$i]['buttons'] = $buttons;
        $i++;
    }
    $res = array(
        "data"=>$res
    );
    $data = json_encode($res);
    echo $data;
    exit;
}
$html = '
<div class="panel panel-default">
    <div class="panel-body">
        <div class="buttons_act">
                <a href="#addSubscriber" class="btn btn-success" data-toggle="modal">
                <i class="fa fa-user-plus" aria-hidden="true"></i> '.$lang['subscriber_add_header'].'
                </a>

                <a href="#csvImort" class="btn btn-default" data-toggle="modal">
                <i class="fa fa-cloud-download" aria-hidden="true"></i> '.$lang['import_title'].'
                </a>

                <a href="" class="btn btn-warning floatright" data-toggle="modal">
                <i class="fa fa-database" aria-hidden="true"></i> '.$lang['backup_btn'].'
                </a>
        </div>
        <div class="tbl_subscribers">
            <table id="example" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Email</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Email</th>
                        <th>Действия</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- HTML-код модального окна -->
<div id="addSubscriber" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Заголовок модального окна</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
        Содержимое модального окна...
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary">Сохранить изменения</button>
      </div>
    </div>
  </div>
</div>';
$content .= $html;