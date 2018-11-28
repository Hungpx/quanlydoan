<?php
use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
include_once 'frame/top.php';
?>
<?php 
$lop = new Lop();
$lopMapper = new LopMapper($connect);
$lops = $lopMapper->search($lop);
$messages = 'Bạn vui lòng điền đầy đủ thông tin.';
$isValid = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataPost = [];
    foreach ($_POST as $key => $value){
        $dataPost[$key] = isValidFormPost($value);
    }
    $isValid = true;
    if (empty($dataPost['maSV']) || empty($dataPost['tenSV']) || empty($dataPost['maLop']) || empty($dataPost['soDT'])  || empty($dataPost['matkhau']) || empty($dataPost['matkhau2'])){
        $isValid = false;
        $messages = 'Bạn cần nhập đầy đủ thông tin';
    }
    elseif (!isValidPhoneNumber($dataPost['soDT'])){
        $isValid = false;
        $messages = 'Số điện thoại không hợp lệ';
    }
    elseif ($dataPost['matkhau'] != $dataPost['matkhau2']){
        $isValid = false;
        $messages = 'Mật khẩu xác nhận không đúng';
    }
    else{
        //Check mã sinh viên đã tồn tại trên hệ thống chưa
        $sinhvien = new Sinhvien();
        $sinhvien->setMaSV($dataPost['maSV']);
        $sinhvienMapper = new SinhvienMapper($connect);
        if ($sinhvienMapper->isExist($sinhvien)){
            $isValid = false;
            $messages = 'Mã sinh viên này đã tồn tại. Vui lòng chọn mã sinh viên khác khác.';
        }
        
    }
    if ($isValid){
        $messages = 'Đăng ký thành công. Bạn vui lòng chờ Admin kích hoạt tài khoản. <a href="'.getLink('index.php').'"> Trở lại trang chủ</a>';
        //Save Tài khoản
        $user = new User();
        $user->setTaikhoan($dataPost['maSV']);
        $user->setMatkhau(md5($dataPost['matkhau']));
        $user->setTrangthai($user::STATUS_INACTIVE);
        $user->setNhomquyen($user::ROLE_STUDENT);
        $userMapper = new UserMapper($connect);
        $userMapper->save($user);
        
        $sinhvien = new Sinhvien();
        $sinhvien->exchangeArray($dataPost);
        $sinhvien->setMaTaikhoan($user->getId());
        $sinhvienMapper = new SinhvienMapper($connect);
        $sinhvienMapper->save($sinhvien);
        
        
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
              <div class="col-md-9 form-content-area">
                   <div id="from-heading">
                      <p class="from-heading-title"><i class="fa fa-user"></i> Đăng ký tài khoản</p>
                   </div>
                   <div class="<?= $isValid ? 'alert alert-success' : 'alert alert-danger' ?>"> <?= $messages; ?>.</div>
                   <div class="show-form-area">
                      <div id="form-login-area">
                         <form id="registerForm" method="post" action="index.php?linkpage=dangky" class="formBase">
                            <div class="form-group">
                               <input type="text" name="maSV" class="form-control required" id="maSV" placeholder="Mã sinh viên"><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <input type="text" class="form-control required" name="tenSV" id="tenSV" placeholder="Họ tên sinh viên"><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <select id="maLop" name="maLop" class="form-control required">
                                  <option value="">--Lớp--</option>
                                  <?php 
                                  if ($lops){
                                      foreach ($lops as $lop){
                                          echo '<option value="'.$lop->getId().'">'.$lop->getMaLop().' - '.$lop->getTenLop().'</option>';
                                      }
                                  }
                                  ?>
                               </select><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <input type="text" class="form-control required" name="soDT" id="soDT" placeholder="Số điện thoại"><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <input type="password" class="form-control required" name="matkhau" id="matkhau" placeholder="Mật khẩu"><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <input type="password" class="form-control required" name="matkhau2" id="matkhau2" placeholder="Xác nhận Mật khẩu"><span class="requiredInput">(*)</span>
                            </div>
                            <div class="form-group">
                               <textarea id="diachiSv" style="min-height: 80px;" name="diachi"  class="form-control" placeholder="Địa chỉ"></textarea>
                            </div>
                            <a id="btnSaveForm" href="javascript:;"  class="btn btn-info col-xs-12">  Đăng ký</a>
                         </form>
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
</style>
<script src="js/lib/jquery/v3.3.1/jquery.min.js"></script>
<script src="js/lib/bootstrap/v3.3.7/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
    document.title = 'Đăng ký tài khoản';
    $('#btnSaveForm').on('click',function(){
    	if(checkForm()){
        	$('form#registerForm').submit();
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
