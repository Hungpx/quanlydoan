<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Report.php';
use Model\Base\ModelMapper;
use Model\Sinhvien;
use Model\Report;

if (!class_exists('ReportMapper')) {
    class ReportMapper extends ModelMapper{  
       /* @var $report Model\Report  */
       public function reportDashboard($report){
           $whereArr = [];$result = [];
           if ($report->getYear()){
               $whereArr[] = 'year = "'.$report->getYear().'"';
           }
           //Tổng sinh viên
           $queryStr = 'SELECT COUNT(id) as totalSV FROM sinhvien ';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalSV'] = $row['totalSV'];
           }
           //Tổng lớp
           $queryStr = 'SELECT COUNT(id) as totalLop FROM lop';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalLop'] = $row['totalLop'];
           }
           //Tổng khoa
           $queryStr = 'SELECT COUNT(id) as totalKhoa FROM khoa ';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalKhoa'] = $row['totalKhoa'];
           }
           //Tổng đồ án
           $queryStr = 'SELECT COUNT(id) as totalDoan FROM doan ';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalDoan'] = $row['totalDoan'];
           }
           //Tổng giảng viên
           $queryStr = 'SELECT COUNT(id) as totalGV FROM giangvien ';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalGV'] = $row['totalGV'];
           }
           //Tổng bài viết
           $queryStr = 'SELECT COUNT(id) as totalBaiviet FROM baiviet ';
           if($whereArr){
               $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
           }
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalBaiviet'] = $row['totalBaiviet'];
           }
           
           //Tổng số sv đạt
           $queryStr = 'SELECT COUNT(maSV) as totalSV FROM phanbien WHERE trangthai = 2';
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalSVDat'] = $row['totalSV'];
           }
           //Tổng số sv không đạt
           $queryStr = 'SELECT COUNT(maSV) as totalSV FROM phanbien WHERE trangthai = 3';
           $query = $this->connect->query($queryStr);
           if ($row = $query->fetch_assoc()){
               $result['totalSVKhongDat'] = $row['totalSV'];
           }
           return $result;
       }
       //Báo cáo đồ án theo chủ đề
       public function reportDoanByChude($report){
           
       }
       
    }
}