<?php 
use Model\Lop;
use Model\LopMapper;
use Model\HuongdanMapper;
use Model\Giangvien;
use Model\PhanBienMapper;
use Model\GiangvienMapper;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $giangvien = new Giangvien();
    $giangvien->setId($id);
    $giangvienMapper = new GiangvienMapper($connect);
    $data = [];
    if (! $id || ! $giangvienMapper->get($giangvien)){
        $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
        echo json_encode($data);
        return;
    }
    $doan = new Model\Doan();
    $doan->setGiangvienHD($giangvien->getId());
    $doanMapper = new Model\DoanMapper($connect);
    if ($doanMapper->isExist($doan)){
        $data = ['code' => 0, 'messages' => ['Không thể xóa dữ liệu này']];
        echo json_encode($data);
        return;
    }
    $huongdan = new Model\Huongdan();
    $huongdan->setMaGV($giangvien->getId());
    $huongdanMapper = new HuongdanMapper($connect);
    if ($huongdanMapper->isExist($huongdan)){
        $data = ['code' => 0, 'messages' => ['Không thể xóa dữ liệu này']];
        echo json_encode($data);
        return;
    }
    $phanBien = new Model\PhanBien();
    $phanBien->setMaGV($giangvien->getId());
    $phanBienMapper = new PhanBienMapper($connect);
    if ($phanBienMapper->isExist($phanBien)){
        $data = ['code' => 0, 'messages' => ['Không thể xóa dữ liệu này']];
        echo json_encode($data);
        return;
    }
    if ($giangvienMapper->delete($giangvien)){
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

$giangvien = new Giangvien();
$giangvien->exchangeArray($_GET);
$giangvienMapper = new GiangvienMapper($connect);
$listGV = $giangvienMapper->fetchAll($giangvien);

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
            <h5>Danh sách giảng viên</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=addgv') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="gvTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Mã giảng viên</th>
                  <th>Tên giảng viên</th>
                  <th>Email</th>
                  <th>Chức vụ</th>
                  <th>Số điện thoại</th>
                  <th>Nhóm quyền</th>
                  <th>SL đồ án</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listGV){
              	     foreach ($listGV as $giangvien){
              	         $user = $giangvien->getOption('user') ? : new Model\User();
              	?>
                <tr class="gradeX">
                  <td><?= $giangvien->getId() ?></td>
                   <td><?= $giangvien->getMaGV() ?></td>
                  <td><?= $giangvien->getTenGV() ?></td>
                  <td><?= $giangvien->getEmail() ?></td>
                  <td><?= $giangvien->getChucvu() ?></td>
                  <td><?= $giangvien->getSoDT() ?></td>
                  <td>
                  <?php 
                   $textNhomQuyen = '';
                   if ($user->getNhomquyen() == Model\User::ROLE_ADMIN){
                       $textNhomQuyen = '<span class="date badge badge-important">Quản lý</span>';
                   }elseif ($user->getNhomquyen() == Model\User::ROLE_TEACHER){
                       $textNhomQuyen = '<span class="date badge badge-success">Giảng viên</span>';
                   }
                   echo $textNhomQuyen;
                  ?>
                  </td>
                  
                  <td><span class="date badge badge-important"><?=  $giangvien->getOption('totalDoan') ?></span></td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editgv&id='.$giangvien->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $giangvien->getId() ?>"></a></td>
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
	            "<?= getLink('administrator/index.php?linkpage=dsgv') ?>",
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
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'dsdoan.csv'});
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