<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php

if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php 
// Biến chứa lỗi
$error = array();
 
// SUBMIT FORM
if (is_submit('add_name')) {
    
    //Lấy ds dl từ form
    $now = new DateTime();
    $result = $now->format('Y-m-d H:i:s');
    $data = array(
        'name' => input_post('name'),
        'password' => input_post('password'),
        're-password' => input_post('re-password'),
        'email' => input_post('email'),
        'created_date' => $result,
        'updated_date' => null,
        'level' => input_post('level'),
    );
    // require file xử lý database cho user
    require_once('database/user.php');

    //Thực hiện validate
    $error = db_user_validate($data);

    //Nếu k error
    if (!$error) {

        // xóa key re-password ra khỏi $data;
        unset($data['re-password']);

        //Nếu insert thành công-> thông báo -> chuyển hướng về list
        if (db_insert('tb_user', $data)){
            ?>
            <script language="javascript">
                alert('Thêm người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    }
}
?>
 
<?php include_once('widgets/header.php'); ?>
 
<h1>Thêm thành viên</h1>
 
<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">Trở về</a>
</div>
 
<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'add')); ?>">
    <input type="hidden" name="request_name" value="add_name"/>
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td width="200px">Name</td>
            <td>
                <input type="text" name="name" value="<?php echo input_post('name'); ?>" />
                <?php show_error($error, 'name'); ?>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <input type="password" name="password" value="<?php echo input_post('password'); ?>" />
                <?php show_error($error, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>Re-password</td>
            <td>
                <input type="password" name="re-password" value="<?php echo input_post('re-password'); ?>" />
                <?php show_error($error, 're-password'); ?>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="text" name="email" value="<?php echo input_post('email'); ?>" class="style-input" />
                <?php show_error($error, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td>
                <select name="level">
                    <option value="">-- Chọn Level --</option>
                    <option value="1" <?php echo (input_post('level') == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo (input_post('level') == 2) ? 'selected' : ''; ?>>Member</option>
                </select>
                <?php show_error($error, 'level'); ?>
            </td>
        </tr>
    </table>
</form>
 
<?php include_once('widgets/footer.php'); ?>