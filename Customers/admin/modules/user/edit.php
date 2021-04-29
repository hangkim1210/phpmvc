<?php 
	if (!defined('IN_SITE')) die ('The request not found');
?>
<?php
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>
<?php 
    if(isset($_GET['id'])){
        $id = (int)($_GET['id']);
        //thong tin ng dùng
        $name = db_get_row(db_create_sql('SELECT * FROM tb_user {where}', array('id' => $id)));
    }
?>
<?php 
	$error = array();
	 
	// SUBMIT EDIT FORM
	if (is_submit('edit_name')) {
	    
	    //Lấy ds dl từ form
	    $data = array(
	        'name' => $_POST['name'],
	        'password' => $_POST['password'],
	        'email' => $_POST['email'],
	        'level' => $_POST['level'],
	    );
	    // require file xử lý database cho user
	    require_once('database/user.php');
	    //Thực hiện validate
	    $error = update_validate($data);

	    //Nếu k error
	    if (!$error) {
	    	$idUpdate = $_POST['id_update'];
	    	if (db_update('tb_user', $data, $idUpdate)){
	            ?>
	            <script language="javascript">
	                alert('Sửa thông tin người dùng thành công!');
	                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>';
	            </script>
	            <?php
	            die();
	        }
	    }
	}
?>
<?php include_once('widgets/header.php'); ?>
 
<h1>Sửa thành viên</h1>
 
<div class="controls">
    <a class="button" onclick="$('#edit-form').submit()" href="#">Sửa</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">Trở về</a>
</div>
 
<form id="edit-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'edit')); ?>">
    <input type="hidden" name="request_name" value="edit_name"/>
    <table cellspacing="0" cellpadding="0" class="form">
    	<input type="hidden" name="id_update" value="<?= $id; ?>" />
        <tr>
            <td width="200px">Name</td>
            <td>
                <?php 
                    $inputName = '';
                    if (isset($name['name'])) {
                        $inputName = $name['name'];
                    }
                ?>
                <input type="text" name="name" required="" value="<?php echo $inputName; ?>" />
                <?php show_error($error, 'name'); ?>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <?php 
                    $inputPass = '';
                    if (isset($name['password'])) {
                        $inputPass = $name['password'];
                    }
                ?>
                <input type="password" name="password" required="" value="<?php echo $inputPass; ?>" />
                <?php show_error($error, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <?php 
                    $inputEmail = '';
                    if (isset($name['email'])) {
                        $inputEmail = $name['email'];
                    }
                ?>
                <input type="text" name="email" required="" value="<?php echo $inputEmail; ?>" class="style-input" />
                <?php show_error($error, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td>
                <?php 
                    $inputLevel = '';
                    if (isset($name['level'])) {
                        $inputLevel = $name['level'];
                    }
                ?>
                <input type="number" min="1" max="2" name="level" value="<?php echo $inputLevel; ?>" />
                <?php show_error($error, 'level'); ?>
            </td>
        </tr>
    </table>
</form>
 
<?php include_once('widgets/footer.php'); ?>