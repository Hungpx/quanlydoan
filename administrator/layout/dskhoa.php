<?php 

use Model\Khoa;
use Model\KhoaMapper;
use Model\Lop;
use Model\LopMapper;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $khoa = new Khoa();
    $khoa->setId($id);
    $khoaMapper = new KhoaMapper($connect);
    $data = [];
    if (! $id || ! $khoaMapper->get($khoa)){
        $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
        echo json_encode($data);
        return;
    }
    $lop = new Lop();
    $lopMapper = new LopMapper($connect);
    $lop->setMaKhoa($khoa->getId());
    if ($lopMapper->isExist($lop)){
        $data['code'] = 0;
        $data['messages'] = 'khoa <b class="text-danger">'.$khoa->getTenKhoa().'</b> đang có lớp <b class="text-success">'.$lop->getTenLop().'</b> sử dụng, cần xóa lớp trước.';
        echo json_encode($data);
        return;
    }
    if ($khoaMapper->delete($khoa)){
        $data['code'] = 1;
        $data['messages'] = 'Xóa thành công';
        echo json_encode($data);
        return;
    }else{
        $data['code'] = 0;
        $data['messages'] = 'Có lỗi khi xóa dữ liệu';
        echo json_encode($data);
        return;
    }
    echo json_encode($data);
    return;
}

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';

$khoa = new Khoa();
$khoaMapper = new KhoaMapper($connect);
$listKhoa = $khoaMapper->fetchAll($khoa);

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
            <h5>Danh sách khoa</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=addkhoa') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="KhoaTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Mã khoa</th>
                  <th>Tên khoa</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listKhoa){
              	     foreach ($listKhoa as $khoa){
              	?>
                <tr class="gradeX">
                	<td><?= $khoa->getId() ?></td>
                  <td><?= $khoa->getMaKhoa() ?></td>
                  <td><?= $khoa->getTenKhoa() ?></td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editkhoa&id='.$khoa->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $khoa->getId() ?>"></a></td>
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
	            "<?= getLink('administrator/index.php?linkpage=dskhoa') ?>",
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
	$('#exportCSV').on('click',function(){
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'danh_sach_khoa.csv'});
	  })
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