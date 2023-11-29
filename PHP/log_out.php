<?php
// Bắt đầu session
session_start();

// Xóa các biến session cụ thể (ví dụ: 'email')
unset($_SESSION['email']);

// Hủy session
session_destroy();
include('libs/helper.php');
Helper::redirect(Helper::get_url('../Web_QLTV/PHP/log_in.php'));
