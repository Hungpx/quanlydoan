<?php 
use Model\Lop;
use Model\LopMapper;
use Model\HuongdanMapper;
use Model\Giangvien;
use Model\PhanBienMapper;
use Model\GiangvienMapper;


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
            <h5>Báo cáo đồ án theo giảng viên</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="gvTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Mã giảng viên</th>
                  <th>Tên giảng viên</th>
                  <th>Số lượng đồ án</th>
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
                  <td style="text-align: center;"><b><?=  $giangvien->getOption('totalDoan') ? : 0 ?></b></td>
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