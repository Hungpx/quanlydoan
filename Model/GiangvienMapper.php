<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Giangvien.php';
use Model\Base\ModelMapper;
class GiangvienMapper extends ModelMapper{
    const TABLE_NAME = 'giangvien';
    /**
     * 
     * @var $model \Model\Giangvien 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'maGV'      => $model->getMaGV(),
            'tenGV'     => $model->getTenGV(),
            'email'     => $model->getEmail() ? : null,
            'chucvu'    => $model->getChucvu() ? : null,
            'soDT'      => $model->getSoDT() ? : null,
            'maTaikhoan'=> $model->getMataikhoan() ? : null,
        ];
        if (! $model->getId()){
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
            $valueUpdate = [];
            foreach ($data as $field => $value){
                $valueUpdate[] = $field .' = "'.$value.'"';
            }
            $queryStr = 'UPDATE '.self::TABLE_NAME.' SET '.implode(', ', $valueUpdate).' WHERE id='.$model->getId();
            $query = $this->connect->query($queryStr);
            return $model;
        }
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
    
    public function search($user){
        $queryStr = 'select * from '.self::TABLE_NAME;
        $query = $this->connect->query($queryStr);
        $result = [];
        while($row = $query->fetch_assoc()){
            $giangvien = new Giangvien();
            $giangvien->exchangeArray($row);
            $result[] = $giangvien;
        }
        return $result;
    }
    
    public function delete($model){
        if (! $model->getId()){
            return false;
        }
        $queryStr = 'DELETE from '.self::TABLE_NAME.' where id = '.$model->getId();
        $query = $this->connect->query($queryStr);
        if ($this->connect->affected_rows == 1){
            return true;
        }
        return false;
    }
    
    public function fetchAll($model){
        $whereArr = [];
        if ($model->getMaGV()){
            $whereArr[] = 'maGV = "'.$model->getMaGV().'"';
        }
        if ($model->getId()){
            $whereArr[] = 'id = '.$model->getId();
        }
        $queryStr = 'select * from '.self::TABLE_NAME;
        if ($whereArr){
          $queryStr = 'select * from '.self::TABLE_NAME .' WHERE '.implode(' AND ', $whereArr);
        }
        $query = $this->connect->query($queryStr);
        $result = [];
        $userIds =[]; $giangvienIds = [];
        while($row = $query->fetch_assoc()){
            $giangvien = new Giangvien();
            $giangvien->exchangeArray($row);
            $userIds[$giangvien->getMaTaikhoan()] = $giangvien->getMaTaikhoan();
            $giangvienIds[$giangvien->getId()] = $giangvien->getId();
            $result[] = $giangvien;
        }
        $users = [];
        if ($userIds){
            $queryStr = 'select * from taikhoan WHERE id IN ('.implode(' ,', $userIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $user = new User();
                $user->exchangeArray($row);
                $users[$row['id']] = $user;
            }
        }
        $totalDoan = [];
        if ($giangvienIds){
            $queryStr = 'select giangvienHD, COUNT(d.id) as totalDoan from doan as d WHERE giangvienHD IN ('.implode(' ,', $giangvienIds).') AND giangvienHD is NOT NULL';
            $queryStr .= ' GROUP BY giangvienHD';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $totalDoan[$row['giangvienHD']] = $row['totalDoan'];
            }
        }
        foreach ($result as $giangvien){
            if (!empty($users[$giangvien->getMaTaikhoan()])){
                $giangvien->addOption('user', $users[$giangvien->getMaTaikhoan()]);
            }
            if (!empty($totalDoan[$giangvien->getId()])){
                $giangvien->addOption('totalDoan', $totalDoan[$giangvien->getId()]);
            }
        }
        return $result;
    }
    
    public function isExist($model){
        if (! $model->getMaGV()){
            return false;
        }
        $whereArr = [];
        if ($model->getMaGV()){
            $whereArr[] = 'maGV = "'.$model->getMaGV().'"';
        }
        if ($model->getId()){
            $whereArr[] = 'id <> '.$model->getId();
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' WHERE '.implode(' AND ', $whereArr);
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return true;
        }
        return false;
    }
}