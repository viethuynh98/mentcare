<?php
// Start the session
session_start();
?>
<?php
include('libs/helper.php');
Database::db_connect();



// Dữ liệu đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set session variables
    $_SESSION['email'] = $_POST['email'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql_check_users = "SELECT * FROM users
    JOIN medicalstaff ON users.staff_id = medicalstaff.staff_id
    WHERE users.email_address = '$email' and users.password = '$password' and medicalstaff.specialty = 'Doctor' ";
    // Thực thi câu lệnh SQL
    if (Database::db_get_list($sql_check_users)) {
        Helper::redirect(Helper::get_url('../mentcare/app/interface.php'));
    } else {
        Helper::redirect(Helper::get_url('../mentcare/app/log_in.php?success=5'));
    }
}
// Đóng kết nối
Database::db_disconnect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../CSS/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/log_in.css">
    <!-- <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->
    <link href="../image/logo.jpg" rel="icon">
    <title>Home Page</title>

</head>

<body>
    <div class="full">
        <!-- ======= Header ======= -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex justify-content-between">

                <div id="logo">
                    <h1><a href="">Mental Health<span>Care</span></a></h1>
                </div>
            </div>
        </header><!-- End Header -->
        <div class="full_home_page">
            <!-- sidebar -->
            <div class="home_book">
                <div class="home_img_book">
                    <img src="../image/anh1.png" alt="book1">
                    <img src="../image/anh2.jpg" alt="book2">
                    <img src="../image/anh3.avif" alt="book3">
                </div>
                <div class="home_img_book">
                    <img src="../image/anh4.jpg" alt="book4">
                    <img src="../image/anh5.jpg" alt="book5">
                    <img src="../image/anh6.jpg" alt="book6">
                </div>
            </div>
            <!-- login -->
            <div class="full_login">
                <div class="login">
                    <form action="" method="post">
                        <div class="box1">
                            <h3>Log in</h3>
                        </div>
                        <div class="box2">
                            <input type="email" name="email" class="mail" placeholder="Email" required>
                        </div>
                        <div class="box2">
                            <div>
                                <input id="pass" type="password" name="password" class="mail" placeholder="Password" required>
                            </div>
                            <div class="notification">
                                <?php
                                if (isset($_GET['success']) && $_GET['success'] == 5) {
                                    echo "<h5>Email/password was wrong. Please log in again!</h5>";
                                }
                                ?>
                            </div>
                            <div class="showpass">
                                <input id="check" type="checkbox"> Show password
                            </div>
                        </div>
                        <div class="box3">
                            <button type="submit">Log in</button>
                        </div>
                    </form>

                    <div class="box4">
                        <p> Don't have a account<a href="">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    check.onclick = togglePassword;

    function togglePassword() {
        if (check.checked) pass.type = "text";
        else pass.type = "password";
    }
</script>

</html>