<?php
session_start();
?>
<?php
include('libs/helper.php');
if (!$_SESSION['email']) {
    Helper::redirect(Helper::get_url('../mentcare/app/log_in.php'));
}
Database::db_connect();
$email = $_SESSION['email'];
$sql_select_name = "SELECT last_name FROM medicalstaff
                    JOIN users ON medicalstaff.staff_id = users.staff_id
where users.email_address = '$email'";
$names = Database::db_get_list($sql_select_name);
foreach ($names as $name) {
    $last_name = $name["last_name"];
}

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
    <link rel="stylesheet" href="../css/home.css">
    <link href="../image/logo.jpg" rel="icon">
    <title>Home Page</title>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex justify-content-between">

            <div id="logo">
                <h1><a href="./interface.php">Mental Health<span>Care</span></a></h1>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="./interface.php">Home</a></li>
                    <li><a class="nav-link scrollto" href="./showRecords.php">Patient Record</a></li>
                    <li><a href="./log_out.php">Log Out</a></li>
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <div class="full_home">
        <div class="title">
            <h2>Welcome back, Dr.<?php echo $last_name ?>! Your patients are in good hands.</h2>
        </div>
        <div class="home">
            <div class="home_background">
                <img src="../image/anh7.png" alt="home.jpg">
            </div>
            <div class="home_book">
                <div class="home_img_book">
                    <img src="../image/anh1.png" alt="anh1.png">
                    <img src="../image/anh2.jpg" alt="anh2.jpg">
                    <img src="../image/anh3.avif" alt="anh3.avif">
                </div>
                <div class="home_img_book">
                    <img src="../image/anh4.jpg" alt="anh4.jpg">
                    <img src="../image/anh5.jpg" alt="anh5.jpg">
                    <img src="../image/anh6.jpg" alt="anh6.jpg">
                </div>
            </div>
        </div>
    </div>

    <!-- ======= Contact Section ======= -->
    <section id="contact">
        <div class="container" data-aos="fade-up">
            <!-- <div class="section-header">
                <h2>Contact Us</h2>
                <p>If you have any questions, feedback, or simply want to share your thoughts with us, please feel
                    free to get in touch. We are always ready to listen and assist you. You can reach us via email
                    at [your email address] or use the contact form below. We'll respond to you at our earliest
                    convenience</p>
            </div> -->

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Address</h3>
                        <address>136 Phạm Như Xương, Hòa Khánh Nam, Liên Chiểu, Đà Nẵng</address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="bi bi-phone"></i>
                        <h3>Phone Number</h3>
                        <p><a href="tel:+155895548855">+84 702032064</a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:info@example.com">viet.gm.2k3@gmail.com</a></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.008947147585!2d108.15049700000002!3d16.0650255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219293660fbd5%3A0x8e72ecf102cea468!2zMTM2IMSQLiBQaOG6oW0gTmjGsCBYxrDGoW5nLCBIb8OgIEtow6FuaCBOYW0sIExpw6puIENoaeG7g3UsIMSQw6AgTuG6tW5nIDU1MDAwMA!5e0!3m2!1svi!2s!4v1701074386339!5m2!1svi!2s" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="container">
            <div class="form">
                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group col-md-6 mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                    </div>

                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div>

        </div>
    </section><!-- End Contact Section -->

    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Bản quyền thuộc Hệ Thống Quản Lý Thư Viện - <strong>Team 2</strong>
            </div>
        </div>
    </footer><!-- End Footer -->

</body>

</html>