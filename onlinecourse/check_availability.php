<!-- sv  k thể đky khóa học đã đky trc đó
 	sv k thể dky nếu hết chỗ ngồi -->

	 <?php session_start();
require_once("includes/config.php");
if(!empty($_POST["cid"])) { //check id khóa học không rỗng
$cid= $_POST["cid"];
 $regid=$_SESSION['login']; //lấy id khóa học và id sc
		//truy vấn sv đã đăng ký khóa học này chưa, sử dụng bảng courseenrolls
		$result =mysqli_query($con,"SELECT studentRegno FROM 	courseenrolls WHERE course='$cid' and studentRegno=' $regid'");
	$count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red'> Already Applied for this course.</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>"; // vô hiệu hóa submit để ngăn sv đăng ký lại
} 
}
if(!empty($_POST["cid"])) {
	$cid= $_POST["cid"];

		$result =mysqli_query($con,"SELECT * FROM courseenrolls WHERE course='$cid'"); //truy vấn số lượng sv đã đky khóa học
		$count=mysqli_num_rows($result);
		$result1 =mysqli_query($con,"SELECT noofSeats FROM course WHERE id='$cid'"); //truy vấn lấy số lượng chỗ ngồi của khóa học
		$row=mysqli_fetch_array($result1);
		$noofseat=$row['noofSeats'];
if($count>=$noofseat)
{
echo "<span style='color:red'> Seat not available for this course. All Seats Are full</span>"; //tbao hết chỗ
 echo "<script>$('#submit').prop('disabled',true);</script>"; // vô hiệu hóa submit để ngăn sv đăng ký lại
} 
}

?>
