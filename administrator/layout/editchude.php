<?php 

use Model\Chude;
use Model\ChudeMapper;
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$chude = new Chude();
$chude->setId($_GET['id']);
$chudeMapper = new ChudeMapper($connect);
if (! $chudeMapper->get($chude)){
    redirect_to('administrator/index.php?linkpage=page404');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $isValid = true;
    if (empty($dataPost['maChude']) || empty($dataPost['tenChude'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $chude = new Chude();
    $chude->setId($_GET['id']);
    $chude->setMaChude($dataPost['maChude']);
    if ($chudeMapper->isExist($chude)){
        $isValid = false;
        $messages = 'Mã chủ đề đã tồn tại';
    }
    if ($isValid){
        $chude->setId($_GET['id']);
        $chude->exchangeArray($dataPost);
        $chudeMapper->save($chude);
        redirect_to('administrator/index.php?linkpage=dschude');
    }   
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dschude') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách chủ đề</a>
    <a href="#" class="current">Cập nhật chủ đề</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cập nhật chủ đề</h5>
          </div>
          <?php 
          if($_SERVER['REQUEST_METHOD'] == 'POST') {
              if ($isValid){
                  echo '<div class="alert alert-success">'.$messages.'</div>';
              }else{
                  echo '<div class="alert alert-danger">'.$messages.'</div>';
              }
          }
          ?>
          <div class="widget-content nopadding">
          	<form action="" method="post" class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Mã chủ đề :</label>
                  <div class="controls">
                    <input type="text" value="<?= $chude->getMaChude() ?>" name="maChude" id="maChude" class="span11" placeholder="Mã chủ đề" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tên chủ đề:</label>
                  <div class="controls">
                    <input type="text" value="<?= $chude->getTenChude() ?>" name="tenChude" id="requried" class="span11" placeholder="Tên chủ đề" /><span class="required">(*)</span>
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