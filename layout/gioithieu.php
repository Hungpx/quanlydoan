<?php
use Model\Lop;
use Model\LopMapper;
use Model\Sinhvien;
use Model\SinhvienMapper;
use Model\User;
use Model\UserMapper;
include_once 'frame/top.php';
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
					<div class="new-content"><h2>TRƯỜNG ĐẠI HỌC CÔNG NGHIỆP VIỆT - HUNG</h2></div>
					<div class="new-content-wrapper">
						<div class="panel-body-detail">
<p style="margin-bottom: .0001pt; text-align: justify; line-height: 150%;"><strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">1.1. Giới thiệu khái quát về VIU</span></strong></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Tổng quan:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Trường Đại học Công nghiệp Việt-Hung là trường đại học công lập trực thuộc Bộ Công Thương. Trường đã trải qua 40 năm hoạt động đào tạo. Nhà trường ra đời là kết quả của sự giúp đỡ to lớn về vật chất, tinh thần và chuyên gia đào tạo của nhà nước Hungary. Tính đến nay, Trường ĐHCN Việt-Hung đã đào tạo cho đất nước gần 70.000 kỹ sư, cử nhân và kỹ thuật viên các khối ngành công nghệ, công nghệ kỹ thuật và kinh tế; được tặng thưởng Huân chương Độc lập hạng 3, Huân chương Lao động các hạng: Nhất, Nhì, Ba và nhiều phần thưởng cao quý khác của Đảng và Nhà nước.</span><img src="<?= getViewPath('/upload/media/VMfjOFD43ej_NBbOUHddC7jTuK58M-OXgnG3bIMhg4TAnWHfwnMhCvFRT37sONxs.jpg') ?>" alt=""></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Bước vào giai đoạn phát triển mới - giai đoạn hội nhập quốc tế sâu rộng, nhà trường có vai trò tiên phong trong việc đào tạo nguồn nhân lực khởi nghiệp và nhân lực hội nhập, có trình độ và chất lượng cao phục vụ sự nghiệp công nghiệp hóa, hiện đại hóa đất nước nói chung và ngành Công thương nói riêng. Bộ Công Thương với các tập đoàn, tổng công ty lớn và hàng nghìn doanh nghiệp vừa sản xuất vừa tiêu thụ hàng hóa, đóng vai trò đi đầu trong việc nâng cao năng suất lao động, thực hiện thắng lợi các mục tiêu kinh tế - xã hội mà Đảng và Nhà nước đề ra, là nơi tiếp nhận sinh viên của nhà trường đến thực tập và làm việc sau khi tốt nghiệp.&nbsp;&nbsp;&nbsp; </span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hiện tại, Trường có hai địa điểm đào tạo chính:</span></p>
<ul>
<li style="text-indent: -14.2pt; line-height: 150%; margin: 0cm -14.2pt 0.0001pt 49.65pt; text-align: left;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Symbol; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Khu A:&nbsp;&nbsp; <strong>Số 16, phố Hữu Nghị, phường Xuân Khanh, Sơn Tây, TP. Hà Nội</strong></span></li>
</ul>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Diện tích sử dụng:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5.6 ha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Diện tích xây dựng:&nbsp;&nbsp; 29.720 m2</span></p>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hệ thống Ký túc xá:&nbsp;&nbsp; 6720 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sức chứa:&nbsp; 1088 sinh viên&nbsp;&nbsp; </span></p>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hệ thống CSVC phục vụ đào tạo: </span></p>
<ul>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Thư viện:&nbsp;&nbsp; 2352 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số đầu sách:&nbsp; 10000 bản (điện tử) </span></li>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Phòng thực nghiệm: 2484 m2&nbsp;&nbsp;&nbsp;&nbsp; Số phòng:&nbsp;&nbsp;&nbsp; 15 phòng </span></li>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Phòng thí nghiệm:&nbsp;&nbsp;&nbsp;&nbsp; 511 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số phòng:&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;9 phòng</span></li>
</ul>
<p><span style="font-size: 13.5pt; line-height: 150%; font-family: Symbol; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';"><img src="<?= getViewPath('/upload/media/yX2l0ADbKYNERkaTOL7Zz-HtLLhAUElM_IE495Bj9Xz-hmRpNAwhfuE11O7V1tnO.jpg') ?>" alt=""></span></span></p>
<ul>
<li style="text-align: justify; text-indent: -14.2pt; line-height: 150%; margin: 0cm 0cm .0001pt 49.65pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Symbol; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Khu B:&nbsp; <strong>Khu Công nghiệp Bình Phú, Thạch Thất, TP. Hà Nội</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></li>
</ul>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Diện tích sử dụng:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4.5 ha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Diện tích xây dựng:&nbsp;&nbsp; 15.427 m2</span></p>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hệ thống Ký túc xá:&nbsp;&nbsp; 4246 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sức chứa:&nbsp; 550 sinh viên&nbsp;&nbsp; </span></p>
<p style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 78.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hệ thống CSVC phục vụ đào tạo: </span></p>
<ul>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Thư viện:&nbsp;&nbsp; 1788 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số đầu sách:&nbsp; 10000 bản (điện tử) </span></li>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Phòng thực nghiệm: 1346 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số phòng:&nbsp;&nbsp;&nbsp; 10 phòng </span></li>
<li style="text-align: justify; text-indent: -17.85pt; line-height: 150%; margin: 0cm 0cm .0001pt 144.0pt;"><span style="font-size: 13.5pt; line-height: 150%; font-family: Wingdings; color: #002060;"><span style="font-stretch: normal; font-size: 7pt; line-height: normal; font-family: 'Times New Roman';">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></span><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Phòng thí nghiệm:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 373 m2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số phòng:&nbsp;&nbsp;&nbsp;&nbsp; 7 phòng</span></li>
</ul>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Với một vị trí địa lý hết sức thuận lợi, Trường gần Khu Công nghệ cao Láng - Hòa Lạc (một trung tâm kinh tế lớn nằm cách trung tâm Thủ đô Hà Nội 30 km về phía Tây, nối liền trung tâm Hà Nội bởi Đại lộ Thăng Long và sân bay Hòa Lạc, cầu hàng không Miếu Môn), Làng văn hóa cộng đồng các dân tộc Việt Nam, khu du lịch sinh thái - sân golf Đồng Mô,… và quần thể du lịch Ba vì nổi tiếng cả nước với hệ thống giao thông thuận tiện và điều kiện sống thoải mái.</span></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"><img style="float: left;" src="<?= getViewPath('/upload/media/v74TsWGcN4Ku9TxMJmLJfKYkkPzxW6iXhm1eBakF00KzrFsMHgNq4izm4z3EcIUw.jpg') ?>" alt=""></span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;">&nbsp;</p>
<p style="text-align: justify; text-indent: 36.0pt; line-height: 150%; margin: 12.0pt 0cm .0001pt 0cm;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Nhận diện thương hiệu:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Tên gọi:<strong>&nbsp;&nbsp; </strong>Tiếng Việt: &nbsp;&nbsp;Trường Đại học Công nghiệp Việt - Hung</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tiếng Anh: &nbsp;&nbsp;Viet - Hung Industrial University</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tên viết tắt: &nbsp;VIU</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Biểu tượng</span></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"><img style="float: left;" src="<?= getViewPath('/upload/media/lPqm38wO3P_x7RdJDHKX4dUIjg4BEXCBp7p8P7_TOwBy9K17hOnKOBAYakGsnW35.png') ?>" alt="" width="546" height="276"></span></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Sứ mệnh - Tầm nhìn:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Trên cơ sở tiềm năng phát triển các khu công nghiệp, phát triển kinh tế- xã hội vùng đồng bằng Sông Hồng nói chung, Hà Nội mở rộng nói riêng, nhà trường đã xác định sứ mệnh, tầm nhìn và mục tiêu chiến lược của trường đến năm 2025, tầm nhìn 2030 như sau:</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Sứ mệnh:</span></em></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Là trường đại học thuộc khối Công Thương đào tạo đa ngành, đa lĩnh vực định hướng ứng dụng, là trung tâm nghiên cứu khoa học, công nghệ và hợp tác quốc tế đạt trình độ quốc gia và khu vực, có khả năng hội nhập với giáo dục châu Âu. Trường đào tạo và cung cấp nguồn nhân lực khởi nghiệp có chất lượng và trình độ phù hợp với nhu cầu của xã hội trong từng giai đoạn phát triển, góp phần thiết thực vào sự nghiệp CNH, HĐH đất nước và hội nhập quốc tế.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Tầm nhìn:</span></em></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Trở thành trường đại học đào tạo đa ngành, đa lĩnh vực đẳng cấp khu vực, hội nhập giáo dục toàn cầu, thực hiện công nhận chất lượng, bằng cấp lẫn nhau với giáo dục Châu Âu mà hạt nhân là Hungary. Thực hiện triết lý giáo dục cho mọi người trong xã hội của nền văn minh tri thức.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 12.0pt 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu chiến lược đến năm 2030:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về đào tạo:</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"> &nbsp;Trở thành trường đại học có uy tín về chất lượng đào tạo đáp ứng nhu cầu xã hội trong khu vực và quốc tế. Đào tạo trình độ đại học và trên đại học đa ngành, đa lĩnh vực định hướng ứng dụng với trên 80% chương trình đào tạo ngành, chuyên ngành được kiểm định bởi các tổ chức kiểm định có uy tín trong và ngoài nước. Qui mô đào tạo đạt 12.000-15.000 sinh viên, học viên, trong đó các chương trình đào tạo định hướng ứng dụng trình độ đại học, thạc sĩ chiếm khoảng 85-90%. Tốt nghiệp có trên 90% sinh viên có việc làm phù hợp với ngành, nghề đào tạo; 15-20% sinh viên tốt nghiệp có năng lực, kiến thức, kỹ năng đạt chuẩn khu vực, có thể làm việc tại các tập đoàn đa quốc gia hoặc tiếp tục học tập, nghiên cứu ở nước ngoài.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về khoa học và công nghệ:</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"> Thiết lập đa dạng các mối quan hệ giữa Nhà trường, các Vụ, Viện, doanh nghiệp và cộng đồng xã hội để triển khai các hoạt động nghiên cứu khoa học và chuyển giao công nghệ. Đảm nhận được các đề tài trọng điểm cấp bộ, cấp nhà nước; có sản phẩm khoa học công nghệ phục vụ tốt cho phát triển kinh tế-xã hội, đặc biệt là kinh tế - xã hội địa phương khu vực nông thôn và các doanh nghiệp thuộc khu vực không chính quy. Nâng cao chất lượng nghiên cứu khoa học phục vụ quản lý, giáo dục đại học đáp ứng yêu cầu, nhiệm vụ công nghiệp hóa, hiện đại hóa và hội nhập quốc tế.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về hợp tác quốc tế:</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">&nbsp; Phát triển, nâng tầm quan hệ đối tác truyền thống với các trường đại học Hungary. Từng bước hội nhập với giáo dục châu Âu và các nền giáo dục hàng đầu châu Á về đào tạo và công nhận bằng cấp lẫn nhau. Hợp tác về đào tạo và sử dụng nguồn nhân lực giảng viên trình độ cao. Thực hiện gắn kết nhà trường với các cơ sở sản xuất và sử dụng lao động. Hàng năm đưa từ 05 đến 10 giảng viên đi làm nghiên cứu sinh ở các nước, 10 đến 15 sinh viên đi du học theo các chương trình hợp tác quốc tế.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về phục vụ cộng đồng:</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"> &nbsp;Tạo dựng niềm tin cho cộng đồng về Trường Đại học Công nghiệp Việt - Hung, duy trì và phát triển các chương trình hoạt động phục vụ cộng đồng như chương trình “chung tay xây dựng nông thôn mới” triển khai tại khu vực nông thôn thuộc thành phố Hà Nội.&nbsp; Tham gia đầy đủ các hoạt động phục vụ cộng đồng dân cư địa phương. Cung cấp nguồn nhân lực chất lượng cao góp phần phát triển mạnh kinh tế-xã hội địa phương và vùng đồng bằng Sông Hồng.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về phát triển đội ngũ:</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"> &nbsp;Đến năm 2025, phấn đấu đạt chuẩn đội ngũ giảng viên đại học theo tiêu chí mới của ngành giáo dục: 100% giảng viên đạt chuẩn quốc gia và khu vực, trong đó từ 25-30% giảng viên có trình độ Tiến sĩ, bảo đảm đủ số lượng giảng viên đào tạo trình độ đại học, trên đại học đáp ứng quy mô 10.000-15.000 sinh viên, học viên.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Xây dựng đội ngũ viên chức có đạo đức nghề nghiệp và trình độ chuyên môn cao, gắn bó với nhà trường, luôn theo kịp với những yêu cầu mới của thời đại, đáp ứng yêu cầu nhiệm vụ của nhà trường đặt ra trong từng giai đoạn.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Đến năm 2030 có 45% giảng viên dạy đại học, trên đại học có trình độ GS, PGS, Tiến sĩ. Các ngành dạy theo chương trình tiên tiến mỗi ngành có ít nhất 10 giảng viên tài năng (được các trường đối tác đào tạo và công nhận).&nbsp; </span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về bảo đảm cơ sở vật chất</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">: &nbsp;Tăng cường xây dựng cơ sở hạ tầng đảm bảo hệ thống các phòng học đa dạng, đầy đủ và đạt chuẩn. Đầu tư các trang thiết bị hiện đại, đồng bộ, đặc biệt là các phòng thí nghiệm, thực nghiệm, thư viện đáp ứng đào tạo các ngành ở bậc đại học và trên đại học với quy mô 15000 sinh viên. Hoàn thành dự án đầu tư nâng cấp cơ sở hạ tầng bằng nguồn vốn trong nước, triển khai dự án đầu tư hiện đại hóa trang thiết bị đào tạo từ nguồn viện trợ ODA.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Mục tiêu về bảo đảm tài chính</span></em></strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">: &nbsp;Đảm bảo đủ nguồn tài chính cho các hoạt động của Trường theo cơ chế tự chủ và thực hiện các dự án chiến lược phát triển trường. Từng bước nâng cao đời sống cán bộ, viên chức, phấn đấu đến năm 2030 thu nhập bình quân đầu người tăng gấp 4-4.5 lần so với năm 2015.</span></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Thành tựu đạt được:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Trong quá trình phát triển cùng đất nước Đại học Công nghiệp Việt - Hung không ngừng đa dạng hóa và mở rộng quy mô đào tạo. Nhờ đó chất lượng đào tạo, uy tín của nhà trường ngày càng nâng cao và được xã hội công nhận.</span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Nhờ những thành tựu đó, nhà trường đã vinh dự được trao tặng một số phần thưởng cao quý của Đảng và Chính phủ, bao gồm:</span></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt; text-align: left;"><strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"><br><img src="<?= getViewPath('/upload/media/aAM6OqoYHx9l3at60G-VvTCIyvvYYl8a2B7OHsP4Bopccio0lOOC2G3DizocwaISFyLEUmJ8MpTVQVSsCQEWbA.png') ?>" alt="" width="473" height="260"></span></strong></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt; text-align: left;"><strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">1.2. Hệ thống tổ chức của VIU</span></strong></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Tổ chức chính trị</span></em></strong></p>
<p style="margin: 0cm 0cm 0.0001pt 77.95pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Đảng ủy</span></p>
<p style="margin: 0cm 0cm 0.0001pt 77.95pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Công đoàn</span></p>
<p style="margin: 0cm 0cm 0.0001pt 77.95pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Đoàn thanh niên</span></p>
<p style="margin: 0cm 0cm 0.0001pt 77.95pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Hội phụ nữ</span></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Chính quyền</span></em></strong></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Ban giám hiệu</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Phòng ban chức năng:</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Phòng Tổ chức hành chính</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Phòng Đào tạo, Khoa học công nghệ và Hợp tác quốc tế</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Phòng Tài chính - Kế toán</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Phòng Quản trị</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; font-family: 'Courier New'; color: #002060;">o<span style="font-stretch: normal; font-size: 7pt; font-family: 'Times New Roman';">&nbsp;&nbsp; </span></span><span style="font-size: 13.5pt; color: #002060;">Khoa/ Trung tâm đào tạo:</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa Đại cương</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa Công nghệ&nbsp;thông tin</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa Điện - Điện tử</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa Cơ khí</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa Ô tô</span></p>
<p style="margin: 0cm 0cm 0.0001pt 78pt; text-align: justify; text-indent: -17.85pt;"><span style="font-size: 13.5pt; color: #002060;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Khoa&nbsp;Xây dựng</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Khoa Quản trị, kinh tế và Ngân hàng</span></p>
<p style="margin: 0cm 0cm 0.0001pt 72pt; text-align: justify; text-indent: 36pt;"><span style="font-size: 13.5pt; color: #002060;">- Viện nghiên cứu và hỗ trợ phát triển.</span></p>
<p style="text-align: justify; line-height: 150%; margin: 12.0pt 0cm .0001pt 0cm;"><strong><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">1.3. Hệ thống hỗ trợ đào tạo</span></strong></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Cố vấn học tập</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Khi còn là học sinh ngồi trên ghế nhà trường tại các trường THPT, các em đã được các giảng viên trẻ, nhiệt tình, có kinh nghiệm quản lý học sinh, sinh viên làm quen, hỗ trợ, tư vấn và định hướng nghề nghiệp, lựa chọn ngành học, …… cho đến khi trở thành sinh viên chính thức của Trường Đại học Công nghiệp Việt - Hung. </span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Cố vấn học tập sẽ đồng hành cùng sinh viên trong suốt quá trình học tập tại Trường và thực tập thực tế tại doanh nghiệp, nhằm tạo điều kiện thuận lợi giúp sinh viên phát huy tốt nhất khả năng học tập và nắm bắt đầy đủ thông tin liên quan tới quá trình học tập của mình. </span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Cố vấn học tập có trách nhiệm tư vấn cho sinh viên về quy chế, quy định của Bộ Giáo dục - Đào tạo và của nhà trường liên quan đến quá trình đào tạo, cụ thể là: đưa các thông tin có liên quan đối với quá trình học tập đến với sinh viên; giải đáp cho sinh viên về quy chế đào tạo và các quy định có liên quan của Trường, thời khóa biểu, lịch thi, danh sách thi, kết quả xử lý học vụ, thời hạn trả nợ môn học, trả nợ tốt nghiệp…; giải đáp thắc mắc và trực tiếp tư vấn, hướng dẫn sinh viên trong các đợt đăng ký học phần, thực tập thực tế tại doanh nghiệp hoặc định hướng tương lai nghề nghiệp khi sinh viên tốt nghiệp ra trường.</span></p>
<p style="text-align: justify; text-indent: 36.0pt; line-height: 150%; margin: 12.0pt 0cm .0001pt 0cm;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Thư viện:</span></em></strong></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Hệ thống thư viện được xây dựng tại hai khu đào tạo chính của nhà trường, với diện tích sử dụng tại mỗi khu khoảng 2.000 m2, các phòng đọc, phòng khai thác thông tin, phòng truy cập Internet,... được đầu tư trang bị hiện đại phục vụ các độc giả là sinh viên và các giảng viên nhà trường. với trên 10.000 đầu tài liệu các thể loại từ văn hóa, nghệ thuật đến các tài liệu chuyên ngành phụ học tập và nghiên cứu,.... (với trên 90.000 bản cả tiếng việt, tiếng anh và tài liệu điện tử) và nhiều ấn phẩm, báo tạp trí chuyên ngành khác tạo lên một hệ thống thư viện hiện đại, phòng phú.<img style="float: left;" src="<?= getViewPath('/upload/media/WxJThLNAIlrz_KRrq9yyXLGx04fxMHJbJvryRqgsTAOzTmTL7jT3EYfz66MJzTvb.jpg') ?>" alt=""></span></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Phòng khai thác Internet được trang bị hệ thống máy tính hiện đại với 150 máy tính tại mỗi phòng. Được kết nối Internet đường truyền băng thông rộng, hệ thống wifi miễn phí đáp ứng nhu cầu khai thác thông tin của người đọc tại thư viện.</span></p>
<p style="margin-bottom: .0001pt; text-align: justify; text-indent: 36.0pt; line-height: 150%;"><strong><em><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Ký túc xá:</span></em></strong></p>
<p style="text-align: justify; text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm .0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;">Ký túc xá được thiết kế trong khuôn viên nhà trường, độc lập với khu vực đào tạo nhưng vẫn thuận tiễn cho quá trình di chuyển của sinh viên khi học tập. Với 10.966 m2 và 2.000 chỗ ở đủ cho sinh viên theo học tại hai khu đào tạo của nhà trường. Hệ thống điện, nước, công trình phụ khép kín; hệ thống mạng wifi phủ kín 24/24, … giúp sinh viên thuận lợi trong việc cập nhật thông tin, học tập, hoạt động ngoại khóa và hoạt động Online tại nơi ở Ký túc xá.</span></p>
<p style="text-indent: 28.9pt; line-height: 150%; margin: 0cm 0cm 0.0001pt 7.1pt;"><span style="font-size: 13.5pt; line-height: 150%; color: #002060;"><img style="float: left;" src="<?= getViewPath('/upload/media/jQCnQD4ddelJnrhsB7Iueekp2V4E4tDFD4DYZe4sioSzcSvZOzTLFU1lK52i41jp.jpg') ?>" alt=""></span></p>                            <div style="clear:both; overflow:hidden">
                            </div>
                        </div>
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
.panel-body-detail img {
    width: 100%;
    text-align: center;
}
img {
    vertical-align: middle;
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
