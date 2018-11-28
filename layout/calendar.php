<?php
include_once 'frame/top.php';
use Model\Doan;
use Model\DoanMapper;
use Model\SinhvienThamgia;
?>
<?php 

$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<div id="content">
		<div class="row formArea">
               <div class="col-md-3">
                  <?php include_once 'frame/sidebar.php';?>
               </div>
              <div class="col-md-9">
				<div id="news-area" class="col-xs-12 row">
					<div class="title-content"><h2><i style="font-size: 26px;line-height: 36px;" class="fa fa-calendar"></i> Đồ án đã đăng ký</h2></div>
					<?php if (! $userService){?>
					<div class="alert alert-info">Bạn vui lòng đăng nhập để thực hiện chức năng này. Đăng nhập <a class="text-danger" href="<?= getLink('index.php?linkpage=dangnhap') ?>"> Tại đây</a></div>
					<?php }elseif ($userService['nhomquyen'] != Model\User::ROLE_STUDENT){ ?>
					<div class="alert alert-info">Chức năng này chỉ áp dụng cho sinh viên.</div>
					<?php }else{ 
					    $sinhvienThamgia = new SinhvienThamgia();
					    $sinhvienThamgia->setMaSV($userService['id']);
					    $sinhvienThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
					    $lstSvtg = $sinhvienThamgiaMapper->fetchAll($sinhvienThamgia) ? : [];
					    if (! $lstSvtg){
					?>
					<div class="alert alert-info">Bạn chưa đăng ký đồ án nào cả. Vui lòng đăng ký <a class="text-danger" href="<?= getLink('index.php?linkpage=dsdoan') ?>"> Tại đây</a></div>
					<?php }else{?>
						 <table id="svThamgiaTable" class="table table-bordered">
                            <thead>
                              <tr>
                              	<th>Tên đồ án</th>
                                <th>Loại</th>
                                <th>Ngày hết hạn</th>
                                <th>Năm</th>
                                <th>File Nộp</th>
                                <th>Trạng thái</th>
                              </tr>
                            </thead>
                            <tbody>
                             	<?php 
                             	if ($lstSvtg){
                             	  foreach ($lstSvtg as $sinhvienThamgia){
                             	      $doan = $sinhvienThamgia->getOption('doan') ? : new Model\Doan();
                             	      $textFile = '';
                             	      $status = '<span class="text-danger label label-warning"> Chưa nộp</span>';
                             	      if ($sinhvienThamgia->getFileName()){
                             	          $textFile = '<a target="_blank" href="'.getLink('administrator/download.php?maSV='.$sinhvienThamgia->getMaSV().'&maDoan='.$sinhvienThamgia->getMaDoan()).'">'.$sinhvienThamgia->getFileName().'</a>';
                             	          $status =  '<span class="text-danger label label-success"> Đã nộp</span>';
                             	      }else{
                             	          $textFile = '<a target="blank" href="'.getLink('index.php?linkpage=nopdoan').'" class="fa fa-plus"></a>';
                             	      }
                             	      echo '<tr>
                                                <td><a target="_blank" href="'.getLink('index.php?linkpage=ctdoan&id='.$doan->getId()).'">'.$doan->getTenDoan().'</a></td>
                                                 <td>'.$doan->getOption('tenLoai').'</td>
                                                 <td>'.($doan->getNgayHetHan() ? toDisplayDate($doan->getNgayHetHan()) : '').'</td>
                                                 <td>'.$doan->getNamRaDe().'</td>
                                                 <td style="text-align: center;">'.$textFile.'</td>
                                                 <td>'.$status.'</td>
                                            </tr>';
                             	  }
                             	}
                             	?>
                            </tbody>
                          </table>
                          <?php } ?>
					<?php } ?>
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
            	<div class="alert alert-info">Bạn chắc chắn đăng ký đề tài <b class="showTenDoan text-success"></b></div>
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
.showTenDoan{
	font-weight:bold;
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
    document.title = 'Đồ án đã đăng ký';
    
})
</script>
</body>
</html>
