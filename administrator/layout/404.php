<?php
use Model\Report;
use Model\ReportMapper;

include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$report = new Report();
$reportMapper = new ReportMapper($connect);
$result = $reportMapper->reportDashboard($report) ? : [];
?>
<div id="content">
	<div id="content-header">
		<div id="breadcrumb">
			<a href="<?php getLink('/administrator/index.php') ?>" title=""
				class="tip-bottom"><i class="icon-home"></i> Trang chủ</a>
		</div>
	</div>
	<div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Error 404</h5>
          </div>
          <div class="widget-content">
            <div class="error_ex">
              <h1>404</h1>
              <h3>Xin lỗi, trang này không tồn tại.</h3>
              <p>Chúng tôi không thể tìm thấy trang này.</p>
              <a class="btn btn-warning btn-big"  href="<?= getLink('/administrator/index.php') ?>">Trở về trang chủ</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once 'layout/frame/footer.php';?>
