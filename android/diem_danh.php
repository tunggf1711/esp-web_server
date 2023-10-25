<?php 
$tgv=0;
$tgr=0;
$gio_vao=0;
$gio_ra=0;
if($_SERVER["REQUEST_METHOD"]=="GET") //khi từ trang khác chuyển vào trang này
    {
		 $usename_='root';
     $passwork_="";
     $database="diem_danh_online";
	 $conn=mysqli_connect("localhost",$usename_,$passwork_,$database);
	 if($conn)
	      {
		    $sql="SELECT trangthai FROM trangthai WHERE id=1";
			 $result = mysqli_query($conn, $sql);
	         if(mysqli_num_rows($result)>0)
	        { 
			 $sql="UPDATE trangthai SET trangthai=0, gio_vao=0 , gio_ra=0 WHERE id=1";
			 mysqli_query($conn, $sql); 
			}
			else
			{
				$sql="INSERT INTO trangthai(id, trangthai, gio_vao, gio_ra) VALUES (1,0,0,0)";
				mysqli_query($conn, $sql);
			}
			 mysqli_close($conn); 
	      }
     }
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	
	if(!empty($_POST["gio_vao"])) $gio_vao=test_input($_POST["gio_vao"]);
	if(!empty($_POST["gio_ra"])) $gio_ra=test_input($_POST["gio_ra"]);
	$usename_='root';
    $passwork_="";
    $database="diem_danh_online"; 
    $conn=mysqli_connect("localhost",$usename_,$passwork_,$database);
	 if($conn&&!empty($_POST["gio_vao"])&&!empty($_POST["gio_ra"])) 
	 { 
		 $sql="DELETE FROM `diem_danh` WHERE 1";
			mysqli_query($conn, $sql); //xóa sữ liệu cũ
		  $sql="SELECT trangthai FROM trangthai WHERE id=1";
			 $result = mysqli_query($conn, $sql);
	         if(mysqli_num_rows($result)>0)
	        { 
			 $sql="UPDATE trangthai SET trangthai=2, gio_vao='".$gio_vao."' , gio_ra='".$gio_ra."' WHERE id=1";
			 if(mysqli_query($conn, $sql))
			 {
				 $tgr=$gio_ra;
				 $tgv=$gio_vao;
				 echo "da nhan";
			 }
			 else
			 {
				 $tgr=0;
				 $tgv=0; 
			 }
			}
			else
			{
				$sql="INSERT INTO trangthai(id, trangthai, gio_vao, gio_ra) VALUES (1,2,'".$gio_vao."','".$gio_ra."')";
				if(mysqli_query($conn, $sql))
			    {
				 $tgr=$gio_ra;
				 $tgv=$gio_vao;
				  echo "da nhan";
			     }
				 else
				 {
				 }
			}
			 mysqli_close($conn); 
	 }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;}
?>