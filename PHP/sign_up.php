<?php
include('libs/helper.php');
Database::db_connect();
// Dữ liệu bạn muốn chèn
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['username'];
    $place_of_origin = $_POST['place_of_origin'];
    // Kiểm tra tồn tại
    $sql_check_users = "SELECT email_address FROM users WHERE email_address = '$email'";
    if (Database::db_execute($sql_check_users)) {
        $sql_check_users = "SELECT email_address FROM users WHERE email_address = '$email' AND Users_status = 'Đã xoá'";
        if (Database::db_execute($sql_check_users)) {
            $sql_update_users = " UPDATE users
            SET email_address = '$email', passwords = '$password'
            WHERE email_address = '$email'";
            if (Database::db_execute($sql_update_users)) {
                Helper::redirect(Helper::get_url('../mentcare/PHP/log_in.php?success=1'));
            }
        } else {
            Helper::redirect(Helper::get_url('../mentcare/PHP/sign_up.php?success=4'));
        }
    } else {
        // Chèn dữ liệu
        $sql_insert_users = "INSERT INTO users (email_address, passwords, full_name, place_of_origin, type)
                        VALUES ('$email', '$password', '$fullname','$place_of_origin', '0')";
        if (Database::db_execute($sql_insert_users)) {
            // Chuyển hướng và truyền thông báo thành công
            Helper::redirect(Helper::get_url('../mentcare/PHP/log_in.php?success=1'));
        } else {
            echo "Lỗi khi thêm dữ liệu vào bảng: ";
        }
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/sign_up.css">
    <title>Sign_up</title>
</head>

<body>
    <div class="full">
        <!-- thông báo -->
        <div id="thong_bao">
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 2) {
                echo "Account is not registered. Please register!";
            }
            ?>
        </div>
        <!-- Sign_up -->
        <div id="Sign_up">
            <div id="sidebar"></div>
            <div class="container" id="form">
                <h2>Infomation Register</h2>
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email: </label>
                        <div class="col-sm-10">
                            <input type="email" id="email" class="form-control" placeholder="Enter email" name="email" required>
                        </div>
                    </div>
                    <!-- thông báo -->
                    <div id="thong_bao1">
                        <?php
                        if (isset($_GET['success']) && $_GET['success'] == 4) {
                            echo "Account already exists!";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Full Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control ml-2" placeholder="Enter username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Place of Origin:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter place of origin" name="place_of_origin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="btn" class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Register</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

</html>