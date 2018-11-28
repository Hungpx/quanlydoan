<?php
use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
include_once 'frame/top.php';
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isValid = true;$errorMsg = '';
    if (empty($_POST['maDoan'])){
        $isValid = false;
        $errorMsg = 'Bạn chưa chọn đồ án.';
    }
    if (empty($_FILES['fileUpload']['name'])){
        $isValid = false;
        $errorMsg = 'Bạn chưa chọn file cần upload.';
    }
    $fileUpload = $_FILES['fileUpload'];
    $name = $fileUpload["name"];
    $ext = end((explode(".", $name)));
    $ext = strtolower($ext);
    if ($ext && ! in_array($ext, ['zip', 'doc', 'docx', 'rar','.txt', '.pdf'])){
        $isValid = false;
        $errorMsg = 'File Upload không đúng định dạng.';
    }
    if ($isValid){
        $svThamgia = new Model\SinhvienThamgia();
        $svThamgia->exchangeArray($_POST);
        $svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
        if ($svThamgiaMapper->isExist($svThamgia)){
            $savePath = 'doan'.'/'.$svThamgia->getMaDoan().'/'.$svThamgia->getMaSV();
            $targetFolder = getSavePath($savePath);
            if (!file_exists($targetFolder)) {
                $oldmask = umask(0);
                mkdir($targetFolder, 0777, true);
                umask($oldmask);
            }
            rename($fileUpload['tmp_name'], $targetFolder.'/'.$fileUpload['name']);
            $svThamgia->setFileName($fileUpload['name']);
            $svThamgia->setTrangthai(Model\SinhvienThamgia::STATUS_DONE);
            $svThamgiaMapper->update($svThamgia);
        }
    }
    
}
if ($userService){
    $sinhvienThamgia = new Model\SinhvienThamgia();
    $sinhvienThamgia->setMaSV($userService['id']);
    $sinhvienThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
    $lstSvtg = $sinhvienThamgiaMapper->fetchAll($sinhvienThamgia);
}
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<div id="content">
		<div class="row formArea">
               <div class="col-md-3">
                  <?php include_once 'frame/sidebar.php';?>
               </div>
              <div class="col-md-9 form-content-area">
                   <div id="from-heading">
                      <p class="from-heading-title"><i class="fa fa-user"></i> Nộp đồ án</p>
                   </div>
                   <?php if(! $userService){?>
                   	<div class="alert alert-info">Bạn vui lòng đăng nhập để thực hiện chức năng này. Đăng nhập <a class="text-danger" href="<?= getLink('index.php?linkpage=dangnhap') ?>"> Tại đây</a></div>
					<?php }elseif ($userService['nhomquyen'] != Model\User::ROLE_STUDENT){ ?>
					<div class="alert alert-info">Chức năng này chỉ áp dụng cho sinh viên.</div>
					<?php }elseif (! $lstSvtg){ ?>
					<div class="alert alert-info">Bạn chưa đăng ký đồ án nào. Vui lòng đăng ký <a class="text-danger" href="<?= getLink('index.php?linkpage=dsdoan') ?>"> Tại đây</a></div>
					<?php }else{ 
					    ?>
                   <div class="alert alert-info"> Chỉ cho phép upload file .doc, .docx, .rar, .zip, .txt, .pdf</div>
                   <div class="show-form-area">
                   		
                      <div id="form-login-area">
                         <form id="registerDoanForm" method="post" action="index.php?linkpage=nopdoan" class="formBase" enctype="multipart/form-data">
                           <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){?>
                           <?php if (! $isValid){?>
                           <div class="form-group">
                   				<span style="text-align: center;" class="text-danger"><?= $errorMsg ?></span>
                   			</div>
                   			<?php }else{ ?>
                   			<div class="form-group">
                   				<span style="line-height: 20px;" class="text-success">Bạn đã đăng ký đồ án thành công! Vui lòng chờ giảng viên chấm bài. Xem kết quả <a class="text-danger" href="<?= getLink('index.php?linkpage=kq') ?>">Tại đây</a></span>
                   			</div>
                   			<?php }} ?>
                            <div class="form-group">
                               <input type="hidden" name="maSV" class="form-control required" id="maSV" value="<?= $userService['id'] ?>" >
                            </div>
                            <div class="form-group">
                               <select id="maDoan" name="maDoan" class="form-control required">
                                  <option value="">--Chọn đồ án--</option>
                                  <?php 
                                  
                                  if ($lstSvtg){
                                      foreach ($lstSvtg as $sinhvienThamgia){
                                          $doan = $sinhvienThamgia->getOption('doan') ? : new Model\Doan();
                                          echo '<option value="'.$sinhvienThamgia->getMaDoan().'">'.$doan->getTenDoan().'</option>';
                                      }
                                  }
                                  ?>
                               </select><span class="requiredInput">(*)</span>
                            </div>
                             <div class="form-group">
                                 <input type="file" name="fileUpload" id="fileUpload">
                            </div>
                            <div class="form-group"></div>
                            <a id="btnSaveForm" href="javascript:;"  class="btn btn-info col-xs-12"> Nộp đồ án</a>
                         </form>
                      </div>
                   </div>
                   <?php } ?>
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
</style>
<script src="js/lib/jquery/v3.3.1/jquery.min.js"></script>
<script src="js/lib/bootstrap/v3.3.7/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
    document.title = 'Đăng ký tài khoản';
    $('#btnSaveForm').on('click',function(){
    	if(checkForm()){
        	$('form#registerDoanForm').submit();
        }
    })
})
function checkForm(){
    	$('.formBase .error').removeClass('error');
    	var isValid = true;
    	$('.formBase .required').each(function(){
    		if(!$(this).val()){
    			isValid = false;
    			$(this).addClass('error');
    		}
    	});
    	return isValid;
    }
</script>
</body>
</html>
