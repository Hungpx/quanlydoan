<?php 
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
$huongdan = new Model\Huongdan();
if(!empty($_GET['q'])){
    $huongdan->addOption('q', trim($_GET['q']));
}
if(!empty($_GET['maGV'])){
    $huongdan->setMaGV((int)$_GET['maGV']);
}
if(!empty($_GET['tenDoan'])){
    $huongdan->addOption('tenDoan', trim($_GET['tenDoan']));
}
if(!empty($_GET['maLoai'])){
    $huongdan->addOption('maLoai', (int)trim($_GET['maLoai']));
}
if(!empty($_GET['maLop'])){
   $huongdan->addOption('maLop', (int)trim($_GET['maLop']));
}
if (isGiangvien($userService)){
    $huongdan->setMaGV($userService['id']);
}
$huongdanMapper = new Model\HuongdanMapper($connect);
$listHuongdan = $huongdanMapper->fetchAll($huongdan);

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
            <h5>Danh sách hướng dẫn</h5>
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
					<?php if (isAdmin($userService)){
					?>
					<div class="span2">
						<select name="maGV" class="form-control">
							<option>- Giảng viên -</option>
							<?php 
							   if ($lstGiangvien){
							       foreach ($lstGiangvien as $giangvien){
							           $selected = '';
							           if (!empty($_GET['maGV']) && $giangvien->getId() == $_GET['maGV']){
							               $selected = 'selected';
							           }
							           echo '<option '.$selected.' value="'.$giangvien->getId().'">'.$giangvien->getTenGV().'</option>';
							       }
							   }
							?>
						</select>
					</div>
					<?php }?>
					
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
                  <th>Tên Đề tài</th>
                  <th>Loại đồ án</th>
                  <th>Giảng viên</th>
                  <th>File Nộp</th>
                  <th style="width:30px;">Điểm HD</th>
                  <th>Nhận xét</th>
                  <th>Trạng thái</th>
                  <?php if (isAdmin($userService)){?>
                  <th>Trạng thái sửa</th>
                  <th>Hội đồng bảo vệ</th>
                   <?php }?>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listHuongdan){
              	     foreach ($listHuongdan as $huongdan){
              	         $sinhvien = $huongdan->getOption('sinhvien') ? : new Model\Sinhvien();
              	         $doan   = $huongdan->getOption('doan') ? : new Model\Doan;
              	?>
                <tr class="gradeX">
                  <td><?= $sinhvien->getMaSV() ?></td>
                  <td class="svName"><?= $sinhvien->getTenSV() ?></td>
                  <td><?= $sinhvien->getOption('tenLop') ?></td>
 				  <td class="doanName"><?= $doan->getTenDoan() ?></td>
 				  <td class="loaiDoan"><?= $doan->getOption('tenLoai') ?></td>
 				  <td><?= $huongdan->getOption('tenGV') ?></td>
 				  <td><?='<a target="_blank" href="'.getLink('administrator/download.php?maSV='.$huongdan->getMaSV().'&maDoan='.$huongdan->getMaDoan()).'">'. ($huongdan->getOption('fileName') ? $huongdan->getOption('fileName').' <i class="icon-download-alt"></i>' : '').'</a>'; ?></td>
 				  <td style="text-align: center;">
 				  <?php 
 				  $textDiem = '';
 				  if ($huongdan->getTrangthai() == Model\Huongdan::STATUS_NEW){
 				      $textDiem = '<a href="javascript:;"  data-madoan="'.$huongdan->getMaDoan().'" data-masv="'.$huongdan->getMaSV().'" class="addDiem icon-plus text-success"></a>';
 				  }else{
 				      $textDiem = $huongdan->getDiem() ? '<span class="textDiem">'.$huongdan->getDiem().'</span>' : 0;
 				  }
 				  if ($huongdan->getTrangthaiSua() == Model\Huongdan::EDIT_STATUS_ALLOW){
 				      $textDiem .= ' <a data-madoan="'.$huongdan->getMaDoan().'" data-masv="'.$huongdan->getMaSV().'" href="javascript:;" class="icon-pencil addDiem"></a>';
 				  }
 				      echo $textDiem;
 				  ?>
 				  </td>
 				  <td class="textNhanxet"><?= $huongdan->getNhanxet() ?></td>
 				  <td>
 				  	<?php 
 				  	    $status = '';
 				  	    switch ($huongdan->getTrangthai()){
 				  	        case Model\Huongdan::STATUS_NEW:
 				  	            $status = '<span>Mới</span>';
 				  	            break;
			  	            case Model\Huongdan::STATUS_DELETE:
			  	                $status = '<span class="label label-important">Không được bảo vệ</span>';
			  	                break;
		  	                case Model\Huongdan::STATUS_DONE:
		  	                    $status = '<span class="label label-success">được bảo vệ</span>';
		  	                    break;
	  	                    case Model\Huongdan::STATUS_DONE_PHANBIEN:
	  	                        $status = '<span class="label label-success">được bảo vệ</span>';
	  	                        break;
		  	                default:
		  	                    $status = '<span class="label label-info">Chờ chấm điểm</span>';
		  	                    break;
 				  	    }
 				  	    
 				  	    echo $status;
 				  	?>
 				  </td>
 				  
 				   <?php if (isAdmin($userService)){?>
 				   <td>
 				   <?php 
 				  	    $editStatus = '';
 				  	    switch ($huongdan->getTrangthaiSua()){
 				  	        case Model\Huongdan::EDIT_STATUS_NEW:
 				  	            $editStatus = 'Mới';
 				  	            break;
			  	            case Model\Huongdan::EDIT_STATUS_NOT_ALLOW:
			  	                $editStatus = '<a href="javascript:;" data-madoan="'.$huongdan->getMaDoan().'" data-masv="'.$huongdan->getMaSV().'" class="label label-important changestatus">Không được Sửa</a>';
			  	                break;
		  	                case Model\Huongdan::EDIT_STATUS_ALLOW:
		  	                    $editStatus = '<a href="javascript:;" data-madoan="'.$huongdan->getMaDoan().'" data-masv="'.$huongdan->getMaSV().'" class="label label-success changestatus">Cho phép sửa</a>';
		  	                    break;
 				  	    }
 				  	    echo $editStatus;
 				  	?>
 				  	 </td>
 				  
 				  <td style="text-align: center;">
 				  	<?php 
 				  	$textAddHDBV = '';
 				  	if ($huongdan->getTrangthai() == Model\Huongdan::STATUS_DONE){
 				  	    $textAddHDBV = '<a  href="javascript:;" data-madoan="'.$huongdan->getMaDoan().'" data-masv="'.$huongdan->getMaSV().'" class="icon-plus addHDPB"></a>';
 				  	}elseif ($huongdan->getTrangthai() == Model\Huongdan::STATUS_DONE_PHANBIEN){
 				  	    $textAddHDBV = '<span class="icon-check"></span>';
 				  	}
 				  	echo $textAddHDBV;
 				  	?>
 				  </td>
 				   <?php }?>
                </tr>
               <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php if (isAdmin($userService)){?>
        <div class="alert alert-waring">Nếu bạn muốn đổi trạng thái sửa, vui lòng <b>click vào trạng thái</b> đó.</div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php include_once 'layout/frame/footer.php';?>
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

<div id="addDiemModal" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chấm điểm</h4>
            </div>
            <div class="modal-body">
            	<div class="form-horizontal">
            		<div class="alert alert-info">
            			<p>Tên đồ án : <span class="showTenDoan text-success">Đồ án ....</span></p> 
            			<p>Tên Sinh viên : <span class="showTenSV text-danger"></span></p> 
            		</div>
                    <div class="control-group">
                      <label class="control-label">Trạng thái</label>
                      <div class="controls">
                        <label>
                          <div class="radio"><span class=""><input checked="checked" value=<?= Model\Huongdan::STATUS_DONE ?> type="radio" name="trangthai-radio" style="opacity: 0;"></span></div>
                          Cho phép bảo vệ</label>
                        <label>
                          <div class="radio"><span class=""><input type="radio" name="trangthai-radio" value=<?= Model\Huongdan::STATUS_DELETE ?> style="opacity: 0;"></span></div>
                          Không cho phép bảo vệ</label>
                      </div>
                    </div>
                	<div class="control-group">
                		<label class="control-label">Điểm:</label>
                      <div class="controls">
                        <input type="text" value=""  id="diem-txt" class="span3" placeholder="Điểm" /><span class="required">(*)</span></br>
                        <i class="description">VD: Điền dạng 7.5, 7.0, 5.0 ...</i>
                      </div>
                    </div>
                    <div class="control-group">
                    <label class="control-label">Nhận xét:</label>
                      <div class="controls">
                        <textarea style="min-height: 100px;" placeholder="Nhận xét" id="nhanxet-txt" class="span3" rows="" cols="2"></textarea>
                      </div>
                    </div>
            	</div>
            	
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="maSV-txt" />
            	<input type="hidden" id="maDoan-txt" />
            	<button type='button' id="saveAdd" class='btn btn-success'>Lưu</button>
                <button type='button' class='btn btn-default reload' data-dismiss='modal'>Đóng</button>
            </div>
        </div>
    </div>
</div>

<div id="addHDPBModal" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thêm hội đồng phản biện</h4>
            </div>
            <div class="modal-body">
            	<div class="form-horizontal">
            		<div class="alert alert-info">
            			<p>Tên đồ án : <span class="showTenDoan text-success">Đồ án ....</span></p> 
            			<p>Tên Sinh viên : <span class="showTenSV text-danger">Phạm Xuân Hùng</span></p> 
            		</div>
                    <div class="control-group">
                      <label class="control-label">Giảng viên 1</label>
                      <div class="controls">
                       	<select id="maGVPB1-txt">
							<option>- Giảng viên -</option>
							<?php 
							   if ($lstGiangvien){
							       foreach ($lstGiangvien as $giangvien){
							           $selected = '';
							           if (!empty($_GET['maGV']) && $giangvien->getId() == $_GET['maGV']){
							               $selected = 'selected';
							           }
							           echo '<option '.$selected.' value="'.$giangvien->getId().'">'.$giangvien->getTenGV().'</option>';
							       }
							   }
							?>
						</select>
						<span class="required">(*)</span>
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label">Giảng viên 2</label>
                      <div class="controls">
                       	<select id="maGVPB2-txt" >
							<option>- Giảng viên -</option>
							<?php 
							   if ($lstGiangvien){
							       foreach ($lstGiangvien as $giangvien){
							           $selected = '';
							           if (!empty($_GET['maGV']) && $giangvien->getId() == $_GET['maGV']){
							               $selected = 'selected';
							           }
							           echo '<option '.$selected.' value="'.$giangvien->getId().'">'.$giangvien->getTenGV().'</option>';
							       }
							   }
							?>
						</select>
						<span class="required">(*)</span>
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label">Giảng viên 3</label>
                      <div class="controls">
                       	<select id="maGVPB3-txt">
							<option>- Giảng viên -</option>
							<?php 
							   if ($lstGiangvien){
							       foreach ($lstGiangvien as $giangvien){
							           $selected = '';
							           if (!empty($_GET['maGV']) && $giangvien->getId() == $_GET['maGV']){
							               $selected = 'selected';
							           }
							           echo '<option '.$selected.' value="'.$giangvien->getId().'">'.$giangvien->getTenGV().'</option>';
							       }
							   }
							?>
						</select>
						<span class="required">(*)</span>
                      </div>
                    </div>
                	
            	</div>
            	
            </div>
            <div class="modal-footer">
            	<input type="hidden" class="maSV-txt" />
            	<input type="hidden" class="maDoan-txt" />
            	<button type='button' id="saveAddHDPB" class='btn btn-success'>Lưu</button>
                <button type='button' class='btn btn-default reload' data-dismiss='modal'>Đóng</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
	$('#exportCSV').on('click',function(){
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'diem_huong_dan.csv'});
	  });
	$('.addDiem').on('click',function(){
		var item = $(this);
		var doanName = $(this).closest('tr').find('.doanName').text();
		var svName =  $(this).closest('tr').find('.svName').text();
		var diem = $(this).closest('tr').find('.textDiem').text();
		var nhanxet =  $(this).closest('tr').find('.textNhanxet').text();
		$('#addDiemModal .showTenDoan').empty().append(doanName);
		$('#addDiemModal .showTenSV').empty().append(svName);
		$('#addDiemModal #maSV-txt').empty().val(item.attr('data-masv'));
		$('#addDiemModal #maDoan-txt').empty().val(item.attr('data-madoan'));
		$('#addDiemModal #diem-txt').empty().val(diem);
		$('#addDiemModal #nhanxet-txt').empty().val(nhanxet);
		$('#addDiemModal').modal('show');
	});
	$('#addDiemModal #saveAdd').on('click',function(){
		if(! $('#diem-txt').val()){
			var html = '<div class="alert alert-warning alert-dismissable"> Bạn chưa nhập điểm</div>';
			$('#addDiemModal').modal('hide');
            $("#alertModal").modal('show');
            $('#alertModal .modal-body').empty();
            $('#alertModal .modal-body').append(html);
		}else{
			$.post(
		            "<?= getLink('administrator/postAjax.php?type=chamdiemhd') ?>",
		            {
		                'maSV' : $('#maSV-txt').val(),
		                'maDoan' : $('#maDoan-txt').val(),
		                'diem' : $('#diem-txt').val(),
		                'trangthai' : $('input[name=trangthai-radio]:checked').val(),
		                'nhanxet': $('#nhanxet-txt').val(),
		            },
		            function(rs){
		            	var rs = JSON.parse(rs);
		                if(rs.code){
		                    window.location.reload();
		                }else {
		                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
		                    $('#addDiemModal').modal('hide');
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
		            "<?= getLink('administrator/postAjax.php?type=changestatusHD') ?>",
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
	$('.addHDPB').on('click',function(){
		var item = $(this);
		var doanName = $(this).closest('tr').find('.doanName').text();
		var svName =  $(this).closest('tr').find('.svName').text();
		$('#addHDPBModal .showTenDoan').empty().append(doanName);
		$('#addHDPBModal .showTenSV').empty().append(svName);
		$('#addHDPBModal .maSV-txt').empty().val(item.attr('data-masv'));
		$('#addHDPBModal .maDoan-txt').empty().val(item.attr('data-madoan'));
		$('#addHDPBModal').modal('show');
	});
	$('#addHDPBModal #saveAddHDPB').on('click',function(){
		$.post(
	            "<?= getLink('administrator/postAjax.php?type=addhdpb') ?>",
	            {
	                'maSV' : $('#addHDPBModal .maSV-txt').val(),
	                'maDoan' : $('#addHDPBModal .maDoan-txt').val(),
	                'maGVPB1': $('#addHDPBModal #maGVPB1-txt').val(),
	                'maGVPB2': $('#addHDPBModal #maGVPB2-txt').val(),
	                'maGVPB3': $('#addHDPBModal #maGVPB3-txt').val(),
	            },
	            function(rs){
	            	var rs = JSON.parse(rs);
	                if(rs.code){
	                    window.location.reload();
	                }else {
	                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
	                    $('#addHDPBModal').modal('hide');
	                    $("#alertModal").modal('show');
	                    $('#alertModal .modal-body').empty();
	                    $('#alertModal .modal-body').append(html);
	                } 
	            }
	        );
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