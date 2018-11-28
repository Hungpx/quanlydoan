<?php 

use Model\Khoa;
use Model\KhoaMapper;



include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $khoa = new Khoa();
    $khoaMapper = new KhoaMapper($connect);
    $isValid = true;
    $messages = '';
    if (empty($dataPost['maKhoa']) || empty($dataPost['tenKhoa'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $khoa->setMaKhoa($dataPost['maKhoa']);
    if ($khoaMapper->isExist($khoa)){
        $isValid = false;
        $messages = 'Thông tin đã tồn tại';
    }
    if ($isValid){
        $khoa->exchangeArray($dataPost);
        $khoaMapper->save($khoa);
    }
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dskhoa') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách khoa</a>
    <a href="#" class="current">Thêm mới khoa</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Thêm mới khoa</h5>
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
                  <label class="control-label">Mã khoa :</label>
                  <div class="controls">
                    <input type="text" name="maKhoa" id="maKhoa" class="span11" placeholder="Mã khoa" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tên khoa:</label>
                  <div class="controls">
                    <input type="text" name="tenKhoa"  id="tenKhoa" class="span11" placeholder="Tên khoa" /><span class="required">(*)</span>
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