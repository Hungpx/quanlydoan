<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Menu')) {
    class Menu extends Model{   
        protected $id;
        protected $tenMenu;
        /**
         * @return the $id
         */
        public function getId()
        {
            return $this->id;
        }
    
        
        /**
         * @return the $tenMenu
         */
        public function getTenMenu()
        {
            return $this->tenMenu;
        }
    
        /**
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
        
        /**
         * @param field_type $tenMenu
         */
        public function setTenMenu($tenMenu)
        {
            $this->tenMenu = $tenMenu;
        }
     
    }
}
