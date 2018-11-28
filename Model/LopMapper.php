<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Lop.php';
use Model\Base\ModelMapper;
class LopMapper extends ModelMapper{
    const TABLE_NAME = 'lop';
    /**
     * 
     * @var $model \Model\Lop 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'maLop'      => $model->getMaLop(),
            'tenLop'     => $model->getTenLop(),
            'maKhoa'     => $model->getMaKhoa(),
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
    
    public function search($model){
        $queryStr = 'select * from '.self::TABLE_NAME;
        $query = $this->connect->query($queryStr);
        $result = [];
        while($row = $query->fetch_assoc()){
            $Lop = new Lop();
            $Lop->exchangeArray($row);
            $result[] = $Lop;
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
        $khoaIds = []; $lopIds =[];
        while($row = $query->fetch_assoc()){
            $lop = new Lop();
            $lop->exchangeArray($row);
            $khoaIds[$lop->getMaKhoa()] = $lop->getMaKhoa();
            $lopIds[$lop->getId()] = $lop->getId();
            $result[] = $lop; 
        }
        $dsKhoa = [];
        if ($khoaIds){
            $queryStr = 'select * from khoa WHERE id IN ('.implode(' ,', $khoaIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $dsKhoa[$row['id']] = $row['tenKhoa'];
            }
        }
        $totalSV = [];
        if ($lopIds){
            $queryStr = 'select maLop, COUNT(sv.id) as totalSV from sinhvien as sv WHERE maLop IN ('.implode(' ,', $lopIds).') AND maLop is NOT NULL';
            $queryStr .= ' GROUP BY maLop';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $totalSV[$row['maLop']] = $row['totalSV'];
            }
        }
        foreach ($result as $lop){
            if (!empty($dsKhoa[$lop->getMaKhoa()])){
                $lop->addOption('tenKhoa', $dsKhoa[$lop->getMaKhoa()]);
            }
            if (!empty($totalSV[$lop->getId()])){
                $lop->addOption('totalSV', $totalSV[$lop->getId()]);
            }
        }
        return $result;
    }
    
    public function isExist($model){
        if (! $model->getMaLop() && ! $model->getMaKhoa() && ! $model->getTenLop()){
            return false;
        }
        $whereArr = [];
        if ($model->getMaKhoa()){
            $whereArr[] = 'maKhoa = "'.$model->getMaKhoa().'"';
        }
        if ($model->getMaLop()){
            $whereArr[] = 'maLop = "'.$model->getMaLop().'"';
        }
        if ($model->getTenLop()){
            $whereArr[] = 'tenLop = "'.$model->gettenLop().'"';
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