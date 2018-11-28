<?php 
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$id = !empty($_GET['id']) ? trim($_GET['id']) : '';
$baiviet = new Model\Baiviet();
$baiviet->setId($id);
$baivietMapper = new Model\BaivietMapper($connect);
if (! $baivietMapper->get($baiviet)){
    redirect_to('administrator/index.php?linkpage=page404');
}
$anhDaidien = $baiviet->getAnhDaiDien();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = $_POST;
    $baiviet = new Model\Baiviet();
    $baiviet->setId($id);
    $baivietMapper = new Model\BaivietMapper($connect);
    $isValid = true;
    $messages = '';
    $fileUpload = $_FILES['fileUpload'];
    if (empty($dataPost['tieude']) || empty($dataPost['menuId']) || empty($dataPost['mota']) || empty($dataPost['chitiet'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    if (!empty($fileUpload["name"])){
        $ext = end((explode(".", $fileUpload["name"])));
        $ext = strtolower($ext);
        if ($ext && ! in_array($ext, ['png', 'jpeg', 'jpg'])){
            $isValid = false;
            $messages = 'File Upload không đúng định dạng.';
        }
    }
    if ($isValid){
        $baiviet->exchangeArray($dataPost);
        if (!empty($fileUpload["name"])){
            $targetFolder = getSavePath('baiviet');
            if (!file_exists($targetFolder)) {
                $oldmask = umask(0);
                mkdir($targetFolder, 0777, true);
                umask($oldmask);
            }
            rename($fileUpload['tmp_name'], $targetFolder.'/'.$fileUpload['name']);
            $baiviet->setAnhDaiDien($fileUpload['name']);
        }else{
             $baiviet->setAnhDaiDien($anhDaidien);
        }
        $baivietMapper->save($baiviet);
        redirect_to('administrator/index.php?linkpage=baiviet');
    }
}
$userService = $_SESSION['userService'];
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=baiviet') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách bài viết</a>
    <a href="#" class="current">Cập nhật bài viết</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Thêm mới bài viết</h5>
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
          	<form action="" method="post"  enctype="multipart/form-data"  class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Tiêu đề:</label>
                  <div class="controls">
                    <input value="<?= $baiviet->getTieude(); ?>" type="text" name="tieude"  id="tieude" class="span11" placeholder="Tiêu đề" /><span class="required">(*)</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Menu:</label>
                  <div class="controls">
                  	<?php 
                  	$menu = new Model\Menu();
                  	$menuMapper = new Model\MenuMapper($connect);
                  	$dsMenu = $menuMapper->fetchAll($menu);
                  	?>
                 	<select name="menuId" id="menuId" >
                      <option>- Chọn Menu -</option>
                     <?php 
                        foreach ($dsMenu as $menu){
                            $selected = '';
                            if ($menu->getId() == $baiviet->getMenuId()){
                                $selected = 'selected';
                            }
                            echo '<option '.$selected.' value="'.$menu->getId().'">'.$menu->getTenMenu().'</option>';
                        }
                     ?>
                    </select>
                    <span class="required">(*)</span>
                  </div>
                </div>
               
                <div class="control-group">
                  <label class="control-label">Ảnh đại diện:</label>
                  <div class="controls">
                    <div class="uploader" id="uniform-undefined">
                    	<input name="fileUpload" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span>
                    	
                    </div>
                    	<i class="description">Chỉ upload File dạng ảnh .jpg, .jpeg, .png</i>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Mô tả:</label>
                  <div class="controls">
                  	<textarea name="mota" class=" span8" rows="6" placeholder="Mô tả ..."><?= $baiviet->getMota() ?></textarea>
                  	<span class="required">(*)</span>
                  </div>
                 </div>
                 <div class="control-group">
                  <label class="control-label">Chi tiết bài viết :</label>
                  <div class="controls">
                  	<textarea name="chitiet" class="textarea_editor span8" rows="10" placeholder="chi tiết bài viết..."><?= $baiviet->getChitiet() ?></textarea>
                  	<span class="required">(*)</span>
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
	$('.textarea_editor').wysihtml5();
})	
	
</script>