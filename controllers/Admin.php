<?php

class Admin extends Controller
{

    public function index($id = '')
    {
        $modelRegister = new ModelRegister();
        $list = $modelRegister->getTop3(1);
        $this->viewAdmin('homeadmin', $list);

    }
    public function usermanagement($id = '')
    {
        $modelUser = new ModelUser();
        if ($id == '') {
            $list = $modelUser->getAll();
            $this->viewAdmin('usermanagement', $list);
        } else {
            $list = [];
            $user = $modelUser->getById($id);
            array_push($list, $user);
            array_push($list, $user->getUserRole());
            $teacher = $modelUser->getById($user->getClassFormal()->getTeacherId());
            array_push($list, $teacher);
            $this->viewAdmin('viewuser', $list);
        }
    }
    public function adduser($id = '')
    {
        $this->viewAdmin('adduser');
    }
    // public function deleteuser($id = '')
    // {
    //     $modelUser = new ModelUser();
    //     if($modelUser->deleteObject((int)$id)){
    //         $_SESSION['error']='Xoá người dùng thành công';

    //     }
    //     else{
    //         $_SESSION['error']='Xoá thất bại, vui lòng xoá dữ liệu các';

    //     }
    //     $list = $modelUser->getAll();
    //     $this->viewAdmin('usermanagement', $list);

    // }

    public function updateuser($id = '')
    {
        $modelUser = new ModelUser();
        $list = [];
        $user = $modelUser->getById((int) $id);
        array_push($list, $user);
        $this->viewAdmin('updateuser', $list);
    }
    public function classcreditmanagement($id = '')
    {
        $modelClassCredit = new ModelClassCredit();
        $list = $modelClassCredit->getAll();
        $this->viewAdmin('classcreditmanagement', $list);
    }
    public function addclasscredit($id = '')
    {
        $this->viewAdmin('addclasscredit');
    }
    public function updateclasscredit($id = '')
    {
        $modelClassCredit = new ModelClassCredit();
        $list = [];
        $classcredit = $modelClassCredit->getById((int) $id);
        array_push($list, $classcredit);
        $this->viewAdmin('updateclasscredit', $list);
    }
    // public function deleteclasscredit($id = '')
    // {
    //     $modelClassCredit = new ModelClassCredit();
    //     if($modelClassCredit->deleteObject((int)$id)){
    //         $_SESSION['error']='Xoá lớp tín chỉ thành công';

    //     }
    //     else{
    //         $_SESSION['error']='Xoá thất bại';

    //     }
    //     $list = $modelClassCredit->getAll();
    //     $this->viewAdmin('classcreditmanagement', $list);

    // }
    public function registermanagement($id = '')
    {
        $modelRegister = new ModelRegister();
        $list = $modelRegister->getAll();
        $this->viewAdmin('registermanagement', $list);
    }
    public function addregister($id = '')
    {
        $this->viewAdmin('addregister');
    }
    // public function deleteregister($id = '')
    // {
    //     $modelRegister = new ModelRegister();
    //     if($modelRegister->deleteObject((int)$id)){
    //         $_SESSION['error']='Xoá đăng ký thành công';

    //     }
    //     else{
    //         $_SESSION['error']='Xoá thất bại';

    //     }
    //     $list = $modelRegister->getAll();
    //     $this->viewAdmin('registermanagement', $list);

    // }

}

?>