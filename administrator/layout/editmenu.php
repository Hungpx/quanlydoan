<?php 

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$menu = new Model\Menu();
$menu->setId($_GET['id']);
$menuMapper = new Model\MenuMapper($connect);
if (! $menuMapper->get($menu)){
    redirect_to('administrator/index.php?linkpage=page404');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $menuMapper = new Model\MenuMapper($connect);
    $isValid = true;
    $messages = '';
    if ( empty($dataPost['tenMenu'])){
        $isValid = false;
        $messages = 'Bạn vui lòng nhập đầy đủ thông tin';
    }
    $menu = new Model\Menu();
    $menu->setId($_GET['id']);
    $menu->setTenMenu($dataPost['tenMenu']);
    if ($menuMapper->isExist($menu)){
        $isValid = false;
        $messages = 'Tên Menu đã tồn tại';
    }
    if ($isValid){
        $menu->setId($_GET['id']);
        $menu->setTenMenu($dataPost['tenMenu']);
        $menuMapper->save($menu);
        redirect_to('administrator/index.php?linkpage=menu');
    }   
}

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="<?= getLink('administrator/index.php?linkpage=dsmenu') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Danh sách Menu</a>
    <a href="#" class="current">Cập nhật menu</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Cập nhật menu</h5>
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
                  <label class="control-label">Tên Menu:</label>
                  <div class="controls">
                    <input type="text" value="<?= $menu->getTenMenu() ?>" name="tenMenu" id="requried" class="span11" placeholder="Tên Menu" /><span class="required">(*)</span>
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