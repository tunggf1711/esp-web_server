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
<script type="text/javascript">
function trangthai() 
 {
	
	var xmlhttp = new XMLHttpRequest();
	var a="request.php?trangthai=0";								
    xmlhttp.open("GET",a,true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
                                              if (this.readyState == 4 && this.status == 200)
										      {	  
                                                var data=this.responseText;
												var obj = JSON.parse(data);
												var ketqua="this.responseText";
												//alert(this.responseText);
												ketqua= "<table id='tblStocks' cellpadding='0' cellspacing='0'><tr> <th>STT</th><th>HỌ VÀ TÊN</th><th>MSSV</th><th>GIỚI TÍNH</th><th>ID</th><th>THỜI GIAN VÀO</th><th>THỜI GIAN RA</th> <th>TRẠNG THÁI</th><tr> "
		                                       
												for(var x=0;x<obj.length;x++)
												{ 												
												 ketqua+="<tr><td>";
												 ketqua+=obj[x].id;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].ten_sinh_vien;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].mssv;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].gioi_tinh
												 ketqua+="</td><td>"
												 ketqua+=obj[x].uuid;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].gio_vao;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].gio_ra;
												 ketqua+="</td><td>"
												 ketqua+=obj[x].status;
												 ketqua+="</td></tr>"		
												} 
												ketqua+=" <tr> </table> "
												
												document.getElementById("table_cc").innerHTML=ketqua;
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


<style>
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
            background-color: #294c67;;
            color: white;
          }
      </style>
      
</head>

<?php 
$tgv=0;
$tgr=0;
$gio_vao=0;
$gio_ra=0;
$abc=0;
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
	
	if(!empty($_POST["gio_vao"])) {$gio_vao=test_input($_POST["gio_vao"]);$abc=$gio_vao;}
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


<body style="overflow:scroll">

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
 
 <div class="container">
  <div class="row">
    <div class="col-sm-8">
    <p>THỜI GIAN VÀO:</p><p><?php echo $tgv; ?></p>
     <p>THỜI GIAN RA:</p><p><?php echo $tgr; ?></p>
    </div>
    <div class="col-sm-4">
    <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"">
    <div class="form-group">
    <label for="gio_vao">GIỜ VÀO</label>
    <input type="datetime-local" name="gio_vao">
    </div>
    <div class="form-group">
    <label for="gio_ra">GIỜ RA </label>
    <input type="datetime-local" name="gio_ra">
  </div>
  <input type="submit" value="BẮT ĐẦU" width="100px"/>
    </form>
    </div>
   </div>
 </div>
 
 </br>
 <div id="table_cc">
  <table id="tblStocks" cellpadding="0" cellspacing="0">
            <tr>
                <th>STT</th>
                <th>HỌ VÀ TÊN</th>
                <th>MSSV</th>
                <th>GIỚI TÍNH</th>
                <th>ID</th>
                
                <th>THỜI GIAN VÀO</th>
                <th>THỜI GIAN RA</th>
                <th>TRẠNG THÁI</th>
             <tr>      
        </table> 
         </div>
        <br />
  <center> 
<div class="container">
  <div class="row">
    <div class="col-sm-4">
<form   action="dangnhap.php?trangthai=3" >
<button name="submit" class="btn"><i class="fa fa-home"></i> ĐĂNG XUẤT</button>
</form>
     </div>
   <div class="col-sm-4">
<center><button class="btn btn-success" onclick="xuat_exel()" >Xuất File Excel</button></center>
</div>  
 <div class="col-sm-4">
<form action="diem_danh_sinh_vien.php">
<button name="submit" class="btn"><i class="fa fa-home"></i> THÔNG TIN</button>
</form>
</div>
</div>
</center>
</body>
</html>