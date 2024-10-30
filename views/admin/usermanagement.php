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
                                    <h4 class="animate__animated animate__fadeInDown"> Danh sách người dùng</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="animate__animated animate__fadeInDown text-center"><?php check_message() ?></p>
                <?php echo '<div><a class=" btn-get-started" href="http://localhost/BT3-WEB/admin/adduser" title="Sửa Thông Tin" data-toggle="tooltip" >  Thêm người dùng </a> </div>'; ?>

                <table class="table table-hover table-bordered table-responsive animate__animated animate__fadeInUp">
                    <thead class="thead-light">
                        <tr>

                            <th class="text-center align-middle"
                                style="width: 5%;background-color: #3ec1d5; color:#fff">STT</th>
                            <th class="text-center align-middle"
                                style="width: 10%;background-color: #3ec1d5; color:#fff">Họ và tên</th>
                            <th class="text-center align-middle"
                                style="width: 3%;background-color: #3ec1d5; color:#fff">Mã định danh</th>
                            <th class="text-center align-middle"
                                style="width: 5%;background-color: #3ec1d5; color:#fff">Vai trò</th>
                            <th class="text-center align-middle"
                                style="width: 5%;background-color: #3ec1d5; color:#fff">Thao tác</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ok = 1;
                        foreach ($data as $key => $li) {
                            if (!is_null($li)) {
                                $roleString = '';
                                if ($li->getUserRole() == 1) {
                                    $roleString = 'Sinh viên';

                                } else if ($li->getUserRole() == 2) {
                                    $roleString = 'Trợ giảng';

                                } else if ($li->getUserRole() == 4) {
                                    $roleString = 'Admin';

                                } else {
                                    $roleString = 'Giảng viên';

                                }
                                echo '<tr id="' . $li->getUserId() . '">';
                                echo '<td class="text-center align-middle">' . $ok . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getFullName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li->getUserName() . '</td>';
                                echo '<td class="text-center align-middle">' . $roleString . '</td>';
                                echo '<td>';
                                echo '<a class="btn-crud" href="http://localhost/BT3-WEB/admin/usermanagement/' . $li->getUserId() . '" title="Xem Người Dùng" data-toggle="tooltip" ><i class="fa-solid fa-eye"></i></a>';
                                echo '<a class="btn-crud" href="http://localhost/BT3-WEB/admin/updateuser/' . $li->getUserId() . '" title="Sửa Thông Tin" data-toggle="tooltip" > <span><i class="fa-solid fa-pen"></i> </span> </a> ';
                                echo '<button  id="' . $li->getUserId() . '" class="btn-crud text-center align-middle" style="border:0"title="Xoá người dùng" data-toggle="tooltip" ><i class="fa-solid fa-delete-left"></i></button> ';

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
            var userId = $(this).attr('id');
            console.log('Clicked on link:', userId)
            $.ajax({
                url: "http://localhost/BT3-WEB/views/admin/deleteuser.php",
                method: "POST",
                data: { userId: userId },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.id);
                    if (data.id > 1) {
                        alert('Xoá người dùng thành công');
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