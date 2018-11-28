<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : '';
    $baiviet = new Model\Baiviet();
    $baiviet->setId($id);
    $baivietMapper = new Model\BaivietMapper($connect);
    $data = [];
    if (! $id || ! $baivietMapper->get($baiviet)){
        $data = ['code' => 0, 'messages' => ['Không có dữ liệu']];
        echo json_encode($data);
        return;
    }

    if ($baivietMapper->delete($baiviet)){
        $data['code'] = 1;
        $data['messages'] = 'Xóa thành công';
        echo json_encode($data);
        return;
    }else{
        $data['code'] = 0;
        $data['messages'] = 'Có lỗi khi xóa dữ liệu';
        echo json_encode($data);
        return;
    }
    echo json_encode($data);
    return;
    
}
include_once 'layout/frame/top-head.php';
include_once 'layout/frame/header.php';
include_once 'layout/frame/sidebar.php';
$baiviet = new Model\Baiviet();
$baivietMapper = new Model\BaivietMapper($connect);
$lstBaiviet = $baivietMapper->fetchAll($baiviet);

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php getLink('administrator/index.php') ?>" title="" class="tip-bottom"><i class="icon-home"></i> Trang chủ</a></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
              <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Danh sách bài viết</h5>
          </div>
          <div class="widget-content nopadding">
          	<div class="fr fr-btn-action">
              <a href="<?= getLink('administrator/index.php?linkpage=addbaiviet') ?>" class="btn btn-success btn-mini"><i class="icon-plus"></i> Thêm mới</a>
              <a id="exportCSV" href="javascript:;" class="btn btn-success btn-mini"><i class="icon-download-alt"></i> Xuất CSV</a>
            </div>
            <table id="baivietTable" class="table table-bordered data-table csvExportTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Menu</th>
                  <th>Tiêu đề</th>
                  <th>Ảnh đại diện</th>
                  <th>Mô tả</th>
                  <th><i class="icon-pencil"></i></th>
                   <th><i class="icon-remove"></i></th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($lstBaiviet){
              	     foreach ($lstBaiviet as $baiviet){
              	?>
                <tr class="gradeX">
                	<td><?= $baiviet->getId() ?></td>
                	<td><?= $baiviet->getOption('tenMenu') ?></td>
                  <td><?= $baiviet->getTieude() ?></td>
                  <td style="width:50px;">
                  <?php 
                  if ($baiviet->getAnhDaiDien()){
                      echo '<img style="width:50px;height:auto;" src="'. getViewPath('upload/baiviet/'.$baiviet->getAnhDaiDien()).'" />';
                  }
                  ?>
                  </td>
                  <td><?= $baiviet->getMota(); ?></td>
                  <td style="text-align: center;" class="center"><a href="<?= getLink('administrator/index.php?linkpage=editbaiviet&id='.$baiviet->getId()) ?>" ><i class="icon-pencil"></i></a></td>
                  <td style="text-align: center;" class="center"><a class="removeItem icon-remove text-danger" href="javascript:;" data-id="<?= $baiviet->getId() ?>"></a></td>
                </tr>
               <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="alertModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type='button' class='btn btn-default reload'
                        data-dismiss='modal'>Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php include_once 'layout/frame/footer.php';?>

<script type="text/javascript">
$(function(){
	$('.removeItem').on('click', function(){
		var item = $(this);
		if(confirm('Bạn chắc chắn xóa bài viết này?')){
			$.post(
		            "<?= getLink('administrator/index.php?linkpage=baiviet') ?>",
		            {
		                'id' : $(this).attr('data-id'),
		            },
		            function(rs){
		            	var rs = JSON.parse(rs);
		                if(rs.code){
		                    item.closest('tr').remove();
		                }else {
		                    var html = '<div class="alert alert-warning alert-dismissable"> '+rs.messages+'</div>';
		                    $("#alertModal").modal('show');
		                    $('#alertModal .modal-body').empty();
		                    $('#alertModal .modal-body').append(html);
		                } 
		            }
		        );
		}	
	});
	$('#exportCSV').on('click',function(){
	    $(".csvExportTable").tableHTMLExport({type:'csv',filename:'danh_sach_bai_viet.csv'});
	  })
})
</script>
<style>
.fr-btn-action{
	float:left;
	margin-top: 45px;
    margin-bottom: 15px;
    margin-left: 20px;
}
</style>