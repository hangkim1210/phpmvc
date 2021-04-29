<?php 
// Biến lưu trữ kết nối
$conn = null;

// Hàm kết nối
function db_connect(){
	global $conn;
	if (!$conn) {
		$conn = mysqli_connect('localhost','root','','customers') or die ('not connect database!!');
		mysqli_set_charset($conn, 'UTF-8');
	}
} 

// Hàm ngắt kết nối
function db_close(){
	global $conn;
	if ($conn) {
		mysqli_close($conn);
	}
}

// Hàm lấy danh sách, kết quả trả về danh sách các record trong 1 mảng
function db_get_list($sql){
	db_connect();
	global $conn;
	$data = array();
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row;
	}
	return $data;
}

// Hàm lấy chi tiết, select theo ID vì nó trả về record
function db_get_row($sql){
	db_connect();
	global $conn;
	$result = mysqli_query($conn, $sql);
	$row = array();
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
	}
	return $row;
}

// Hàm thực thi truy vấn insert, update, delete
function db_execute($sql){
	db_connect();
	global $conn;
	return mysqli_query($conn, $sql);
}

// Truy vấn đk where
function db_create_sql($sql, $filter = array()){

	// chuỗi where
	$where = '';

	//lặp qua biến filter và bổ sung vào $where
	foreach ($filter as $field => $value) {
		if ($value != '') {
			$value = addslashes($value);
			$where .= "AND $field = '$value', ";
		}
	}

	// remove chữ AND ở đầu
	$where = trim($where, 'AND');

	// remove ký tự, cuối
	$where = trim($where, ', ');

	// nếu có đk where thì nối chuỗi
	if($where){
		$where = ' WHERE '.$where;
	}

	// return về câu truy vấn
	return str_replace('{where}', $where, $sql);
}

// Hàm insert dữ liệu vào table
function db_insert($table, $data = array())
{
    // Hai biến danh sách fields và values
    $fields = '';
    $values = '';
     
    // Lặp mảng dữ liệu để nối chuỗi
    foreach ($data as $field => $value){
        $fields .= $field .',';
        $values .= "'".addslashes($value)."',";
    }
     
    // Xóa ký từ , ở cuối chuỗi
    $fields = trim($fields, ',');
    $values = trim($values, ',');
     
    // Tạo câu SQL
    $sql = "INSERT INTO {$table}($fields) VALUES ({$values})";
     
    // Thực hiện INSERT
    return db_execute($sql);
}
//Hàm update dl
function db_update($table, $data = array(), $id){

    $name = $data['name'];
    $password = $data['password'];
    $email = $data['email'];
    $level = $data['level'];
    
    // Tạo câu SQL
	$sql = "UPDATE $table SET name = '$name', password = '$password', email = '$email', level ='$level' WHERE id = '$id'";
	return db_execute($sql);
}
?>
