<?php

$modelUser = new ModelUser();
$username = $password = $newpassword = $enternewpassword = "";
$_SESSION['error'] = "";

if ((isset($_POST['doimaukhau']))) {
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $newpassword = test_input($_POST['newpassword']);
    $enternewpassword = test_input($_POST['enternewpassword']);
    $user = $modelUser->getByUserName($username);
    if ($user instanceof User) {
        if (password_verify($password, $user->getPassword())) {
            if ($newpassword != $enternewpassword) {
                $_SESSION['error'] = "Xác thực mật khẩu không chính xác";
            } else {
                $hashpassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $user->setPassword($hashpassword);
                if ($modelUser->updateObject($user))
                    $_SESSION['error'] = "Đổi mật khẩu thành công";
                else {
                    $_SESSION['error'] = "Lỗi CSDL";
                }

            }

        } else {
            $_SESSION['error'] = "Thông tin tài khoản hoặc mật khẩu không chính xác";

        }

    } else {
        $_SESSION['error'] = "Thông tin tài khoản hoặc mật khẩu không chính xác";
    }
}









?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tín Chỉ</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="http://localhost/thuc-tap-co-so-thay-Tien/public/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="http://localhost/thuc-tap-co-so-thay-Tien/public/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="./public/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body class="img js-fullheight" style="background-image: url(./public/image/ok1.jpg);">

    <section class="section-one">
        <div class="container">
            <div class="row justify-content-center animate__animated animate__fadeInDown">
                <div class="col-md-12 text-center mb-5">
                    <div class="inner-head">
                        <h1 class="inner-title kanit-bold">HỌC VIỆN CÔNG NGHỆ BƯU CHÍNH VIỄN THÔNG</h1>
                        <h2 class="inner-desc kanit-medium">CỔNG THÔNG TIN ĐĂNG KÝ TÍN CHỈ</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center animate__animated animate__fadeInUp">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center kanit-medium">Đổi Mật Khẩu</h3>
                        <form method="post" action="/BT3-WEB/change" class="signin-form">
                            <div class="form-group mb-2">
                                <input name="username" type="text" class="form-control" placeholder="Tên đăng nhập"
                                    required>

                            </div>
                            <div class="form-group mb-2">
                                <input name="password" id="password-field" type="password" class="form-control"
                                    placeholder="Mật khẩu" required>

                            </div>
                            <div class="form-group mb-2">
                                <input name="newpassword" id="password-field" type="password" class="form-control"
                                    placeholder="Mật khẩu mới" required>

                            </div>
                            <div class="form-group mb-2">
                                <input name="enternewpassword" id="password-field" type="password" class="form-control"
                                    placeholder="Nhập lại mật khẩu mới" required>

                            </div>
                            <div class="form-group">
                                <p><?php check_message() ?></p>
                                <button name="doimaukhau" type="submit" class="form-control btn kanit-medium">Đổi mật
                                    khẩu</button>
                            </div>
                            <div class="form-group ">
                                <div class="inner-pass">
                                    <a href="login" style="color:#ffffff;text-decoration:none;float:left">Đăng nhập</a>
                                    <a href="forgot" style="color:#ffffff;text-decoration:none">Quên mật khẩu</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>