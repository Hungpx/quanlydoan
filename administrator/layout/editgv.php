<?php 

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$giangvien = new Model\Giangvien();
$giangvien->setId($_GET['id']);
$giangvienMapper = new Model\GiangvienMapper($connect);
if (! $giangvienMapper->get($giangvien)){
    redirect_to('administrator/index.php?linkpage=page404');
}
$user = new Model\User();
$user->setId($giangvien->getMaTaikhoan());
$userMapper = new Model\UserMapper($connect);
$userMapper->get($user);
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $isValid = true;
    $messages = '';
    if (empty($dataPost['maGV']) || empty($dataPost['tenGV']) || empty($dataPost['email']) || empty($dataPost['soDT']) || empty($dataPost['chucvu']) || empty($dataPost['nhomquyen'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $giangvien = new Model\Giangvien();
    $giangvien->setId($_GET['id']);
    $giangvien->setMaGV($dataPost['maGV']);
    if ($giangvienMapper->isExist($giangvien)){
        $isValid = false;
        $messages = 'Mã giảng viên đã tồn tại';
    }
    if ($isValid){
        $user->setTaikhoan($dataPost['maGV']);
        $user->setNhomquyen($dataPost['nhomquyen']);
        $userMapper = new Model\UserMapper($connect);
        $userMapper->save($user);

        $giangvien->exchangeArray($dataPost);
        $giangvien->setMaTaikhoan($user->getId());
        $giangvienMapper->save($giangvien);
        redirect_to('administrator/index.php?linkpage=dsgv&id='.$giangvien->getId());
    }   
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dsgv') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách giảng viên</a>
    <a href="#" class="current">Cập nhật giảng viên</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cập nhật giảng viên</h5>
          </div>
          <?php 
             if($_SERVER['REQUEST_METHOD'] == 'POST') {
                  if ($isValid){
                      echo '<div class="alert alert-success">'.$messages.'</div>';
                  }else{
                      echo '<div class="alert alert-danger">'.$messages.'</div>';
                  }
            }
            $giangvien = new Model\Giangvien();
            $giangvien->setId($_GET['id']);
            $giangvienMapper = new Model\GiangvienMapper($connect);
            $giangvienMapper->get($giangvien);
          ?>
          
          <div class="widget-content nopadding">
          	<form action="" method="post" class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Mã giảng viên :</label>
                  <div class="controls">
                    <input type="text" value="<?= $giangvien->getMaGV() ?>" name="maGV" id="maGV" class="span11" placeholder="Mã giảng viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Họ tên:</label>
                  <div class="controls">
                    <input type="text" value="<?= $giangvien->getTenGV() ?>"  name="tenGV"  id="tenGV" class="span11" placeholder="Họ tên giảng viên" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Số điện thoại:</label>
                  <div class="controls">
                    <input type="text" value="<?= $giangvien->getSoDT() ?>"  name="soDT"  id="soDT" class="span11" placeholder="SĐT" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Emai:</label>
                  <div class="controls">
                    <input type="text" value="<?= $giangvien->getEmail() ?>"  name="email"  id="email" class="span11" placeholder="Email" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Chức vụ:</label>
                  <div class="controls">
                    <input type="text" value="<?= $giangvien->getChucvu() ?>"  name="chucvu"  id="chucvu" class="span11" placeholder="Chức vụ" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Nhóm quyền:</label>
                  <div class="controls">
                 	<select name="nhomquyen" id="nhomquyen" >
                      <option>- Phân quyền -</option>
                     <?php 
                        $listNhomQuyen = $user->getDsNhomquyen();
                        unset($listNhomQuyen[Model\User::ROLE_STUDENT]);
                        foreach ($listNhomQuyen as $idNhomquyen => $tenNhomquyen){
                            $selected = '';
                            if ($user->getNhomquyen() == $idNhomquyen){
                                $selected = 'selected';
                            }
                            echo '<option '.$selected.' value="'.$idNhomquyen.'">'.$tenNhomquyen.'</option>';
                        }
                     ?>
                    </select><span class="required">(*)</span>
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