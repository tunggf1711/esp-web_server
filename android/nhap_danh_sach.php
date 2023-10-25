<?php
 

if($_SERVER['REQUEST_METHOD']=="POST")
{   
  
  if(!empty($_POST["NAME"])) $name=test_input($_POST["NAME"]);
  if(!empty($_POST["MSSV"])) $mssv=test_input($_POST["MSSV"]);
  if(!empty($_POST["UUID"])) $uuid=test_input($_POST["UUID"]);
  if(!empty($_POST["xoa_uuid"])) {$xoa_uuid=test_input($_POST["xoa_uuid"]);$uuid=test_input($_POST["xoa_uuid"]);}
  if(!empty($_POST["gioi_tinh"])) $gioi_tinh=test_input($_POST["gioi_tinh"]);
  if((!empty($_POST["NAME"])&&!empty($_POST["UUID"])&&!empty($_POST["MSSV"]))||!empty($_POST["xoa_uuid"]))
	{
		 $usename_='root';
         $passwork_="";
         $database="diem_danh_online";
		 $conn=mysqli_connect("localhost",$usename_,$passwork_,$database);
	     if($conn) 
	      {
		  $sql="SELECT uuid FROM danh_sach_sinh_vien WHERE uuid='".$uuid."'";
			 $result = mysqli_query($conn, $sql);
	         if (mysqli_num_rows($result)>0)
	        { 
              if((!empty($_POST["NAME"])&&!empty($_POST["UUID"])&&!empty($_POST["MSSV"]))){
				  	$sql="UPDATE danh_sach_sinh_vien SET ten_sinh_vien='".$name."' , mssv='".$mssv."' , gioi_tinh='".$gioi_tinh."' WHERE uuid='".$uuid."'";
		            if(mysqli_query($conn,$sql)){ echo"da cap nhat"; }
					else echo"THỬ LẠI"; 
				  }
				else if(!empty($_POST["xoa_uuid"])){
				  	$sql="DELETE FROM danh_sach_sinh_vien WHERE uuid='". $xoa_uuid."'";
		            if(mysqli_query($conn,$sql)){ echo"da xoa"; }
					else echo"THỬ LẠI"; 
				  }
	        }
			else
			{ 
			   echo"KHÔNG TỒN TẠI ID NÀY"; 
			}
	     mysqli_close($conn);
	     }
	     else{echo"KHÔNG KẾT NỐI ĐƯỢC";}	
	}
   else 
   {
	   if((empty($_POST["NAME"])||empty($_POST["UUID"])||empty($_POST["MSSV"])))
	   echo"NHẬP THIẾU THÔNG TIN";
	   else if(empty($_POST["xoa_uuid"]))
	   {
		   echo"NHẬP THIẾU THÔNG TIN";
		   }
   }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;}
?>