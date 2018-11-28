<?php 
use Model\MenuMapper;
use Model\Menu;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $menu = new Model\Menu();
    $menu->setId($id);
    $menuMapper = new MenuMapper($connect);
    $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
    if (! $id || ! $menuMapper->get($menu)){
        echo json_encode($data);
        return;
    }
    $baiviet = new Model\Baiviet();
    $baiviet->setMenuId($menu->getId());
    $baivietMapper = new Model\BaivietMapper($connect);
    if ($baivietMapper->isExist($baiviet)){
        $data['code'] = 0;
        $data['messages'] = 'Cần xóa bài viết trước khi xóa Menu này.';
        echo json_encode($data);
        return;
    }
    if ($menuMapper->delete($menu)){
        $data['code'] = 1;
        $data['messages'] = 'Xóa thành công.';
        echo json_encode($data);
        return;
    }else{
        $data['code'] = 0;
        $data['messages'] = 'Có lỗi khi xóa dữ liệu.';
    }

    echo json_encode($data);
    return;
}
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';

$menu = new Menu();
$menuMapper = new MenuMapper($connect);
$listMenu = $menuMapper->fetchAll($menu);
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php getLink('administrator/index.php') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Trang chủ</a></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
              <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Danh sách menu</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=addmenu') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
            </div>
            <table id="loaidoanTable" class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên Menu</th>
                  <th>SL bài viết</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listMenu){
              	     foreach ($listMenu as $menu){
              	?>
                <tr class="gradeX">
                  <td><?= $menu->getId() ?></td>
                  <td><?= $menu->getTenMenu() ?></td>
                  <td style="text-align: center;"><span class="badge badge-success"><?= $menu->getOption('totalBaiviet')?></span></td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editmenu&id='.$menu->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $menu->getId() ?>"></a></td>
                </tr>
               <?php }} ?>
              </tbody>
            </table>
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
<?php include_once 'layout/frame/footer.php';?>

<script type="text/javascript">
$(function(){
	$('.removeItem').on('click', function(){
		var item = $(this);
		$.post(
	            "<?= getLink('administrator/index.php?linkpage=menu') ?>",
	            {
	                'id' : $(this).attr('data-id'),
	            },
	            function(rs){
	            	var rs = JSON.parse(rs);
	                if(rs.code){
	                    item.closest('tr').remove();
	                }else {
	                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
	                    $("#alertModal").modal('show');
	                    $('#alertModal .modal-body').empty();
	                    $('#alertModal .modal-body').append(html);
	                } 
	            }
	        );
	});
	
})
</script>
<style>
.fr-btn-action{
	float:left;
	margin-top: 45px;
    margin-bottom: 15px;
    margin-left: 20px;
}
</style>