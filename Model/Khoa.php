<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Khoa')) {
    class Khoa extends Model{   
        protected $id;
        protected $maKhoa;
        protected $tenKhoa;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @return the $maKhoa
         */
        public function getMaKhoa()
        {
            return $this->maKhoa;
        }
    
        /**
         * @return the $tenKhoa
         */
        public function getTenKhoa()
        {
            return $this->tenKhoa;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @param field_type $maKhoa
         */
        public function setMaKhoa($maKhoa)
        {
            $this->maKhoa = $maKhoa;
        }
    
        /**
         * @param field_type $tenKhoa
         */
        public function setTenKhoa($tenKhoa)
        {
            $this->tenKhoa = $tenKhoa;
        }
     
    }
}
