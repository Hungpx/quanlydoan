<!--Header-part-->
<?php 
if (empty($_SESSION['userService'])){
    redirect_to('index.php');
}
$userService = $_SESSION['userService'];

?>
<div id="header">
  <h1><a href="dashboard.html">ĐH công nghiệp Việt - Hung <br> ADMINISTRATOR</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" >
    	<a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  
    	<span class="text">Chào <?= $userService['tenNhomquyen'].' '.$userService['ten']; ?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> Thông tin cá nhân</a></li>
        <li class="divider"></li>
        <li><a href="<?= getLink('administrator/index.php?linkpage=logout') ?>"><i class="icon-key"></i> Đăng xuất</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Cài đặt</span></a></li>
    <li class=""><a title="" href="<?= getLink('administrator/index.php?linkpage=logout') ?>"><i class="icon icon-share-alt"></i> <span class="text">Đăng xuất</span></a></li>
  </ul>
</div>