<?php 
use Model\Lop;
use Model\LopMapper;
use Model\SinhvienMapper;
use Model\Sinhvien;
use Model\HuongdanMapper;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $sinhvien = new Sinhvien();
    $sinhvien->setId($id);
    $sinhvienMapper = new SinhvienMapper($connect);
    $data = [];
    if (! $id || ! $sinhvienMapper->get($sinhvien)){
        $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
        echo json_encode($data);
        return;
    }
    $huongdan = new Model\Huongdan();
    $huongdan->setMaSV($sinhvien->getId());
    $huongdanMapper = new HuongdanMapper($connect);
    if ($huongdanMapper->isExist($huongdan)){
        $data = ['code' => 0, 'messages' => ['Không thể xóa dữ liệu sinh viên này']];
        echo json_encode($data);
        return;
    }
    //Xóa danh sách đồ án sinh viên đã tham gia trước
    $sinhvienThamgia = new Model\SinhvienThamgia();
    $sinhvienThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
    $sinhvienThamgia->setMaSV($sinhvien->getId());
    $listSv = $sinhvienThamgiaMapper->fetchAll($sinhvienThamgia);
    if ($listSv){
        $data = ['code' => 0, 'messages' => ['Không thể xóa dữ liệu này sinh viên này']];
        echo json_encode($data);
        return;
    }
    if ($sinhvienMapper->delete($sinhvien)){
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

$sinhvien = new Sinhvien();
$sinhvienMapper = new SinhvienMapper($connect);
$listSV = $sinhvienMapper->fetchAll($sinhvien);

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
            <h5>Danh sách sinh viên</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=addsv') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="svTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Mã sinh viên</th>
                  <th>Tên sinh viên</th>
                  <th>Lớp</th>
                  <th>Khoa</th>
                  <th>Số điện thoại</th>
                  <th>Địa chỉ</th>
                  <th>Tài khoản</th>
                  <th>Trạng thái</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listSV){
              	     foreach ($listSV as $sinhvien){
              	?>
                <tr class="gradeX">
                  <td><?= $sinhvien->getId() ?></td>
                   <td><?= $sinhvien->getMaSV() ?></td>
                  <td><?= $sinhvien->getTenSV() ?></td>
                  <td><?= $sinhvien->getOption('tenLop') ?></td>
                  <td><?= $sinhvien->getOption('tenKhoa') ?></td>
                  <td><?= $sinhvien->getSoDT() ?></td>
                  <td><?= $sinhvien->getDiachi() ?></td>
                  <?php  $user = $sinhvien->getOption('user') ? : new Model\User(); ?>
                  <td><?= $user->getTaikhoan() ?></td>
                  <td>
                  <?php 
                    if ($user->getTrangthai() == Model\User::STATUS_ACTIVE){
                        echo '<a data-id="'.$user->getId().'" href="javascript:;" class="badge badge-success changeStatus"> đã kích hoạt</a>';
                    }else{
                         echo '<a data-id="'.$user->getId().'" href="javascript:;" class="badge badge-important changeStatus"> Chưa kích hoạt</a>';
                    }
                  ?>
                  </td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editsv&id='.$sinhvien->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $sinhvien->getId() ?>"></a></td>
                </tr>
               <?php }} ?>
              </tbody>
            </table>
          </div>
          
        </div>
        <div class="alert alert-waring">Nếu bạn muốn đổi trạng thái sinh viên, vui lòng <b>click vào trạng thái</b> đó.</div>
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
	            "<?= getLink('administrator/index.php?linkpage=dssv') ?>",
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
	$('.changeStatus').on('click',function(){
		if(confirm('Bạn có muốn đổi trạng thái tài khoản này?')){
			$.post(
		            "<?= getLink('administrator/postAjax.php?type=changestatususer') ?>",
		            {
		                'id' : $(this).attr('data-id'),
		            },
		            function(rs){
		            	var rs = JSON.parse(rs);
		                if(rs.code){
		                    window.location.reload();
		                }else {
		                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
		                    $("#alertModal").modal('show');
		                    $('#alertModal .modal-body').empty();
		                    $('#alertModal .modal-body').append(html);
		                } 
		            }
		        );
		}
	})
	$('#exportCSV').on('click',function(){
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'danh_sach_sinh_vien.csv'});
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