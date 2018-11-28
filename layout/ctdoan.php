<?php
use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
use Model\SinhvienThamgia;
use Model\SinhvienThamgiaMapper;
include_once 'frame/top.php';
$doan = new Model\Doan();
$doan->setId(!empty($_GET['id'])? $_GET['id'] : '');
$doan->addOption('loadInfor', true);
$doanMapper = new Model\DoanMapper($connect);
if (! $doanMapper->get($doan)){
    redirect_to('index.php');
}
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
?>
<?php 
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<div id="content">
		<div class="row formArea">
               <div class="col-md-3">
                  <?php include_once 'frame/sidebar.php';?>
               </div>
              <div id="new-area" class="col-md-9">
				<div class="col-xs-12 row">
					<div class="new-content">
						<h2>ĐỀ TÀI: <?= $doan->getTenDoan(); ?></h2>
					</div>
					<?php if ($doan->checkDangKy($connect) && $userService){ ?>
					<div style="float: right;">
						<a href="javascript:;" data-id="<?= $doan->getId() ?>" class="registerDoan btn btn-sm btn-success"> Đăng ký</a>
					</div>
					<?php } ?>
					<div class="new-content-wrapper">
						<?php 
						  if ($doan->getYeucau()){
						      echo '<div class="yeucau-content"><b style="font-weight:bold;">Yêu cầu:</b> <br/>'.nl2br($doan->getYeucau()).'</div>';
						      echo '<hr/>';
						  }
						?>
						<b class="text-bold yeucau-content">Giảng viên hướng dẫn: <span class="text-success text-bold"><?= $doan->getOption('tenGV') ?></span></b> <br/>
						<b class="text-bold yeucau-content">Chủ đề: <span class="text-success text-bold"><?= $doan->getOption('tenChude') ?></span></b><br/>
						<b class="text-bold yeucau-content">Loại: <?= $doan->getOption('tenLoai') ?></b><br/>
						<b class="text-bold yeucau-content">Số lượng sinh viên tối đa: <span class="text-danger text-bold"><?= $doan->getSoSVThamGia() ?></span></b><br/>
						<b class="text-bold yeucau-content">Ngày hết hạn:  <span class="text-danger text-bold"><?= toDisplayDate($doan->getNgayHetHan()) ?></span></b><br/>
						<b class="text-bold yeucau-content">Năm ta đề : <span class="text-danger text-bold"><?= $doan->getNamRaDe() ?></span></b><br/>
						<hr/>
						<div class="showRegister">
						<?php 
						$sinhvienThamgia = new SinhvienThamgia();
						$sinhvienThamgia->setMaDoan($doan->getId());
						$sinhvienThamgiaMapper = new SinhvienThamgiaMapper($connect);
						$lstSvtg = $sinhvienThamgiaMapper->fetchAll($sinhvienThamgia);
						if ($lstSvtg){
						?>
						<p><i style="line-height: 20px;" class="fa fa-users"></i> Danh sách sinh viên đã đăng ký đồ án này</p>
						 <table id="svThamgiaTable" class="table table-bordered">
                            <thead>
                              <tr>
                              	<th>Mã sinh viên</th>
                                <th>Tên sinh viên</th>
                                <th>Lớp</th>
                                <th>Khoa</th>
                                <th>File Nộp</th>
                                <th>Trạng thái</th>
                              </tr>
                            </thead>
                            <tbody>
                             	<?php 
                             	  foreach ($lstSvtg as $sinhvienThamgia){
                             	      $sinhvien = $sinhvienThamgia->getOption('sinhvien') ? : new Model\Sinhvien();
                             	      $textFile = '';
                             	      $status = '<span class="text-danger label label-warning"> Chưa nộp</span>';
                             	      if ($sinhvienThamgia->getFileName()){
                             	          $textFile = $sinhvienThamgia->getFileName();
                             	          $status =  '<span class="text-danger label label-success"> Đã nộp</span>';
                             	      }else{
                             	          $textFile = '<a target="blank" href="'.getLink('index.php?linkpage=nopdoan').'" class="fa fa-plus"></a>';
                             	      }
                             	      echo '<tr>
                                                <td>'.$sinhvien->getMaSV().'</td>
                                                 <td>'.$sinhvien->getTenSV().'</td>
                                                 <td>'.$sinhvien->getOption('tenLop').'</td>
                                                 <td>'.$sinhvien->getOption('tenKhoa').'</td>
                                                 <td style="text-align: center;">'.$textFile.'</td>
                                                 <td>'.$status.'</td>
                                            </tr>';
                             	  }
                             	?>
                            </tbody>
                          </table>
						<?php }else{?>
							<div class="alert alert-warning"> Chưa có sinh viên nào đăng ký đồ án này</div>
						<?php }?>
						</div>
					</div>
				</div>
              </div>
          </div>
	</div>
</div>
<div id="registerDoanModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Đăng ký đồ án</h4>
            </div>
            <div class="modal-body">
            	<div class="alert alert-info">Bạn chắc chắn đăng ký đề tài này?</div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="registerDoanTxt" />
            	<button type='button' class='btn btn-success saveRegisterDoan'> Đồng ý</button>
                <button type='button' class='btn btn-default reload'
                        data-dismiss='modal'>Đóng</button>
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
<?php include_once 'frame/footer.php';?>
<style>
.form-group{
	position:relative;
}
.form-group .requiredInput{
	color: red;
    position: absolute;
    right: -25px;
    top: 11px;
}
.error{
	border: 1px solid red;
}
.yeucau-content{
	line-height:20px;
}
.text-bold{
	font-weight:bolder;
}
table#svThamgiaTable tr th{
	font-weight:bolder;
	    color: #fff;
    background-color: #01b4dd;
	border: none;
}
</style>
<script src="js/lib/jquery/v3.3.1/jquery.min.js"></script>
<script src="js/lib/bootstrap/v3.3.7/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
    document.title = '<?= $doan->getTenDoan() ?>';
})
$('.registerDoan').on('click',function(){
	var name = $(this).closest('.newItem').find('.newItem-title a').text();
	var id = $(this).attr('data-id');
	$('#registerDoanModal .showTenDoan').empty().append(name);
	$('#registerDoanModal #registerDoanTxt').val(id);
	$('#registerDoanModal').modal('show');
})
$('#registerDoanModal .saveRegisterDoan').on('click',function(){
	$.post(
            "<?= getLink('administrator/postAjax.php?type=registerdoan') ?>",
            {
                'id' : $('#registerDoanTxt').val(),
            },
            function(rs){
            	var rs = JSON.parse(rs);
                if(rs.code){
                	window.location.reload();
                }else {
                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
                    $('#registerDoanModal').modal('hide');
                    $("#alertModal").modal('show');
                    $('#alertModal .modal-body').empty();
                    $('#alertModal .modal-body').append(html);
                    
                } 
            }
        );
})

</script>
</body>
</html>
