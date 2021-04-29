<?php

// Định nghĩa 1 const bảo vệ project
define('IN_SITE', true);

// Lấy module và action trên url
$module = isset($_GET['m']) ? $_GET['m'] : '';
$action = isset($_GET['a']) ? $_GET['a'] : '';

// TH không truyền module và action
// lấy module mặc định là common
// action mặc định là login
if (empty($module) || empty($action)){
	$module = 'common';
	$action = 'login';
}

// Tạo đường dẫn và lưu vào biến $path
$path = 'modules/'.$module.'/'.$action.'.php';

// trường hợp URL chạy đúng
if (file_exists($path)) {
	include_once ('../libs/session.php');
	include_once ('../libs/database.php');
	include_once ('../libs/role.php');
	include_once ('../libs/helper.php');
	include_once ($path);
} else {
	// TH k tồn tại thì thông báo lỗi
	include_once ('modules/common/404.php');
}
?>