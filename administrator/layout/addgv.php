<?php 
use Model\Giangvien;
use Model\GiangvienMapper;
use Model\User;
use Model\UserMapper;
use Model\Lop;
use Model\LopMapper;

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $giangvien = new Giangvien();
    $giangvienMapper = new GiangvienMapper($connect);
    $isValid = true;
    $messages = '';
    if (empty($dataPost['maGV']) || empty($dataPost['tenGV']) || empty($dataPost['email']) || empty($dataPost['soDT']) || empty($dataPost['chucvu']) || empty($dataPost['nhomquyen']) || empty($dataPost['matkhau'])){
        $isValid = false;
        $messages = 'Bạn cần nhập đầy đủ thông tin';
    }elseif (!isValidPhoneNumber($dataPost['soDT'])){
        $isValid = false;
        $messages = 'Số điện thoại không hợp lệ';
    }
    if ($isValid){
        $giangvien->setMaGV($dataPost['maGV']);
        if ($giangvienMapper->isExist($giangvien)){
            $isValid = false;
            $messages = 'Thông tin giảng viên đã tồn tại';
        }
    }
    
    if ($isValid){
        $user = new User();
        $user->setTaikhoan($dataPost['maGV']);
        $user->setMatkhau(md5($dataPost['matkhau']));
        $user->setTrangthai(Model\User::STATUS_ACTIVE);
        $user->setNhomquyen($dataPost['nhomquyen']);
        $userMapper = new UserMapper($connect);
        $userMapper->save($user);
        
        $giangvien->exchangeArray($dataPost);
        $giangvien->setMaTaikhoan($user->getId());
        $giangvienMapper->save($giangvien);
    }
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dssv') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách giảng viên</a>
    <a href="#" class="current">Thêm mới giảng viên</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Thêm mới giảng viên</h5>
          </div>
          <?php 
          if($_SERVER['REQUEST_METHOD'] == 'POST') {
              if ($isValid){
                  echo '<div class="alert alert-success">Thêm mới thành công</div>';
              }else{
                  echo '<div class="alert alert-danger">'.$messages.'</div>';
              }
          }
          ?>
          <div class="widget-content nopadding">
          	<form action="" method="post" class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Mã giảng viên :</label>
                  <div class="controls">
                    <input type="text" name="maGV" id="maGV" class="span11" placeholder="Mã giảng viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Họ tên:</label>
                  <div class="controls">
                    <input type="text" name="tenGV"  id="tenGV" class="span11" placeholder="Họ tên giảng viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Số điện thoại:</label>
                  <div class="controls">
                    <input type="text" name="soDT"  id="soDT" class="span11" placeholder="SĐT" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Emai:</label>
                  <div class="controls">
                    <input type="text" name="email"  id="email" class="span11" placeholder="Email" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Chức vụ:</label>
                  <div class="controls">
                    <input type="text" name="chucvu"  id="chucvu" class="span11" placeholder="Chức vụ" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Nhóm quyền:</label>
                  <div class="controls">
                 	<select name="nhomquyen" id="nhomquyen" >
                      <option>- Phân quyền -</option>
                     <?php 
                        $user = new Model\User();
                        $listNhomQuyen = $user->getDsNhomquyen();
                        unset($listNhomQuyen[Model\User::ROLE_STUDENT]);
                        foreach ($listNhomQuyen as $idNhomquyen => $tenNhomquyen){
                            echo '<option value="'.$idNhomquyen.'">'.$tenNhomquyen.'</option>';
                        }
                     ?>
                    </select><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Mật khẩu:</label>
                  <div class="controls">
                    <input type="password" name="matkhau"  id="matkhau" class="span11" /><span class="required">(*)</span>
                  </div>
                </div>
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