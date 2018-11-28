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
if (isGiangvien($userService)){
    $phanBien->setMaGV($userService['id']);
}
$phanBien->addOption('loadGVPB', true); //Chỉ show danh sách phản biện đã add giảng viên phản biện
$phanBienMapper = new Model\PhanBienMapper($connect);
$listPhanBien = $phanBienMapper->fetchAll($phanBien);

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
                  <th>Giảng viên 1</th>
                  <th>Giảng viên 2</th>
                  <th>Giảng viên 3</th>
                  <th>Điểm PB 1</th>
                  <th>Điểm PB 2</th>
                  <th>Điểm PB 3</th>
                  <th>Trạng thái</th>
                   <?php if (isAdmin($userService)){?>
                  <th>Trạng thái sửa</th>
                   <?php }?>
                </tr>
              </thead>
              <tbody>
              	<?php if ($listPhanBien){
              	     foreach ($listPhanBien as $phanBien){
              	         $sinhvien = $phanBien->getOption('sinhvien') ? : new Model\Sinhvien();
              	         $doan   = $phanBien->getOption('doan') ? : new Model\Doan;
              	         $gvPB1 = $phanBien->getOption('giangvienPB1') ? : new Model\Giangvien();
              	         $gvPB2 = $phanBien->getOption('giangvienPB2') ? : new Model\Giangvien();
              	         $gvPB3 = $phanBien->getOption('giangvienPB3') ? : new Model\Giangvien();
              	?>
                <tr class="gradeX">
                  <td><?= $sinhvien->getMaSV() ?></td>
                  <td class="svName"><?= $sinhvien->getTenSV() ?></td>
                  <td><?= $sinhvien->getOption('tenLop') ?></td>
 				  <td class="doanName"><?= $doan->getTenDoan() ?></td>
 				  <td><?= $doan->getOption('tenLoai') ?></td>
 				  <td style="text-align: center;"><?= $gvPB1->getTenGV();?></td>
 				  <td style="text-align: center;"><?= $gvPB2->getTenGV();?></td>
 				  <td style="text-align: center;"><?= $gvPB3->getTenGV();?></td>
 				  <td style="text-align: center;">
 				  	<?php 
 				  	    $textDiem = '';
 				  	    if ($phanBien->getDiemPB1() > 0){
 				  	        $textDiem = '<b class="diemPBValue">'.$phanBien->getDiemPB1().'</b>';
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB3()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem && $phanBien->getTrangthaiSua() == Model\PhanBien::EDIT_STATUS_ALLOW){
 				  	            $textDiem .= ' <a data-type="1" data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" href="javascript:;" class="icon-pencil addDiem"></a>';
 				  	        }
 				  	    }else{
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB1()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem){
 				  	            $textDiem = '<a href="javascript:;"  data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" data-type="1" class="addDiem icon-plus text-success"></a>';
 				  	        }
 				  	    }
 				  	    echo $textDiem;
 				  	?>
 				  </td>
 				  <td style="text-align: center;">
 				  	<?php 
 				  	    $textDiem = '';
 				  	    if ($phanBien->getDiemPB2() > 0){
 				  	        $textDiem = '<b class="diemPBValue">'.$phanBien->getDiemPB2().'</b>';
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB3()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem && $phanBien->getTrangthaiSua() == Model\PhanBien::EDIT_STATUS_ALLOW){
 				  	            $textDiem .= ' <a data-type="2" data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" href="javascript:;" class="icon-pencil addDiem"></a>';
 				  	        }
 				  	    }else{
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB2()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem){
 				  	            $textDiem = '<a href="javascript:;"  data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" data-type="2" class="addDiem icon-plus text-success"></a>';
 				  	        }
 				  	    }
 				  	    echo $textDiem;
 				  	?>
 				  </td>
 				   <td style="text-align: center;">
 				  	<?php 
 				  	    $textDiem = '';
 				  	    if ($phanBien->getDiemPB3() > 0){
 				  	        $textDiem = '<b class="diemPBValue">'.$phanBien->getDiemPB3().'</b>';
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB3()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem && $phanBien->getTrangthaiSua() == Model\PhanBien::EDIT_STATUS_ALLOW){
 				  	            $textDiem .= ' <a data-type="3" data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" href="javascript:;" class="icon-pencil addDiem"></a>';
 				  	        }
 				  	    }else{
 				  	        $alowAddDiem = false;
 				  	        if (isAdmin($userService)){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if (!empty($userService['id']) && $userService['id'] == $phanBien->getMaGVPB3()){
 				  	            $alowAddDiem = true;
 				  	        }
 				  	        if ($alowAddDiem){
 				  	            $textDiem = '<a href="javascript:;"  data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" data-type="3" class="addDiem icon-plus text-success"></a>';
 				  	        }
 				  	    }
 				  	    echo $textDiem;
 				  	?>
 				  </td>
 				  <td style="text-align: center;">
 				  	<?php 
 				  	$status = '';
 				  	switch ($phanBien->getTrangthai()){
 				  	    case Model\PhanBien::STATUS_NEW:
 				  	        $status = '<span>Mới</span>';
 				  	        break;
 				  	    case Model\PhanBien::STATUS_NOT_DONE:
 				  	        $status = '<span class="label label-success">Đã chấm</span>';
 				  	        break;
 				  	    case Model\PhanBien::STATUS_DONE:
 				  	        $status = '<span class="label label-success">Đã chấm</span>';
 				  	        break;
 				  	}
 				  	echo $status;
 				  	?>
 				  </td>
 				  <?php if (isAdmin($userService)){?>
 				  <td style="text-align: center;">
 				  <?php 
 				  	    $editStatus = '';
 				  	    switch ($phanBien->getTrangthaiSua()){
 				  	        case Model\PhanBien::EDIT_STATUS_NEW:
 				  	            $editStatus = 'Mới';
 				  	            break;
			  	            case Model\PhanBien::EDIT_STATUS_NOT_ALLOW:
			  	                $editStatus = '<a href="javascript:;" data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" class="label label-important changestatus">Không được Sửa</a>';
			  	                break;
		  	                case Model\PhanBien::EDIT_STATUS_ALLOW:
		  	                    $editStatus = '<a href="javascript:;" data-madoan="'.$phanBien->getMaDoan().'" data-masv="'.$phanBien->getMaSV().'" class="label label-success changestatus">Cho phép sửa</a>';
		  	                    break;
 				  	    }
 				  	    echo $editStatus;
 				  	?>
 				  </td>
 				  <?php }?>
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

<div id="addDiemPBModal" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chấm điểm phản biện</h4>
            </div>
            <div class="modal-body">
            	<div class="form-horizontal">
            		<div class="alert alert-info">
            			<p>Tên đồ án : <span class="showTenDoan text-success">Đồ án ....</span></p> 
            			<p>Tên Sinh viên : <span class="showTenSV text-danger"></span></p> 
            		</div>
                	<div class="control-group">
                		<label class="control-label">Điểm:</label>
                      <div class="controls">
                        <input type="text" value=""  id="diemPB-txt" class="span3" placeholder="Điểm" /><span class="required">(*)</span></br>
                        <i class="description">VD: Điền dạng 7.5, 7.0, 5.0 ...</i>
                      </div>
                    </div>
            	</div>
            	
            </div>
            <div class="modal-footer">
            	<input type="hidden" class="typeDiem" />
            	<input type="hidden" class="maSV-txt" />
            	<input type="hidden" class="maDoan-txt" />
            	<button type='button' id="saveAddPb" class='btn btn-success saveAddPb'>Lưu</button>
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