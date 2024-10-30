<?php
require_once "header.php";
$modelUser = new ModelUser();
$userId = $_SESSION['login']['username'];
$user = $modelUser->getByUserName($userId);
$modelsemester = new ModelSubjectSemester();
$currentDate = getdate();
$month = $currentDate['mon'];
$year = $currentDate['year'];
//ki hoc
$kihoc = '';
if ($month > 5) {
    $kihoc .= '1 - NĂM HỌC ' . $year . ' - ' . ($year + 1);
} else {
    $kihoc .= '2 - NĂM HỌC ' . ($year - 1) . ' - ' . ($year);
}
$text = '';
if ($user->getUserRole() > 1)
    $text = 'Giảng Dạy';
else
    $text = 'Học';
//
$classCourse = $user->getClassFormal()->getClassCourse();

if ($classCourse == 1) {
    $listsubject = $modelsemester->getByNameAndBranch(0, $user->getClassFormal()->getBranch()->getBranchId());
    // show($listsubject);
} else {
    $ki = -1;
    if ($month > 7)
        $ki = 2 * ($year - 2000 - $classCourse) + 1;
    else
        $ki = 2 * ($year - 2000 - $classCourse);
    $listsubject = $modelsemester->getByNameAndBranch($ki, $user->getClassFormal()->getBranch()->getBranchId());
}

$list = [];
$modelcredit = new ModelClassCredit();
$modelRegister = new ModelRegister();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$listUserRegister = $modelRegister->getByUserId($user->getUserId());
foreach ($listsubject as $value) {
    $creditlist = $modelcredit->getBySubject($value->getSubject()->getSubjectId());
    if (!is_null($creditlist)) {
        $list = array_merge($list, $creditlist);
    }
}
$number = 70;

?>

<div class="section-one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2">
                <?php
                require "narbar.php";
                ?>
            </div>
            <div class="col-xl-10">


                <div class="suscribe-area animate__animated animate__fadeInDown "
                    style="display:block; margin: 5px 0px; border-radius: 10px;  ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="suscribe-text text-center">
                                    <h4>Đăng Ký Lịch <?php echo $text . ' Học Kỳ ' . $kihoc ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Suscribe Section -->

                <table class="table table-hover table-bordered table-responsive animate__animated animate__fadeInUp">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 2%;background-color: #3ec1d5; 
                            color:#fff"> </th>
                            <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Mã MH</th>
                            <th class="text-center align-middle" style="width: 10%;background-color: #3ec1d5; 
                            color:#fff">Tên môn học</th>
                            <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">Nhóm</th>
                            <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Số TC</th>
                            <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">Lớp</th>
                            <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Số lượng</th>
                            <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Còn lại</th>
                            <th class="text-center align-middle" style="width: 20%;background-color: #3ec1d5; 
                            color:#fff">Thời khóa biểu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($list as $key => $li) {
                            if (!is_null($li)) {
                                $check = 1;
                                echo '<tr>';
                                foreach ($listUserRegister as $key1 => $li1) {
                                    if (!is_null($key1)) {
                                        if ((int) $li->getClassCreditId() == $li1->getClassCredit()->getClassCreditId())
                                            $check = 0;
                                    }
                                }
                                $listSv = $modelRegister->getSvByClassCreditId($li->getClassCreditId());
                                $listGv = $modelRegister->getGvByClassCreditId($li->getClassCreditId());
                                $listTg = $modelRegister->getTgByClassCreditId($li->getClassCreditId());
                                if ($check == 1)
                                    echo '<td  class="text-center align-middle" ><input type="checkbox" id="' . $li->getClassCreditId() . '" data-credit-id="' . $li->getClassCreditId() . '"></td>';
                                else
                                    echo '<td  class="text-center align-middle"><input type="checkbox" id="' . $li->getClassCreditId() . '" data-credit-id="' . $li->getClassCreditId() . '" checked ></td>';
                                echo '<td class="text-center align-middle">' . $li->getSubject()->getSubjectCode() . '</td>';
                                echo '<td class="align-middle">' . $li->getSubject()->getSubjectName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getGroupClass() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getSubject()->getCredit() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getGroupClass() . '</td>';
                                if ($_SESSION['login']['role'] == 1) {
                                    echo '<td class="text-center align-middle">' . $li->getSvMax() . '</td>';
                                    echo '<td class="text-center align-middle">' . $li->getSvMax() - sizeof($listSv) . '</td>';
                                } else if ($_SESSION['login']['role'] == 2) {
                                    echo '<td class="text-center align-middle">' . $li->getTgMax() . '</td>';
                                    echo '<td class="text-center align-middle">' . $li->getTgMax() - sizeof($listTg) . '</td>';
                                } else {
                                    echo '<td class="text-center align-middle">' . $li->getGvMax() . '</td>';
                                    echo '<td class="text-center align-middle">' . $li->getGvMax() - sizeof($listGv) . '</td>';
                                }

                                echo
                                    '<td class="text-justify">';

                                foreach ($li->getListSchedule() as $key => $schedule) {
                                    if (!is_null($schedule)) {
                                        $day = '';
                                        if ($schedule->getDayStudy() == 8)
                                            $day = 'Chủ nhật';
                                        else
                                            $day = 'Thứ ' . $schedule->getDayStudy();
                                        $timeStart = $schedule->getKipStudy()->getTimeStart();
                                        echo $day . ' kíp ' . $schedule->getKipStudy()->getKipStudyId() . ', từ ' . toStr($timeStart) . ' đến ' . toStr(addDate($timeStart, $schedule->getKipStudy()->getTimeStudy())) .
                                            ', phòng ' . $schedule->getClassRoom()->getClassRoomName() . '. Thời gian học từ ' . formatYear($schedule->getWeek()->getStartTime()) . ' đến ' . formatYear($schedule->getWeekEnd()->getEndTime()) .
                                            '<br/>';
                                    }
                                }
                                if (sizeof($listGv) != 0) {

                                    echo 'Giảng viên: ';
                                    foreach ($listGv as $ok => $gv) {
                                        if (!is_null($gv)) {
                                            echo $gv->getFullName() . ' ';
                                        }

                                    }
                                    echo '<br/>';
                                }
                                if (sizeof($listTg) != 0) {
                                    echo 'Trợ giảng: ';
                                    foreach ($listTg as $ok => $gv) {
                                        if (!is_null($gv)) {
                                            echo $gv->getFullName() . ' ';
                                        }

                                    }
                                }

                                echo '</td>';
                                echo '</tr>';
                            }
                        }

                        ?>

                    </tbody>
                </table>
                <div class="suscribe-area " style="display:block;margin: 5px 0px; border-radius: 10px;  ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="suscribe-text text-center">
                                    <h4>DANH SÁCH ĐĂNG KÝ</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Suscribe Section -->
                <div id="credit-container">
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">STT</th>
                                <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Mã MH</th>
                                <th class="text-center align-middle" style="width: 10%;background-color: #3ec1d5; 
                            color:#fff">Tên môn học</th>
                                <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">Nhóm</th>
                                <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Số TC</th>
                                <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">Lớp</th>
                                <th class="text-center align-middle" style="width: 10%;background-color: #3ec1d5; 
                            color:#fff">Ngày đăng ký</th>

                                <th class="text-center align-middle" style="width: 20%;background-color: #3ec1d5; 
                            color:#fff">Thời khóa biểu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            showRegister($listUserRegister);
                            ?>

                        </tbody>
                    </table>

                </div>
                <div id="cart-container"></div>
                <div>
                    <a href='/BT3-WEB/schedules' class="btn-get-started animate__animated animate__fadeInUp">Xem thời
                        khoá
                        biểu</a>
                </div>

            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        myElement = document.getElementById('credit-container');
        $('input[type="checkbox"]').click(function (event) {
            const creditId = event.target.getAttribute('data-credit-id');
            const isChecked = event.target.checked;
            myElement.style.display = "none";
            if (isChecked) {
                $.ajax({
                    method: "POST",
                    data: { credit_id: creditId },
                    url: "http://localhost/BT3-WEB/views/registerlist.php",
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data[0].status == 1) {
                            checkbox = document.getElementById(data[0].error);// tắt checkbox môn cũ
                            checkbox.checked = false;
                        }
                        else if (data[0].status == 2) {// trùng lịch
                            event.target.checked = false;
                            alert(data[0].error);
                        }
                        else if (data[0].status == 3) {//'Lớp đã đủ số lượng.
                            event.target.checked = false;
                            alert(data[0].error);
                        }
                        else {
                            console.log(data[0].status);
                        }

                        const table = document.createElement('table');
                        table.className = 'table table-hover  table-responsive '
                        const tableHeader = document.createElement('thead');
                        const tableBody = document.createElement('tbody');
                        const headerRow = document.createElement('tr');
                        const headers = ['STT', 'Mã MH', 'Tên môn học', 'Nhóm', 'Số TC', 'Lớp', 'Ngày đăng ký', 'Thời khoá biểu'];
                        var ok = 1;
                        for (const header of headers) {
                            const headerCell = document.createElement('th');
                            headerCell.textContent = header;
                            switch (ok) {
                                case 1:
                                    headerCell.className = " text-center align-middle r-3";
                                    break;
                                case 2:
                                    headerCell.className = " text-center align-middle r-5";
                                    break;
                                case 3:
                                    headerCell.className = " text-center align-middle r-10";
                                    break;
                                case 4:
                                    headerCell.className = " text-center align-middle r-3";
                                    break;
                                case 5:
                                    headerCell.className = " text-center align-middle r-5";
                                    break;
                                case 6:
                                    headerCell.className = " text-center align-middle r-3";
                                    break;
                                case 7:
                                    headerCell.className = " text-center align-middle r-10";
                                    break;
                                case 8:
                                    headerCell.className = " text-center align-middle r-20";
                                    break;

                            }


                            headerRow.appendChild(headerCell);
                            ok += 1;
                        }
                        tableHeader.appendChild(headerRow);

                        for (const key of data) {
                            if (key != '0') {
                                const dataRow = document.createElement('tr');
                                const dataCells = [
                                    key.STT,
                                    key.subjectCode,
                                    key.subjectName,
                                    key.groupClass,
                                    key.credit,
                                    key.class,
                                    key.time,
                                    key.schedule
                                ];
                                var check = 1;
                                for (const data of dataCells) {
                                    const dataCell = document.createElement('td');
                                    dataCell.textContent = data;
                                    dataCell.className = "text-center align-middle";
                                    if (check == 8) dataCell.className = "text-justify";
                                    dataRow.appendChild(dataCell);
                                    check += 1;
                                }
                                tableBody.appendChild(dataRow);
                            }
                        }
                        table.appendChild(tableHeader);
                        table.appendChild(tableBody);
                        $("#cart-container").html(table);
                    }
                });
            } else {
                $.ajax({
                    method: "POST",
                    data: { credit_id: creditId },
                    url: "http://localhost/thuc-tap-co-so-thay-Tien/views/removecredit.php",
                    success: function (data) {
                        data = JSON.parse(data);
                        const cartContainer = document.getElementById('cart-container');
                        const table = document.createElement('table');
                        table.className = 'table table-hover  table-responsive '
                        const tableHeader = document.createElement('thead');
                        const tableBody = document.createElement('tbody');
                        const headerRow = document.createElement('tr');
                        const headers = ['STT', 'Mã MH', 'Tên môn học', 'Nhóm', 'Số TC', 'Lớp', 'Ngày đăng ký', 'Thời khoá biểu'];
                        var ok = 1;
                        for (const header of headers) {
                            const headerCell = document.createElement('th');
                            headerCell.textContent = header;
                            switch (ok) {
                                case 1:
                                    headerCell.className = " text-center align-middle r-3 table-th";

                                    break;
                                case 2:
                                    headerCell.className = " text-center align-middle r-5";
                                    break;
                                case 3:
                                    headerCell.className = " text-center align-middle r-10";
                                    break;
                                case 4:
                                    headerCell.className = " text-center align-middle r-3";
                                    break;
                                case 5:
                                    headerCell.className = " text-center align-middle r-5";
                                    break;
                                case 6:
                                    headerCell.className = " text-center align-middle r-3";
                                    break;
                                case 7:
                                    headerCell.className = " text-center align-middle r-10";
                                    break;
                                case 8:
                                    headerCell.className = " text-center align-middle r-20";
                                    break;

                            }


                            headerRow.appendChild(headerCell);
                            ok += 1;
                        }
                        tableHeader.appendChild(headerRow);

                        for (const key of data) {
                            if (key != '0') {
                                const dataRow = document.createElement('tr');
                                const dataCells = [
                                    key.STT,
                                    key.subjectCode,
                                    key.subjectName,
                                    key.groupClass,
                                    key.credit,
                                    key.class,
                                    key.time,
                                    key.schedule
                                ];
                                var check = 1;
                                for (const data of dataCells) {
                                    const dataCell = document.createElement('td');
                                    dataCell.textContent = data;
                                    dataCell.className = "text-center align-middle";

                                    if (check == 8) dataCell.className = "text-justify  align-middle";
                                    dataRow.appendChild(dataCell);
                                    check += 1;
                                }
                                tableBody.appendChild(dataRow);
                            }
                        }
                        table.appendChild(tableHeader);
                        table.appendChild(tableBody);
                        $("#cart-container").html(table);
                    }
                });
            }

        }

        );
    });
</script>

<?php

require "footer.php";
?>