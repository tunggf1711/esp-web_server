<?php 
if($_SERVER["REQUEST_METHOD"]=="GET")
{
	 $trangthai=0;
	 if(!empty($_GET["trangthai"])) $trangthai=test_input($_GET["trangthai"]);
	 
     $usename_='root';
     $passwork_="";
     $database="diem_danh_online"; 
     $conn=mysqli_connect("localhost",$usename_,$passwork_,$database);
	 if($conn)
	  {    
	   if($trangthai!=0)
		{
			if($trangthai==1)
			{
			 $sql="UPDATE trangthai SET trangthai='".$trangthai."' WHERE id=1";  //cập nhập trạng thái nếu khac 0
             mysqli_query($conn, $sql);
			
		     $sql="SELECT * FROM danh_sach_sinh_vien WHERE 1"; //trường hợp ở tab nhập thông tin
		     $result = mysqli_query($conn, $sql);
		     $a=array();
             if (mysqli_num_rows($result) > 0) 
		    {
				
				while($row = mysqli_fetch_assoc($result))
				{
					$a[]=$row;
				}echo json_encode($a); 
				
			}
			}

        }
		else //neue trang thái =0 và co request thì đang ở trang điểm danh 
		{
		  $sql="SELECT * FROM trangthai WHERE trangthai=2"; //nếu ấn nút bắt đđàu
		  $result = mysqli_query($conn, $sql);
           $b=array();
          if (mysqli_num_rows($result) > 0)  //nếu trạn thái =2
		    {   
			     while($row = mysqli_fetch_assoc($result))
			   	   {
					$b[]=$row;
				   }
				 $sql="SELECT * FROM diem_danh WHERE 1";
				 $result = mysqli_query($conn, $sql);
		         $a=array();
                 if (mysqli_num_rows($result) > 0) 
		          {
				   while($row = mysqli_fetch_assoc($result))
			   	   {
					$a[]=$row;
				    }
				    echo json_encode($a); 
				
			      }
			 }
		 }
		
	  }
	 
	   mysqli_close($conn); 
	   
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;}
?>