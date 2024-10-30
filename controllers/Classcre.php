<?php

class Classcre extends Controller
{
    public function index($id = '')
    {
        $modelRegister = new ModelRegister();
        $modelUser = new ModelUser();
        $user = $modelUser->getByUserName($_SESSION['login']['username']);
        $list = $modelRegister->getByUserId($user->getUserId());
        $this->view('classcredit', $list);

    }
    public function list($id = '')
    {
        $modelRegister = new ModelRegister();
        $listGv = $modelRegister->getGvByClassCreditId((int) $id);
        $listTg = $modelRegister->getTgByClassCreditId((int) $id);
        $listSv = $modelRegister->getSvByClassCreditId((int) $id);
        $list = array();
        array_push($list, $listGv);
        array_push($list, $listTg);
        array_push($list, $listSv);
        $this->view('listMemberClassCredit', $list);

    }
}
?>