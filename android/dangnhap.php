<?php
$conten="*";

$tendangnhap="";
	$matkhau="";
	$tendangnhap="";
	$trangthai=0;
if($_SERVER["REQUEST_METHOD"]=="GET")
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
			 echo "update trangthai";
			}
			else
			{
				$sql="INSERT INTO trangthai(id, trangthai, gio_vao, gio_ra) VALUES (1,0,0,0)";
				mysqli_query($conn, $sql);
				 echo "insert trangthai";
			}
			
			
	      }
     }
 if($_SERVER["REQUEST_METHOD"]=="POST")
{
	
	if(!empty(test_input($_POST["tdn"]))) $tendangnhap=test_input($_POST["tdn"]);
	if(!empty(test_input($_POST["mk"]))) $matkhau=test_input($_POST["mk"]);
	if(!empty($_POST["trangthai"])) $trangthai=test_input($_POST["trangthai"]);
	if($tendangnhap!=""&&$matkhau!="")
	{
     $usename_='root';
     $passwork_="";
     $database="diem_danh_online";
	 $conn=mysqli_connect("localhost",$usename_,$passwork_,$database);
	 if($conn)
	 {
		  $sql="SELECT usename ,pass FROM admin WHERE usename='".$tendangnhap."' AND pass='".$matkhau."'";
			 $result = mysqli_query($conn, $sql);
	         if (mysqli_num_rows($result) > 0)
	        { 
			  echo "dang nhap thanh cong";
	        }else echo "dang nhap that bai";
		 mysqli_close($conn); 				
	 }
	 else
	  {
		 echo "khong ket noi";
	  }
	}
	
	
}
function test_input($data)
{
 $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
	return $data;
	}
?>