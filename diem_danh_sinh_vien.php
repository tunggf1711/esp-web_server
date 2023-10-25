<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>QUẢN LÝ CHẤM CÔNG NHÂN VIÊN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<style type="text/css">
body
{
     font-family: 'Roboto', sans-serif;
     overflow: hidden;
     line-height: 1.4;
     width: 100%;	
	 background-attachment:scroll;
	 
	 background-repeat:no-repeat;
	 background-size:cover;
	 overflow:scroll;
	 
}
table{
    border:2px double;
	background-color:#CCC;
	margin-left:10px;
	margin-top:20px;
}
th{
    border:1px solid black;
}
td{
    border:1px solid black;
}
.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 16px;
  cursor: pointer;
}

  #tblStocks {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
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
            background-color: #294c67;
            color: white;
          }
    
</style>

<script type="text/javascript">
function trangthai() 
 {
	 
	var xmlhttp = new XMLHttpRequest();
	
	var a="request.php?trangthai=1";								
    xmlhttp.open("GET",a,true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
                                              if (this.readyState == 4 && this.status == 200)
										      {	  
                                                var data=this.responseText;
												var obj = JSON.parse(data);
												var ketqua="";
												ketqua= "<table id='tblStocks' cellpadding='0' cellspacing='0'><tr> <th>STT</th><th>HỌ VÀ TÊN</th><th>MSSV</th><th>GIỚI TÍNH</th><th>ID</th><tr> "
												for(var x=0;x<obj.length;x++)
												{ 												
												 ketqua+="<tr><td>";
												 ketqua+=obj[x].id;
												 ketqua+="</td><td>";
												 if(obj[x].ten_sinh_vien=="") ketqua+="*"
												 else ketqua+=obj[x].ten_sinh_vien;
												 ketqua+="</td><td>";
												 if(obj[x].mssv==0) ketqua+="*"
												 else ketqua+=obj[x].mssv;
												 ketqua+="</td><td>";
												 ketqua+=obj[x].gioi_tinh;
												 ketqua+="</td><td>";
												 ketqua+=obj[x].uuid;
												 ketqua+="</td></tr>"
													
												}
												//alert(+obj[1].uuid);
												ketqua+= "</tbody> </table>"
												document.getElementById("table_danh_sach").innerHTML=ketqua;
											  }

                                            };
											
		
}
   var tg2 = setInterval(trangthai,2000);
   
   function xuat_exel()
   {
	  
	   $("#tblStocks").table2excel({
      name: "Worksheet Name",
      filename: "FileExcel",
      fileext: ".xls"}) ;

   }
  
</script>

<?php
 $conten="*"; 
 $conten2="*"; 
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
		            if(mysqli_query($conn,$sql)){ $conten="ĐÃ CẬP NHẬT"; }
					else $conten="THỬ LẠI"; 
				  }
				else if(!empty($_POST["xoa_uuid"])){
				  	$sql="DELETE FROM danh_sach_sinh_vien WHERE uuid='". $xoa_uuid."'";
		            if(mysqli_query($conn,$sql)){ $conten2="ĐÃ XÓA"; }
					else $conten2="THỬ LẠI"; 
				  }
	        }
			else
			{ 
			   $conten="KHÔNG TỒN TẠI ID NÀY"; 
			}
	     mysqli_close($conn);
	     }
	     else{$conten="KHÔNG KẾT NỐI ĐƯỢC";}	
	}
   else 
   {
	   if((empty($_POST["NAME"])||empty($_POST["UUID"])||empty($_POST["MSSV"])))
	   $conten="NHẬP THIẾU THÔNG TIN";
	   else if(empty($_POST["xoa_uuid"]))
	   {
		   $conten2="NHẬP THIẾU THÔNG TIN";
		   }
   }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;}
?>




<body class="body" >

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
<center>
 <h2><p style="background-size:100px 300px" style="color:#060">HỆ THỐNG QUẢN LÝ CHẤM CÔNG NHÂN VIÊN</p></h2>
 </center>
 </br>
 
 
 <div class="container">
 <div class="row">
 <div class="col-sm-8">
 
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table style="width:300px">
<tr>
<th colspan="2"style="background-color:#294c67"><center><p style="color:#FFF">NHẬP THÔNG TIN NHÂN VIÊN</p></center> </th>
</tr>
<tr>
<th><p style="width:100px">HỌ VÀ TÊN</p> </th>
<td><input type="text" style="border:double" name="NAME" width="200px  "/></td>
</tr>
<tr>
<th>MSNV</th>
<td><input type="text" style="border:double" name="MSSV" width="200px"/></td>
</tr>
<tr>
<th>UUID</th>
<td><input type="text" style="border:double" name="UUID" width="200px"/></td>
</tr>
<tr>
<th>GIỚI TÍNH</th>
<td >

<input type="radio"  id="NAM" name="gioi_tinh" value="NAM" checked="checked">
<label for="NAM">NAM</label><br>
<input type="radio"  id="NỮ" name="gioi_tinh" value="NỮ">
<label for="NỮ">NỮ</label><br>

</td>
</tr>
<tr>
<td colspan="2"><center><input type="submit" name="submit"  value="CẬP NHẬT"  style="width:100px" /></center></td>
</tr>
<tr>
<td colspan="2">
<center><p><?php echo $conten; ?></p></center>
</td>
</tr>

</table>
</form>
</div>
</br>
<center>
<center> 
<div class="col-sm-4">
<div class="row">
<form action="dangnhap.php">
<button name="submit" class="btn"><i class="fa fa-home"></i> ĐĂNG XUẤT</button>
</form>
<br />
</div>
<div class="row">
<form action="diem_danh.php">
<button name="submit" class="btn"><i class="fa fa-home"></i>CHẤM CÔNG</button>
</form>
</div></div>
</center>

</div>

 <div class="row">
 <div class="col-sm-8">
<form action="diem_danh_sinh_vien.php" method="POST">
<table style="width:300px">
<tr>
<th colspan="2" style="background-color:#294c67"><center><p style="color:#FFF">XÓA THÔNG TIN NHÂN VIÊN</p></center> </th>
</tr>
<tr>
<th><p style="width:100px">UUID </p></th>
<td><input style="border:double" type="text" name="xoa_uuid" width="200px"/></td>
</tr>
<td colspan="2"><center><input type="submit" name="submit" value="XÓA"  style="width:100px" /></center></td>
</tr>
</tr>
<td colspan="2"><center><p><?php echo $conten2; ?></p></center></td>
</tr>
</table>
</form> </div>
<div class="col-sm-4">

</div> </div>

<center>
 <div id="table_danh_sach">
  <table id="tblStocks" cellpadding="0" cellspacing="0">
            <tr>
                <th>STT</th>
                <th>HỌ VÀ TÊN</th>
                <th>MSNV</th>
                <th>GIỚI TÍNH</th>
                <th>ID</th>
             <tr>      
        </table> 
         </div>
         
  </center>
  </br>
  <center><button class="btn btn-success" onclick="xuat_exel()" >Xuất File Excel</button></center>
</body>
</html>