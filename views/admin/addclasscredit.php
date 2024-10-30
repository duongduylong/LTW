<?php
if ($_SESSION['login']['role'] != 4) {
    header('location: home');
}
require_once _DIR_ROOT . '\views\header.php';
$modelSubject = new ModelSubject();
$modelSchedule = new ModelSchedule();
$modelClassCredit = new ModelClassCredit();
if (isset($_POST['addclasscredit'])) {
    $name = test_input($_POST['classcreditname']);
    $subjectId = test_input($_POST['subject']);
    $subject = $modelSubject->getById($subjectId);
    $groupclass = test_input($_POST['groupclass']);
    $scheduleCode = test_input($_POST['schedule']);
    $schedule = $modelSchedule->getByCode($scheduleCode);
    $classCredit = new ClassCredit(1, $name, $subject, $groupclass, $schedule, 70, 2, 2);
    if ($modelClassCredit->addObject($classCredit)) {
        $_SESSION['error'] = 'Thêm lớp tín chỉ thành công';
        header('Location: classcreditmanagement');

    } else {
        $_SESSION['error'] = 'Thất bại';
        header('Location: classcreditmanagement');

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
                                    <h4 class="animate__animated animate__fadeInDown"> Thêm lớp tín chỉ</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="font-family: 'Inria Serif', sans-serif;">

                    <div class="col-xs-12">
                        <form method="post" action="/BT3-WEB/admin/addclasscredit" role="form"
                            class="form-horizontal" id="form-edit">
                            <div class="form-group">
                                <label class="col-xs-2">Tên lớp tín chỉ</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="classcreditname" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-2">Môn học</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="subject" id="districtId">

                                        <option>---Chọn môn học---</option>
                                        <?php

                                        $list = $modelSubject->getAll();

                                        foreach ($list as $key => $li) {
                                            if (!is_null($li)) {
                                                $subject = $li->getSubjectName();
                                                $id = $li->getSubjectId();
                                                echo '<option value="' . $id . '">' . $subject . '</option>';
                                            }
                                        }

                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Nhóm</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="groupclass">

                                        <option>---Chọn nhóm---</option>

                                        <option value="1"> Nhóm 1</option>

                                        <option value="2"> Nhóm 2</option>
                                        <option value="3"> Nhóm 3</option>
                                        <option value="4"> Nhóm 4</option>
                                        <option value="5"> Nhóm 5</option>
                                        <option value="6"> Nhóm 6</option>
                                        <option value="7"> Nhóm 7</option>
                                        <option value="8"> Nhóm 8</option>
                                        <option value="9"> Nhóm 9</option>


                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Lịch học</label>
                                <div class="col-xs-9">
                                    <select  class="form-control" name="schedule">
                                        <option>---Chọn lịch học---</option>
                                        <?php
                                        $list = $modelSchedule->getAll();
                                        $uniqueSchedules = array_unique($list); // Assuming 'scheduleCode' is unique
                                        
                                        foreach ($uniqueSchedules as $key=>$code) {
                                            if (!is_null($code)) {
                                                $scheduleli = $modelSchedule->getByCode((int)$code);
                                                $scheduletext = viewSchedule($scheduleli);
                                                echo '<option value="'.$code.'">' . $scheduletext . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-2"></div>
                                <div class="col-xs-9">
                                    <button class="btn-get" style="margin-right: 10px;" name='addclasscredit'>
                                        <i class="ace-icon glyphicon glyphicon-plus"></i>
                                        <span> Thêm lớp tín chỉ</span>
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