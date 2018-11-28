<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Doan')) {
    class Doan extends Model{  
        
        protected $id;
        protected $maDoan;
        protected $tenDoan;
        protected $maLoai;
        protected $maChude;
        protected $yeucau;
        protected $giangvienHD;
        protected $namRaDe;
        protected $soSVThamGia;
        protected $ngayHetHan;
        /**
         * @return the $ngayHetHan
         */
        public function getNgayHetHan()
        {
            return $this->ngayHetHan;
        }
    
        /**
         * @param field_type $ngayHetHan
         */
        public function setNgayHetHan($ngayHetHan)
        {
            $this->ngayHetHan = $ngayHetHan;
        }
    
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
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
         * @return the $maLoai
         */
        public function getMaLoai()
        {
            return $this->maLoai;
        }
    
        /**
         * @return the $maChude
         */
        public function getMaChude()
        {
            return $this->maChude;
        }
    
        /**
         * @return the $yeucau
         */
        public function getYeucau()
        {
            return $this->yeucau;
        }
    
        /**
         * @return the $giangvienHD
         */
        public function getGiangvienHD()
        {
            return $this->giangvienHD;
        }
    
        /**
         * @return the $namRaDe
         */
        public function getNamRaDe()
        {
            return $this->namRaDe;
        }
    
        /**
         * @return the $soSVThamGia
         */
        public function getSoSVThamGia()
        {
            return $this->soSVThamGia;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
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
         * @param field_type $maLoai
         */
        public function setMaLoai($maLoai)
        {
            $this->maLoai = $maLoai;
        }
    
        /**
         * @param field_type $maChude
         */
        public function setMaChude($maChude)
        {
            $this->maChude = $maChude;
        }
    
        /**
         * @param field_type $yeucau
         */
        public function setYeucau($yeucau)
        {
            $this->yeucau = $yeucau;
        }
    
        /**
         * @param field_type $giangvienHD
         */
        public function setGiangvienHD($giangvienHD)
        {
            $this->giangvienHD = $giangvienHD;
        }
    
        /**
         * @param field_type $namRaDe
         */
        public function setNamRaDe($namRaDe)
        {
            $this->namRaDe = $namRaDe;
        }
    
        /**
         * @param field_type $soSVThamGia
         */
        public function setSoSVThamGia($soSVThamGia)
        {
            $this->soSVThamGia = $soSVThamGia;
        }
    
        public function checkDangKy($connect){       
            if ($this->getNgayHetHan() && getCurrentDate() > $this->getNgayHetHan()){
                return false;
            }
            
            $userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
            if ($userService){
                $svThamgia = new SinhvienThamgia();
                $svThamgia->setMaDoan($this->getId());
                $svThamgia->setMaSV($userService['id']);
                $svThamgia->addOption('namRaDe', date('Y'));
                $svThamgiaMapper = new SinhvienThamgiaMapper($connect);
                if ($svThamgiaMapper->isExist($svThamgia)){
                  return false;
                }
            }
            return true;
        }
        
    }
}
