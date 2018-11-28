<?php 
ob_start();
session_start();
$title = 'Đại học công nghiệp Việt - Hung';
require_once 'Model/Base/Function.php';
include_once  'Model/Giangvien.php';
include_once  'Model/GiangvienMapper.php';
include_once  'Model/User.php';
include_once  'Model/UserMapper.php';
include_once  'Model/Sinhvien.php';
include_once  'Model/SinhvienMapper.php';
include_once  'Model/Lop.php';
include_once  'Model/LopMapper.php';
include_once  'Model/Menu.php';
include_once  'Model/MenuMapper.php';
include_once  'Model/Doan.php';
include_once  'Model/DoanMapper.php';
include_once  'Model/Chude.php';
include_once  'Model/ChudeMapper.php';
include_once  'Model/LoaiDoan.php';
include_once  'Model/LoaiDoanMapper.php';
include_once  'Model/Report.php';
include_once  'Model/ReportMapper.php';
include_once  'Model/SinhvienThamgia.php';
include_once  'Model/SinhvienThamgiaMapper.php';
include_once  'Model/Huongdan.php';
include_once  'Model/HuongdanMapper.php';
include_once  'Model/PhanBien.php';
include_once  'Model/PhanBienMapper.php';
include_once  'Model/Baiviet.php';
include_once  'Model/BaivietMapper.php';
$linkpage = !empty($_GET['linkpage']) ? $_GET['linkpage'] : '';
if ($linkpage){
    switch ($linkpage){
        case 'dangnhap':
            include_once 'layout/dangnhap.php';
            break;
        case 'dangky':
            include_once 'layout/dangky.php';
            break;
        case 'dstintuc':
            include_once 'layout/dsTintuc.php';
            break;
        case 'dsdoan':
            include_once 'layout/dsDoan.php';
            break;
        case 'tintuc':
            include_once 'layout/tintuc.php';
            break;
        case 'ctdoan':
            include_once 'layout/ctdoan.php';
            break;
        case 'calendar':
            include_once 'layout/calendar.php';
            break;
        case 'nopdoan':
            include_once 'layout/nopDoan.php';
            break;
        case 'kq':
            include_once 'layout/ketqua.php';
            break;
        case 'gioithieu':
            include_once 'layout/gioithieu.php';
            break;
        case 'logout':
            unset($_SESSION['userService']);
            session_destroy();
            redirect_to('index.php');
            break;
        default:
            include_once 'layout/trangchu.php';
            break;
    }
}else{
    include_once 'layout/trangchu.php';
}
?>

