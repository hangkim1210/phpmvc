<?php 

	if (!defined('IN_SITE')) die ('The request not found');

	if (!is_admin()) {
		redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
	}

?>
<?php include_once('widgets/header.php'); ?>

<?php
	// Tìm tổng số records
	$sql = db_create_sql('SELECT count(id) as counter from tb_user {where}');
	$result = db_get_row($sql);
	$total_records = $result['counter'];
	 
	// Lấy trang hiện tại
	$current_page = input_get('page');
	 
	// Lấy limit
	$limit = 10;
	 
	// Lấy link
	$link = create_link(base_url('admin'), array(
	    'm' => 'user',
	    'a' => 'list',
	    'page' => '{page}'
	));
	$paging = paging($link, $total_records, $current_page, $limit);
	 
	// Lấy danh sách User
	$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
	$names = db_get_list($sql);
?>
 
<h2>Bảng danh sách user</h2>
<div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'add')); ?>">Thêm</a>
</div>
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Created_date</td>
            <td>Updated_date</td>
            <?php if (is_supper_admin()){ ?>
            <td>Action</td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    	
        <?php 
     	foreach ($names as $item) { ?>
        <tr>
        	<td><?php echo $item['name']; ?></td>
        	<td><?php echo $item['email']; ?></td>
        	<td><?php echo $item['created_date']; ?></td>
        	<td><?php echo $item['updated_date']; ?></td>
        	<?php if (is_supper_admin()){ ?>
	        	<td>
	        		<form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'delete')); ?>">
	        			<a href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'edit', 'id' => $item['id'])); ?>">Edit</a>
	        			<input type="hidden" name="name_id" value="<?php echo $item['id']; ?>" />
	        			<input type="hidden" name="request_name" value="delete_name"/>
	        			<a href="#" class="btn-submit">Delete</a>
	        			
	        		</form>
	        	</td>
	        <?php } ?>
        </tr>
    	<?php } ?>
    </tbody>
</table>
<?php include_once('widgets/footer.php'); ?>

<script type="text/javascript">

	$(document).ready(function(){

		$('.btn-submit').click(function(){
			$(this).parent().submit();
			return false;
		});

		$('.form-delete').submit(function(){
			if (!confirm('Bạn có chắc chắn muốn xóa tài khoản này?')) {
				return false;
			}
			$(this).append('<input type = "hidden" name = "redirect" value="'+window.location.href+'" />');

			return true;
		});

	});
</script>