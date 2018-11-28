<?php 
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
use Model\LoaiDoan;
use Model\LoaiDoanMapper;
use Model\Chude;
use Model\ChudeMapper;
use Model\Giangvien;
use Model\GiangvienMapper;
use Model\Doan;
use Model\DoanMapper;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $doan = new Doan();
    $doanMapper = new DoanMapper($connect);
    $isValid = true;
    $messages = '';
    if (empty($dataPost['tenDoan']) || empty($dataPost['maLoai']) || empty($dataPost['maChude']) || empty($dataPost['giangvienHD']) || empty($dataPost['ngayHetHan'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $doan->setTenDoan($dataPost['tenDoan']);
    if ($doanMapper->isExist($doan)){
        $isValid = false;
        $messages = 'Thông tin đề tài đã tồn tại';
    }
    if ($isValid){
        $doan->exchangeArray($dataPost);
        $doan->setNgayHetHan(toCommonDate($dataPost['ngayHetHan']));
        $doanMapper->save($doan);
    }
}
$userService = $_SESSION['userService'];
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dsdoan') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách đồ án</a>
    <a href="#" class="current">Thêm mới đồ án</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Thêm mới đồ án</h5>
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
                  <label class="control-label">Tên đề tài:</label>
                  <div class="controls">
                    <input type="text" name="tenDoan"  id="tenLop" class="span11" placeholder="Tên đề tài" /><span class="required">(*)</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Loại đồ án:</label>
                  <div class="controls">
                  	<?php 
                  	$loaiDoan = new LoaiDoan();
                  	$loaiDoanMapper = new LoaiDoanMapper($connect);
                  	$dsLoaiDoan = $loaiDoanMapper->fetchAll($loaiDoan);
                  	?>
                 	<select name="maLoai" id="maLoai" >
                      <option>- Chọn Loại -</option>
                     <?php 
                        foreach ($dsLoaiDoan as $loai){
                            echo '<option value="'.$loai->getId().'">'.$loai->getMaLoai().' - '.$loai->getTenLoai().'</option>';
                        }
                     ?>
                    </select>
                    <span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Chủ đề:</label>
                  <div class="controls">
                  	<?php 
                  	$chude = new Chude();
                  	$chudeMapper = new ChudeMapper($connect);
                  	$dsChude = $chudeMapper->fetchAll($chude);
                  	?>
                 	<select name="maChude" id="maChude" >
                      <option>- Chọn chủ đề -</option>
                     <?php 
                        foreach ($dsChude as $chude){
                            echo '<option value="'.$chude->getId().'">'.$chude->getMaChude().' - '.$chude->getTenChude().'</option>';
                        }
                     ?>
                    </select>
                    <span class="required">(*)</span>
                  </div>
                </div>
                <?php if ($userService['nhomquyen'] == Model\User::ROLE_ADMIN){ ?>
                <div class="control-group">
                  <label class="control-label">Giảng viên hướng dẫn:</label>
                  <div class="controls">
                  	<?php 
                  	$giangvien = new Giangvien();
                  	$giangvienMapper = new GiangvienMapper($connect);
                  	$dsgiangvien = $giangvienMapper->search($giangvien);
                  	?>
                 	<select name="giangvienHD" id="giangvienHD" >
                      <option>- Chọn giảng viên hướng dẫn-</option>
                     <?php 
                        foreach ($dsgiangvien as $giangvien){
                            echo '<option value="'.$giangvien->getId().'">'.$giangvien->getMaGV().' - '.$giangvien->getTenGV().'</option>';
                        }
                     ?>
                    </select>
                    <span class="required">(*)</span>
                  </div>
                </div>
                <?php }else{?>
                <input type="hidden" name="giangvienHD" value="<?= $userService['id']; ?>" /> 
                <?php }?>
                <?php $dateTime = new \DateTime(); ?>
                <div class="control-group">
                  <label class="control-label">Ngày hết hạn:</label>
                  <div class="controls">
                    <input type="text" name="ngayHetHan" data-date-format="dd/mm/yyyy" class="datepicker"  id="ngayHetHan" class="span11"  />
                     <span class="required">(*)</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Năm ra đề:</label>
                  <div class="controls">
                  	
                  	<select name="namRaDe"  id="namRaDe" class="span11">
                  		<?php 
                  		    for ($i=2010;$i <= 2030; $i++){
                  		        $selected = '';
                  		        if ($dateTime->format('Y') == $i){
                  		            $selected = 'selected';
                  		        }
                  		        echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
                  		    }
                  		?>
                  	</select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Số sinh viên tối đa:</label>
                  <div class="controls">
                    <input type="text" name="soSVThamGia"  id="soSVThamGia" class="span11" value="10" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Mô tả yêu cầu:</label>
                  <div class="controls">
                  	<textarea name="yeucau" class="textarea_editor span8" rows="6" placeholder="Mô tả yêu cầu chi tiết đồ án ..."></textarea>
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
<script type="text/javascript">
$(function(){
	 $('.datepicker').datepicker();
	//$('.textarea_editor').wysihtml5();
})	
	
</script>