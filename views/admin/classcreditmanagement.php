<?php
require_once _DIR_ROOT . '\views\header.php';
if ($_SESSION['login']['role'] != 4) {
    header('location: home');
}
?>
<div class="section-one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 ">

                <?php
                require "narbaradmin.php";
                ?>

            </div>
            <div class="col-xl-10 justify-content-center">

                <div class="suscribe-area animate__animated animate__fadeInDown "
                    style="display:block;margin: 5px 0px; border-radius: 10px;  ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="suscribe-text text-center">
                                    <h4 class="animate__animated animate__fadeInDown"> danh sách lớp tín chỉ</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="animate__animated animate__fadeInDown text-center"><?php check_message() ?></p>
                <?php echo '<div><a class=" btn-get-started" href="http://localhost/BT3-WEB/admin/addclasscredit" title="Sửa Thông Tin" data-toggle="tooltip" >  Thêm lớp tín chỉ </a> </div>'; ?>
                <table class="table table-hover table-bordered table-responsive animate__animated animate__fadeInUp">
                    <thead class="thead-light">
                        <tr>

                            <th class="text-center align-middle"
                                style="width: 1%;background-color: #3ec1d5; color:#fff">STT</th>
                            <th class="text-center align-middle"
                                style="width: 4%;background-color: #3ec1d5; color:#fff">Tên môn học</th>
                            <th class="text-center align-middle"
                                style="width: 1%;background-color: #3ec1d5; color:#fff">Lớp</th>
                            <th class="text-center align-middle"
                                style="width: 1%;background-color: #3ec1d5; color:#fff">Nhóm</th>
                            <th class="text-center align-middle"
                                style="width: 9%;background-color: #3ec1d5; color:#fff">Lịch học</th>
                            <th class="text-center align-middle"
                                style="width: 3%;background-color: #3ec1d5; color:#fff">Thao tác</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ok = 1;
                        foreach ($data as $key => $li) {
                            if (!is_null($li)) {

                                echo '<tr  id="' . $li->getClassCreditId() . '">';
                                echo '<td class="text-center align-middle">' . $ok . '</td>';
                                echo '<td class=" align-middle">' . $li->getSubject()->getSubjectName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getClassCreditName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getGroupClass() . '</td>';
                                echo '<td class="text-justify align-middle">' . getSchedule($li, '') . '</td>';
                                echo '<td>';
                                echo '<a class="btn-crud text-center align-middle" href="http://localhost/BT3-WEB/classcre/list/' . $li->getClassCreditId() . '" title="Xem lớp" data-toggle="tooltip" ><i class="fa-solid fa-eye"></i></a>';
                                echo '<a class="btn-crud text-center align-middle"  href="http://localhost/BT3-WEB/admin/updateclasscredit/' . $li->getClassCreditId() . '" title="Sửa Thông Tin" data-toggle="tooltip" > <span><i class="fa-solid fa-pen"></i> </span> </a> ';
                                echo '<button  id="' . $li->getClassCreditId() . '" class="btn-crud text-center align-middle" style="border:0"title="Xoá lớp tín chỉ" data-toggle="tooltip" ><i class="fa-solid fa-delete-left"></i></button> ';

                                echo '</tr>';
                                $ok += 1;
                            }
                        }



                        ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("button").click(function (event) {
            event.preventDefault();
            var classCreditId = $(this).attr('id');
            console.log('Clicked on link:', classCreditId)
            $.ajax({
                url: "http://localhost/BT3-WEB/views/admin/deleteclasscredit.php",
                method: "POST",
                data: { classCreditId: classCreditId },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.id);
                    if (data.id > 1) {
                        alert('Xoá lớp tín chỉ thành công');
                        myElement = document.getElementById(data.id);
                        myElement.style.display = "none";
                    }
                    else {
                        alert('Server đang lỗi tí, thông cảm ');
                    }
                }
            });

        });
    });
</script>
<?php
require_once _DIR_ROOT . '\views\footer.php';
?>