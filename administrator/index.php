<?php
ob_start();
session_start();
include_once '../Model/Base/Function.php';
include_once '../Model/User.php';
include_once '../Model/UserMapper.php';
include_once '../Model/Base/Function.php';
include_once  '../Model/Giangvien.php';
include_once  '../Model/GiangvienMapper.php';
include_once  '../Model/User.php';
include_once  '../Model/UserMapper.php';
include_once  '../Model/Sinhvien.php';
include_once  '../Model/SinhvienMapper.php';
include_once  '../Model/Lop.php';
include_once  '../Model/LopMapper.php';
include_once  '../Model/Menu.php';
include_once  '../Model/MenuMapper.php';
include_once '../Model/Chude.php';
include_once '../Model/ChudeMapper.php';
include_once '../Model/LoaiDoan.php';
include_once '../Model/LoaiDoanMapper.php';
include_once '../Model/Khoa.php';
include_once '../Model/KhoaMapper.php';
include_once '../Model/Lop.php';
include_once '../Model/LopMapper.php';
include_once '../Model/Doan.php';
include_once '../Model/DoanMapper.php';
include_once '../Model/Sinhvien.php';
include_once '../Model/SinhvienMapper.php';
include_once '../Model/Huongdan.php';
include_once '../Model/HuongdanMapper.php';
include_once '../Model/SinhvienThamgia.php';
include_once '../Model/SinhvienThamgiaMapper.php';
include_once '../Model/Report.php';
include_once '../Model/ReportMapper.php';
include_once '../Model/Baiviet.php';
include_once '../Model/BaivietMapper.php';
include_once '../Model/PhanBien.php';
include_once '../Model/PhanBienMapper.php';
if (empty($_SESSION['userService'])){
    redirect_to('index.php?linnkpage=dangnhap');
}
$userService = $_SESSION['userService'];
if ($userService['nhomquyen']  == Model\User::ROLE_STUDENT){
    redirect_to('index.php');
}
$linkpage = !empty($_GET['linkpage']) ? $_GET['linkpage'] : '';
if ($linkpage){
    switch ($linkpage){
        case 'dschude':
            include_once 'layout/dschude.php';
            break;
        case 'addchude':
            include_once 'layout/addchude.php';
            break;
        case 'editchude':
            include_once 'layout/editchude.php';
            break;
        case 'dsloaidoan':
            include_once 'layout/dsloaidoan.php';
            break;
        case 'addloaidoan':
            include_once 'layout/addloaidoan.php';
            break;
        case 'editloaidoan':
            include_once 'layout/editloaidoan.php';
            break;
        case 'dskhoa':
            include_once 'layout/dskhoa.php';
            break;
        case 'addkhoa':
            include_once 'layout/addkhoa.php';
            break;
        case 'editkhoa':
            include_once 'layout/editkhoa.php';
            break;
        case 'dslop':
            include_once 'layout/dslop.php';
            break;
        case 'addlop':
            include_once 'layout/addlop.php';
            break;
        case 'editlop':
            include_once 'layout/editlop.php';
            break;
        case 'dsdoan':
            include_once 'layout/dsdoan.php';
            break;
        case 'adddoan':
            include_once 'layout/adddoan.php';
            break;
        case 'editdoan':
            include_once 'layout/editdoan.php';
            break;
        case 'dssv':
            include_once 'layout/dssv.php';
            break;
        case 'addsv':
            include_once 'layout/addsv.php';
            break;
        case 'editsv':
            include_once 'layout/editsv.php';
            break;
        case 'dsgv':
            include_once 'layout/dsgv.php';
            break;
        case 'addgv':
            include_once 'layout/addgv.php';
            break;
        case 'editgv':
            include_once 'layout/editgv.php';
            break;
        case 'menu':
            include_once 'layout/menu.php';
            break;
        case 'addmenu':
            include_once 'layout/addmenu.php';
            break;
        case 'editmenu':
            include_once 'layout/editmenu.php';
            break;
        case 'baiviet':
            include_once 'layout/baiviet.php';
            break;
        case 'addbaiviet':
            include_once 'layout/addbaiviet.php';
            break;
        case 'editbaiviet':
            include_once 'layout/editbaiviet.php';
            break;
        case 'cdhd':
            include_once 'layout/chamdiemhd.php';
            break;
        case 'cdpb':
            include_once 'layout/chamdiempb.php';
            break;
        case 'page404':
            include_once 'layout/404.php';
            break;
        case 'logout':
            unset($_SESSION['userService']);
            session_destroy();
            redirect_to('index.php');
            break;
        default: 
            redirect_to('/administrator/index.php');
            break;
    }
}else{
    include_once 'layout/trangchu.php';
}
?>
