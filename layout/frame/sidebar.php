<?php if (empty($_SESSION['userService']) && $_GET['linkpage'] != 'dangnhap'){   ?>
 <a style="margin-bottom: 10px;display: block;" href="<?= getLink('index.php?linkpage=dangnhap')?>"><i
					class="fa fa-sign-in-alt"></i> Đăng nhập hệ thống</a>
<?php } ?>
<ul class="list-group list-group-flush list-menu-base-area">
    <li class="list-group-item"><a href="<?= getLink('index.php?linkpage=dsdoan') ?>"><i class="fa fa-search"></i> Tra cứu đồ án</a></li>
    <li class="list-group-item"><a href="<?= getLink('index.php?linkpage=calendar') ?>"><i class="fa fa-calendar"></i> Đồ án đã đăng ký</a></li>
    <li class="list-group-item"><a href="<?= getLink('index.php?linkpage=nopdoan') ?>"><i class="fa fa-upload"></i> Nộp đồ án</a></li>
    <li class="list-group-item"><a href="<?= getLink('index.php?linkpage=kq') ?>" ><i class="fa fa-check"></i> Xem kết quả</a></li>
</ul>
<?php
$user = new Model\User();
$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
if (!empty($userService['nhomquyen'])){ 
?>
<table class="table table-sm">
  <thead>
    <tr>
      <th colspan="2" scope="col"><b class="text-danger" style="font-size: 14px;font-weight: bold;"><i style="line-height: 19px;" class="fa fa-user"></i> Thông tin <?= $userService['tenNhomquyen'] ?></b></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Họ tên:</th>
      <td><?= $userService['ten'] ?></td>
    </tr>
    <?php if(! empty($userService['soDT'])){?>
    <tr>
      <th scope="row">Số ĐT:</th>
      <td><?= $userService['soDT'] ?></td>
    </tr>
    <?php } ?>
    <?php if(! empty($userService['email'])){?>
    <tr>
      <td scope="row">Email:</td>
      <td><?= $userService['email'] ?></td>
    </tr>
    <?php } ?>
    <?php if(! empty($userService['diachi'])){?>
    <tr>
      <td scope="row">Địa chỉ:</td>
      <td><?= $userService['diachi'] ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td scope="row">Nhóm quyền:</td>
      <td><?= $userService['tenNhomquyen'] ?></td>
    </tr>
    <tr>
      <td colspan="2" scope="col"><a href="<?= getLink('index.php?linkpage=logout') ?>" class="btn btn-warning btn-sm"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a> </td>
    </tr>
  </tbody>
</table>
<?php }?>