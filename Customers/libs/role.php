<?php 

// Hàm thiết lập là đã đăng nhập
function set_logged($name, $level){
	session_set('ss_user_token', array(
		'name' => $name,
		'level' => $level
	));
}

// Hàm thiết lập đăng xuất
function set_logout(){
	session_delete('ss_user_token');
}

// Hàm kiểm tra trạng thái đăng nhập chưa??
function is_logged(){
	$user = session_get('ss_user_token');
	return $user;
}

// Hàm kiểm tra có phải admin??
function is_admin(){

	$user = is_logged();
	
	if (!empty($user['level']) && $user['level'] == '1') {
		return true;
	}
	return false;
}

//logout

// Lấy name ng dùng hiện tại
function get_current_name(){
	$name = is_logged();
	return isset($name['name']) ? $name['name'] : '';
}

// Lấy ;level ng dùng hiện tại
function get_current_level(){
	$name = is_logged();
	return isset($name['level']) ? $name['level'] : '';
}

// Kiểm tra là supper admin
function is_supper_admin(){
	$name = is_logged();
	if (!empty($name['level']) && $name['level'] == '1' && $name['name'] == 'admin') {
		return true;
	}
	return false;
}
?>