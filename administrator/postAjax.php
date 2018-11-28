<?php
ob_start();
session_start();
include_once '../Model/Base/Function.php';
include_once '../Model/User.php';
include_once '../Model/UserMapper.php';
include_once '../Model/Doan.php';
include_once '../Model/DoanMapper.php';
include_once '../Model/SinhvienThamgia.php';
include_once '../Model/SinhvienThamgiaMapper.php';
include_once '../Model/Huongdan.php';
include_once '../Model/HuongdanMapper.php';
include_once '../Model/PhanBien.php';
include_once '../Model/PhanBienMapper.php';
use Model\UserMapper;
$type = trim($_GET['type']);
if ($type){
    switch ($type){
        case 'changestatususer':
            echo json_encode(changeStatusUser(trim($_POST['id']),$connect)) ;
            break;
        case 'registerdoan':
            echo json_encode(registerDoan(trim($_POST['id']),$connect)) ;
            break;
        case 'chamdiemhd':
            echo json_encode(addDiemHD($_POST,$connect)) ;
            break;
        case 'changestatusHD':
            echo json_encode(changeStatusHD($_POST,$connect)) ;
            break;
        case 'addhdpb':
            echo json_encode(addHDPB($_POST,$connect)) ;
            break;
        case 'chamdiempb':
            echo json_encode(addDiemPb($_POST,$connect)) ;
            break;
        case 'changestatusPB':
            echo json_encode(changeStatusPB($_POST,$connect)) ;
            break;
    }
}
function changeStatusUser($id,$connect){
    $user = new Model\User();
    $user->setId($id);
    $userMapper = new UserMapper($connect);
    if (!$id || ! $userMapper->get($user)){
        return ['code' => 0, 'messages' => 'Không có dữ liệu'];
    }
    if ($user->getTrangthai() == Model\User::STATUS_ACTIVE){
        $user->setTrangthai(Model\User::STATUS_INACTIVE);
        $userMapper->save($user);
    }else{
        $user->setTrangthai(Model\User::STATUS_ACTIVE);
        $userMapper->save($user);
    }
    return ['code' => 1, 'messages' => 'Thay đổi trạng thái thành công!'];
}

function registerDoan($id,$connect){
    $doan = new Model\Doan();
    $doan->setId($id);
    $doan->addOption('loadTotalSV', true); //Lấy dữ liệu số lượng sv đăng ký
    $doanMapper = new Model\DoanMapper($connect);
    if (! $id || ! $doanMapper->get($doan)){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    $userService = ! empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
    if (! $userService){
        return ['code' => 0, 'messages' => 'Bạn vui lòng đăng nhập trước khi thực hiện chức năng này'];
    }
    if ($userService['nhomquyen'] != Model\User::ROLE_STUDENT){
        return ['code' => 0, 'messages' => 'Đăng ký đồ án chỉ áp dụng cho sinh viên'];
    }
    
    if ($doan->getNgayHetHan() < getCurrentDate()){
        return ['code' => 0, 'messages' => 'Đã hết hạn đăng ký đồ án'];
    }
    if ($doan->getOption('totalSV') && $doan->getOption('totalSV') >= $doan->getSoSVThamGia()){
        return ['code' => 0, 'messages' => 'Đã đủ số lượng sinh viên đăng ký đồ án này'];
    }
    $svThamgia = new Model\SinhvienThamgia();
    $svThamgia->setMaDoan($doan->getId());
    $svThamgia->setMaSV($userService['id']);
    $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
    if ($svThamgiaMapper->isExist($svThamgia)){
        return ['code' => 0, 'messages' => 'Bạn đã đăng ký đồ án này rồi'];
    }
    
    if ($doan->getMaLoai() == 4){
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 4);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if ($svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn đã đăng ký đồ án học phần 1 trong năm nay rồi.'];
        }
    }
    
    //Nếu đăng ký học phần 2 cần check học phần 1
    if ($doan->getMaLoai() == 5){
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 5);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if ($svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn đã đăng ký đồ án học phần 2 trong năm nay rồi.'];
        }
        
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 4);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if (! $svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn chưa đăng ký đồ án học phần 1, chưa thể đăng ký đồ án học phần 2'];
        }
    }
    //Nếu đăng ký học phần 2 cần check học phần 1
    if ($doan->getMaLoai() == 6){
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 6);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if ($svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn đã đăng ký đồ án thực tập tốt nghiệp trong năm nay rồi.'];
        }
        
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 5);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if (! $svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn chưa đăng ký đồ án học phần 2, chưa thể đăng ký thực tập tốt nghiệp'];
        }
    }
    
    //Nếu đăng ký học phần 2 cần check học phần 1
    if ($doan->getMaLoai() == 7){
        
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 7);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if ($svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn đã đăng ký luận văn tốt nghiệp trong năm nay rồi.'];
        }
        
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->setMaSV($userService['id']);
        $svThamgia->addOption('maLoai', 6);
        $svThamgia->addOption('namRaDe', date('Y'));
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if (! $svThamgiaMapper->isExist($svThamgia)){
            return ['code' => 0, 'messages' => 'Bạn chưa đăng ký đồ án thực tập tốt nghiệp, chưa thể đăng ký đồ án luận văn tốt nghiệp'];
        }
    }
    $svThamgia = new Model\SinhvienThamgia();
    $svThamgia->setMaDoan($doan->getId());
    $svThamgia->setMaSV($userService['id']);
    $svThamgia->setTenDoan($doan->getTenDoan());
    $svThamgia->setLanThamGia(1);
    $svThamgia->setTrangthai(Model\SinhvienThamgia::STATUS_NEW);
    $svThamgia->setTenSV($userService['ten']);
    $svThamgiaMapper->save($svThamgia);
    
    $huongdan = new Model\Huongdan();
    $huongdan->setMaDoan($doan->getId());
    $huongdan->setMaSV($userService['id']);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    if (! $huongdanMapper->isExist($huongdan)){
        $huongdan->setMaGV($doan->getGiangvienHD());
        $huongdan->setTrangthai(Model\Huongdan::STATUS_NEW);
        $huongdan->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_NEW);
        $huongdanMapper->save($huongdan);
    }
    $phanBien = new Model\PhanBien();
    $phanBien->setMaDoan($doan->getId());
    $phanBien->setMaSV($userService['id']);
    $phanBienMapper = new Model\PhanBienMapper($connect);
    if (! $phanBienMapper->isExist($phanBien)){
        $phanBien->setTrangthai( Model\PhanBien::STATUS_NEW);
        $phanBienMapper->save($phanBien);
    }
    
    return ['code' => 1, 'messages' => 'Đăng ký thành công'];
}

function addDiemHD($postData,$connect){
    if (empty($postData['maSV']) || empty($postData['maDoan']) || empty($postData['diem'])){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    $diem = (float)$postData['diem'];
    if (!$diem){
        return ['code' => 0, 'messages' => 'Bạn chưa điền điểm'];
    }
    $huongdan = new Model\Huongdan();
    $huongdan->setMaDoan($postData['maDoan']);
    $huongdan->setMaSV($postData['maSV']);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    if (! $huongdanMapper->isExist($huongdan)){
        return ['code' => 0, 'messages' => 'Không tìm thấy thông tin hướng dẫn'];
    }
    $huongdan->exchangeArray($postData);
    $huongdan->setDiem($diem);
    $huongdan->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_NOT_ALLOW);
    $huongdanMapper->save($huongdan);
    return ['code' => 1, 'messages' => 'Chấm điểm thành công'];
}

function changeStatusHD($postData, $connect){
    if (empty($postData['maSV']) || empty($postData['maDoan'])){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    $huongdan = new Model\Huongdan();
    $huongdan->setMaDoan($postData['maDoan']);
    $huongdan->setMaSV($postData['maSV']);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    if (! $huongdanMapper->isExist($huongdan)){
        return ['code' => 0, 'messages' => 'Không tìm thấy thông tin hướng dẫn'];
    }
    if ($huongdan->getTrangthaiSua() == Model\Huongdan::EDIT_STATUS_NEW){
         return ['code' => 0, 'messages' => 'Không cập nhật trạng thái mới'];
    }
    if ($huongdan->getTrangthaiSua() == Model\Huongdan::EDIT_STATUS_NOT_ALLOW){
        $huongdan->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_ALLOW);
    }else{
        $huongdan->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_NOT_ALLOW);
    }
    $huongdanMapper->save($huongdan);
    return ['code' => 1, 'messages' => 'Update Thành công'];
}

function addHDPB($postData, $connect){
    if (empty($postData['maSV']) || empty($postData['maDoan'])){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    if (empty($postData['maGVPB1']) || empty($postData['maGVPB2']) || empty($postData['maGVPB3'])){
        return ['code' => 0, 'messages' => 'Vui lòng chọn đầy đủ thông tin giảng viên phản biện.'];
    }

    $phanbien = new Model\PhanBien();
    $phanbien->setMaDoan($postData['maDoan']);
    $phanbien->setMaSV($postData['maSV']);
    $phanbienMapper = new Model\PhanBienMapper($connect);
    $phanbienMapper->isExist($phanbien);
    $phanbien->exchangeArray($postData);
    $phanbien->setTrangthai(Model\PhanBien::STATUS_NEW);
    $phanbien->setTrangthaiSua(Model\PhanBien::EDIT_STATUS_NEW);
    $phanbienMapper->save($phanbien);
    
    $huongdan = new Model\Huongdan();
    $huongdan->setMaDoan($postData['maDoan']);
    $huongdan->setMaSV($postData['maSV']);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    if ($huongdanMapper->isExist($huongdan)){
        $huongdan->setTrangthai(Model\Huongdan::STATUS_DONE_PHANBIEN);
        $huongdanMapper->save($huongdan);
    }
    return ['code' => 1, 'messages' => 'Update Thành công'];
}

function changeStatusPB($postData, $connect){
    if (empty($postData['maSV']) || empty($postData['maDoan'])){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    $phanbien = new Model\PhanBien();
    $phanbien->setMaDoan($postData['maDoan']);
    $phanbien->setMaSV($postData['maSV']);
    $phanbienMapper = new Model\PhanBienMapper($connect);
    if (! $phanbienMapper->isExist($phanbien)){
        return ['code' => 0, 'messages' => 'Không tìm thấy thông tin'];
    }
    if ($phanbien->getTrangthaiSua() == Model\Huongdan::EDIT_STATUS_NEW){
        return ['code' => 0, 'messages' => 'Không cập nhật trạng thái mới'];
    }
    if ($phanbien->getTrangthaiSua() == Model\Huongdan::EDIT_STATUS_NOT_ALLOW){
        $phanbien->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_ALLOW);
    }else{
        $phanbien->setTrangthaiSua(Model\Huongdan::EDIT_STATUS_NOT_ALLOW);
    }
    $phanbienMapper->save($phanbien);
    return ['code' => 1, 'messages' => 'Update Thành công'];
}

function addDiemPb($postData, $connect){
    if (empty($postData['maSV']) || empty($postData['maDoan']) || empty($postData['type'])){
        return ['code' => 0, 'messages' => 'Dữ liệu không hợp lệ'];
    }
    $diem = (float)$postData['diem'];
    if (!$diem){
        return ['code' => 0, 'messages' => 'Bạn chưa điền điểm'];
    }
    $huongdan = new Model\Huongdan();
    $huongdan->setMaDoan($postData['maDoan']);
    $huongdan->setMaSV($postData['maSV']);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    if (! $huongdanMapper->isExist($huongdan)){
        return ['code' => 0, 'messages' => 'Không tìm thấy thông tin hướng dẫn'];
    }
    $phanbien = new Model\PhanBien();
    $phanbien->setMaDoan($postData['maDoan']);
    $phanbien->setMaSV($postData['maSV']);
    $phanbienMapper = new Model\PhanBienMapper($connect);
    if (! $phanbienMapper->isExist($phanbien)){
        return ['code' => 0, 'messages' => 'Không tìm thấy thông tin'];
    }
    $phanbien->exchangeArray($postData);
    switch ($postData['type']){
        case 1:
            $phanbien->setDiemPB1($diem);
            break;
        case 2:
            $phanbien->setDiemPB2($diem);
            break;
        case 3:
            $phanbien->setDiemPB3($diem);
            break;
    }
    $phanbien->setTrangthaiSua(Model\PhanBien::EDIT_STATUS_NOT_ALLOW);
    if ($phanbien->getDiemPB1() && $phanbien->getDiemPB2() && $phanbien->getDiemPB3()){
        $totalDiem = ($huongdan->getDiem() * 0.035) + (($phanbien->getDiemPB1() + $phanbien->getDiemPB2() + $phanbien->getDiemPB3())*0.65/3);
        if ($totalDiem > 5){
            $phanbien->setTrangthai(Model\PhanBien::STATUS_DONE);
        }else{
            $phanbien->setTrangthai(Model\PhanBien::STATUS_NOT_DONE);
        }
    }
    $phanbienMapper->save($phanbien);
    return ['code' => 1, 'messages' => 'Chấm điểm thành công'];
}