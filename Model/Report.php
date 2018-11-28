<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;
if (!class_exists('Report')) {
    class Report extends Model{
        protected $year;
        protected $maSV;
        protected $maDoan;
        /**
         * @return the $year
         */
        public function getYear()
        {
            return $this->year;
        }
    
        /**
         * @return the $maSV
         */
        public function getMaSV()
        {
            return $this->maSV;
        }
    
        /**
         * @return the $maDoan
         */
        public function getMaDoan()
        {
            return $this->maDoan;
        }
    
        /**
         * @param field_type $year
         */
        public function setYear($year)
        {
            $this->year = $year;
        }
    
        /**
         * @param field_type $maSV
         */
        public function setMaSV($maSV)
        {
            $this->maSV = $maSV;
        }
    
        /**
         * @param field_type $maDoan
         */
        public function setMaDoan($maDoan)
        {
            $this->maDoan = $maDoan;
        }
    }
}
