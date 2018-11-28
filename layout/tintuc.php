<?php
use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
include_once 'frame/top.php';
$baiviet = new Model\Baiviet();
$baiviet->setId($_GET['id']);
$baivietMapper = new Model\BaivietMapper($connect);
if (! $baivietMapper->get($baiviet)){
    redirect_to('index.php');
}
?>
<?php 
?>
<div id="wrapper">
	<?php include 'frame/head.php';?>
	<div id="content">
		<div class="row formArea">
               <div class="col-md-3">
                  <?php include_once 'frame/sidebar.php';?>
               </div>
              <div id="new-area" class="col-md-9">
				<div class="col-xs-12 row">
					<div class="new-content"><h2><?= $baiviet->getTieude(); ?></h2></div>
					<div class="new-content-wrapper">
						<?= $baiviet->getChitiet(); ?>
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
    document.title = 'Giới thiệu';
})

</script>
</body>
</html>
