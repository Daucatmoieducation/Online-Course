
<?php
session_start(); //khởi tạo session để qly thông tin người dùng đăng nhập
include('includes/config.php'); 
error_reporting(0); //Tắt hiển thị thông báo lỗi
if(strlen($_SESSION['login'])==0) //ktra đăng nhập nếu k tồn tại  hoặc để trống
    {   
header('location:index.php'); //về trang index.php
}
else{ 
date_default_timezone_set('Asia/Kolkata');// đặt múi giờ theo khu vực 
$currentTime = date( 'd-m-Y h:i:s A', time () );
 
//Code for Change Password
if(isset($_POST['submit']))
{ 
$regno=$_SESSION['login'];   //lấy id (regno) hs từ session login
$currentpass=md5($_POST['cpass']); //Mã hóa mật khẩu hiện tại
$newpass=md5($_POST['newpass']); //Mã hóa mật khẩu mới

//kiểm tra mật khẩu hiện tại
//Truy vấn csdl để kiểm tra xem mật khẩu hiện tại có khớp với mật khẩu đã lưu trong csdl không.
$sql=mysqli_query($con,"SELECT password FROM  students where password='$currentpass' && studentRegno='$regno'");
$num=mysqli_fetch_array($sql); //Lấy kết quả truy vấn. Nếu tồn tại bản ghi thì mật khẩu khớp.
//nếu khớp, cập nhật mật khẩu mới và thời gian thay đổi trong csdl
if($num>0)
{
 $con=mysqli_query($con,"update students set password='$newpass', updationDate='$currentTime' where studentRegno='$regno'");
echo '<script>alert("Password Changed Successfully !!")</script>'; //tbao 
echo '<script>window.location.href=change-password.php</script>'; //về trang change password
}
//hiển thị lỗi, về trang change-password
else{ 
echo '<script>alert("Current Password not match !!")</script>';
echo '<script>window.location.href=change-password.php</script>';
}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Student | Student Password</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<script type="text/javascript">
function valid()
{
//thay đổi mật khẩu
if(document.chngpwd.cpass.value=="")
{
alert("Current Password Filed is Empty !!");
document.chngpwd.cpass.focus();
return false;
}
else if(document.chngpwd.newpass.value=="")
{
alert("New Password Filed is Empty !!");
document.chngpwd.newpass.focus();
return false;
}
else if(document.chngpwd.cnfpass.value=="")
{
alert("Confirm Password Filed is Empty !!");
document.chngpwd.cnfpass.focus();
return false;
}
else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.cnfpass.focus();
return false;
}
return true;
}
</script>
<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php'); //chỉ hiển thị nếu người dùng đăng nhập
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Student Change Password </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Change Password
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="chngpwd" method="post" onSubmit="return valid();">
   <div class="form-group">
    <label for="exampleInputPassword1">Current Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="cpass" placeholder="Password" />
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">New Password</label>
    <input type="password" class="form-control" id="exampleInputPassword2" name="newpass" placeholder="Password" />
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputPassword3" name="cnfpass" placeholder="Password" />
  </div>
 
  <button type="submit" name="submit" class="btn btn-default">Submit</button>
                           <hr />
   



</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
