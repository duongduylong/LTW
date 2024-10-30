<?php
require_once _DIR_ROOT . '\views\header.php';
if ($_SESSION['login']['role'] != 4) {
    header('location: home');
}
$modelClassFormal = new ModelClassFormal();
$userr = $data[0];
if (isset($_POST['updateuser'])) {
    $username = test_input($_POST['username']);
    $fullname = test_input($_POST['fullname']);
    $classformalid = test_input($_POST['classformal']);
    $classformal = $modelClassFormal->getById($classformalid);
    $userrole = test_input($_POST['userrole']);
    $status = test_input($_POST['status']);
    $dateofbirth = test_input($_POST['dateofbirth']);
    $gender = test_input($_POST['gender']);
    $address = test_input($_POST['address']);
    $birthplace = test_input($_POST['birthplace']);
    $img = test_input($_POST['img']);
    $social = test_input($_POST['social']);
    $userr->setUserName($username);
    $userr->setFullName($fullname);
    $userr->setUserRole($userrole);
    $userr->setStatus($status);
    $userr->setDateOfBirth($dateofbirth);
    $userr->setGender($gender);
    $userr->setCurrentAddress($address);
    $userr->setBirthplace($birthplace);
    $userr->setAvatarImagePath($img);
    $userr->setLinkSocial($social);
    $modelUser = new ModelUser();
    if ($modelUser->updateObject($userr)) {
        $_SESSION['error'] = 'Thay đổi thông tin thành công';
        header('Location:http://localhost/BT3-WEB/admin/usermanagement');

    } else {
        $_SESSION['error'] = 'Thất bại';
        header('Location: http://localhost/BT3-WEB/admin/usermanagement');

    }


}
?>

<div class="section-one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2">
                <?php
                require "narbaradmin.php";
                ?>
            </div>

            <div class="col-xl-10">
                <div class="suscribe-area animate__animated animate__fadeInDown "
                    style="display:block;margin: 5px 0px; border-radius: 10px;  ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="suscribe-text text-center">
                                    <h4 class="animate__animated animate__fadeInDown"> Sửa thông tin người dùng</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="font-family: 'Inria Serif', sans-serif;">

                    <div class="col-xs-12">
                        <form method="post" action="/BT3-WEB/admin/updateuser/<?php echo $userr->getUserId() ?>"
                            role="form" class="form-horizontal" id="form-edit">
                            <div class="form-group">
                                <label class="col-xs-2">Tên người dùng</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="username"
                                        value="<?php echo $userr->getUserName(); ?>" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-xs-2">Họ và tên</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="fullname"
                                        value="<?php echo $userr->getFullName() ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Lớp chính quy</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="classformal" id="districtId">


                                        <?php
                                        $classformalbegin = $userr->getClassFormal();
                                        echo '<option value="' . $classformalbegin->getClassFormalId() . '">D ' . $classformalbegin->getClassCourse() . ' ' . $classformalbegin->getBranch()->getBranchName() . ' ' . $classformalbegin->getClassNumber() . '</option>';
                                        $modelClassFormal = new ModelClassFormal();
                                        $list = $modelClassFormal->getAll();

                                        foreach ($list as $key => $li) {
                                            if (!is_null($li)) {
                                                $classCourse = $li->getClassCourse();
                                                $classNumber = $li->getClassNumber();
                                                $brand = $li->getBranch()->getBranchName();
                                                $id = $li->getClassFormalId();
                                                $classFormal = 'D ' . $classCourse . ' ' . $brand . ' ' . $classNumber;
                                                echo '<option value="' . $id . '">' . $classFormal . '</option>';
                                            }
                                        }

                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Phân quyền</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="userrole">

                                        <?php
                                        $roleString = '';
                                        $role = $userr->getUserRole();
                                        if ($role == 1)
                                            $roleString = 'Sinh Viên';
                                        else if ($role == 2)
                                            $roleString = 'Trợ Giảng';
                                        else if ($role == 3)
                                            $roleString = 'Giảng Viên';
                                        else
                                            $roleString = 'Admin';

                                        echo '<option value="' . $role . '">' . $roleString . '</option> '; ?>

                                        <option value="1">Sinh viên</option>

                                        <option value="2">Trợ giảng</option>

                                        <option value="3">Giảng viên</option>

                                        <option value="4">Admin</option>


                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Hiện diện</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="status">
                                        <?php
                                        $statusbegin = $userr->getStatus();
                                        $hiendien = '';
                                        if ($statusbegin == 1)
                                            $hiendien = 'Đang làm việc';
                                        else
                                            $hiendien = 'Đã nghỉ';
                                        echo '<option  value="' . $statusbegin . '">' . $hiendien . '</option>';
                                        ?>
                                        <option value="1">Đang làm việc</option>

                                        <option value="0">Đã nghỉ</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Ngày sinh</label>
                                <div class="col-xs-9">
                                    <input type="text" name="dateofbirth" class="form-control"
                                        value="<?php echo $userr->getDateOfBirth() ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Giới tính </label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="gender">
                                        <?php
                                        $gioitinh = '';
                                        $genderbegin = $userr->getGender();
                                        if ($genderbegin == 1) {
                                            $gioitinh = 'Nam';

                                        } else
                                            $gioitinh = 'Nữ';
                                        echo '<option value="' . $genderbegin . '">' . $gioitinh . '</option>';
                                        ?>


                                        <option value="1">Nam</option>

                                        <option value="0">Nữ</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Địa chỉ</label>
                                <div class="col-xs-9">
                                    <input type="text" name="address" required class="form-control"
                                        value="<?php echo $userr->getCurrentAddress() ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Nơi sinh</label>
                                <div class="col-xs-9">
                                    <input type="text" name="birthplace" class="form-control" required
                                        value="<?php echo $userr->getBirthplace() ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Ảnh đại diện</label>
                                <div class="col-xs-9">
                                    <input type="text" name="img" class="form-control" required
                                        value="<?php echo $userr->getAvatarImagePath() ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Link Sosial</label>
                                <div class="col-xs-9">
                                    <input type="text" id="level" name="social" class="form-control" required
                                        value="<?php echo $userr->getLinkSocial() ?>">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-2"></div>
                                <div class="col-xs-9">
                                    <button class="btn-get" style="margin-right: 10px;" name='updateuser'>
                                        <i class="ace-icon glyphicon glyphicon-plus"></i>
                                        <span> Sửa người dùng</span>
                                    </button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once _DIR_ROOT . '\views\footer.php';
?>