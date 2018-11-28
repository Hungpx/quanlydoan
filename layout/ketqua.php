<?php
include_once 'frame/top.php';
?>
<?php 
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
$loaiDoan = new Model\LoaiDoan();
$loaiDoanMapper = new Model\LoaiDoanMapper($connect);
$lstLoaiDoan = $loaiDoanMapper->fetchAll($loaiDoan);

$showArea = '';
$isValid = false;
if (!empty($_GET['maLoai']) && !empty($_GET['maSV'])){
    $isValid = true;
}
if ($isValid){
    $huongdan = new Model\Huongdan();
    $huongdan->addOption('maLoai', $_GET['maLoai']);
    $huongdan->addOption('maSV', $_GET['maSV']);
    $huongdan->addOption('trangthais', [Model\Huongdan::STATUS_DONE, Model\Huongdan::STATUS_DELETE, Model\Huongdan::STATUS_DONE_PHANBIEN]);
    $huongdanMapper = new Model\HuongdanMapper($connect);
    $huongdans = $huongdanMapper->fetchAll($huongdan);
    if ($huongdans){
        $huongdan = $huongdans[0];
        $showArea = 'huongdan';
    }
    
    $phanbien = new Model\PhanBien();
    $phanbien->addOption('maLoai', $_GET['maLoai']);
    $phanbien->addOption('maSV', $_GET['maSV']);
    $phanbien->addOption('trangthais', [Model\PhanBien::STATUS_DONE, Model\PhanBien::STATUS_NOT_DONE]);
    $phanbien->addOption('loadHuongdan', true);
    $phanbienMapper = new Model\PhanBienMapper($connect);
    $phanbiens = $phanbienMapper->fetchAll($phanbien);
    if ($phanbiens){
        $phanbien = $phanbiens[0];
        $showArea = 'phanbien';
    }
}

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
					<div class="title-content"><h2><i style="font-size: 26px;line-height: 36px;" class="fa fa-check"></i> Kết quả</h2></div>
					<div class="formFilter">
						<form method="get" action="">
							<div class="col-md-3">
								<select name="maLoai" class="form-control">
									<option value="">- Học phần -</option>
									<?php 
									   if ($lstLoaiDoan){
									       foreach ($lstLoaiDoan as $loaiDoan){
									           $selected = '';
									           if (!empty($_GET['maLoai']) && $loaiDoan->getId() == $_GET['maLoai']){
									               $selected = 'selected';
									           }
									           echo '<option '.$selected.' value="'.$loaiDoan->getId().'">'.$loaiDoan->getTenLoai().'</option>';
									       }
									   }
									?>
								</select>
							</div>
							<div class="col-md-3"><input value="<?= !empty($_GET['maSV']) ? $_GET['maSV'] : ''; ?>" placeholder="Nhập mã SV" name="maSV" class="form-control" /></div>
							<div class="col-md-2">
								<input type="hidden" name="linkpage" value="<?= !empty($_GET['linkpage']) ? $_GET['linkpage'] : ''; ?>" />
								<input type="submit" name="search" class="btn btn-success" value="Xem kết quả" />
							</div>
						</form>
					</div>
					<div style="margin-top:15px;" class="col-md-12">
						<?php if (! $isValid){ ?>
						<div class="alert alert-info">Bạn vui lòng <span class="text-danger">chọn học phần</span> và <span class="text-danger">điền mã sinh viên</span> để xem kết quả</div>
						<?php }else{
						  if (! $showArea){
						      echo '<div class="alert alert-warning">Không tìm thấy mã sinh viên <b>'.(! empty($_GET['maSV']) ? $_GET['maSV'] : '').'</b> hoặc chưa có kết quả. Vui lòng chờ kết quả sau.</div>';
						  }elseif ($showArea == 'huongdan'){
						      $sinhvien = $huongdan->getOption('sinhvien') ? : new Model\Sinhvien();
						      $doan = $huongdan->getOption('doan') ? : new Model\Doan();
						?>
						<table id="svThamgiaTable" class="table table-bordered">
                            <thead>
                              <tr>
                              	<th>Mã SV</th>
                                <th>Tên SV</th>
                                <th>Lớp</th>
                                <th>Tên đồ án</th>
                                <th>Điểm HD</th>
                                <th>Nhận xét</th>
                                <th>Trạng thái</th>
                              </tr>
                            </thead>
                            <tbody>
                            	<tr>
                            		<td><?= $sinhvien->getMaSV() ?></td>
                            		<td><?= $sinhvien->getTenSV() ?></td>
                            		<td><?= $sinhvien->getOption('tenLop') ?></td>
                            		<td><?= $doan->getTenDoan() ?></td>
                            		<td style="text-align: center;"><b><?= toNumber($huongdan->getDiem()) ?></b></td>
                            		<td><span class="text-danger"><?= $huongdan->getNhanxet() ?></span></td>
                            		<td>
                            			<?php 
                            			 if ($huongdan->getTrangthai() == Model\Huongdan::STATUS_DELETE){
                            			     echo '<span class="label label-danger">Không được bảo vệ</span>';
                            			 }else{
                            			     echo '<span class="label label-success">Được bảo vệ</span>';
                            			 }
                            			?>
                            		</td>
                            	</tr>
                            </tbody>
                        </table>
						<?php }elseif ($showArea == 'phanbien'){ 
						    $sinhvien = $phanbien->getOption('sinhvien') ? : new Model\Sinhvien();
						    $doan = $phanbien->getOption('doan') ? : new Model\Doan();
						    ?>
						   <table id="svThamgiaTable" class="table table-bordered">
                                <thead>
                                  <tr>
                                  	<th>Mã SV</th>
                                    <th>Tên SV</th>
                                    <th>Lớp</th>
                                    <th>Tên đồ án</th>
                                    <th>Điểm HD</th>
                                    <th>Điểm PB 1</th>
                                    <th>Điểm PB 2</th>
                                    <th>Điểm PB 3</th>
                                    <th>Tổng điểm</th>
                                    <th>Trạng thái</th>
                                  </tr>
    							</thead>
    							<tbody>
                            	<tr>
                            		<td><?= $sinhvien->getMaSV() ?></td>
                            		<td><?= $sinhvien->getTenSV() ?></td>
                            		<td><?= $sinhvien->getOption('tenLop') ?></td>
                            		<td><?= $doan->getTenDoan() ?></td>
                            		<td style="text-align: center;"><b><?= toNumber($phanbien->getOption('diemHD')) ?></b></td>
                            		<td style="text-align: center;"><b><?= toNumber($phanbien->getDiemPB1()) ?></b></td>
                            		<td style="text-align: center;"><b><?= toNumber($phanbien->getDiemPB2()) ?></b></td>
                            		<td style="text-align: center;"><b><?= toNumber($phanbien->getDiemPB3()) ?></b></td>
                            		<td style="text-align: center;">
                            		<?php
                            		$classShow = 'text-danger';
                            		$totalDiem = $phanbien->getOption('diemHD') * 0.035 + (($phanbien->getDiemPB1()+$phanbien->getDiemPB2() + $phanbien->getDiemPB3())*0.65/3);
                            		$totalDiem = round($totalDiem,2);
                            		if ($totalDiem >= 5){
                            		    $classShow = 'text-success';
                            		}
                            		?>
                            		<b class="<?= $classShow ?>"><?= $totalDiem ?>
                            		</b>
                            		</td>
                            		<td>
                            			<?php 
                            			 if ($phanbien->getTrangthai() == Model\PhanBien::STATUS_NOT_DONE){
                            			     echo '<span class="label label-danger">Không đạt</span>';
                            			 }else{
                            			     echo '<span class="label label-success">Đạt</span>';
                            			 }
                            			?>
                            		</td>
                            	</tr>
                            </tbody>
							</table>
						
						<?php }}?>
					</div>
					
				</div>
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
