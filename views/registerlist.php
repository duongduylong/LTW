<?php
session_start();
ob_start();
require_once '../helper/functions.php';
require_once '../models/ModelDAO.php';
$modelUser = new ModelUser();
$modelRegister = new ModelRegister();
$modelcredit = new ModelClassCredit();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$userId = $_SESSION['login']['username'];
$user = $modelUser->getByUserName($userId);
$listSchedule = $modelRegister->getByUserId($user->getUserId());
$listKq=[];
$tmp=null;

if (isset($_POST['credit_id'])) {
    $creditId = $_POST['credit_id'];
    $listGv=$modelRegister->getGvByClassCreditId($creditId);
    $listTg=$modelRegister->getTgByClassCreditId($creditId);
    $listSv=$modelRegister->getSvByClassCreditId($creditId);
    $classCredit = $modelcredit->getById($creditId);
    $gvMax=$classCredit->getGvMax();
    $tgMax=$classCredit->getTgMax();
    $svMax=$classCredit->getSvMax();
    $role=$user->getUserRole();
    if(checkRegister($listGv,$listTg,$listSv,$gvMax,$tgMax,$svMax,$role)){
        foreach ($listSchedule as $key => $li){
            if(!is_null($key)){
                if($li->getClassCredit()->getSubject()->getSubjectId() == $classCredit->getSubject()->getSubjectId()) {
                    $tmp=$li->getClassCredit();
                }
            }
        }
        
        if(!is_null($tmp)){
            $credittmp=null;
            foreach ($listSchedule as $key => $li){
                if(!is_null($key)){
                    if(checkClassCredit($li->getClassCredit(),$classCredit)){
                        $credittmp=$li->getClassCredit();
                    }
                    
                }
            }
            if(is_null($credittmp)){
                $modelRegister->deleteByUserAndClassCredit($user->getUserId(),$tmp->getClassCreditId());
                $regiter = new Register(1, $classCredit, $user, new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')));
                $modelRegister->addObject($regiter);
                $listKq[0]['status']=1;
                $listKq[0]['error'] = $tmp->getClassCreditId();
            }
            else{
                $listKq[0]['status']=2;
                $listKq[0]['error'] = getSchedule($credittmp,'Trùng lịch học với môn');
            }
        }
        else{
            $credittmp=null;
            foreach ($listSchedule as $key => $li){
                if(!is_null($key)){
                    if(checkClassCredit($li->getClassCredit(),$classCredit)){
                        $credittmp=$li->getClassCredit();
                    }
                    
                }
            }
            if(is_null($credittmp)){
                $listKq[0]['status']=0;
                $regiter = new Register(1, $classCredit, $user, new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')));
                $modelRegister->addObject($regiter);
            }
            else{
                $listKq[0]['status']=2;
                $listKq[0]['error'] = getSchedule($credittmp,'Trùng lịch học với môn');
            }
    
        }
    }
    else{
        $listKq[0]['status']= 3;
        $listKq[0]['error'] = 'Lớp đã đủ số lượng.';
    }
   

    $list = $modelRegister->getByUserId($user->getUserId());
	$ok = 1;
	foreach ($list as $key => $li) {
		if (!is_null($key)) {        
			$creditlist = $li->getClassCredit();
            
            $listKq[$ok]['STT']=$ok;
			$listKq[$ok]['subjectCode'] =  $creditlist->getSubject()->getSubjectCode() ;
			$listKq[$ok]['subjectName'] =  $creditlist->getSubject()->getSubjectName() ;
			$listKq[$ok]['groupClass'] =  $creditlist->getGroupClass();
            $listKq[$ok]['credit'] = $creditlist->getSubject()->getCredit();
            $listKq[$ok]['class'] = $creditlist->getClassCreditName();
            $listKq[$ok]['time'] = toStrRegister($li->getRegisterTime());
            $listKq[$ok]['schedule'] = getSchedule($creditlist,'TKB ');
			$ok+=1;
		}
	}
    echo json_encode($listKq,JSON_UNESCAPED_UNICODE) ;
}


