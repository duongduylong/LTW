<?php
require "header.php";
$roleString = '';
$hiendien = '';
if ($data[1] == 1) {
  $roleString = 'Sinh viên';
  $hiendien = 'học';
} else if ($data[1] == 2) {
  $roleString = 'Trợ giảng';
  $hiendien = 'giảng dạy';
} else {
  $roleString = 'Giảng viên';
  $hiendien = 'giảng dạy';
}

?>

<div class="section-one">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-2">
        <?php
        require "narbar.php";
        ?>
      </div>

      <div class="col-xl-8">
        <div class="inner-profile">

          <?php

          echo ' <h3 class="animate__animated animate__fadeInDown">Thông tin ' . $roleString . '</h3>' ?>
          <div class="row animate__animated animate__fadeInUp">

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
              <?php echo '<p>Mã ' . $roleString . ' </p>'; ?>
              <p>Họ và tên</p>
              <p>Vai trò</p>
              <p>Ngày sinh</p>
              <p>Giới tính</p>

              <p>Nơi sinh</p>
              <p>Địa chỉ</p>
              <p>Hiện diện</p>
              <p>Social</p>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
              <?php
              $gender = $data[0]->getGender() == 1 ? 'Nam' : 'Nữ';

              $status = $data[0]->getStatus() == 1 ? 'Đang ' . $hiendien : 'Đã nghỉ';
              echo '<p>' . $data[0]->getUserName() . '</p>';
              echo '<p>' . $data[0]->getFullName() . '</p>';
              echo '<p>' . $roleString . '</p>';
              echo '<p>' . $data[0]->getDateOfBirth() . '</p>';
              echo '<p>' . $gender . '</p>';

              echo '<p>' . $data[0]->getBirthplace() . '</p>';
              echo '<p>' . $data[0]->getCurrentAddress() . '</p>';
              echo '<p>' . $status . '</p>';
              echo '<p><a href="' . $data[0]->getLinkSocial() . '" target="_blank" class="btn-crud"><i class="fa-brands fa-facebook"></i></a></p>';
              ?>
            </div>
          </div>
          <?php if ($data[1] == 1) {
            $teacher = $data[2];
            echo '<h3 class="animate__animated animate__fadeInUp"style="left:45px">Thông tin cố vấn học tập</h3> 
            <div class="row animate__animated animate__fadeInUp">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <p>Tài khoản</p>
                <p>Họ và tên</p>
                <p>Ngày sinh</p>
                <p>Địa chỉ</p>
                <p>Social</p>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
              <p>' . $data[2]->getUserName() . '</p>
              <p>' . $data[2]->getFullName() . '</p>
              <p>' . $data[2]->getDateOfBirth() . '</p>
              <p>' . $data[2]->getCurrentAddress() . '</p>
              
             <p><a href="' . $data[2]->getLinkSocial() . '"target="_blank" class="btn-crud"><i class="fa-brands fa-facebook"></i></a></p>
          
            </div>
          </div>';
          } ?>

        </div>
      </div>

      <div class="col-xl-2 animate__animated animate__fadeInRight mt-3">
        <?php echo '<img src="' . $data[0]->getAvatarImagePath() . '" width=200 height=200> ' ?>
      </div>

    </div>
  </div>
</div>



<?php
require "footer.php";
?>