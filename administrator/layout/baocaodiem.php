<?php 
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
$phanBien = new Model\PhanBien();
if(!empty($_GET['q'])){
    $phanBien->addOption('q', trim($_GET['q']));
}
if(!empty($_GET['maGV'])){
    $phanBien->setMaGV((int)$_GET['maGV']);
}
if(!empty($_GET['tenDoan'])){
    $phanBien->addOption('tenDoan', trim($_GET['tenDoan']));
}
if(!empty($_GET['maLoai'])){
    $phanBien->addOption('maLoai', (int)trim($_GET['maLoai']));
}
if(!empty($_GET['maLop'])){
   $phanBien->addOption('maLop', (int)trim($_GET['maLop']));
}
if(!empty($_GET['trangthai'])){
    $phanBien->setTrangthai((int)trim($_GET['trangthai']));
}
if (isGiangvien($userService)){
    $phanBien->setMaGV($userService['id']);
}
$phanBien->addOption('loadGVPB', true); //Chỉ show danh sách phản biện đã add giảng viên phản biện
$phanBien->addOption('trangthais', [Model\PhanBien::STATUS_DONE, Model\PhanBien::STATUS_NOT_DONE]);
$phanBienMapper = new Model\PhanBienMapper($connect);
$listPhanBien = $phanBienMapper->baocaoDiem($phanBien);

$loaiDoan = new Model\LoaiDoan();
$loaiDoanMapper = new Model\LoaiDoanMapper($connect);
$lstLoaiDoan = $loaiDoanMapper->fetchAll($loaiDoan);

$lop = new Model\Lop();
$lopMapper = new Model\LopMapper($connect);
$lstLop = $lopMapper->fetchAll($lop);

$giangvien = new Model\Giangvien();
$giangvienMapper = new Model\GiangvienMapper($connect);
$lstGiangvien = $giangvienMapper->fetchAll($giangvien);
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
          <div class="widget-content">
			<div class="formFilter span12">
				<form method="get" action="">
					<div class="span2">
						<input value="<?= !empty($_GET['q']) ? $_GET['q'] : ''; ?>" class="span11" type="text" name="q" placeholder="Mã / Tên Sinh viên" />
					</div>
					<div class="span2">
						<input value="<?= !empty($_GET['tenDoan']) ? $_GET['tenDoan'] : ''; ?>" class="span11" type="text" name="tenDoan" placeholder="Tên đề tài" />
					</div>
					<div class="span2">
						<select name="maLoai" class="span11">
							<option>- Học phần -</option>
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
					<div class="span2">
						<select name="maLop" class="span11">
							<option>- Lớp -</option>
							<?php 
							   if ($lstLop){
							       foreach ($lstLop as $lop){
							           $selected = '';
							           if (!empty($_GET['maLop']) && $lop->getId() == $_GET['maLop']){
							               $selected = 'selected';
							           }
							           echo '<option '.$selected.' value="'.$lop->getId().'">'.$lop->getTenLop().'</option>';
							       }
							   }
							?>
						</select>
					</div>
					<div class="span2">
						<select name="trangthai" class="span11">
							<option>- Trạng thái -</option>
							<option <?= (!empty($_GET['trangthai']) && $_GET['trangthai'] == Model\PhanBien::STATUS_DONE) ? 'selected' : '' ?> value="<?= Model\PhanBien::STATUS_DONE ?>">Đạt</option>
							<option <?= (!empty($_GET['trangthai']) && $_GET['trangthai'] == Model\PhanBien::STATUS_NOT_DONE) ? 'selected' : '' ?>  value="<?= Model\PhanBien::STATUS_NOT_DONE ?>">Không đạt</option>
						</select>
					</div>
					<div class="span1">
						<input type="hidden" name="linkpage" value="<?= !empty($_GET['linkpage']) ? $_GET['linkpage'] : ''; ?>" />
						<input  style="float: left;"type="submit" name="search" class="btn btn-success" value="Lọc" />
					</div>
				</form>
			</div>
          	<div class="fr fr-btn-action">
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="huondanTable" class="table table-bordered table-striped csvExportTable">
              <thead>
                <tr>
                  <th>Mã Sinh viên</th>
                  <th>Tên Sinh viên</th>
                  <th>Lớp</th>
                  <th>Khoa</th>
                  <th>Tên Đề tài</th>
                  <th>Loại đồ án</th>
                  <th>Điểm hướng dẫn</th>
                  <th>Điểm PB 1</th>
                  <th>Điểm PB 2</th>
                  <th>Điểm PB 3</th>
                  <th>Tổng điểm</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listPhanBien){
              	     foreach ($listPhanBien as $phanBien){
              	         $sinhvien = $phanBien->getOption('sinhvien') ? : new Model\Sinhvien();
              	         $doan   = $phanBien->getOption('doan') ? : new Model\Doan;
              	        
              	?>
                <tr class="gradeX">
                  <td><?= $sinhvien->getMaSV() ?></td>
                  <td class="svName"><?= $sinhvien->getTenSV() ?></td>
                  <td><?= $sinhvien->getOption('tenLop') ?></td>
                  <td><?= $sinhvien->getOption('tenKhoa') ?></td>
 				  <td class="doanName"><?= $doan->getTenDoan() ?></td>
 				  <td><?= $doan->getOption('tenLoai') ?></td>
 				  <td style="text-align: center;"><b><?= $phanBien->getOption('diemHD') ? toNumber($phanBien->getOption('diemHD')) : ''?></b></td>
 				  <td style="text-align: center;"><b><?= $phanBien->getDiemPB1() ? toNumber($phanBien->getDiemPB1()) : ''?></b></td>
 				  <td style="text-align: center;"><b><?= $phanBien->getDiemPB2() ? toNumber($phanBien->getDiemPB2()) : ''?></b></td>
 				 <td style="text-align: center;"><b><?= $phanBien->getDiemPB3() ? toNumber($phanBien->getDiemPB3()) : ''?></b></td>
 				  <td style="text-align: center;"><b><?php
 				       $totalDiem = ( $phanBien->getOption('diemHD') ? : 0)*0.035 
 				       + (($phanBien->getDiemPB1() + $phanBien->getDiemPB2() + $phanBien->getDiemPB3()) * 0.65 / 3);
 				       $totalDiem = round($totalDiem,2);
 				       echo toNumber($totalDiem);
 				  ?></b></td>
 				  <td style="text-align: center;">
 				  	<?php 
 				  	$status = '';
 				  	switch ($phanBien->getTrangthai()){
 				  	    case Model\PhanBien::STATUS_NEW:
 				  	        $status = '<span>Mới</span>';
 				  	        break;
 				  	    case Model\PhanBien::STATUS_NOT_DONE:
 				  	        $status = '<span class="label label-important">Không đạt</span>';
 				  	        break;
 				  	    case Model\PhanBien::STATUS_DONE:
 				  	        $status = '<span class="label label-success">Đạt</span>';
 				  	        break;
 				  	}
 				  	echo $status;
 				  	?>
 				  </td>
                </tr>
               <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
         <div class="alert alert-waring">
         	Tổng điểm = (Điểm hướng dẫn * 0.035) + ((Điểm phản biện 1 + Điểm phản biện 2 + điểm phản biện 3) * 0.65/ 3).<br/>
         	Tổng điểm >=5 là đạt. <br/>
         	Tổng điểm < 5 là không đạt.
         </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'layout/frame/footer.php';?>


<script type="text/javascript">
$(function(){
	$('#exportCSV').on('click',function(){
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'diem_huong_dan.csv'});
	  });
	$('.addDiem').on('click',function(){
		var item = $(this);
		var doanName = $(this).closest('tr').find('.doanName').text();
		var svName =  $(this).closest('tr').find('.svName').text();
		var diem = $(this).closest('td').find('.diemPBValue').text();
		$('#addDiemPBModal .showTenDoan').empty().append(doanName);
		$('#addDiemPBModal .showTenSV').empty().append(svName);
		$('#addDiemPBModal .maSV-txt').empty().val(item.attr('data-masv'));
		$('#addDiemPBModal .maDoan-txt').empty().val(item.attr('data-madoan'));
		$('#addDiemPBModal #diemPB-txt').empty().val(diem);
		$('#addDiemPBModal .typeDiem').empty().val($(this).attr('data-type'));
		$('#addDiemPBModal').modal('show');
	});
	$('#addDiemPBModal #saveAddPb').on('click',function(){
		if(! $('#diemPB-txt').val()){
			var html = '<div class="alert alert-warning alert-dismissable"> Bạn chưa nhập điểm</div>';
			$('#addDiemPBModal').modal('hide');
            $("#alertModal").modal('show');
            $('#alertModal .modal-body').empty();
            $('#alertModal .modal-body').append(html);
		}else{
			
			$.post(
		            "<?= getLink('administrator/postAjax.php?type=chamdiempb') ?>",
		            {
		                'maSV' : $('#addDiemPBModal .maSV-txt').val(),
		                'maDoan' : $('#addDiemPBModal .maDoan-txt').val(),
		                'diem' : $('#diemPB-txt').val(),
		                'type': $('#addDiemPBModal .typeDiem').val(),
		            },
		            function(rs){
		            	var rs = JSON.parse(rs);
		                if(rs.code){
		                    window.location.reload();
		                }else {
		                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
		                    $('#addDiemPBModal').modal('hide');
		                    $("#alertModal").modal('show');
		                    $('#alertModal .modal-body').empty();
		                    $('#alertModal .modal-body').append(html);
		                } 
		            }
		        );
		}
	});
	$('.changestatus').on('click',function(){
		if(confirm('Bạn có muốn đổi trạng thái sửa, cho phép hoặc không cho phép giảng viên sửa điểm?')){
			$.post(
		            "<?= getLink('administrator/postAjax.php?type=changestatusPB') ?>",
		            {
		                'maSV' : $(this).attr('data-masv'),
		                'maDoan' : $(this).attr('data-madoan'),
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
	
})
</script>
<style>
.fr-btn-action{
	float:left;
	margin-top: 45px;
    margin-bottom: 15px;
}
.required{
	color:red;
}
.form-horizontal .control-label {
    padding-top: 15px;
    width: 94px;
}
.select2-with-searchbox{
	    z-index: 99999;
}
.form-horizontal .controls {
    margin-left: 136px;
    padding: 10px 0;
}
</style>