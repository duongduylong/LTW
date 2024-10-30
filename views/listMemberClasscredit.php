<?php
require_once 'header.php';

?>

<div class="section-one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 ">

                <?php
                if ($_SESSION['login']['role'] == '4') {
                    require "admin/narbaradmin.php";

                } else
                    require "narbar.php";
                ?>

            </div>
            <div class="col-xl-10 ">
                <div class="inner-body text-center pt-3">

                    <div class="suscribe-area animate__animated animate__fadeInDown "
                        style="display:block;margin: 5px 0px; border-radius: 10px;  ">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="suscribe-text text-center">
                                        <h4 class="animate__animated animate__fadeInDown">Danh sách thành viên lớp tín
                                            chỉ</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Suscribe Section -->

                    <table
                        class="table table-hover table-bordered table-responsive animate__animated animate__fadeInUp">
                        <thead class="thead-light">
                            <tr>

                                <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">STT</th>
                                <th class="text-center align-middle" style="width: 10%;background-color: #3ec1d5; 
                            color:#fff">Họ và tên</th>
                                <th class="text-center align-middle" style="width: 3%;background-color: #3ec1d5; 
                            color:#fff">Mã định danh</th>
                                <th class="text-center align-middle" style="width: 5%;background-color: #3ec1d5; 
                            color:#fff">Vai trò</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ok = 1;
                            foreach ($data as $key => $li) {
                                if (!is_null($li)) {
                                    foreach ($li as $key1 => $li1) {
                                        if (!is_null($li1)) {
                                            $roleString = '';

                                            if ($li1->getUserRole() == 1) {
                                                $roleString = 'Sinh viên';

                                            } else if ($li1->getUserRole() == 2) {
                                                $roleString = 'Trợ giảng';

                                            } else {
                                                $roleString = 'Giảng viên';

                                            }
                                            echo '<tr>';
                                            echo '<td>' . $ok . '</td>';
                                            echo '<td>' . $li1->getFullName() . '</td>';
                                            echo '<td>' . $li1->getUserName() . '</td>';
                                            echo '<td>' . $roleString . '</td>';

                                            echo '</tr>';
                                            $ok += 1;
                                        }
                                    }
                                }
                            }

                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>



<?php
require_once 'footer.php';

?>