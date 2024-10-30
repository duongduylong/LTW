<?php
$modelUser = new ModelUser();
$modelEmail = new ModelEmail();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require _DIR_ROOT . '/public/vendor/PHPMailer/src/Exception.php';
require _DIR_ROOT . '/public/vendor/PHPMailer/src/PHPMailer.php';
require _DIR_ROOT . '/public/vendor/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
if ((isset($_POST['forgot']))) {
    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $user = $modelUser->getByUserName($username);
    if ($user instanceof User) {
        $id = $user->getUserId();
        $emaildatabase = $modelEmail->getByUserId($id)->getEmail();
        if ($emaildatabase == $email) {
            try {

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'wonwon5800@gmail.com';
                $mail->Password = 'mxrm tgfr efgi rdml';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('wonwon5800@gmail.com', 'Mailer');
                $mail->addAddress($email, 'Người nhận');
                $pass = rand(10000, 10000000);
                $mail->isHTML(true);
                $mail->Subject = 'CAP LAI MAT KHAU MOI';
                $hashpassword = password_hash($pass, PASSWORD_DEFAULT);
                $user->setPassWord($hashpassword);
                if ($modelUser->updateObject($user)) {
                    $mail->Body = 'Xin chào ' . $user->getFullName() . '. Mật khẩu mới của bạn là ' . $pass . ', vui lòng bảo quản cẩn thận.';

                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    $_SESSION['error'] = 'Gửi thành công';
                } else {
                    $_SESSION['error'] = 'Máy chủ đang quá tải, vui lòng thử lại sau';
                }

            } catch (Exception $e) {
                $_SESSION['error'] = 'Máy chủ đang quá tải, vui lòng thử lại sau';
            }

        } else {
            $_SESSION['error'] = 'Sai thông tin';
        }
    } else {
        $_SESSION['error'] = 'Sai thông tin';
    }

}








?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                        <h2 class="inner-desc kanit-medium">CỔNG THÔNG TIN ĐĂNG KÝ TIN CHỈ</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center animate__animated animate__fadeInUp">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center kanit-medium">Quên Mật Khẩu</h3>
                        <form action="/BT3-WEB/forgot" class="signin-form" method="post">
                            <div class="form-group">
                                <input name="username" type="text" class="form-control" placeholder="Tên đăng nhập"
                                    required>
                            </div>
                            <div class="form-group">
                                <input name="email" id="password-field" class="form-control" placeholder="Email"
                                    required>

                            </div>
                            <div class="form-group">
                                <p><?php check_message() ?></p>
                                <button type="submit" name="forgot" class="form-control btn kanit-medium">Gửi Mật
                                    Khẩu</button>
                            </div>
                            <div class="form-group ">

                                <div class="inner-pass">
                                    <a href="login" style="color: #fff;text-decoration: none">Đăng nhập</a>
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