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
    where email_address = '$email' and passwords = '$password'";
    $sql_check_admin = "SELECT * FROM admins 
    where email_address = '$email' and passwords = '$password'";
    // Thực thi câu lệnh SQL
    if (Database::db_execute($sql_check_users)) {
        Helper::redirect(Helper::get_url('../mentcare/PHP/admins_interface.php'));
    } elseif (Database::db_execute($sql_check_admin)) {
        Helper::redirect(Helper::get_url('../mentcare/PHP/admins_interface.php'));
    } else {
        // echo "Email or password was wrong. Please sign in again!";
        Helper::redirect(Helper::get_url('../mentcare/PHP/log_in.php?success=5'));
    }
}
// Đóng kết nối
Database::db_disconnect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/log_in.css">
    <link rel="stylesheet" href="../CSS/header_footer.css">
    <title>Team One - Log In</title>
</head>

<body>
    <div class="full">
        <!-- header -->
        <div class="header">
            <img src="../Image/logo.png" alt="logo_team">
            <div>
                <h2>MentCare System</h2>
                <h3>Development Team - Team One</h3>
            </div>
        </div>
        <div class="full_home_page">
            <!-- sidebar -->
            <div class="home_book">
                <div class="home_img_book">
                    <img src="../Image/anh1.png" alt="anh1">
                    <img src="../Image/anh2.jpg" alt="anh2">
                    <img src="../Image/anh3.avif" alt="anh3">
                </div>
                <div class="home_img_book">
                    <img src="../Image/anh4.jpg" alt="anh4">
                    <img src="../Image/anh5.jpg" alt="anh5">
                    <img src="../Image/anh6.jpg" alt="anh6">
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
                        <p> Don't have a account<a href="./sign_up.php">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer-->
        <div class="footer">
            <ul>
                <li>
                    <p><i class="fa-solid fa-location-dot"></i> Address: 136 Phạm Như Xương, Hòa Khánh Nam, quận
                        Liên Chiểu, TP.Đà Nẵng</p>
                </li>
                <li>
                    <p><i class="fa-solid fa-phone"></i> A Phone Number: 0867548549 - 0702032064</p>
                </li>
                <li>
                    <p><i class="fa-solid fa-envelope"></i> Email: viet.gm.2k3@gmail.com</p>
                </li>
                <div class="license">
                    <li>
                        <p>&#169 Bản quyền thuộc Hệ Thống Quản Lý Thư Viện - Team 2</p>
                    </li>
                </div>
            </ul>
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