<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('LoaiDoan')) {
    class LoaiDoan extends Model{   
        protected $id;
        protected $maLoai;
        protected $tenLoai;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @return the $maLoai
         */
        public function getMaLoai()
        {
            return $this->maLoai;
        }
    
        /**
         * @return the $tenLoai
         */
        public function getTenLoai()
        {
            return $this->tenLoai;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @param field_type $maLoai
         */
        public function setMaLoai($maLoai)
        {
            $this->maLoai = $maLoai;
        }
    
        /**
         * @param field_type $tenLoai
         */
        public function setTenLoai($tenLoai)
        {
            $this->tenLoai = $tenLoai;
        }
     
    }
}
