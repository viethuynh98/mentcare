<?php
session_start();
?>
<?php
include('libs/helper.php');
if (!$_SESSION['email']) {
    Helper::redirect(Helper::get_url('../mentcare/PHP/log_in.php'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/header_footer.css">
    <title>Team 2 - User</title>
</head>

<body>
    <!-- header -->
    <div class="header">
        <img src="../Image/logo.png" alt="logo_team">
        <div>
            <h2>MentCare System</h2>
            <h3>Development Team - Team 2</h3>
        </div>
    </div>
    <!-- menu -->
    <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
        <div class="dropdown-content">
            <a href="../HTML/home.html" class="showContentLink">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
        </div>
    </div>
    <!-- content -->
    <div class="content">
        <iframe id="contentFrame" src="../HTML/home.html" width="100%" height="100%" style="border:none;"></iframe>

        <script>
            var contentFrame = document.getElementById("contentFrame");
            var showLinks = document.querySelectorAll(".showContentLink");

            showLinks.forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    contentFrame.src = this.href;
                });
            });
        </script>
    </div>
    <!-- Footer-->
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

    </div>
</body>

</html>