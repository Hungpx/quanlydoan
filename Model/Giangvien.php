<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;

class Giangvien extends Model{
    protected $mapper;
    /**
     * @return Model\UserMapper
     */
    public function getMapper() {
        if(!$this->mapper) {
            $this->mapper = new GiangvienMapper();
        }
        return $this->mapper;
    }
    
    protected $id;
    protected $maGV;
    protected $tenGV;
    protected $email;
    protected $chucvu;
    protected $soDT;
    protected $maTaikhoan;
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $maGV
     */
    public function getMaGV()
    {
        return $this->maGV;
    }

    /**
     * @return the $tenGV
     */
    public function getTenGV()
    {
        return $this->tenGV;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $chucvu
     */
    public function getChucvu()
    {
        return $this->chucvu;
    }

    /**
     * @return the $soDT
     */
    public function getSoDT()
    {
        return $this->soDT;
    }

    /**
     * @return the $maTaikhoan
     */
    public function getMaTaikhoan()
    {
        return $this->maTaikhoan;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $maGV
     */
    public function setMaGV($maGV)
    {
        $this->maGV = $maGV;
    }

    /**
     * @param field_type $tenGV
     */
    public function setTenGV($tenGV)
    {
        $this->tenGV = $tenGV;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param field_type $chucvu
     */
    public function setChucvu($chucvu)
    {
        $this->chucvu = $chucvu;
    }

    /**
     * @param field_type $soDT
     */
    public function setSoDT($soDT)
    {
        $this->soDT = $soDT;
    }

    /**
     * @param field_type $maTaikhoan
     */
    public function setMaTaikhoan($maTaikhoan)
    {
        $this->maTaikhoan = $maTaikhoan;
    }

   
}