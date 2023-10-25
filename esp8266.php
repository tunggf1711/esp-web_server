<?php
$giovao = 0;
$giora = 0;
$row_danh_sach_sinh_vien = "";
$status = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uuid = "";

    // Check if UUID is present in the POST data
    if (!empty($_POST["UUID"])) {
        $uuid = test_input($_POST["UUID"]);
    }

    if (!empty($_POST["UUID"])) {
        $usename_ = 'root';
        $passwork_ = "";
        $database = "diem_danh_online";
        $conn = mysqli_connect("localhost", $usename_, $passwork_, $database);

        if ($conn) {
            $sql = "SELECT * FROM danh_sach_sinh_vien WHERE uuid='" . $uuid . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row_danh_sach_sinh_vien = mysqli_fetch_assoc($result);

                $sql = "SELECT * FROM trangthai WHERE trangthai=2";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $today = date("Y-m-d H:i:s");
                    $today_ = strtotime($today);

                    $row_trangthai = mysqli_fetch_assoc($result);
                    $giora = $row_trangthai["gio_ra"];
                    $giovao = $row_trangthai["gio_vao"];
                    $gio_ra = strtotime($giora);
                    $gio_vao = strtotime($giovao);

                    $sql = "SELECT * FROM diem_danh WHERE uuid='" . $uuid . "'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row_diem_danh = mysqli_fetch_assoc($result);

                        //if (strtotime($row_diem_danh["gio_ra"]) == -62170009600)
                         {
                            if ($gio_ra > $today_) {
                                $h = ($gio_ra - $today_) / 60;
                                $h = (int)$h;
                                $status = $row_diem_danh["status"] . ",RA SỚM:" . $h . " phút";
                            } else if ($gio_ra < $today_) {
                                $h = (-$gio_ra + $today_) / 60;
                                $h = (int)$h;
                                $status = $row_diem_danh["status"] . ",RA MUỘN:" . $h . " phút";
                            } else {
                                $status = ",RA ĐÚNG GIỜ";
                            }

                            $sql = "UPDATE `diem_danh` SET `gio_ra`='" . date("Y-m-d H:i:s") . "',`status`='" . $status . "' WHERE uuid='" . $uuid."'";
                            if (mysqli_query($conn, $sql)) {
                                $b = array();
                                $b[] = $row_danh_sach_sinh_vien;
                                echo json_encode($b);
                            } else {
                                echo "chua diem danh";
                            }
                        }
                    } else {
                        if ($gio_vao > $today_) {
                            $h = ($gio_vao - $today_) / 60;
                            $h = (int)$h;
                            $status = "ĐẾN SỚM:" . $h . " phút";
                        } else if ($gio_vao < $today_) {
                            $h = (-$gio_vao + $today_) / 60;
                            $h = (int)$h;
                            $status = "ĐẾN MUỘN:" . $h . " phút";
                        } else {
                            $status = "ĐẾN ĐÚNG GIỜ:";
                        }

                        $sql = "INSERT INTO `diem_danh`(`ten_sinh_vien`, `mssv`, `gioi_tinh`, `uuid`, `gio_vao`, `status`) VALUES ('" . $row_danh_sach_sinh_vien['ten_sinh_vien'] . "', '" . $row_danh_sach_sinh_vien['mssv'] . "', '" . $row_danh_sach_sinh_vien['gioi_tinh'] . "', '" . $uuid . "', '" . date("Y-m-d H:i:s") . "', '" . $status . "')";
                        if (mysqli_query($conn, $sql)) {
                            $b = array();
                            $b[] = $row_danh_sach_sinh_vien;
                            echo json_encode($b);
                        } else {
                            echo "chua diem danh vao";
                        }
                    }
                } else {
                    echo "chua ton tai uuid";
                }
            } else {
                $sql = "SELECT * FROM trangthai WHERE trangthai=1";
                $result = mysqli_query($conn, $sql);
                $b = array();

                if (mysqli_num_rows($result) > 0) {
                    $sql = "INSERT INTO danh_sach_sinh_vien(`uuid`) VALUES ('" . $uuid . "')";
                    if (mysqli_query($conn, $sql)) {
                        echo "insert suscess data";
                    } else {
                        echo "insert failed";
                    }
                } else {
                    echo "he thong dag dong";
                }
            }
            mysqli_close($conn);
        } else {
            echo 'chua ket noi';
        }
    }

    if (!empty($_POST["lay_trang_thai"])) {
        $usename_ = 'root';
        $passwork_ = "";
        $database = "diem_danh_online";
        $conn = mysqli_connect("localhost", $usename_, $passwork_, $database);

        if ($conn) {
            $sql = "SELECT * FROM trangthai WHERE id='1'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "status:" . $row["trangthai"];
            }
            mysqli_close($conn);
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
