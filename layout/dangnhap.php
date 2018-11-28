<?php
require_once 'Model/Base/Function.php';
include_once 'frame/top.php';
if (!empty($_SESSION['userService'])){
    redirect_to('index.php');
}
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<div id="content">
		<div class="row formArea">
               <div class="col-md-3">
                  <?php include_once 'frame/sidebar.php';?>
               </div>
               <?php 
               $statusClass = 'alert alert-warning';
               $message = ' Bạn vui lòng nhập tài khoản và mật khẩu. Nếu chưa có tài khoản, bạn vui lòng đăng ký <a href="'.getLink('index.php?linkpage=dangky').'" style="font-weight: bold;" class="text-danger">Tại đây.</a>';
               if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                   $isValid = true;
                  if (empty($_POST['taikhoan']) || empty($_POST['matkhau'])){
                      $isValid = false;
                      $statusClass = 'alert alert-danger';
                      $message = 'Bạn vui lòng nhập đầy đủ thông tin';
                  }else{
                      $user = new Model\User();
                      $user->setTaikhoan(isValidFormPost($_POST['taikhoan']));
                      $user->setMatkhau(isValidFormPost(md5($_POST['matkhau'])));
                      $user->setTrangthai(Model\User::STATUS_INACTIVE);
                      $userMapper = new Model\UserMapper($connect);
                      if ($userMapper->isExist($user)){
                          $isValid = false;
                          $statusClass = 'alert alert-danger';
                          $message = 'Tài khoản chưa được kích hoạt! Bạn vui lòng chờ quản lý kích hoạt tài khoản. ';
                      }
                      elseif (! $userMapper->checkLogin($user)){
                          $isValid = false;
                          $statusClass = 'alert alert-danger';
                          $message = 'Tài khoản hoặc mật khẩu không đúng! ';
                      }else{
                          $data = [
                              'taikhoan' => $user->getTaikhoan(),
                              'trangthai'=> $user->getTrangthai(),
                              'nhomquyen' => $user->getNhomquyen() ];
                          if ($user->getNhomquyen() == $user::ROLE_ADMIN){
                              $giangvien = $user->getOption('giangvien')? : new Model\Giangvien();
                              $data['id'] = $giangvien->getId();
                              $data['maCode'] = $giangvien->getMaGV();
                              $data['ten']= $giangvien->getTenGV();
                              $data['soDT']= $giangvien->getSoDT();
                              $data['email']= $giangvien->getEmail();
                              $data['tenNhomquyen']= 'Quản lý';
                          }
                          elseif ($user->getNhomquyen() == $user::ROLE_TEACHER ){
                              $giangvien = $user->getOption('giangvien')? : new Model\Giangvien();
                              $data['id'] = $giangvien->getId();
                              $data['maCode'] = $giangvien->getMaGV();
                              $data['ten']= $giangvien->getTenGV();
                              $data['soDT']= $giangvien->getSoDT();
                              $data['email']= $giangvien->getEmail();
                              $data['tenNhomquyen']= 'giảng viên';
                          }elseif ($user->getNhomquyen() == $user::ROLE_STUDENT){
                              $sinhvien = $user->getOption('sinhvien')? : new Model\Sinhvien();
                              $data['id'] = $sinhvien->getId();
                              $data['maCode'] = $sinhvien->getMaSV();
                              $data['ten']= $sinhvien->getTenSV();
                              $data['soDT']= $sinhvien->getSoDT();
                              $data['diachi']= $sinhvien->getDiachi();
                              $data['tenNhomquyen']= 'sinh viên';   
                          }else{
                              $data['ten'] = '';
                              $data['tenNhomquyen'] = 'Admin';
                          }
                          $_SESSION['userService'] = $data;
                          redirect_to('index.php');
                      }
                  }
                  
               }
               ?>
               <div class="col-md-9 form-content-area">
                  <div id="from-heading">
                        <p class="from-heading-title"><i class="fa fa-sign-in-alt"></i> Đăng nhập hệ thống</p>
                  </div>
                  <div id="showMessage" class="col-md-12">
                  	 <div class="<?= $statusClass ?>"> <?= $message; ?></div>
                  </div>
                  <div class="show-form-area">
                     <div id="form-login-area">
                        <form id="loginForm" method="post" class="formBase">
                           <div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
                                        <span class="fa fa-user"></span>
                                    </span>
									<input type="text" class="form-control required" name="taikhoan" id="username" placeholder="Tài khoản">
								</div>
                           </div>
                           <div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
                                        <span class="fa fa-lock"></span>
                                    </span>
									<input type="password" name="matkhau" class="form-control required" id="password" placeholder="Mật khẩu">
								</div>
                           </div>
                           <button id="btnSave" class="btn btn-info col-xs-12">  Đăng nhập</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
	</div>
</div>
<?php include_once 'frame/footer.php';?>
<script src="js/lib/jquery/v3.3.1/jquery.min.js"></script>
<script src="js/lib/bootstrap/v3.3.7/bootstrap.min.js"></script>
<script type="text/javascript">
$('')
</script>
</body>
</html>
