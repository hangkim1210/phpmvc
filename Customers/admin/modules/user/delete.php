<?php 

	if (!defined('IN_SITE')) die ('The request not found');
	
	// thiết lập utf-8
	header('Content-Type: text/html; charset=utf-8');

	//kiem tra quyen, nếu k có->logout
	if (!is_supper_admin()) {
		redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
	}

	//neu ng dùng submit delete user
	if (is_submit('delete_name')) {
		
		//lay ID và ép kiểu
		$id = (int)input_post('name_id');
		if ($id) {
			
			//thong tin ng dùng
			$name = db_get_row(db_create_sql('SELECT * FROM tb_user {where}', array('id' => $id)));
			// kiểm tra có phải xóa nhầm admin k
			if ($name['name'] == 'admin') {
				?>
				<script type="text/javascript">
					alert('You cant delete name of admin!');
					window.location = '<?php echo input_post('redirect'); ?>';
				</script>
				<?php
			} else {
				$sql = db_create_sql('DELETE FROM tb_user {where}', array('id' => $id));
				if (db_execute($sql)) {
					?>
					<script type="text/javascript">
						alert('Delete is success!!');
						window.location = '<?php echo input_post('redirect'); ?>';
					</script>
					<?php
				} else {
					?>
					<script type="text/javascript">
						alert('Delete is faild!!');
						window.location = '<?php echo input_post('redirect'); ?>';
					</script>
					<?php
				}
			}
		}
	} else {
		// Nếu k phải submit delete -> trang chủ
		redirect(base_url('admin'));
	}
?>