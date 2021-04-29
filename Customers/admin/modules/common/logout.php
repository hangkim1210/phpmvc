<?php

if (!defined('IN_SITE')) die('The request not found');

// Xóa login
set_logout();

//chuyển hướng login
redirect(base_url('admin/?m=common&a=login'));

?>