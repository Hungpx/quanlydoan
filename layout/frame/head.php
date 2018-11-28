<?php 
use Model\Menu;
use Model\MenuMapper;

include_once  'Model/Menu.php';
include_once  'Model/MenuMapper.php';
$linkpage = !empty($_GET['linkpage']) ? $_GET['linkpage'] : '';
$menu = new Menu();
$menuMapper = new MenuMapper($connect);
$menus = $menuMapper->fetchAll($menu);
?>
<div class="head-wrapper">
    <div id="top-head">
       <div class="logo-area pull-left">
          <a href="<?= getLink('index.php')?> ?>"><img class="logo-main scale-with-grid" src="<?= getViewPath('images/logo.png')?>" alt="" style="width: auto; height: 100px;"></a>
       </div>
       <div class="right-info pull-right">
          <div class="right-conten-banner">
             <div class="row">
                <div class="name-description col-md-9">
                   <p style="margin:15px 0 0;color:#000000;font-size:19px">ĐẠI HỌC CÔNG NGHIỆP VIỆT - HUNG</p>
                   <p style="margin:10px 0 0;color:#01b4dd;font-size:18px">VietNam -Hungary Industrial University </p>
                </div>
                <div class="language col-md-3 pull-right;">
                   <a class="pull-right" href="#"><img src="<?= getViewPath('images/quoc-ky-viet-nam.jpg') ?>" title="Tiếng Việt" style="text-align:right;"></a>
                   <a class="pull-right" href="#"><img src="<?= getViewPath('images/quoc-ky-anh.jpg') ?>" title="Tiếng Anh" style="text-align:right;"></a>
                </div>
             </div>
          </div>
          <div class="clearfix"></div>
          <div class="menu-area">
             <nav id="menu" class="menu-main-menu-container">
                <ul id="menu-main-menu" class="menu">
                <?php 
                ?>
                   <li class="menu-item <?= (! $linkpage && empty($_GET['menuId'])) ? 'active' : ''; ?>"><a href="<?= getLink('index.php') ?>"><span>Trang chủ</span></a></li>
                   <li class="menu-item <?= (! empty($_GET['linkpage']) && $_GET['linkpage'] == 'gioithieu') ? 'active' : ''; ?>"><a href="<?= getLink('index.php?linkpage=gioithieu') ?>"><span>Giới thiệu</span></a></li>
                   <?php 
                   if ($menus){
                       foreach ($menus as $menu){
                           $active = '';
                           if (!empty($_GET['menuId']) && $_GET['menuId'] == $menu->getId()){
                               $active = 'active';
                           }
                           echo '<li class="menu-item '.$active.'"><a href="'.getLink('index.php?linkpage=dstintuc&menuId='.$menu->getId()).'"><span>'.$menu->getTenMenu().'</span></a></li>' ;
                       }
                   }
                   unset($menus);
                   unset($menu);
                   ?>
                   
                </ul>
             </nav>
          </div>
          <div class="search-icon"><i style="cursor: pointer;" id="showSearchArea" class="fa fa-lg fa-search"></i></div>
       </div>
    </div>
 </div>