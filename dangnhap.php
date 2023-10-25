<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ĐĂNG NHẬP HỆ THỐNG CHẤM CÔNG NHÂN VIÊN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
</head>

<style type="text/css">
h1
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:16px;
	font-style:italic| oblique;
	border-color:#CC3;
	color:#F06;
	
	
}
h2
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:24px;
	font-style:italic;
	border-color:#3C6;
	color:#00F;

}

div
{
	padding:=10px;
}
.btn
{
	font:Arial, Helvetica, sans-serif;
	font-size:12px;
	background:#969;
	font-style:oblique;
	color:#00C;
	border:double;
	border-color:#F00;
}


        #tblStocks {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width:400px;
        }
 
        #tblStocks td, #tblStocks th {
          border: 1px solid #ddd;
          padding: 8px;
        }
 
        #tblStocks tr:nth-child(even){background-color: #f2f2f2;}
 
        #tblStocks tr:hover {background-color: #ddd;}
 
        #tblStocks th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #294c67;;
            color: white;
          }
     
      
</head>
</style>

<body>
<?php
	$conten="*";
	$trang=$_SERVER["PHP_SELF"];
	$disable="";
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
				}
				else
				{
					$sql="INSERT INTO trangthai(id, trangthai, gio_vao, gio_ra) VALUES (1,0,0,0)";
					mysqli_query($conn, $sql);
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
		
				$conten="ĐĂNG NHẬP THÀNH CÔNG</br>ẤN LẦN NỮA ĐẺ CHUYỂN TRANG";
				$trang="/diem_danh_online/diem_danh.php";
				$disable="readonly";
				
				}else $conten="THÔNG TIN SAI!!!MỜI NHẬP LẠI THÔNG TIN";
			mysqli_close($conn); 				
		}
		else
		{
			$conten="KHÔNG KẾT NỐI ĐƯỢC";
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


<div class="container-fluid" style="background-color:#CCC" >

  <div class="row center" >    
    <div class="col-xs-4"> 
     <img class="img-responsive" src="anh3.jpg" alt="Chania" width="300" height="100"> 
    </div>
     <div class="col-xs-4"> 
     <img class="img-responsive" src="anh3.jpg" alt="Chania"  width="300" height="100"> 
    </div>
    <div class="col-xs-4"> 
     <img class="img-responsive" src="anh3.jpg" alt="Chania" width="300" height="100"> 
    </div>
  </div>
  </div>
<div>
<center>




<marquee width="30%" direction="left" hspace="35%" ><h1>ĐĂNG NHẬP HỆ THỐNG QUẢN LÝ CHẤM CÔNG NHÂN VIÊN</h1></marquee>
<h1>ĐĂNG NHẬP</h1>
<table border="5px" bgcolor="#33FFFF" cellpadding="5px" cellspacing="5px" id="tblStocks"  >
<tr>
<form method="POST" action="<?php echo htmlspecialchars($trang);?>">
<th><p><center>TÊN ĐĂNG NHẬP</center></p></th>
<td><input type="text" name="tdn" value="<?php echo $tendangnhap ;?>" <?php echo $disable; ?>/></td>
</tr>
<tr>
<th><p><center>MẬT KHẨU</center></p></th>
<td><input type="password" name="mk" value="<?php echo $matkhau ;?>" <?php echo $disable; ?>/></td>
</tr>
<tr>
<td colspan="2"><center><input type="submit" name="submit" value="ĐĂNG NHẬP"/></center></td>
</tr>
</form>
</table>

</center>
</div>
<p><center><?php echo $conten;?></center></p>
</body>
</html>