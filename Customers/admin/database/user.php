<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_name_get_by_name($name){
    
    $name = addslashes($name);
    $sql = "SELECT * FROM tb_user where name = '{$name}'";
    return db_get_row($sql);
}

// Hàm validate dữ liệu user
function db_user_validate($data){

	//Biến chữa lỗi
	$error = array();

	//name
	if (isset($data['name']) && $data['name'] == '') {
		$error['name'] = 'Bạn chưa nhập tên đăng nhập!';
	}

	//email
	if (isset($data['email']) && $data['email'] == '') {
		$error['email'] = 'Bạn chưa nhập email!';
	}
	if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
		$error['email'] = 'Email không hợp lệ!';
	}

	//Password
	if (isset($data['password']) && $data['password'] == '' ) {
		$error['password'] = 'Bạn chưa nhập mật khẩu!';
	}

	//Re-password
	if (isset($data['password']) && isset($data['re-password']) && $data['password'] != $data['re-password']) {
		$error['re-password'] = 'Mật khẩu nhập lại không đúng!';
	}

	//Level
	if (isset($data['level']) && !in_array($data['level'], array('1', '2'))) {
		$error['level'] = 'Level bạn chọn không tồn tại!';
	}

	// Validate lw CSDL
	//Kiểm tra thao tác có lỗi k??
	//Nếu k tiếp tục ktra = truy vấn csdl
	
	//name
	if (!($error) && isset($data['name']) && $data['name']) {
		$sql = "SELECT count(id) as counter FROM tb_user WHERE name ='".addslashes($data['name'])."'";
		$row = db_get_row($sql);
		if ($row['counter'] > 0) {
			$error['name'] = 'Tên đăng nhập đã tồn tại!';
		}
	}

	//Email
	if (!($error) && isset($data['email']) && $data['email']) {
		$sql = "SELECT count(id) as counter FROM tb_user WHERE email = '".addslashes($data['email'])."'";
		$row = db_get_row($sql);
		if ($row['counter'] > 0) {
			$error['email'] = 'Email này đã tồn tại!';
		}
	}
	return $error;
}
// Hàm update dữ liệu
function update_validate($data){
	//Biến chữa lỗi
	$error = array();

	//name
	if (isset($data['name']) && $data['name'] == '') {
		$error['name'] = 'Bạn chưa nhập tên đăng nhập!';
	}

	//email
	if (isset($data['email']) && $data['email'] == '') {
		$error['email'] = 'Bạn chưa nhập email!';
	}
	if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
		$error['email'] = 'Email không hợp lệ!';
	}

	//Password
	if (isset($data['password']) && $data['password'] == '' ) {
		$error['password'] = 'Bạn chưa nhập mật khẩu!';
	}

	//Level
	if (isset($data['level']) && !in_array($data['level'], array('1', '2'))) {
		$error['level'] = 'Level bạn chọn không tồn tại!';
	}

	//Kiểm tra thao tác có lỗi k??
	//Nếu k tiếp tục ktra = truy vấn csdl
	return $error;
}