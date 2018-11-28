<?php
use Model\Report;
use Model\ReportMapper;

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$report = new Report();
$reportMapper = new ReportMapper($connect);
$result = $reportMapper->reportDashboard($report) ? : [];
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
?>
<div id="content">
	<div id="content-header">
		<div id="breadcrumb">
			<a href="<?php getLink('administrator/index.php') ?>" title=""
				class="tip-bottom"><i class="icon-home"></i> Trang chủ</a>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<?php if (isAdmin($userService)){?>
				<ul class="site-stats">
					<li class="bg_lb"><a href="<?= getLink('administrator/index.php?linkpage=dssv') ?>" style="color: #fff;"><i class="icon-group"></i> <strong><?= !empty($result['totalSV']) ? $result['totalSV'] : 0; ?></strong>
						<small>Tổng số sinh viên</small></a></li>
					<li class="bg_lg"><a href="<?= getLink('administrator/index.php?linkpage=dsdoan') ?>" style="color: #fff;"><i class="icon-book"></i> <strong><?= !empty($result['totalDoan']) ? $result['totalDoan'] : 0; ?></strong> <small>Tổng
							số đồ án </small></a></li>
					<li class="bg_ly"><a href="<?= getLink('administrator/index.php?linkpage=dslop') ?>" style="color: #fff;"><i class="icon-bookmark"></i> <strong><?= !empty($result['totalLop']) ? $result['totalLop'] : 0; ?></strong>
						<small>Tổng số lớp</small></a></li>
					<li class="bg_lo"><a href="<?= getLink('administrator/index.php?linkpage=dskhoa') ?>" style="color: #fff;"><i class="icon-folder-close"></i> <strong><?= !empty($result['totalKhoa']) ? $result['totalKhoa'] : 0; ?></strong>
						<small>Tổng số khoa</small></a></li>
					<li class="bg_ls"><a href="<?= getLink('administrator/index.php?linkpage=dsgv') ?>" style="color: #fff;"><i class="icon-user"></i> <strong><?= !empty($result['totalGV']) ? $result['totalGV'] : 0; ?></strong> <small>Tổng
							số giảng viên</small></a></li>
					<li class="bg_lh"><a href="<?= getLink('administrator/index.php?linkpage=baiviet') ?>" style="color: #fff;"><i class="icon-pencil"></i> <strong><?= !empty($result['totalBaiviet']) ? $result['totalBaiviet'] : 0; ?></strong>
						<small>Tổng số bài viết</small></a></li>
					<li class="bg_lg"><i class="icon-user"></i> <strong><?= !empty($result['totalSVDat']) ? $result['totalSVDat'] : 0; ?></strong>
						<small>Tổng số sinh viên đạt</small></li>
					<li class="bg_lo"><i class="icon-user"></i> <strong><?= !empty($result['totalSVKhongDat']) ? $result['totalSVKhongDat'] : 0; ?></strong> <small>Tổng
							số sinh viên không đạt </small></li>
				</ul>
				<?php }else{?>
				<ul class="site-stats">
					<li class="bg_lb"><i class="icon-group"></i> <strong><?= !empty($result['totalSV']) ? $result['totalSV'] : 0; ?></strong>
						<small>Tổng số sinh viên</small></li>
					<li class="bg_lg"><i class="icon-book"></i> <strong><?= !empty($result['totalDoan']) ? $result['totalDoan'] : 0; ?></strong> <small>Tổng
							số đồ án </small></li>
					<li class="bg_ly"><i class="icon-bookmark"></i> <strong><?= !empty($result['totalLop']) ? $result['totalLop'] : 0; ?></strong>
						<small>Tổng số lớp</small></li>
					<li class="bg_lo"><i class="icon-folder-close"></i> <strong><?= !empty($result['totalKhoa']) ? $result['totalKhoa'] : 0; ?></strong>
						<small>Tổng số khoa</small></li>
					<li class="bg_ls"><i class="icon-user"></i> <strong><?= !empty($result['totalGV']) ? $result['totalGV'] : 0; ?></strong> <small>Tổng
							số giảng viên</small></li>
					<li class="bg_lh"><i class="icon-pencil"></i> <strong><?= !empty($result['totalBaiviet']) ? $result['totalBaiviet'] : 0; ?></strong>
						<small>Tổng số bài viết</small></li>
					<li class="bg_lg"><i class="icon-user"></i> <strong><?= !empty($result['totalSVDat']) ? $result['totalSVDat'] : 0; ?></strong>
						<small>Tổng số sinh viên đạt</small></li>
					<li class="bg_lo"><i class="icon-user"></i> <strong><?= !empty($result['totalSVKhongDat']) ? $result['totalSVKhongDat'] : 0; ?></strong> <small>Tổng
							số sinh viên không đạt </small></li>
				</ul>
				<?php }?>
			</div>
			
		</div>
	</div>
</div>
<?php include_once 'layout/frame/footer.php';?>
