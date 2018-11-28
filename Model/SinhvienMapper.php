<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Sinhvien.php';
use Model\Base\ModelMapper;
use Model\Sinhvien;

if (!class_exists('SinhvienMapper')) {
    class SinhvienMapper extends ModelMapper{
        const TABLE_NAME = 'sinhvien';
        /**
         * 
         * @var $model \Model\Sinhvien 
         */
        public function save($model){
            //Nếu không có ID thì là thêm mới, nếu có ID thì là update
            $data = [
                'maSV'      => $model->getMaSV(),
                'tenSV'     => $model->getTenSV() ? : null,
                'maLop'     => $model->getMaLop() ? : null,
                'soDT'      => $model->getSoDT() ? : null,
                'diachi'    => $model->getDiaChi() ? : null,
                'maTaikhoan'=> $model->getMaTaikhoan() ? : null,
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
        
        //Hàm kiểm tra mã SV đã tồn tại trên hệ thống chưa
        public function isExist($model){
            if (! $model->getMaSV() && ! $model->getMaLop()){
                return false;
            }
            $whereArr = [];
            if ($model->getMaSV()){
                $whereArr[] = 'maSV = "'.$model->getMaSV().'"';
            }
            if ($model->getMaLop()){
                $whereArr[] = 'maLop = "'.$model->getMaLop().'"';
            }
            if ($model->getId()){
                $whereArr[] = 'id <> '.$model->getId();
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
            $queryStr = 'select * from '.self::TABLE_NAME;
            $query = $this->connect->query($queryStr);
            $result = [];
            while($row = $query->fetch_assoc()){
                $sinhvien = new Sinhvien();
                $sinhvien->exchangeArray($row);
                $result[] = $sinhvien;
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
            $queryStr = 'select * from '.self::TABLE_NAME;
            $query = $this->connect->query($queryStr);
            $result = [];
            $lopIds = []; $sinhvienIds =[];$userIds = [];
            while($row = $query->fetch_assoc()){
                $sinhvien = new Sinhvien();
                $sinhvien->exchangeArray($row);
                $lopIds[$sinhvien->getMaLop()] = $sinhvien->getMaLop();
                $sinhvienIds[$sinhvien->getId()] = $sinhvien->getId();
                $userIds[$sinhvien->getMaTaikhoan()] = $sinhvien->getMaTaikhoan();
                $result[] = $sinhvien;
            }
            $dsLop = [];
            if ($lopIds){
                $queryStr = 'select l.id,l.tenLop, k.tenKhoa from lop as l INNER JOIN khoa as k ON l.maKhoa = k.id WHERE l.id IN ('.implode(' ,', $lopIds).')';
                $query = $this->connect->query($queryStr);
                while($row = $query->fetch_assoc()){
                    $dsLop[$row['id']]['tenLop'] = $row['tenLop'];
                    $dsLop[$row['id']]['tenKhoa'] = $row['tenKhoa'];
                }
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
            foreach ($result as $sinhvien){
                if (!empty($dsLop[$sinhvien->getMaLop()]['tenLop'])){
                    $sinhvien->addOption('tenLop', $dsLop[$sinhvien->getMaLop()]['tenLop']);
                }
                
                if (!empty($dsLop[$sinhvien->getMaLop()]['tenKhoa'])){
                    $sinhvien->addOption('tenKhoa', $dsLop[$sinhvien->getMaLop()]['tenKhoa']);
                }
                if (!empty($users[$sinhvien->getMaTaikhoan()])){
                    $sinhvien->addOption('user', $users[$sinhvien->getMaTaikhoan()]);
                }
            }
            return $result;
        }
        
    }
}