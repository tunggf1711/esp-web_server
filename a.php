<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ĐĂNG NHẬP HỆ THỐNG ĐIỂM DANH SINH VIÊN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<?php
$conten = "*";
$trang = $_SERVER["PHP_SELF"];
$disable = "";
$tendangnhap = "";
$matkhau = "";
$tendangnhap = "";
$trangthai = 0;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $usename_ = 'root';
    $passwork_ = "";
    $database = "diem_danh_online";
    $conn = mysqli_connect("localhost", $usename_, $passwork_, $database);
    
    if ($conn) {
        $sql = "SELECT trangthai FROM trangthai WHERE id=1";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE trangthai SET trangthai=0, gio_vao=0 , gio_ra=0 WHERE id=1";
            mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO trangthai(id, trangthai, gio_vao, gio_ra) VALUES (1,0,0,0)";
            mysqli_query($conn, $sql);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty(test_input($_POST["tdn"]))) {
        $tendangnhap = test_input($_POST["tdn"]);
    }
    if (!empty(test_input($_POST["mk"]))) {
        $matkhau = test_input($_POST["mk"]);
    }
    if (!empty($_POST["trangthai"])) {
        $trangthai = test_input($_POST["trangthai"]);
    }
    
    if ($tendangnhap != "" && $matkhau != "") {
        $usename_ = 'root';
        $passwork_ = "";
        $database = "diem_danh_online";
        $conn = mysqli_connect("localhost", $usename_, $passwork_, $database);
        
        if ($conn) {
            $sql = "SELECT usename ,pass FROM admin WHERE usename='" . $tendangnhap . "' AND pass='" . $matkhau . "'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $conten = "ĐĂNG NHẬP THÀNH CÔNG</br>ẤN LƯU LẠI ĐỂ XÁC NHẬN";
                $trang = "/diem_danh_online/diem_danh.php";
            } else {
                $conten = "TÊN ĐĂNG NHẬP HOẶC MẬT KHẨU KHÔNG ĐÚNG";
            }
        }
    } else {
        $conten = "VUI LÒNG NHẬP ĐẦY ĐỦ TÊN ĐĂNG NHẬP VÀ MẬT KHẨU";
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

<form method="GET" action="<?php echo htmlspecialchars($trang); ?>">
    <input type="hidden" name="trangthai" value="1">
    <?php if (!empty($disable)) { ?>
        <        <input type="submit" class="btn btn-primary" name="submit" value="BẮT ĐẦU ĐIỂM DANH" disabled>
    <?php } else { ?>
        <input type="submit" class="btn btn-primary" name="submit" value="BẮT ĐẦU ĐIỂM DANH">
    <?php } ?>
</form>


  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="text-center">ĐĂNG NHẬP HỆ THỐNG QUẢN LÝ ĐIỂM DANH SINH VIÊN</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 col-xs-offset-4">
        <form method="POST" action="<?php echo htmlspecialchars($trang); ?>">
          <div class="form-group">
            <label for="tdn">TÊN ĐĂNG NHẬP:</label>
            <input type="text" class="form-control" name="tdn" value="<?php echo $tendangnhap; ?>" <?php echo $disable; ?>>
          </div>
          <div class="form-group">
            <label for="mk">MẬT KHẨU:</label>
            <input type="password" class="form-control" name="mk" value="<?php echo $matkhau; ?>" <?php echo $disable; ?>>
          </div>
          <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" name="submit" value="ĐĂNG NHẬP" />
          </div>
        </form>
        <p class="text-center"><?php echo $conten; ?></p>
      </div>
    </div>
  </div>
</body>
</html>

