<?php
include_once 'frame/top.php';
use Model\Doan;
use Model\DoanMapper;
use Model\ChudeMapper;
?>
<?php 
$doan = new Doan();
$doan->exchangeArray($_GET);
if (!empty($_GET['tenGV'])){
    $doan->addOption('tenGV', $_GET['tenGV']);
}
if (!empty($_GET['status'])){
    $doan->addOption('status', $_GET['status']);
}
$doanMapper = new DoanMapper($connect);
$dsDoan = $doanMapper->fetchAll($doan);

$chude = new Model\Chude();
$chudeMapper = new ChudeMapper($connect);
$lstChude = $chudeMapper->fetchAll($chude);

$loaiDoan = new Model\LoaiDoan();
$loaiDoanMapper = new Model\LoaiDoanMapper($connect);
$lstLoaiDoan = $loaiDoanMapper->fetchAll($loaiDoan);

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
					<div class="title-content"><h2><i style="font-size: 26px;line-height: 36px;" class="fa fa-search"></i> Tra cứu đồ án</h2></div>
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
							<div class="col-md-3"><input value="<?= !empty($_GET['tenGV']) ? $_GET['tenGV'] : ''; ?>" placeholder="Tên giảng viên" name="tenGV" class="form-control" /></div>
							<div class="col-md-2">
								<select name="maChude" class="form-control">
									<option value="">- Chủ đề -</option>
									<?php 
									   if ($lstChude){
									       foreach ($lstChude as $chude){
									           $selected = '';
									           if (!empty($_GET['maChude']) && $chude->getId() == $_GET['maChude']){
									               $selected = 'selected';
									           }
									           echo '<option '.$selected.' value="'.$chude->getId().'">'.$chude->getTenChude().'</option>';
									       }
									   }
									?>
								</select>
							</div>
							
							<div class="col-md-3">
								<select name="status" class="form-control">
									<option value="">- Trạng thái -</option>
									<option value="1">Còn hạn</option>
									<option value="-1">hết hạn</option>
								</select>
							</div>
							<div class="col-md-1">
								<input type="hidden" name="linkpage" value="<?= !empty($_GET['linkpage']) ? $_GET['linkpage'] : ''; ?>" />
								<input type="submit" name="search" class="btn btn-success" value="Lọc" />
							</div>
						</form>
						
					</div>
					<?php if ($dsDoan){ foreach ($dsDoan as $doan){?>
              		<div class="newItem-row col-md-12">
						<div class="row">
        					<div class="newItem col-md-12">
        						<h3 class="newItem-title"><a href="<?= getLink('index.php?linkpage=ctdoan&id='.$doan->getId()) ?>"><?= $doan->getTenDoan(); ?></a></h3>
        						<div class="project-extra">
        							<span class="label label-warning chude extraItem"><?= $doan->getOption('tenChude') ?></span>
        							<span class="expiredDate extraItem"><i class="fa fa-user extraItem"></i> (<?= $doan->getOption('totalSV') ? : 0 ?> sinh viên đã đăng ký)</span>
        							<p class="teacher text-success" style="line-height: 18px;font-weight:bold;">Giảng viên hướng dẫn: <?= $doan->getOption('tenGV') ?></p>
        							<p class="teacher text-info" style="line-height: 18px;">Loại đồ án: <?= $doan->getOption('tenLoai') ?></p>
        							<p class="teacher" style="line-height: 18px;">
        							Ngày hết hạn:
        							 <?php 
        							 if (getCurrentDate() > $doan->getNgayHetHan()){
        							     echo '<span style="color:red"><i style="line-height: 16px;" class="fa fa-calendar"></i> '.toDisplayDate($doan->getNgayHetHan()).' (đã hết hạn)</span>';
        							 }else{
        							     echo '<span class="text-success"><i style="line-height: 16px;" class="fa fa-calendar"></i> '.toDisplayDate($doan->getNgayHetHan()).'</span>';
        							 }
        							
        							?></p>
        							<p class="teacher" style="line-height: 18px;">Số lượng sinh viên tối đa cho phép: <b style="font-weight: bolder;"><?= $doan->getSoSVThamGia() ?></b></p>
        						</div>
        						<div class="viewMoreArea">
        							<?php if ($doan->checkDangKy($connect) == true && $userService){?>
        							<a href="javascript:;" data-id="<?= $doan->getId() ?>" class="registerDoan btn btn-sm btn-success"> Đăng ký</a>
        							<?php } ?>
        							<a href="<?= getLink('index.php?linkpage=ctdoan&id='.$doan->getId()) ?>" class="view-more pull-right text-danger">+ Xem chi tiết</a>
        						</div>
        					</div>
						</div>
    				</div>
              		<?php }}?>
              		<?php if ($dsDoan && count($dsDoan) > 5){?>
					<button style="margin-top:10px;" class="btn btn-success pull-right"  id="loadMore">Xem thêm ...</button>
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
.totop {
    position: fixed;
    bottom: 10px;
    right: 20px;
}
.totop a {
    display: none;
}
.newItem-row{
	display:none;
}
</style>
<script src="js/lib/jquery/v3.3.1/jquery.min.js"></script>
<script src="js/lib/bootstrap/v3.3.7/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
    document.title = 'Đăng ký đồ án';
	$('.registerDoan').on('click',function(){
		var name = $(this).closest('.newItem').find('.newItem-title a').text();
		var id = $(this).attr('data-id');
		$('#registerDoanModal .showTenDoan').empty().append(name);
		$('#registerDoanModal #registerDoanTxt').val(id);
		$('#registerDoanModal').modal('show');
	})
	$('#registerDoanModal .saveRegisterDoan').on('click',function(){
		var id = $('#registerDoanTxt').val();
		$.post(
	            "<?= getLink('administrator/postAjax.php?type=registerdoan') ?>",
	            {
	                'id' : $('#registerDoanTxt').val(),
	            },
	            function(rs){
	            	var rs = JSON.parse(rs);
	                if(rs.code){
	                	var html = '<div class="alert alert-success"> Đăng ký thành công, bạn vui lòng truy cập chi tiết <a href="<?=  getLink('index.php?linkpage=ctdoan') ?>&id='+id+'">Tại đây</a> </div>';
	                	$('#registerDoanModal').modal('hide');
	                    $("#alertModal").modal('show');
	                    $('#alertModal .modal-body').empty();
	                    $('#alertModal .modal-body').append(html);
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

	$("div.newItem-row").slice(0, 5).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".newItem-row:hidden").slice(0, 5).slideDown();
        if ($(".newItem-row:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
})
</script>
</body>
</html>
