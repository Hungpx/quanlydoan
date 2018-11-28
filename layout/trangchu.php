<?php
use Model\Sinhvien;
use Model\Giangvien;
use Model\User;

include_once 'frame/top.php';
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<?php include 'frame/slider.php';?>
		<div id="content">
		<div id="show-login-area">
			<div class="register-area pull-right">
			<?php 
			if (isset($_SESSION['userService']) && $_SESSION['userService']){
			    $userService = $_SESSION['userService'];
			    $roleName = 'Quản lý';
			    $user = new User();
			    if ($userService['nhomquyen'] == $user::ROLE_TEACHER){
			        $roleName = 'Giảng viên';
			    }elseif ($userService['nhomquyen'] == $user::ROLE_STUDENT){
			        $roleName = 'bạn';
			    }
			    $code = !empty($userService['maCode']) ? $userService['maCode'] : '';
			    $name = !empty($userService['ten']) ? $userService['ten'] : '';
			    $message = 'Chào '. $roleName.',';
			    $message.= ' '.$code.' - '.$name;
			    $allowJoinDashBoard = false;
			    if ($userService['nhomquyen'] == $user::ROLE_TEACHER || $userService['nhomquyen'] == $user::ROLE_ADMIN){
			        $allowJoinDashBoard = true;
			    }
			    echo '<b class="text-danger"><i style="line-height: 25px;" class="fa fa-user"></i> '.$message.'</b>';
			    if ($allowJoinDashBoard){
			        echo '<a style="margin-left:15px;" href="'.getLink('administrator/index.php').'" > <i style="line-height: 25px;" class="fa fa-list-alt"></i> Vào trang quản trị</a>';
			    }
			    echo '<a style="margin-left:15px;" href="'.getLink('index.php?linkpage=logout').'" >| <i style="line-height: 25px;" class="fa fa-sign-out-alt"></i> Đăng xuất</a>';
			}else{
			?>
				<a href="<?= getLink('index.php?linkpage=dangky')?>"><i style="line-height: 25px;" class="fa fa-user"></i>
					Đăng ký</a> / <a href="<?= getLink('index.php?linkpage=dangnhap')?>"><i style="line-height: 25px;"
					class="fa fa-sign-in-alt"></i> Đăng nhập</a>
			<?php }?>
			</div>
		</div>
		<div class="news-content">
			<div class="row">
				<div class="col-md-12 title-head">
					<h2 class="text-title">
						<a><i class="fa fa-search head-icon"></i> Tra cứu thông tin</a>
					</h2>
				</div>
				<div class="col-md-12 content-area">
					<div class="list-search-map">
						<div class="row">
							<div class="col-md-3 row-map">
								<div class="search-map-icon">
									<a href="<?= getLink('index.php?linkpage=dsdoan') ?>" class="fa fa-search"></a>
								</div>
								<div class="text-map">
									<a href="<?= getLink('index.php?linkpage=dsdoan') ?>">Tra cứu đồ án</a>
								</div>
							</div>
							<div class="col-md-3 row-map">
								<div class="search-map-icon">
									<a href="<?= getLink('index.php?linkpage=calendar') ?>" class="fa fa-calendar"></a>
								</div>
								<div class="text-map">
									<a href="<?= getLink('index.php?linkpage=calendar') ?>">Đồ án đã đăng ký</a>
								</div>
							</div>
							<div class="col-md-3 row-map">
								<div class="search-map-icon">
									<a href="<?= getLink('index.php?linkpage=nopdoan') ?>" class="fa fa-upload"></a>
								</div>
								<div class="text-map">
									<a href="<?= getLink('index.php?linkpage=nopdoan') ?>">Nộp đồ án</a>
								</div>
							</div>
							<div class="col-md-3 row-map">
								<div class="search-map-icon">
									<a href="<?= getLink('index.php?linkpage=kq') ?>" class="fa fa-check"></a>
								</div>
								<div class="text-map">
									<a href="<?= getLink('index.php?linkpage=kq') ?>">Kết quả</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="news-content">
			<div class="row">
				<div class="col-md-12 title-head">
					<h2 class="text-title">
						<a><i class="fa fa-book head-icon"></i> Thông báo - tin tức</a>
					</h2>
				</div>
				<div class="col-md-12 content-area">
					<?php 
					$baiviet = new Model\Baiviet();
					$baivietMapper = new Model\BaivietMapper($connect);
					$lstBaiviet = $baivietMapper->fetchAll($baiviet);
					?>
					<div class="row">
						<?php if ($lstBaiviet){
						      foreach ($lstBaiviet as $baiviet){
						?>
						<div class="col-md-3 row-news">
							<div class="image-area">
								<?php 
								$anhDaidien = getViewPath('images/noImage.jpg');
								if ($baiviet->getAnhDaiDien()){
								    $anhDaidien = getViewPath('upload/baiviet/'.$baiviet->getAnhDaiDien());
								}
								?>
								<a href="#"><img src="<?= $anhDaidien ?>"
									alt="Đại học Việt - Hung"></a>
							</div>
							<div class="news-text-title">
								<a href="<?= getLink('index.php?linkpage=tintuc&id='.$baiviet->getId()) ?>"><?= $baiviet->getTieude(); ?></a>
							</div>
						</div>
						<?php }} ?>
						
						
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
			document.title = 'Đại học công nghiệp Việt - Hung'
	</script>
   </body>
</html>

