<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Baiviet')) {
    class Baiviet extends Model{   
        protected $id;
        protected $menuId;
        protected $mota;
        protected $chitiet;
        protected $anhDaiDien;
        protected $tieude;
        /**
         * @return the $anhDaiDien
         */
        public function getAnhDaiDien()
        {
            return $this->anhDaiDien;
        }
    
        /**
         * @return the $tieude
         */
        public function getTieude()
        {
            return $this->tieude;
        }
    
        /**
         * @param field_type $anhDaiDien
         */
        public function setAnhDaiDien($anhDaiDien)
        {
            $this->anhDaiDien = $anhDaiDien;
        }
    
        /**
         * @param field_type $tieude
         */
        public function setTieude($tieude)
        {
            $this->tieude = $tieude;
        }
    
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @return the $menuId
         */
        public function getMenuId()
        {
            return $this->menuId;
        }
    
        /**
         * @return the $mota
         */
        public function getMota()
        {
            return $this->mota;
        }
    
        /**
         * @return the $chitiet
         */
        public function getChitiet()
        {
            return $this->chitiet;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @param field_type $menuId
         */
        public function setMenuId($menuId)
        {
            $this->menuId = $menuId;
        }
    
        /**
         * @param field_type $mota
         */
        public function setMota($mota)
        {
            $this->mota = $mota;
        }
    
        /**
         * @param field_type $chitiet
         */
        public function setChitiet($chitiet)
        {
            $this->chitiet = $chitiet;
        }
    
        
    }
}
