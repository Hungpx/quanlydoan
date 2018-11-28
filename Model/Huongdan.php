<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Huongdan')) {
    class Huongdan extends Model{   
        protected $maDoan;
        protected $maSV;
        protected $maGV;
        protected $nhanxet;
        protected $diem;
        protected $trangthai;
        protected $trangthaiSua;
        protected $id;
        
        const STATUS_NEW = 1; //Mới
        const STATUS_DELETE = 2; //Không cho bảo vệ
        const STATUS_DONE = 3; //Cho phép bảo vệ
        const STATUS_DONE_PHANBIEN  =4; 
        
        const EDIT_STATUS_NEW = 1; //Mới
        const EDIT_STATUS_NOT_ALLOW  =2; //không cho sửa
        const EDIT_STATUS_ALLOW  =3; //Cho phép sửa
        
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @return the $trangthaiSua
         */
        public function getTrangthaiSua()
        {
            return $this->trangthaiSua;
        }
    
        /**
         * @param field_type $trangthaiSua
         */
        public function setTrangthaiSua($trangthaiSua)
        {
            $this->trangthaiSua = $trangthaiSua;
        }
    
        /**
         * @return the $maDoan
         */
        public function getMaDoan()
        {
            return $this->maDoan;
        }
    
        /**
         * @return the $maSV
         */
        public function getMaSV()
        {
            return $this->maSV;
        }
    
        /**
         * @return the $maGV
         */
        public function getMaGV()
        {
            return $this->maGV;
        }
    
        /**
         * @return the $nhanxet
         */
        public function getNhanxet()
        {
            return $this->nhanxet;
        }
    
        /**
         * @return the $diem
         */
        public function getDiem()
        {
            return $this->diem;
        }
    
        /**
         * @param field_type $maDoan
         */
        public function setMaDoan($maDoan)
        {
            $this->maDoan = $maDoan;
        }
    
        /**
         * @return the $trangthai
         */
        public function getTrangthai()
        {
            return $this->trangthai;
        }
    
        /**
         * @param field_type $trangthai
         */
        public function setTrangthai($trangthai)
        {
            $this->trangthai = $trangthai;
        }
    
        /**
         * @param field_type $maSV
         */
        public function setMaSV($maSV)
        {
            $this->maSV = $maSV;
        }
    
        /**
         * @param field_type $maGV
         */
        public function setMaGV($maGV)
        {
            $this->maGV = $maGV;
        }
    
        /**
         * @param field_type $nhanxet
         */
        public function setNhanxet($nhanxet)
        {
            $this->nhanxet = $nhanxet;
        }
    
        /**
         * @param field_type $diem
         */
        public function setDiem($diem)
        {
            $this->diem = $diem;
        }
    
        
    }
}
