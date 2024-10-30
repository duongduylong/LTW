<?php
require_once "C:xampp/htdocs/BT3-WEB/models/ModelDAO.php";
$modelRegister = new ModelRegister();
if (isset($_POST['selectedOption'])) {
  $role = (int) $_POST['selectedOption'];
  $list = $modelRegister->getTop3($role);
}
$ok = 0;
$data = [];
foreach ($list as $key => $li) {
  if (!is_null($li) && $ok <= 2) {
    $data[$ok]['username'] = $li[0]->getUserName();
    $data[$ok]['fullname'] = $li[0]->getFullName();
    $data[$ok]['num'] = $li[1];
    $ok += 1;
  }
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
