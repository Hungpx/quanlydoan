<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'User.php';

use Model\Base\ModelMapper;
use Model\User;
class UserMapper extends ModelMapper{
    const TABLE_NAME = 'taikhoan';
    /**
     * 
     * @var $model \Model\User 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        if (! $model->getId()){
            $data = [
                'taikhoan' => $model->getTaikhoan(),
                'matkhau'  => $model->getMatkhau(),
                'nhomquyen' => $model->getNhomquyen() ? : null,
                'trangthai' => $model->getTrangthai() ? : null,
            ];
            $valueUpdate = [];
            foreach ($data as $value){
                $valueUpdate[] = '"'.$value.'"';
            }
          $fieldArr = array_keys($data);
          $queryStr = 'INSERT INTO '.self::TABLE_NAME.' ('. implode(', ', $fieldArr).')'.' VALUES ('.implode(',', $valueUpdate).')';
          $query = $this->connect->query($queryStr);
          if ($this->connect->affected_rows == 1){
              $model->exchangeArray($data);
              $model->setId($this->connect->insert_id);
              return $model;
          }
          return false;
        }else{
            $data = [
                'taikhoan' => $model->getTaikhoan(),
                'matkhau'  => $model->getMatkhau(),
                'nhomquyen' => $model->getNhomquyen() ? : null,
                'trangthai' => $model->getTrangthai() ? : null,
            ];
            $valueUpdate = [];
            foreach ($data as $field => $value){
                $valueUpdate[] = $field .' = "'.$value.'"';
            }
            $queryStr = 'UPDATE '.self::TABLE_NAME.' SET '.implode(', ', $valueUpdate).' WHERE id='.$model->getId();
            $query = $this->connect->query($queryStr);
            return $model;
        }
    }
    public function checkLogin($model){
        if(! $model->getTaikhoan() || ! $model->getMatkhau()){
            return false;
        }
        $queryStr = 'select * from '.self::TABLE_NAME.'  where taikhoan = "'.$model->getTaikhoan() .'" 
            AND matkhau =  "'.$model->getMatkhau().'" AND trangthai = "'.$model::STATUS_ACTIVE.'" LIMIT 1';
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            //Kiểm tra nếu là quyền giáo viên thì lấy dữ liệu của giáo viên
            if ($model->getNhomquyen() == $model::ROLE_TEACHER || $model->getNhomquyen() == $model::ROLE_ADMIN ){
                $queryStr = 'select * from '.GiangvienMapper::TABLE_NAME.'  where maTaikhoan = "'.$model->getId() .'"  LIMIT 1';
                $query = $this->connect->query($queryStr);
                 if ($result = $query->fetch_assoc()){
                     $giangvien = new Giangvien();
                     $giangvien->exchangeArray($result);
                     $model->addOption('giangvien', $giangvien);
                 }
            }elseif ($model->getNhomquyen() == $model::ROLE_STUDENT){
                $queryStr = 'select * from '.SinhvienMapper::TABLE_NAME.'  where maTaikhoan = "'.$model->getId() .'"  LIMIT 1';
                $query = $this->connect->query($queryStr);
                if ($result = $query->fetch_assoc()){
                    $sinhvien = new Sinhvien();
                    $sinhvien->exchangeArray($result);
                    $model->addOption('sinhvien', $sinhvien);
                }
            }
            return true;
        }
        return false;
    }
    
    public function get($model){
        if (! $model->getId()){
            return null;
        }
        $queryStr = 'select * from '.self::TABLE_NAME.' where id = '.$model->getId();
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return $model;
        }
        return null;
    }    
    
    public function isExist($model){
        if (! $model->getTaikhoan()){
            return false;
        }
        $whereArr = [];
        if ($model->getTaikhoan()){
            $whereArr[] = 'taikhoan = "'.$model->getTaikhoan().'"';
        }
        if ($model->getMatkhau()){
            $whereArr[] = 'matkhau = "'.$model->getMatkhau().'"';
        }
        if ($model->getTrangthai()){
            $whereArr[] = 'trangthai = "'.$model->getTrangthai().'"';
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' WHERE '.implode(' AND ', $whereArr). ' LIMIT 1';
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return true;
        }
        return false;
    }
    
    public function search($user){
        $queryStr = 'select * from taikhoan';
        $query = $this->connect->query($queryStr);
        $result = [];
        while($row = $query->fetch_assoc()){
            $result[] = $row;
        }
        return $result;
    }
}