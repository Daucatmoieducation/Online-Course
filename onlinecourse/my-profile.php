<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {   
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) { //cập nhật thông tin sv
        $studentname = $_POST['studentname'];
        $photo = $_FILES["photo"]["name"];
        $cgpa = $_POST['cgpa'];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "studentphoto/" . $_FILES["photo"]["name"]);

        $ret = mysqli_query($con, "UPDATE students SET studentName='$studentname', studentPhoto='$photo', cgpa='$cgpa' WHERE StudentRegno='" . $_SESSION['login'] . "'");
        if ($ret) {
            echo '<script>alert("Thay đổi thông tin thành Công!!")</script>';
            echo '<script>window.location.href=my-profile.php</script>';
        } else {
            echo '<script>alert("Đã xảy ra lỗi. Vui lòng thử lại!")</script>';
            echo '<script>window.location.href=my-profile.php</script>';
        }
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
    <title>Student Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php'); ?>

<?php if ($_SESSION['login'] != "") {
    include('includes/menubar.php');
} ?>

<!-- MENU SECTION END -->
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Thông tin sinh viên</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <font color="green" align="center">
                        <?php echo htmlentities($_SESSION['msg']); ?>
                        <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                    </font>

                    <?php //hiển thị thông tin sv
                    $sql = mysqli_query($con, "SELECT * FROM students WHERE StudentRegno='" . $_SESSION['login'] . "'");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($sql)) { 
                    ?>

                    <div class="panel-body">
                        <form name="dept" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="studentname">Tên Sinh Viên</label>
                                <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']); ?>" />
                            </div>

                            <div class="form-group">
                                <label for="studentregno">Mã Sinh Viên</label>
                                <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['StudentRegno']); ?>" placeholder="Student Reg no" readonly />
                            </div>

                            <div class="form-group">
                                <label for="Pincode">Pincode</label>
                                <input type="text" class="form-control" id="Pincode" name="Pincode" readonly value="<?php echo htmlentities($row['pincode']); ?>" required />
                            </div>

                            <div class="form-group">
                                <label for="CGPA">CGPA</label>
                                <input type="text" class="form-control" id="cgpa" name="cgpa" value="<?php echo htmlentities($row['cgpa']); ?>" required />
                            </div>

                            <div class="form-group">
                                <?php if ($row['studentPhoto'] == "") { ?>
                                    <img src="studentphoto/noimage.png" width="200" height="200">
                                <?php } else { ?>
                                    <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']); ?>" width="200" height="200">
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="Pincode">Upload New Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" value="<?php echo htmlentities($row['studentPhoto']); ?>" />
                            </div>
                            <button type="submit" name="submit" id="submit" class="btn btn-default">Update</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>

</body>
</html>
<?php  ?>
