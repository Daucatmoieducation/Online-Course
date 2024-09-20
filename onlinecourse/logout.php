<?php
session_start();
include("includes/config.php");
$_SESSION['login']=="";
date_default_timezone_set('Asia/Kolkata'); //sửa lại múi giờ
$ldate=date( 'd-m-Y h:i:s A', time () );
$uid=$_SESSION['login'];
mysqli_query($con,"UPDATE userlog  SET logout = '$ldate' WHERE studentRegno = '$uid' ORDER BY id DESC LIMIT 1");
session_unset(); //hủy phiên lm vc
$_SESSION['errmsg']="Đăng Xuất Thành Công";
?> 
<script language="javascript">
document.location="index.php";
</script>
