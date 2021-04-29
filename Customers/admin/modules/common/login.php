<?php

$error = array();

// Kiểm tr nếu là admin thì redirect
if(is_admin()){
    redirect(base_url('admin/?m=common&a=dashboard'));
}

//user submit form
if (is_submit('login')) {
    
    // Lấy tên và pass
    $name = input_post('name');
    $password = input_post('password');

    //check tên login
    if (empty($name)) {
        $error['name'] = 'Please, input your name to login!';
    }

    // check pass
    if (empty($password)) {
        $error['password'] = 'Please, input your password!!';
    }

    //Nếu k có error
    if (!$error) {

        // include file xử lý database user
        include_once('database/user.php');

        // lấy thông tin user theo username
        $name = db_name_get_by_name($name);

        // nếu k có kết qủa
        if (empty($name)) {
            $error['name'] = 'Tên đăng nhập không đúng';
        }
        //có kết quả sai mk
        else if ($name['password'] != $password) {
            $error['password'] = 'password k đúng';
        }
        //thành công -> sang trang chủ
        if (!$error) {
            set_logged($name['name'], $name['level']);
            redirect(base_url('admin/?m=common&a=dashboard'));
        }
    }
}
?>
<?php include_once('widgets/header.php'); ?>
<h1>Trang đăng nhập!</h1>
<form method="post" action="<?php echo base_url('admin/?m=common&a=login'); ?>">
    <table>
        <tr>
            <td>Name</td>
            <td>
                <input type="text" name="name" value=""/>
                <?php show_error($error, 'name'); ?>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <input type="password" name="password" value=""/>
                <?php show_error($error, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="request_name" value="login"/>
            </td>
            <td>
                <input type="submit" name="login-btn" value="Đăng nhập"/>
            </td>
        </tr>
    </table>
</form>
<?php include_once('widgets/footer.php'); ?>
