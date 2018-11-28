<?php 

use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$sinhvien = new Sinhvien();
$sinhvien->setId($_GET['id']);
$sinhvienMapper = new SinhvienMapper($connect);
if (! $sinhvienMapper->get($sinhvien)){
    redirect_to('administrator/index.php?linkpage=page404');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $isValid = true;
    $messages = '';
     if (empty($dataPost['maSV']) || empty($dataPost['tenSV']) || empty($dataPost['maLop']) || empty($dataPost['soDT'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $sinhvien = new Sinhvien();
    $sinhvien->setId($_GET['id']);
    $sinhvien->setMaSV($dataPost['maSV']);
    if ($sinhvienMapper->isExist($sinhvien)){
        $isValid = false;
        $messages = 'Mã SV đã tồn tại';
    }
    if ($isValid){
        $sinhvien->exchangeArray($dataPost);
        $sinhvienMapper->save($sinhvien);
        $user = new User();
        $user->setId($sinhvien->getMaTaikhoan());
        $userMapper = new UserMapper($connect);
        if ($userMapper->get($user)){
            $user->setTaikhoan($dataPost['maSV']);
            $userMapper->save($user);
        }
        redirect_to('administrator/index.php?linkpage=dssv');
    }   
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dssv') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách sinh viên</a>
    <a href="#" class="current">Cập nhật sinh viên</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cập nhật sinh viên</h5>
          </div>
          <?php 
          if($_SERVER['REQUEST_METHOD'] == 'POST') {
              if ($isValid){
                  echo '<div class="alert alert-success">'.$messages.'</div>';
              }else{
                  echo '<div class="alert alert-danger">'.$messages.'</div>';
              }
          }
          $sinhvien = new Sinhvien();
          $sinhvien->setId($_GET['id']);
          $sinhvienMapper->get($sinhvien);
          ?>
          
          <div class="widget-content nopadding">
          	<form action="" method="post" class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Mã sinh viên :</label>
                  <div class="controls">
                    <input type="text" value="<?= $sinhvien->getMaSV() ?>" name="maSV" id="maSV" class="span11" placeholder="Mã sinh viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Họ tên sinh viên:</label>
                  <div class="controls">
                    <input type="text" name="tenSV" value="<?= $sinhvien->getTenSV() ?>" id="tenSV" class="span11" placeholder="Họ tên sinh viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Số điện thoại:</label>
                  <div class="controls">
                    <input type="text" name="soDT" value="<?= $sinhvien->getSoDT() ?>" id="soDT" class="span11" placeholder="SĐT" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Lớp:</label>
                  <div class="controls">
                  	<?php 
                  	$lop = new Lop();
                  	$lopMapper = new LopMapper($connect);
                  	$dsLop = $lopMapper->fetchAll($lop);
                  	?>
                 	<select name="maLop" id="maLop" >
                      <option>- Lớp -</option>
                     <?php 
                        foreach ($dsLop as $lop){
                            $selected = '';
                            if ($sinhvien->getMaLop() == $lop->getId()){
                                $selected = 'selected';
                            }
                            echo '<option '.$selected.' value="'.$lop->getId().'">'.$lop->getMaLop().' - '.$lop->getTenLop().'</option>';
                        }
                     ?>
                    </select><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Địa chỉ:</label>
                  <div class="controls">
                    	<textarea name="diachi" class="textarea_editor span8" rows="6" placeholder="Địa chỉ ..."><?= $sinhvien->getDiachi(); ?></textarea>
                  </div>
                </div>
                <input type="hidden" name="maTaikhoan" value="<?= $sinhvien->getMaTaikhoan() ?>">
                <div class="form-actions">
                  <button type="submit" value="Validate" class="btn btn-success">Lưu</button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="alertModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type='button' class='btn btn-default reload'
                        data-dismiss='modal'>Đóng</button>
            </div>
        </div>
    </div>
</div>
<style>
.required{
	color:red;
}
</style>
<?php include_once 'layout/frame/footer.php';?>