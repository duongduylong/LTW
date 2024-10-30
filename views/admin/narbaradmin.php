<?php
$modelUser = new ModelUser();
$user = $modelUser->getByUserName($_SESSION['login']['username']);

?>
<div class="user-container mr-0">
  <div class="inner-box">
    <div class="inner-title kanit-medium">
      <i class="fa-solid fa-user"></i> TÀI KHOẢN
    </div>
    <div class="row" style="margin:0;">
      <div class="col-6 pr-0">
        <div class="inner-head p0">Tài khoản</div>
      </div>
      <div class="col-6 pl-0">
        <div class="inner-head p0"> <?php echo $_SESSION['login']['username'] ?></div>
      </div>
      <div class="col-6 pr-0">
        <div class="inner-head p0">Họ và tên</div>
      </div>
      <div class="col-6 pl-0">
        <div class="inner-head p0"><?php echo $user->getFullName() ?></div>
      </div>
    </div>
    <a href="/BT3-WEB/logout" class="form-control btn btn-primary kanit-medium">Đăng Xuất</a>
  </div>


</div>
<div class="setting-container ">
  <div class="inner-box">
    <div class="inner-title kanit-medium">
      <i class="fa-solid fa-gears"></i> TÍNH NĂNG
    </div>
    <nav class="navbar">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="http://localhost/BT3-WEB/admin">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/BT3-WEB/admin/usermanagement">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/BT3-WEB/admin/classcreditmanagement">Quản lý lớp tín chỉ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/BT3-WEB/admin/registermanagement">Quản lý đăng ký tín chỉ</a>
        </li>

      </ul>
    </nav>
  </div>
</div>