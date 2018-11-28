<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('PhanBien')) {
    class PhanBien extends Model{   
        protected $maDoan;
        protected $maGV;
        protected $maSV;
        protected $diemPB1;
        protected $diemPB2;
        protected $diemPB3;
        protected $nhanxet;
        protected $maGVPB1;
        protected $maGVPB2;
        protected $maGVPB3;
        protected $trangthai;
        protected $id;
        protected $trangthaiSua;
        
        const STATUS_NEW = 1; //Mới
        const STATUS_DONE = 2; //Đạt
        const STATUS_NOT_DONE = 3; //Không đạt
        
        const EDIT_STATUS_NEW = 1; //Mới
        const EDIT_STATUS_NOT_ALLOW  =2; //không cho sửa
        const EDIT_STATUS_ALLOW  =3; //Cho phép sửa
        
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
         * @return the $maGVPB1
         */
        public function getMaGVPB1()
        {
            return $this->maGVPB1;
        }
    
        /**
         * @return the $maGVPB2
         */
        public function getMaGVPB2()
        {
            return $this->maGVPB2;
        }
    
        /**
         * @return the $maGVPB3
         */
        public function getMaGVPB3()
        {
            return $this->maGVPB3;
        }
    
        /**
         * @param field_type $maGVPB1
         */
        public function setMaGVPB1($maGVPB1)
        {
            $this->maGVPB1 = $maGVPB1;
        }
    
        /**
         * @param field_type $maGVPB2
         */
        public function setMaGVPB2($maGVPB2)
        {
            $this->maGVPB2 = $maGVPB2;
        }
    
        /**
         * @param field_type $maGVPB3
         */
        public function setMaGVPB3($maGVPB3)
        {
            $this->maGVPB3 = $maGVPB3;
        }
    
        /**
         * @return the $maSV
         */
        public function getMaSV()
        {
            return $this->maSV;
        }
    
        /**
         * @param field_type $maSV
         */
        public function setMaSV($maSV)
        {
            $this->maSV = $maSV;
        }
    
        /**
         * @return the $maDoan
         */
        public function getMaDoan()
        {
            return $this->maDoan;
        }
    
        /**
         * @return the $maGV
         */
        public function getMaGV()
        {
            return $this->maGV;
        }
    
        /**
         * @return the $diemPB1
         */
        public function getDiemPB1()
        {
            return $this->diemPB1;
        }
    
        /**
         * @return the $diemPB2
         */
        public function getDiemPB2()
        {
            return $this->diemPB2;
        }
    
        /**
         * @return the $diemPB3
         */
        public function getDiemPB3()
        {
            return $this->diemPB3;
        }
    
        /**
         * @return the $nhanxet
         */
        public function getNhanxet()
        {
            return $this->nhanxet;
        }
    
        /**
         * @param field_type $maDoan
         */
        public function setMaDoan($maDoan)
        {
            $this->maDoan = $maDoan;
        }
    
        /**
         * @param field_type $maGV
         */
        public function setMaGV($maGV)
        {
            $this->maGV = $maGV;
        }
    
        /**
         * @param field_type $diemPB1
         */
        public function setDiemPB1($diemPB1)
        {
            $this->diemPB1 = $diemPB1;
        }
    
        /**
         * @param field_type $diemPB2
         */
        public function setDiemPB2($diemPB2)
        {
            $this->diemPB2 = $diemPB2;
        }
    
        /**
         * @param field_type $diemPB3
         */
        public function setDiemPB3($diemPB3)
        {
            $this->diemPB3 = $diemPB3;
        }
    
        /**
         * @param field_type $nhanxet
         */
        public function setNhanxet($nhanxet)
        {
            $this->nhanxet = $nhanxet;
        }
    
        
    }
}
