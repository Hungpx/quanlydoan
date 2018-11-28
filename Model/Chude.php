<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Chude')) {
    class Chude extends Model{   
        protected $id;
        protected $maChude;
        protected $tenChude;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * @return the $maChude
         */
        public function getMaChude()
        {
            return $this->maChude;
        }
    
        /**
         * @return the $tenChude
         */
        public function getTenChude()
        {
            return $this->tenChude;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * @param field_type $maChude
         */
        public function setMaChude($maChude)
        {
            $this->maChude = $maChude;
        }
    
        /**
         * @param field_type $tenChude
         */
        public function setTenChude($tenChude)
        {
            $this->tenChude = $tenChude;
        }
     
    }
}
