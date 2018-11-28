<?php
namespace Model;
include_once 'Base/Model.php';
use Model\Base\Model;

class User extends Model{
    protected $mapper;
    /**
     * @return Model\UserMapper
     */
    public function getMapper() {
        if(!$this->mapper) {
            $this->mapper = new UserMapper();
        }
        return $this->mapper;
    }
    
    const ROLE_ADMIN = 1; //quyền admin
    const ROLE_TEACHER = 2; // quyền giảng viên
    const ROLE_STUDENT = 3; //quyền sinh viên
    
    const STATUS_ACTIVE = 1; //trạng thái đã kích hoạt
    const STATUS_INACTIVE = 2; // trạng thái chưa kích hoạt
    protected $dsNhomquyen = [
        self::ROLE_ADMIN => 'Quản lý',
        self::ROLE_TEACHER => 'Giảng viên',
        self::ROLE_STUDENT => 'Sinh viên',
    ];
    
    protected $dsTrangthai = [
        self::STATUS_ACTIVE => 'Đã kích hoạt',
        self::STATUS_INACTIVE => 'Chưa kích hoạt',
    ];
    
    protected $id;
    protected $taikhoan;
    protected $matkhau;
    protected $nhomquyen;
    protected $trangthai;
    /**
     * @return the $dsNhomquyen
     */
    public function getDsNhomquyen()
    {
        return $this->dsNhomquyen;
    }

    /**
     * @return the $dsTrangthai
     */
    public function getDsTrangthai()
    {
        return $this->dsTrangthai;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $taikhoan
     */
    public function getTaikhoan()
    {
        return $this->taikhoan;
    }

    /**
     * @return the $matkhau
     */
    public function getMatkhau()
    {
        return $this->matkhau;
    }

    /**
     * @return the $nhomquyen
     */
    public function getNhomquyen()
    {
        return $this->nhomquyen;
    }

    /**
     * @return the $trangthai
     */
    public function getTrangthai()
    {
        return $this->trangthai;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $taikhoan
     */
    public function setTaikhoan($taikhoan)
    {
        $this->taikhoan = $taikhoan;
    }

    /**
     * @param field_type $matkhau
     */
    public function setMatkhau($matkhau)
    {
        $this->matkhau = $matkhau;
    }

    /**
     * @param field_type $nhomquyen
     */
    public function setNhomquyen($nhomquyen)
    {
        $this->nhomquyen = $nhomquyen;
    }

    /**
     * @param field_type $trangthai
     */
    public function setTrangthai($trangthai)
    {
        $this->trangthai = $trangthai;
    }
}