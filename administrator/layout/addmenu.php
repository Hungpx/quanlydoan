<?php 
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $menu = new Model\Menu();
    $menu->exchangeArray($dataPost);
    $menuMapper = new Model\MenuMapper($connect);
    $isValid = true;
    $messages = '';
    if (! $menu->getTenMenu()){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin.';
    }
    if ($menuMapper->isExist($menu)){
        $isValid = false;
        $messages = 'Thông tin đã tồn tại.';
    }
    if ($isValid){
        $menuMapper->save($menu);
    }
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=menu') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách menu</a>
    <a href="#" class="current">Thêm mới Menu</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Thêm mới Menu</h5>
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
          	<form action="" method="post" class="form-horizontal"  novalidate="novalidate">
                <div class="control-group">
                  <label class="control-label">Tên Menu:</label>
                  <div class="controls">
                    <input type="text" name="tenMenu" id="requried" class="span11" placeholder="Tên Menu" /><span class="required">(*)</span>
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