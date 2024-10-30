<?php
session_start();
ob_start();
require_once '../helper/functions.php';
require_once '../models/ModelDAO.php';
$modelUser = new ModelUser();
$modelRegister = new ModelRegister();
$modelcredit = new ModelClassCredit();
$userId = $_SESSION['login']['username'];
$user = $modelUser->getByUserName($userId);
$listKq = [];
if (isset($_POST['credit_id'])) {
	$creditId = $_POST['credit_id'];
	$modelRegister->deleteByUserAndClassCredit($user->getUserId(), $creditId);

}
$listKq[0] = 0;
$list = $modelRegister->getByUserId($user->getUserId());
$ok = 1;
foreach ($list as $key => $li) {
	if (!is_null($key)) {
		$creditlist = $li->getClassCredit();
		$listKq[$ok]['STT'] = $ok;
		$listKq[$ok]['subjectCode'] = $creditlist->getSubject()->getSubjectCode();
		$listKq[$ok]['subjectName'] = $creditlist->getSubject()->getSubjectName();
		$listKq[$ok]['groupClass'] = $creditlist->getGroupClass();
		$listKq[$ok]['credit'] = $creditlist->getSubject()->getCredit();
		$listKq[$ok]['class'] = $creditlist->getClassCreditName();
		$listKq[$ok]['time'] = toStrRegister($li->getRegisterTime());
		$listKq[$ok]['schedule'] = getSchedule($creditlist, 'TKB ');
		$ok += 1;
	}
}
echo json_encode($listKq, JSON_UNESCAPED_UNICODE);