<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Sinhvien')) {
    class Sinhvien extends Model{
        protected $mapper;
        /**
         * @return Model\SinhvienMapper
         */
        public function getMapper() {
            if(!$this->mapper) {
                $this->mapper = new SinhvienMapper();
            }
            return $this->mapper;
        }
    
        protected $id;
        protected $maSV;
        protected $tenSV;
        protected $maLop;
        protected $soDT;
        protected $diachi;
        protected $maTaikhoan;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
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
         * @return the $maLop
         */
        public function getMaLop()
        {
            return $this->maLop;
        }
    
        /**
         * @return the $soDT
         */
        public function getSoDT()
        {
            return $this->soDT;
        }
    
        /**
         * @return the $diachi
         */
        public function getDiachi()
        {
            return $this->diachi;
        }
    
        /**
         * @return the $maTaikhoan
         */
        public function getMaTaikhoan()
        {
            return $this->maTaikhoan;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
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
         * @param field_type $maLop
         */
        public function setMaLop($maLop)
        {
            $this->maLop = $maLop;
        }
    
        /**
         * @param field_type $soDT
         */
        public function setSoDT($soDT)
        {
            $this->soDT = $soDT;
        }
    
        /**
         * @param field_type $diachi
         */
        public function setDiachi($diachi)
        {
            $this->diachi = $diachi;
        }
    
        /**
         * @param field_type $maTaikhoan
         */
        public function setMaTaikhoan($maTaikhoan)
        {
            $this->maTaikhoan = $maTaikhoan;
        }
    }
}
