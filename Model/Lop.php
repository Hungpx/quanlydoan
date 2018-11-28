<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Lop')) {
    class Lop extends Model{   
        protected $id;
        protected $maLop;
        protected $tenLop;
        protected $maKhoa;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @return the $maLop
         */
        public function getMaLop()
        {
            return $this->maLop;
        }
    
        /**
         * @return the $tenLop
         */
        public function getTenLop()
        {
            return $this->tenLop;
        }
    
        /**
         * @return the $maKhoa
         */
        public function getMaKhoa()
        {
            return $this->maKhoa;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @param field_type $maLop
         */
        public function setMaLop($maLop)
        {
            $this->maLop = $maLop;
        }
    
        /**
         * @param field_type $tenLop
         */
        public function setTenLop($tenLop)
        {
            $this->tenLop = $tenLop;
        }
    
        /**
         * @param field_type $maKhoa
         */
        public function setMaKhoa($maKhoa)
        {
            $this->maKhoa = $maKhoa;
        }

    }
}
