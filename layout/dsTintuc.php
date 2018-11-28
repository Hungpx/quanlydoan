<?php
use Model\Menu;
use Model\MenuMapper;
include_once 'frame/top.php';
$menu = new Menu();
$menu->setId($_GET['menuId']);
$menuMapper = new MenuMapper($connect);
if (!$menuMapper->get($menu)){
    redirect_to('index.php?');
}
$menuName = $menu->getTenMenu();

$baiviet = new Model\Baiviet();
$baiviet->setMenuId($_GET['menuId']);
$baivietMapper = new Model\BaivietMapper($connect);
$lstBaiviet = $baivietMapper->fetchAll($baiviet);
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
              <div class="col-md-9">
				<div id="news-area" class="col-xs-12 row">
					<div class="title-content"><h2><?= $menuName; ?></h2></div>
					<?php 
					if (!$lstBaiviet){
					    echo '<div class="alert alert-info"> Chưa có bài viết nào trong mục này.</div>';
					}else{
					    foreach ($lstBaiviet as $baiviet){
					?>
					<div class="newItem-row col-md-12">
						<div class="row">
							<div class="image-title col-md-4">
        						<a href="#">
        						<?php 
        						$anhDaidien = getViewPath('images/noImage.jpg');
        						if ($baiviet->getAnhDaiDien()){
        						    $anhDaidien = getViewPath('upload/baiviet/'.$baiviet->getAnhDaiDien());
        						}
        						?>
        						<img src="<?= $anhDaidien ?>" alt="Đại học Việt - Hung">
        						</a>
        					</div>
        					<div class="newItem col-md-8">
        						<h3 class="newItem-title"><a href="<?= getLink('index.php?linkpage=tintuc&id='.$baiviet->getId()) ?>"><?= $baiviet->getTieude() ?></a></h3>
        						<div class="newItem-content">
        							<p>
        							 <?= $baiviet->getMota(); ?>
        							</p>
        						</div>
        						<div class="viewMoreArea">
        							<a href="<?= getLink('index.php?linkpage=tintuc&id='.$baiviet->getId()) ?>" class="view-more pull-right text-danger">+ Xem chi tiết</a>
        						</div>
        					</div>
						</div>
    				</div>
    				
    				<?php }} ?>
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
    document.title = '<?= $menu->getTenMenu() ?>';
})
</script>
</body>
</html>
