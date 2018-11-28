<?php 

use Model\SinhvienThamgia;
use Model\SinhvienThamgiaMapper;
use Model\DoanMapper;
use Model\Doan;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $doan = new Doan();
    $doan->setId($id);
    $doanMapper = new DoanMapper($connect);
    $data = [];
    if (! $id || ! $doanMapper->get($doan)){
        $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
        echo json_encode($data);
        return;
    }
    $sinhvienThamGia = new SinhvienThamgia();
    $sinhvienThamgiaMapper = new SinhvienThamgiaMapper($connect);
    $sinhvienThamGia->setMaDoan($doan->getId());
    if ($sinhvienThamgiaMapper->isExist($sinhvienThamGia)){
        $data['code'] = 0;
        $data['messages'] = 'Đồ án <b class="text-danger">'.$doan->getTenDoan().'</b> đang được sử dụng, không thể xóa.';
        echo json_encode($data);
        return;
    }
    if ($doanMapper->delete($doan)){
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
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
$doan = new Doan();
if (isGiangvien($userService)){
    $doan->setGiangvienHD($userService['id']);
}
$doan->exchangeArray($_GET);
$doanMapper = new DoanMapper($connect);
$listDoan = $doanMapper->fetchAll($doan);
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
            <h5>Danh sách đồ án</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=adddoan') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="doanTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên đề tài</th>
                  <th>Loại đồ án</th>
                  <th>Chủ đề</th>
                  <th>Giảng viên hướng dẫn</th>
                  <th>Ngày hết hạn</th>
                  <th>Năm ra đề</th>
                  <th>Số Sinh viên cho phép</th>
                  <th>Số Sinh viên đã đăng ký</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listDoan){
              	     foreach ($listDoan as $doan){
              	?>
                <tr class="gradeX">
                  <td><?=$doan->getId() ?></td>
                  <td><b><?= $doan->getTenDoan() ?></b></td>
                  <td><span class="btn btn-info btn-mini"><?= $doan->getOption('tenLoai') ?></span></td>
                  <td><span class="date badge badge-success"><?= $doan->getOption('tenChude') ?></span></td>
                  <td><?= $doan->getOption('tenGV') ?></td>
                   <td style="text-align: center"><?php 
                   
                   if (getCurrentDate() <= $doan->getNgayHetHan()){
                       echo '<span style="color:green;" class="text-success"><i class="icon-calendar"></i> '.toDisplayDate($doan->getNgayHetHan()) .'</span>';
                   }else{
                       echo '<span style="color:red;" class="text-danger"><i class="icon-warning-sign"></i> '.toDisplayDate($doan->getNgayHetHan()) .'</span>';
                   }
                   
                   
                   ?></td>
                  <td><?= $doan->getNamRaDe() ?></td>
                  <td><?= $doan->getSoSVThamGia() ?></td>
                  <td> <?php if($doan->getOption('totalSV')){ ?><span class="date badge badge-important"><i class="icon-user"></i> <?=  $doan->getOption('totalSV') ?></span> <?php } ?></td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editdoan&id='.$doan->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $doan->getId() ?>"></a></td>
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
	            "<?= getLink('administrator/index.php?linkpage=dsdoan') ?>",
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
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'danh_sach_do_an.csv'});
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