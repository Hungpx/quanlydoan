<?php  
$activeDoanLinks = [
    'dsdoan', 'dsloaidoan', 'dschude','editdoan','editchude','editloaidoan','adddoan','addloaidoan','addchude'
];
$activeSVLinks = [
    'dssv', 'dslop', 'dskhoa','editsv','editlop','editkhoa','addsv','addkhoa','addchude'
];
$userService = $_SESSION['userService'];
?>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard2</a>
<?php if ($userService['nhomquyen'] == \Model\User::ROLE_ADMIN){ //Check quyền Admin?>
  <ul>
    <li ><a href="<?= getLink('administrator/index.php') ?>"><i class="icon icon-home"></i> <span>Trang chủ</span></a> </li>
     <li class="submenu <?= (!empty($_GET['linkpage']) && in_array($_GET['linkpage'], $activeDoanLinks)) ?  'active' : ''?>"> <a href="#"><i class="icon icon-th-list"></i> <span>Quản lý đồ án</span></a>
      <ul>
      	<li class=""><a href="<?= getLink('administrator/index.php?linkpage=dsdoan') ?>">Danh sách đồ án</a></li>
      	<li><a href="<?= getLink('administrator/index.php?linkpage=dschude') ?>">Danh sách chủ đề</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=dsloaidoan') ?>">Danh sách loại đồ án</a></li>
      </ul>
    </li>
    <li class="submenu" <?= (!empty($_GET['linkpage']) && in_array($_GET['linkpage'], $activeSVLinks)) ?  'active' : ''?>> <a href="#"><i class="icon icon-th-list"></i> <span>Quản lý sinh viên</span></a>
      <ul>
      	<li><a href="<?= getLink('administrator/index.php?linkpage=dssv') ?>">Danh sách sinh viên</a></li>
      	<li><a href="<?= getLink('administrator/index.php?linkpage=dskhoa') ?>">Danh sách khoa</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=dslop') ?>">Danh sách lớp</a></li>
      </ul>
    </li>
    <li> <a href="<?= getLink('administrator/index.php?linkpage=dsgv') ?>"><i class="icon icon-th-list"></i> <span>Quản lý giảng viên</span></a></li>
    <li class="submenu"> 
    	<a href="<?= getLink('administrator/index.php?linkpage=cdhd') ?>"><i class="icon icon-th-list"></i> <span>Chấm điểm</span></a>
    <ul>
        <li><a href="<?= getLink('administrator/index.php?linkpage=cdhd') ?>">Chấm điểm hướng dẫn</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=cdpb') ?>">Chấm điểm phản biện</a></li>
      </ul>
    </li>
    <li> <a href="<?= getLink('administrator/index.php?linkpage=menu') ?>"><i class="icon icon-th-list"></i> <span>Quản lý Menu</span></a></li>
   	<li> <a href="<?= getLink('administrator/index.php?linkpage=baiviet') ?>"><i class="icon icon-th-list"></i> <span>Quản lý bài viết</span></a></li>
    
    <li class="submenu"> <a href="<?= getLink('administrator/index.php?linkpage=bcdiem') ?>"><i class="icon icon-signal"></i> <span>Thống kê - Báo cáo</span></a>
      <ul>
        <li><a href="<?= getLink('administrator/index.php?linkpage=bcdiem') ?>">Báo cáo điểm sinh viên</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=bcgv') ?>">Báo cáo đồ án theo giảng viên</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=bclop') ?>">Báo cáo sinh viên theo lớp</a></li>
      </ul>
    </li>
  </ul>
  <?php }else{ 
        //QUyền giảng viên
      ?>
  		  <ul>
    <li><a href="<?= getLink('administrator/index.php') ?>"><i class="icon icon-home"></i> <span>Trang chủ</span></a> </li>
    <li> <a href="<?= getLink('administrator/index.php?linkpage=dsdoan') ?>"><i class="icon icon-th-list"></i> <span>Quản lý đồ án</span></a>
    </li>
   <li class="submenu"> 
    	<a href="<?= getLink('administrator/index.php?linkpage=cdhd') ?>"><i class="icon icon-th-list"></i> <span>Chấm điểm</span></a>
    <ul>
        <li><a href="<?= getLink('administrator/index.php?linkpage=cdhd') ?>">Chấm điểm hướng dẫn</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=cdpb') ?>">Chấm điểm phản biện</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="<?= getLink('administrator/index.php?linkpage=bcdiem') ?>"><i class="icon icon-signal"></i> <span>Thống kê - Báo cáo</span></a>
      <ul>
        <li><a href="<?= getLink('administrator/index.php?linkpage=bcdiem') ?>">Báo cáo điểm sinh viên</a></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=bcgv') ?>">Báo cáo đồ án theo giảng viên</a></li>
         <li><a href="<?= getLink('administrator/index.php?linkpage=bclop') ?>">Báo cáo sinh viên theo lớp</a></li>
      </ul>
    </li>
  </ul>
  <?php }?>
</div>