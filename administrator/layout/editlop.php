<?php 
use Model\Lop;
use Model\LopMapper;
use Model\Khoa;
use Model\KhoaMapper;

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$lop = new Lop();
$lop->setId($_GET['id']);
$lopMapper = new LopMapper($connect);
if (! $lopMapper->get($lop)){
    redirect_to('administrator/index.php?linkpage=page404');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $lopMapper = new LopMapper($connect);
    $isValid = true;
    $messages = '';
    if (empty($dataPost['maLop'])|| empty($dataPost['maKhoa']) || empty($dataPost['tenLop'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $lop = new Lop();
    $lop->setId($_GET['id']);
    $lop->setMaLop($dataPost['maLop']);
    if ($lopMapper->isExist($lop)){
        $isValid = false;
        $messages = 'Mã lớp đã tồn tại';
    }
    if ($isValid){
        $lop->setId($_GET['id']);
        $lop->exchangeArray($dataPost);
        $lopMapper->save($lop);
        redirect_to('administrator/index.php?linkpage=dslop');
    }   
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dslop') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách lớp</a>
    <a href="#" class="current">Cập nhật lớp</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cập nhật lớp</h5>
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
                  <label class="control-label">Mã lớp :</label>
                  <div class="controls">
                    <input type="text" value="<?= $lop->getMaLop() ?>" name="maLop" id="maLop" class="span11" placeholder="Mã lớp" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tên lớp:</label>
                  <div class="controls">
                    <input type="text" value="<?= $lop->getTenLop() ?>" name="tenLop" id="requried" class="span11" placeholder="Tên lớp" /><span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Khoa:</label>
                  <div class="controls">
                  	<?php 
                  	$khoa = new Khoa();
                  	$khoaMapper = new KhoaMapper($connect);
                  	$dsKhoa = $khoaMapper->fetchAll($khoa);
                  	?>
                 	<select name="maKhoa" id="maKhoa" >
                      <option>- Chọn khoa -</option>
                     <?php 
                        foreach ($dsKhoa as $khoa){
                            $selected = '';
                            if ($khoa->getId() == $lop->getMaKhoa()){
                                $selected = 'selected';
                            }
                            echo '<option '.$selected.' value="'.$khoa->getId().'">'.$khoa->getMaKhoa().' - '.$khoa->getTenKhoa().'</option>';
                        }
                     ?>
                    </select>
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