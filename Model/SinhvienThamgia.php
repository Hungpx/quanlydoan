<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('SinhvienThamgia')) {
    class SinhvienThamgia extends Model{ 
        const STATUS_NEW = 1; //đã nộp đồ án
        const STATUS_DONE = 2; //Chưa nộp đồ án
        
        protected $maDoan;
        protected $tenDoan;
        protected $maSV;
        protected $tenSV;
        protected $lanThamGia;
        protected $fileName;
        protected $trangthai;
        
        /**
         * @return the $maDoan
         */
        public function getMaDoan()
        {
            return $this->maDoan;
        }
    
        /**
         * @return the $tenDoan
         */
        public function getTenDoan()
        {
            return $this->tenDoan;
        }
    
        /**
         * @return the $maSV
         */
        public function getMaSV()
        {
            return $this->maSV;
        }
    
        /**
         * @return the $tenSV
         */
        public function getTenSV()
        {
            return $this->tenSV;
        }
    
        /**
         * @return the $lanThamGia
         */
        public function getLanThamGia()
        {
            return $this->lanThamGia;
        }
    
        /**
         * @return the $fileName
         */
        public function getFileName()
        {
            return $this->fileName;
        }
    
        /**
         * @return the $trangthai
         */
        public function getTrangthai()
        {
            return $this->trangthai;
        }
    
        /**
         * @param field_type $maDoan
         */
        public function setMaDoan($maDoan)
        {
            $this->maDoan = $maDoan;
        }
    
        /**
         * @param field_type $tenDoan
         */
        public function setTenDoan($tenDoan)
        {
            $this->tenDoan = $tenDoan;
        }
    
        /**
         * @param field_type $maSV
         */
        public function setMaSV($maSV)
        {
            $this->maSV = $maSV;
        }
    
        /**
         * @param field_type $tenSV
         */
        public function setTenSV($tenSV)
        {
            $this->tenSV = $tenSV;
        }
    
        /**
         * @param field_type $lanThamGia
         */
        public function setLanThamGia($lanThamGia)
        {
            $this->lanThamGia = $lanThamGia;
        }
    
        /**
         * @param field_type $fileName
         */
        public function setFileName($fileName)
        {
            $this->fileName = $fileName;
        }
    
        /**
         * @param field_type $trangthai
         */
        public function setTrangthai($trangthai)
        {
            $this->trangthai = $trangthai;
        }
    
       
    }
}
