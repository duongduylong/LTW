<?php
require_once 'C:xampp/htdocs/BT3-WEB/models/ModelDAO.php';
$modelRegister = new ModelRegister();
$data['id'] = -1;
if (isset($_POST['registerId'])) {
    $id = $_POST['registerId'];
    if ($modelRegister->deleteObject($id))
        $data['id'] = $id;
    else
        $data['id'] = -1;
}

echo json_encode($data);